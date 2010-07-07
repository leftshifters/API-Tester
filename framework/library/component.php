<?php

	class Component {

		private $generatrix;
		private $db;

		public function setGeneratrix($generatrix) {
			$this->generatrix = $generatrix;
			$this->db = $generatrix->getDb();
		}

		public function getDb() {
			return $this->db;
		}

	}

?>
