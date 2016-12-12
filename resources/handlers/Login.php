<?php

	/**
	*	@author Samih Soylu.
	**/
	
	# Imports generic class
	require_once(dirname(__FILE__).'/Generic.php');

	class Login extends Generic {

		public function __construct() {
			parent::__construct();
		}

		/**
		*	Checks if user is logged in. Determines true or false based on
		* 	user session. If session is not set then the user is not signed in
		*	The function also handles user redirect to prevent users from visiting
		*	incorrect web pages.
		*						The function returns 1 or a 0
		**/
		public function check_user_logged() {

			# If session is not set
			if(!isset($_SESSION['user_id']) || @$_SESSION['must_set_pswd'] == true) {

				# Redirect user
				if(ltrim($_SERVER['REQUEST_URI'], '/') != 'index.php') {
		   	  		header('Location: index.php');
				}
			
				
				# Not signed in
		   	  	return 0;
		   		
		   }

		   	 if(ltrim($_SERVER['REQUEST_URI'], '/') == 'index.php') {

		   	 	# Redirect user
		   	  	header('Location: index.php?p=MyEntries');

		   	  }

		   	  # Signed in
		   	  return 1;
			
		}

		/**
		*	Checking if the users password exists is necessary because
		*	if it does not exist, the user will be able to set a password
		*	once they click login button after they write in their username.
		*		The function returns 1 or a 0.
		*	
		*	@param $username - users login name entered by the user
		**/
		public function check_user_password_exists($username) {

			# Query
			$sql = "SELECT password FROM users WHERE username = '".$username."'";

			# Result
			$result = $this->mysqli->query($sql)->fetch_array(MYSQLI_ASSOC);

			# Password does not exist
			if(!isset($result['password']) || @$result['password'] == '')
				return 0;

			# Password exists
			return 1;
		}

		/**
		*	Matches username and password of the user to determine if the
		*	credentials entered are correct.
		*									Returns true or false
		*
		*	@param $username - users login name entered by the user
		*	@param $password - users password for their login name
		**/
		public function check_username_password_match($username, $password) {

			$sql = "SELECT id FROM users WHERE username = '".$username."' AND password = '".$password."';";

			$result = $this->mysqli->query($sql)->fetch_array(MYSQLI_ASSOC);

			/*
				Array
				(
				    [0] => Array
				        (
				            [id] => 1
				        )

				)
			*/

			if(!isset($result['id']))
				return 0;

			if(@$result['id'] > 0) {
				return 1;
			} else {
				return 0;
			}
		}

		/**
		*	Retrieves user identification number from the MySQL
		*	database to determine which data belongs to the user
		*	later.
		*		  Returns user ID.
		*
		*	@param $username - users login name entered by the user
		**/
		public function getUserID($username) {

			$sql = "SELECT id FROM users WHERE username = '".$username."'";

			$id = $this->mysqli->query($sql)->fetch_array(MYSQLI_ASSOC);

			//print_r($id);

			# if not username exists
			if(!isset($id['id'])) {
				return 0;
			} else {
				return $id['id'];
			}
		}

		/**
		*	Function uses the crypt function to encrypt the password
		*	of the user when necessary.
		*			The function returns an encrypted password.
		*
		*	@param $password - users password for their login name
		**/
		public function encryptPassword($password) {
			return crypt($password, 'loe');
		}

		/**
		*	This function destroys all sessions associated
		*	with the particular user that initiates this
		*	action.
		**/
		public function logout_user() {
			$_SESSION = array();
			session_destroy();
		}

		/**
		*	login_user runs a steps of procedures that checks if the
		*	user has entered correct credentials and if the password
		*	of a new user has been set.
		*
		*	@param $username - users login name entered by the user
		*	@param $password - users password for their login name
		**/
		public function login_user($username, $password) {

			$credentials_correct = false;
			$login_error = false;

			# Escape and encrpt
			$user = $this->mysqli->real_escape_string($username);
			$pass = '';

			$user_id = $this->getUserID($user);

			if($password != "")
				$pass = $this->encryptPassword($password);

			if($user_id < 1) {
				$login_error = true;
				$GLOBALS['error_messages'] = "Username does not exist!";
			}

			# If password does not exist
			if(!$this->check_user_password_exists($user) && !$login_error) {
				$_SESSION['user_id'] = $user_id;
				$_SESSION['must_set_pswd'] = true;

			}

			# If username exists
			if(!$login_error)
				$credentials_correct = $this->check_username_password_match($user, $pass);

			# If credentials are incorrect
			if(!$credentials_correct) {
				$login_error = true;
				$GLOBALS['error_messages'] = "Username or Password incorrect.";
			}

			
			if(!$login_error) {

				# Set session
				$_SESSION['user_id'] = $user_id;

				# Set user last login date
				$this->mysqli->query("UPDATE users SET last_login_date = '".time()."' WHERE id = ".$user_id.";");

				# Redirect
				header("Location:index.php");
			}

		}

		/**
		*	Set pass sets the password for the user when necessary.
		*	the function returns a false or true based on the result
		*	of the query executed.
		*	
		*	@param $password - users password for their login name
		*	@param $user_id  - identification of user
		**/
		public function set_pass($password, $user_id) {

			# Encrypt
			$pass = $this->encryptPassword($password);
			
			if($user_id < 1) {
				$this->logout_user();
				return 0;
			}

			$sql = "UPDATE users SET password = '".$pass."' WHERE id = '".$user_id."'";

			$this->mysqli->query($sql);

			if($this->mysqli->affected_rows > 0) {
				$_SESSION['must_set_pswd'] = false;
				header("Location: index.php");
				return 1;
			}

			return 0;

		}

	}