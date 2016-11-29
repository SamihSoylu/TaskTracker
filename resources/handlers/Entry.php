<?php

  /**
  *
  *   @author Samih Soylu
  *
  **/
	
	# Imports generic class
	require_once(dirname(__FILE__).'/Generic.php');

	class Entry extends Generic {

		public $entry_date;
		public $entry_title;
		public $entry_description;

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

			$sql = "SELECT id, title, description, date_added, date_modified  FROM entries WHERE user_id = '".$userID."' ORDER BY date_modified DESC LIMIT 50";

			$result = $this->mysqli->query($sql);

			$row_cnt = $result->num_rows;

			$result = $result->fetch_all(MYSQLI_ASSOC);

			if($row_cnt < 1) {
				return 0;
			}

			return $result;

		}

		public function ReadEntry($entryID) {
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


			$result = $this->mysqli->query($sql);

			$row_cnt = $result->num_rows;

			$result = $result->fetch_all(MYSQLI_ASSOC);
			if($row_cnt < 1) {
				return 0;
			}

			return $result;
		}

		public function ReadAllUsersEntries() {
/*
    [0] => Array
    (
        [entry_id] => 8
        [user_id] => 1
        [name] => Samih
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
				ORDER BY e.date_modified DESC LIMIT 50";

			$result = $this->mysqli->query($sql);

			$row_cnt = $result->num_rows;

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
		* @param $userID    - number of user
		* @param $title  - title of entry
		* @param $desc   - description of entry.
		*
		*/
		public function WriteUserEntry($userID, $title, $desc) {
			if(@$userID < 1)
				return 0;

			$title = $this->mysqli->real_escape_string($title);
			$desc  = $this->mysqli->real_escape_string($desc);

			$sql = "
				INSERT INTO entries (user_id, title, description, date_added, date_modified)
				VALUES ('".$userID."', '".$title."', '".$desc."', '".time()."', '".time()."')
			";

			$result = $this->mysqli->query($sql);

			if($result)
				return 1;

			return 0;
		}

		public function UpdateUserEntry($userID, $entryID, $title, $desc) {
			if(@$userID < 1 || !is_numeric($entryID))
				return 0;

			$title = $this->mysqli->real_escape_string($title);
			$desc = $this->mysqli->real_escape_string($desc);
 
			$sql = "
				UPDATE entries SET title = '".$title."', description = '".$desc."', date_modified = '".time()."' WHERE user_id = '".$userID."' AND id = '".$entryID."';
			";

			$result = $this->mysqli->query($sql);

			//echo $sql;
			//printf("errormessage: %s\n", $this->mysqli->error);

			if($result) {
				//echo "TRUE";
				return 1;
			}
			//echo "false";
			return 0;
		}

	}

?>