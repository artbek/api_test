<?php

/*
 * php sync.php
 *
 */

namespace TechnicalTrial;

require_once 'system.php';
require_once 'PropertyRecord.php';
require_once 'Countries.php';
require_once 'PropertyType.php';
require_once 'BusinessType.php';
$config = require_once 'config.php';


$params = array(
	"api_key={$config['api_key']}",
	'page[size]=100',
	'page[number]=1',
);

$query_string = implode('&', $params);

$next_page_url = "{$config['base_url']}?{$query_string}";

while ($next_page_url) {

	print_r("Processing [$next_page_url]...\n");

	$ch = curl_init($next_page_url);
	curl_setopt($ch, CURLOPT_HEADER, 0);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

	$raw_response = curl_exec($ch);

	curl_close($ch);

	if ($raw_response) {
		$records = (array)json_decode($raw_response, true);

		foreach ($records['data'] as $record) {
			$propertyRecord = new PropertyRecord($record);
			$propertyRecord->commit();
		}

		$next_page_url = isset($records['next_page_url']) ? $records['next_page_url']: null;
	}

}

