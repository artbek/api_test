<?php

namespace TechnicalTrial;

class BusinessType
{

	private $_table_name = 'business_types';


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
		$stmt->bind_result($id);
		$stmt->fetch();

		if (! $id) {

			print_r("Adding new Business Type [{$name}]...\n");

			$sql = "
				INSERT INTO {$this->_table_name} (name)
				VALUES (?)
			";
			$stmt = $db->prepare($sql);
			$stmt->bind_param('s', $name);
			$stmt->execute();
			$id = $db->insert_id;

			print_r("Added new Business Type with id #{$id}.\n");

		}

		return $id;
	}

}

