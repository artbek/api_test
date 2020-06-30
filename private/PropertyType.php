<?php

namespace TechnicalTrial;

require_once 'Model.php';

class PropertyType extends Model
{

	protected $_table_name = 'property_types';

	protected $_fields = array(
		'id' => array(
			'api_name' => 'id',
			'value' => null,
			'mysqli_bind_type' => 'i',
		),
		'title' => array(
			'api_name' => 'title',
			'value' => null,
			'mysqli_bind_type' => 's',
		),
		'description' => array(
			'api_name' => 'description',
			'value' => null,
			'mysqli_bind_type' => 's',
		),
		'created_at' => array(
			'api_name' => 'created_at',
			'value' => null,
			'mysqli_bind_type' => 's',
		),
		'updated_at' => array(
			'api_name' => 'updated_at',
			'value' => null,
			'mysqli_bind_type' => 's',
		),
	);


	public function __construct(array $values)
	{
		foreach ($this->_fields as $f => $fp) {
			$api_field_name = $fp['api_name'];
			if ( isset($values[$api_field_name]) ) {
				$this->_fields[$f]['value'] = $values[$api_field_name];
			}
		}
	}


	public function commit()
	{
		require 'mysqli.php';

		$sql = $this->_get_prepared_query();

		$stmt = $db->prepare($sql);

		$bind_tokens = $this->_get_bind_types_tokens();

		$stmt->bind_param(
			$bind_tokens,
			$this->_fields['id']['value'],
			$this->_fields['title']['value'],
			$this->_fields['description']['value'],
			$this->_fields['created_at']['value'],
			$this->_fields['updated_at']['value'],
		);

		if (! $stmt->execute()) {
			throw new \Exception($stmt->error);
		}

		$db->close();
	}

}

