<?php

	class Component {

		private $generatrix;
		private $db;

		public function __construct($generatrix) {
			$this->generatrix = $generatrix;
			$this->db = $generatrix->getDb();
		}

		public function getDb() {
			return $this->db;
		}

	}

?>
