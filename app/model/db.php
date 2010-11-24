<?php

	class DbModel {
	
		private $db;
	
		// This function is call by the framework. Please don't remove it.
		public function __construct($db) {
			$this->db = $db;
		}
		
		public function getData() {
			$users = new users($this->db);
			return $users->select('*');
		}
	
	}

?>