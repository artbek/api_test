<?php

namespace TechnicalTrial;

class Countries
{

	private $_table_name = 'countries';


	public function getIdFromName(string $name)
	{
		require 'mysqli.php';

		$sql = "
			SELECT id FROM {$this->_table_name}
			WHERE name = ?
		";
		$stmt = $db->prepare($sql);
		$stmt->bind_param('s', $name);
		$stmt->execute();
		$stmt->bind_result($country_id);
		$stmt->fetch();

		if (! $country_id) {

			print_r("Adding new country [{$name}]...\n");

			$sql = "
				INSERT INTO {$this->_table_name} (name)
				VALUES (?)
			";
			$stmt = $db->prepare($sql);
			$stmt->bind_param('s', $name);
			$stmt->execute();
			$country_id = $db->insert_id;

			print_r("Added new country with id #{$country_id}.\n");

		}

		return $country_id;
	}

}
