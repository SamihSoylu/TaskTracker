<?php

	/**
	*
	*   @author Samih Soylu
	*
	**/

	# Configurations
	$config = array (

		"db" => array (
			"host"     => "localhost",
			"username" => "task_tracker",
			//"username" => "root",
			"password" => "task",
			//"password" => "root",
			"database" => "task_tracker"
		)

	);

	# Enables error reporting
	ini_set('display_errors', 1);
	error_reporting(E_ALL);

	# Setting timezones
	date_default_timezone_set('Europe/Amsterdam');;

	# Directories
	define('BASE_URL', '/');
	define('BASE_PATH', $_SERVER['DOCUMENT_ROOT'].BASE_URL);
	define('RESOURCES', BASE_PATH.'resources/');

	define('INCLUDES_PATH', RESOURCES.'includes/');
	define('TEMPLATE_PATH', RESOURCES.'templates/');
	define('HANDLERS_PATH', RESOURCES.'handlers/');

	# Var to const
	define('PAGE_NAME', @$_GET['p']);

?>