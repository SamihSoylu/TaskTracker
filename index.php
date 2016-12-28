<?php

	/**
	*
	*   @author Samih Soylu
	*
	**/

	session_start();

	# Loads configurations
	require_once("resources/config.php");
	require_once("resources/db_connect.php");

	# Handlers
	require_once(HANDLERS_PATH."Login.php");
	require_once(HANDLERS_PATH."Entry.php");

	# Variables
	$load_page = PAGE_NAME;
	$GLOBALS['error_messages'] = "x";

	# Used later to determine what to display to the user
	# Only if the user is new (Login/Logout module)
	$setPassResult = 2; 

	/**
	*
	*   Login / Logout Module
	*
	**/
	# Login handler
	$login_handler = new Login();

	# Loads login page if user is not logged in
	# Also handles page redirect
	if(!$login_handler->check_user_logged())
		$load_page = "Login";

	# When login button is clicked
	if(isset($_POST['login']))
		$login_handler->login_user(strtolower($_POST['username']), $_POST['password']);

	# When set new pass button is clicked
	if(isset($_POST['setNewPass']))
		$setPassResult = $login_handler->set_pass($_POST['newPassword'], $_SESSION['user_id']);

	# If user has no password set
	if(@$_SESSION['must_set_pswd'] == true)
		$load_page = 'set_pass';

	/**
	*
	* Entry module
	*
	**/
	$entry_handler = new Entry();

	if(isset($_POST['AddNewEntry']))
  		$AddEntrySuccess = $entry_handler->WriteUserEntry($_SESSION['user_id'], $_POST['title'], $_POST['desc']);

  	if(isset($_POST['UpdateEntry']))
  		$UpdateEntrySuccess = $entry_handler->UpdateUserEntry($_SESSION['user_id'], $_SESSION['entry_id'], $_POST['title'], $_POST['desc']);
 

	/**
	*
	* Load page
	*
	**/
  	if(empty($load_page))
  		$load_page = "MyEntries";

	# Imports page templates based on page name
	include(INCLUDES_PATH.'header.php'); 

	$load_path = TEMPLATE_PATH.$load_page.'.inc.php';
	if(file_exists($load_path)) {
		include($load_path);
	} else {
		include(TEMPLATE_PATH.'404.php');
	}

	include(INCLUDES_PATH.'footer.php');

?>