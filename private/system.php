<?php

/*** Constants ***/

define("PRIVATE_PATH", '../private/');
define("IS_DEV", '1');


/*** Environment ***/

if (defined('IS_DEV')) {
	error_reporting(-1);
	ini_set('display_errors', 1);
}


/*** Helper function ***/

function get_path($path) {
	return PRIVATE_PATH . $path;
}
