<?php

  /**
  *
  *   @author Samih Soylu
  *
  **/
	
	# Imports generic class
	require_once(dirname(__FILE__).'/Generic.php');

	class Entry extends Generic {

		# Inherits generic constructor
		public function __construct() {
			parent::__construct();
		}

		/*
		* This function reads user entries from the database
		* based on the parameter given. The function updates
		* the class variables and then returns true.
		*
		* @param $userID - integer user id.
		*/
		public function ReadUserEntries($userID) {
			if($userID < 1)
				return 0;

			$sql = "SELECT id, title, description, date_added, date_modified  FROM entries WHERE user_id = '".$userID."' ORDER BY date_added DESC LIMIT 50";

			# Retrieves data from database
			$result = $this->mysqli->query($sql);

			# Reads amount of rows
			$row_cnt = $result->num_rows;

			# Labels array using ASSOC
			$result = $result->fetch_all(MYSQLI_ASSOC);

			if($row_cnt < 1) {
				return 0;
			}

			return $result;

		}

		/*
		* This function reads entries from the database
		* based on the entry id parameter given.
		*
		* @param $entryID - integer entry id.
		*/
		public function ReadEntry($entryID) {

			# Security Wall 1: Checks if numeric
			if(!is_numeric($entryID))
				return 0;

			# Security Wall 2: Escapes for mysql injection
			$entryID = $this->mysqli->real_escape_string($entryID);

			$sql = "

				SELECT 
					e.id, u.name, e.title, e.description, e.date_added, e.date_modified 
				FROM 
					entries e 
				LEFT JOIN
					users u
				ON
					e.user_id = u.id
				WHERE e.id = '".$entryID."';
			";

			# Retrieves data from database
			$result = $this->mysqli->query($sql);

			# Reads amount of rows
			$row_cnt = $result->num_rows;

			# Labels array using ASSOC
			$result = $result->fetch_all(MYSQLI_ASSOC);

			if($row_cnt < 1) {
				return 0;
			}

			return $result;
		}

		/*
		* Array retrievs last 50 entries from the database. Displays it to the user on 
		* the view all entries screen.
		*/
		public function ReadAllUsersEntries() {
			/*
			    [0] => Array
			    (
			        [entry_id] => 8
			        [user_id] => 1
			        [name] => Mike
			        [title] => ddd
			        [description] => ddd
			        [date_added] => 1480271839
			        [date_modified] => 1480271839
			    )
			*/
			$sql = "
				SELECT 
					e.id AS entry_id,
					u.id AS user_id,
					u.name,
					e.title, 
					e.description, 
					e.date_added, 
					e.date_modified 
				FROM 
					entries e 
				LEFT JOIN 
					users u 
				ON 
					e.user_id = u.id 
				ORDER BY e.date_added DESC LIMIT 50";

			# Retrieves data from database
			$result = $this->mysqli->query($sql);

			# Reads amount of rows
			$row_cnt = $result->num_rows;

			# Labels array using ASSOC
			$result = $result->fetch_all(MYSQLI_ASSOC);

			if($row_cnt < 1) {
				return 0;
			}

			return $result;
		}

		/*
		* This function writes user entries to the database
		* based on parameters given. A new record is added
		* when this function is executed. The date combined
		* with the user id is a candidate key.
		*
		* @param $userID - id of user
		* @param $title  - title of entry
		* @param $desc   - description of entry.
		*
		*/
		public function WriteUserEntry($userID, $title, $desc) {

			# Do not proceed if user is not logged in
			if(@$userID < 1)
				return 0;

			# Strip string from html tags
			$title = strip_tags($title);
			$desc  = strip_tags($desc);

			# Escapes string to prevent tampering with query.
			$title = $this->mysqli->real_escape_string($title);
			$desc  = $this->mysqli->real_escape_string($desc);

			$sql = "
				INSERT INTO entries (user_id, title, description, date_added, date_modified)
				VALUES ('".$userID."', '".$title."', '".$desc."', '".time()."', '".time()."')
			";

			# Inserts new record to entries table
			$result = $this->mysqli->query($sql);

			# If success returns 1.
			if($result)
				return 1;

			return 0;
		}

		/*
		* This function updates user entries to the database
		* based on changes. A record is updated
		* when this function is executed. The date combined
		* with the user id is a candidate key.
		*
		* @param $userID  - id of user
		* @param $entryID - id of entry
		* @param $title   - title of entry
		* @param $desc    - description of entry.
		*
		*/
		public function UpdateUserEntry($userID, $entryID, $title, $desc) {
			if(@$userID < 1 || !is_numeric($entryID))
				return 0;

			# Strip string from html tags
			$title = strip_tags($title, '<br><span>');
			$desc  = strip_tags($desc, '<br><span>');

			# Escapes string to prevent tampering with query.
			$title = $this->mysqli->real_escape_string($title);
			$desc = $this->mysqli->real_escape_string($desc);
 
			$sql = "
				UPDATE entries SET title = '".$title."', description = '".$desc."', date_modified = '".time()."' WHERE user_id = '".$userID."' AND id = '".$entryID."';
			";

			# Inserts new record to entries table
			$result = $this->mysqli->query($sql);

			if($result) {
				return 1;
			}
			return 0;
		}

		/*
		* This function finds the first entry ever added to the database. This then returns
		* the date_added unix time stamp value. This is later used to calculate which entry
		* belongs to which week.(All Entries page)
		*/
		public function getDateOfFirstCreatedEntry() {

			$sql = "SELECT date_added FROM entries ORDER BY date_added DESC LIMIT 1;";

			$result = $this->mysqli->query($sql)->fetch_array(MYSQLI_ASSOC);

			return $result['date_added'];

		}

		/*
		* Simply calculates if displayed entry week is equal to the retrieved
		* entry week from the database. This is to sort-out entries under different
		* week numbers in the AllEntries page.
		*
		* @param $current_processed_week - The week number currently displayed on the page
		* @param $entry_created_week - the week number the $current_processed_week should be.
		*/
		public function checkWeek($current_processed_week, $entry_created_week) {

			# If current week is not equal to entry week
			if($current_processed_week != $entry_created_week) {

				if($current_processed_week == 1) 
				{
					$current_processed_week = 52;
				
				} else {
					
					$current_processed_week--;

				}

				# Second check
				if($current_processed_week != $entry_created_week) {

					$current_processed_week = $this->checkWeek($current_processed_week, $entry_created_week);

				}
				
			}

			return $current_processed_week;
		}

	}

?>