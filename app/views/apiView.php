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

	class apiView extends View {

		public function base() {
			$this->title("Testrix | API Testing Tool | Vercingetorix Technologies"); // Any common text should be added to app/settings/config.json in title-text
			$this->description("This will help you test your APIs");
			$this->add('{ "css" : [ ], "js" : [ ] }');

			$this->getBody()->appendContent(
				$this->loadSubView('api')
			);
		}

	}

?>
