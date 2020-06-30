<?php

namespace TechnicalTrial;

require_once 'Model.php';
require_once 'Countries.php';
require_once 'BusinessType.php';

class PropertyRecord extends Model
{

	// These values reflect what's in table: 'api_trial.sources'
	private const SOURCE_API = 1;
	private const SOURCE_ADMIN = 2;

	protected $_table_name = 'properties';

	protected $_fields = array(
		'uuid' => array(
			'api_name' => 'uuid',
			'form_type' => null,
			'val_type' => '',
			'isValid' => false,
			'value' => null,
			'mysqli_bind_type' => 's',
		),
		'source_id' => array(
			'api_name' => null,
			'form_type' => null,
			'mysqli_bind_type' => 'i',
		),
		'address' => array(
			'api_name' => 'address',
			'form_type' => 'textarea',
			'val_type' => 'string',
			'isValid' => false,
			'value' => null,
			'mysqli_bind_type' => 's',
		),
		'town' => array(
			'api_name' => 'town',
			'form_type' => 'text',
			'val_type' => 'string',
			'isValid' => false,
			'value' => null,
			'mysqli_bind_type' => 's',
		),
		'county' => array(
			'api_name' => 'county',
			'form_type' => 'text',
			'val_type' => 'string',
			'isValid' => false,
			'value' => null,
			'mysqli_bind_type' => 's',
		),
		'country_id' => array(
			'api_name' => 'country',
			'mysqli_bind_type' => 'i',
			'form_type' => 'select',
			'val_type' => 'string',
			'isValid' => false,
			'value' => null,
		),
		'latitude' => array(
			'api_name' => 'latitude',
			'mysqli_bind_type' => 's',
			'form_type' => 'text',
			'val_type' => 'string',
			'isValid' => false,
			'value' => null,
		),
		'longitude' => array(
			'api_name' => 'longitude',
			'mysqli_bind_type' => 's',
			'form_type' => 'text',
			'val_type' => 'string',
			'isValid' => false,
			'value' => null,
		),
		'num_bedrooms' => array(
			'api_name' => 'num_bedrooms',
			'mysqli_bind_type' => 'i',
			'form_type' => 'text',
			'val_type' => 'string',
			'isValid' => false,
			'value' => null,
		),
		'num_bathrooms' => array(
			'api_name' => 'num_bathrooms',
			'mysqli_bind_type' => 'i',
			'form_type' => 'text',
			'val_type' => 'string',
			'isValid' => false,
			'value' => null,
		),
		'property_type_id' => array(
			'api_name' => 'property_type_id',
			'mysqli_bind_type' => 'i',
			'form_type' => 'select',
			'val_type' => 'string',
			'isValid' => false,
			'value' => null,
		),
		'business_type_id' => array(
			'api_name' => 'type',
			'mysqli_bind_type' => 'i',
			'form_type' => 'select',
			'val_type' => 'string',
			'isValid' => false,
			'value' => null,
		),
		'description' => array(
			'api_name' => 'description',
			'mysqli_bind_type' => 's',
			'form_type' => 'textarea',
			'val_type' => 'string',
			'isValid' => false,
			'value' => null,
		),
		'price' => array(
			'api_name' => 'price',
			'mysqli_bind_type' => 's',
			'form_type' => 'text',
			'val_type' => 'string',
			'isValid' => false,
			'value' => null,
		),
	);


	public function __construct(array $values = [], $map_name = "api_name")
	{
		if ( isset($values['property_type']) ) {
			$this->_process_property_type($values['property_type']);
		}

		foreach ($this->_fields as $f => $fp) {
			$field_name = $fp[$map_name];
			if ( isset($values[$field_name]) ) {
				$this->_fields[$f]['value'] = $values[$field_name];
			}
		}
	}


	public function getFields()
	{
		return $this->_fields;
	}


	public function commit()
	{
		require 'mysqli.php';

		$sql = $this->_get_prepared_query();

		$stmt = $db->prepare($sql);

		$source_id = self::SOURCE_API;
		$bind_tokens = $this->_get_bind_types_tokens();
		$country_id = $this->_get_country_id();
		$business_type_id = $this->_get_business_type_id();

		$stmt->bind_param(
			$bind_tokens,
			$this->_fields['uuid']['value'],
			$source_id,
			$this->_fields['address']['value'],
			$this->_fields['town']['value'],
			$this->_fields['county']['value'],
			$country_id,
			$this->_fields['latitude']['value'],
			$this->_fields['longitude']['value'],
			$this->_fields['num_bedrooms']['value'],
			$this->_fields['num_bathrooms']['value'],
			$this->_fields['property_type_id']['value'],
			$business_type_id,
			$this->_fields['description']['value'],
			$this->_fields['price']['value'],
		);

		if (! $stmt->execute()) {
			throw new \Exception($stmt->error);
		}

		$db->close();
	}


	public static function getIterator($limit = 10, $offset = 0)
	{
		require 'mysqli.php';

		$sql = "
			SELECT
				p.*,
				c.name AS country,
				pt.title AS property_title,
				bt.name AS business_type,
				s.name AS source
			FROM properties p
			JOIN countries c ON (c.id = p.country_id)
			JOIN property_types pt ON (pt.id = p.property_type_id)
			JOIN business_types bt ON (bt.id = p.business_type_id)
			JOIN sources s ON (s.id = p.source_id)
			LIMIT ?
			OFFSET ?
		";
		$stmt = $db->prepare($sql);
		$stmt->bind_param('ii', $limit, $offset);
		$stmt->execute();
		$iterator = $stmt->get_result();

		return $iterator;
	}


	public function getByUUID($uuid)
	{
		require 'mysqli.php';

		$sql = "
			SELECT
				p.*,
				c.name AS country,
				pt.title AS property_title,
				bt.name AS type
			FROM {$this->_table_name} p
			JOIN countries c ON (c.id = p.country_id)
			JOIN property_types pt ON (pt.id = p.property_type_id)
			JOIN business_types bt ON (bt.id = p.business_type_id)
			
			WHERE uuid = ?
		";
		$stmt = $db->prepare($sql);
		$stmt->bind_param('s', $uuid);
		$stmt->execute();
		$iterator = $stmt->get_result();

		return new self($iterator->fetch_assoc());
	}




	/*** HELPERS ***/


	private function _get_country_id()
	{
		$c = new Countries();
		$country_id = $c->getIdFromName( $this->_fields['country_id']['value'] );

		return $country_id;
	}


	private function _get_business_type_id()
	{
		$b = new BusinessType();
		$business_type_id = $b->getIdFromName( $this->_fields['business_type_id']['value'] );

		return $business_type_id;
	}


	private function _process_property_type($property_type_values)
	{
		$p = new PropertyType($property_type_values);
		$p->commit();
	}

}
