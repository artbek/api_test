<?php

namespace TechnicalTrial;


class Model
{

	protected function _get_prepared_query()
	{
		$values_tokens = [];
		$on_duplicate_tokens = [];

		foreach ($this->_fields as $f => $fp) {
			$values_tokens[] = "?";
			$on_duplicate_tokens[] = "$f = VALUES({$f})";
		}

		$field_names_tokens =  implode(', ', array_keys($this->_fields));
		$values_tokens = implode(', ', $values_tokens);
		$on_duplicate_tokens = implode(', ', $on_duplicate_tokens);

		$sql = "
			INSERT INTO {$this->_table_name} ({$field_names_tokens})
			VALUES ($values_tokens)
			ON DUPLICATE KEY UPDATE {$on_duplicate_tokens}
		";

		return $sql;
	}


	protected function _get_bind_types_tokens()
	{
		foreach ($this->_fields as $f => $fp) {
			$types_tokens[] = "{$fp['mysqli_bind_type']}";
		}

		$types_tokens = implode('', $types_tokens);

		return $types_tokens;
	}

}

