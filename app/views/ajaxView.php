<?php

	/*
		Inside a view, you can do the following (inside any function declared as public function funcName() {} )
		
		1. ADD CSS OR JAVASCRIPT	
				$this->add('{ "css" : [ "/public/style/batman.css", ... ], "js" : [ "/public/javascript/batman.js", ... ]} ');

		2. ADD TAGS TO HEAD
				$this->getHead()->appendContent($your_content);

		3. TO LOAD A SUB VIEW
				$content = $this->loadSubView("home-body"); // ( This will load the subview located in app/subviews/home-body.php )

		4. TO ADD CONTENT TO THE <body> TAG
				$this->getBody()->appendCOntent($your_content);

	*/

	class ajaxView extends View {

		public function base() {

		}

		public function clear() {

		}

		public function fetch() {

		}

	}

?>
