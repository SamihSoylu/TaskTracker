<?php

  /**
  *
  *   @author Samih Soylu
  *
  **/

class Generic {

	protected $mysqli;

	public function __construct() {

		$this->mysqli = $GLOBALS['mysqli'];

	}

	public function e_log($data) {
		
	}

}

?>