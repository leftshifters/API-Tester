<?php

	//
	// The base class for all views
	//

	class View {
		private $generatrix;
		private $variables;

		private $head;
		private $body;

		private $control_name;
		private $control_options;

		private $added_generated_css;

		public $helper;

		public function __construct() {
			$this->added_generated_css = false;
			if(class_exists('viewHelper')) {
				$this->helper = new viewHelper();
			}
		}

		// Get a variable from the controller
		public function get($var_name) {
			if($this->hasVariable($var_name)) {
				return $this->variables[$var_name];
			} else {
				$bt = bt();
				display_error('The variable <strong>"' . $var_name . '"</strong> is not available in <strong>' . $bt['file'] . ' [ Line ' . $bt['line'] . ']</strong>');
			}
		}

		// Set a variable from the controller
		public function set($var_name, $var_value) {
			$this->variables[$var_name] = $var_value;
		}

		// Check if a variable is defined
		public function hasVariable($var_name) {
			if(isset($this->variables[$var_name]))
				return true;
			return false;
		}

		// Check if the variable has a value
		public function hasValue($var_name) {
			if(isset($this->variables[$var_name]) && ($this->variables[$var_name] != ''))
				return true;
			return false;
		}

		public function getGeneratrix() {
			return $this->generatrix;
		}

		public function setGeneratrix($generatrix) {
			$this->generatrix = $generatrix;
		}

		// Get the <head> object
		public function getHead() {
			return $this->head;
		}

		// Set the <head> object
		public function setHead($head) {
			$this->head = $head;
			return $this;
		}

		// Get the <body> object
		public function getBody() {
			return $this->body;
		}

		// Set the <body> object
		public function setBody($body) {
			$this->body = $body;
			return $this;
		}

		// Start the page, create <head> and <body> elements
		public function startPage() {
			$this->setHead(new Head());
			$this->setBody(new Body());
		}

		// End the page, close the <head> and <body> tags and add them to <html>
		public function endPage() {
			$html = new Html();
			$html->appendContent($this->getHead());
			$html->appendContent($this->getBody());
			return $html;
		}

		// Get the post value
		public function getPostValue($tag_name) {
			return $this->getGeneratrix()->getPost()->getValue($tag_name);
		}

		// Get the cookie value
		public function getCookieValue($tag_name) {
			return $this->getGeneratrix()->getCookie()->getValue($tag_name);
		}

		// Get the cookie value
		public function getSessionValue($tag_name) {
			return $this->getGeneratrix()->getSession()->getValue($tag_name);
		}


		// Add a javscript file to <head>
		public function addJavascript($file) {
			$outside_link = (strpos($file, 'http://') === false) ? false : true;
			if(!$outside_link) {
				if(file_exists(path($file))) {
					return '<script type="text/javascript" src="' . chref($file) . '"></script>';
				} else {
					display_system('The file <strong>' . path($file) . '</strong> does not exist');
				}
			} else {
					return '<script type="text/javascript" src="' . $file . '"></script>';
			}
		}

		// Add a CSS file <head>, check for IE condition
		public function addCss($file, $ie = false, $media = 'screen, projection') {
			$outside_link = (strpos($file, 'http://') === false) ? false : true;
			if(!$outside_link) {
				if(file_exists(path($file))) {
					return $ie 
						?  "\n<!--[if IE]>\n<link rel='stylesheet' href='" . chref($file) . "' type='text/css' media='" . $media . "'>\n<![endif]-->"
						: "<link media='" . $media . "' type='text/css' href='" . chref($file) . "' rel='stylesheet' />";
				} else {
					display_error('The file <strong>' . path($file) . '</strong> does not exist');
				}
			} else {
				return $ie 
					?  "\n<!--[if IE]>\n<link rel='stylesheet' href='" . $file . "' type='text/css' media='" . $media . "'>\n<![endif]-->"
					: "<link media='" . $media . "' type='text/css' href='" . $file . "' rel='stylesheet' />";
			}
		}



		private function loadGenerated() {
			return $this->addCss('/public/style/generated.phpx') . $this->addCss('/public/style/generatrix-ie.css', true);
		}

		// Add the generated css
		private function addGeneratedCss() {
			if(!$this->added_generated_css) {
				$head = $this->getHead();
				$head->appendContent(
					$this->loadGenerated()
				);
				$this->setHead($head);
				$this->added_generated_css = true;
			}
		}

		// Add the GOOGLE Ajax Libraries
		private function addGoogleAjaxLibraries() {
			$content = '';
			if(JS_JQUERY != '') {
				$content .=  $this->addJavascript('/public/javascript/jquery-' . JS_JQUERY . '.min.js');	
			}

			if(JS_COOKIE == '1') {
				$content .= $this->addJavascript('/public/javascript/jquery.cookie.min.js');
			}

			if(GOOGLE_FONTS != '') {
				$fonts = GOOGLE_FONTS;
				$semicolons = explode(';', $fonts);
				foreach($semicolons as $font) {
					$content .= $this->addCss('http://fonts.googleapis.com/css?family=' . trim($font));
				}
			}

			$content .= "
<script type='text/javascript'>
	var Generatrix = {
		basepath: '" . href('') . "',
		use_cdn: " . USE_CDN . ",
		cbasepath: '" . chref('') . "',
		href: function(path) { return this.basepath + path; },
		chref: function(path) { if(this.use_cdn) { return this.cbasepath + this.href(path) } else { href(path) } },
		loading: function(where) { $(where).html(\"<img src='\" + this.href('/images/gears.gif') + \"' />\"); },
		timestamp: function() { var d = new Date(); return d.getTime() / 1000; },
		rand: function(max) { return Math.ceil(Math.random() * max); }
	};
	String.prototype.trim = function() {
		return this.replace(/^\s*/, \"\").replace(/\s*$/, \"\");
	};
</script>
			";
			$this->getHead()->appendContent($content);
			//return;

			$loadGoogle = false;
			$content = $this->addJavascript('http://www.google.com/jsapi');
			if(JS_COOKIE) {
				$content .= $this->addJavascript('/public/javascript/jquery.cookie.min.js');
			}
			$content .= '<script type="text/javascript">';

			if( (JS_JQUERYUI != '') || (JS_PROTOTYPE != '') || (JS_SCRIPTACULOUS != '') || (JS_MOOTOOLS != '') || (JS_DOJO != '') || (JS_SWFOBJECT != '') || (JS_YUI != '') || (JS_EXT_CORE != '') ) {
				$loadGoogle = true;
			}

			if(JS_JQUERYUI != '') $content .= 'google.load("jquery", "' . JS_JQUERYUI . '");';
			if(JS_PROTOTYPE != '') $content .= 'google.load("jquery", "' . JS_PROTOTYPE . '");';
			if(JS_SCRIPTACULOUS != '') $content .= 'google.load("jquery", "' . JS_SCRIPTACULOUS . '");';
			if(JS_MOOTOOLS != '') $content .= 'google.load("jquery", "' . JS_MOOTOOLS . '");';
			if(JS_DOJO != '') $content .= 'google.load("jquery", "' . JS_DOJO . '");';
			if(JS_SWFOBJECT != '') $content .= 'google.load("jquery", "' . JS_SWFOBJECT . '");';
			if(JS_YUI != '') $content .= 'google.load("jquery", "' . JS_YUI . '");';
			if(JS_EXT_CORE != '') $content .= 'google.load("jquery", "' . JS_EXT_CORE . '");';

			$content .= '</script>';
			if($loadGoogle) {
				$this->getHead()->appendContent($content);
			}
		}

		// Add the libraries
		private function addLibraries() {
			if(MOBILE_SITE == 1) {

			} else {
				$this->addGenericHeader();
				$this->addGeneratedCss();
				$this->addGoogleAjaxLibraries();
			}
		}

		// Public function which adds stuff to the <head> from the view
		public function add($list) {
			$this->addLibraries();
			$head = $this->getHead();
			$files = (array) json_decode($list, true);

			if(checkArray($files, 'css')) {
				foreach($files['css'] as $file) {
					$head->appendContent($this->addCss($file));
				}
			}

			if(checkArray($files, 'js')) {
				foreach($files['js'] as $file) {
					$head->appendContent($this->addJavascript($file));
				}
			}

			$this->setHead($head);
		}

		// Public function to set the title for a page
		public function title($title) {
			$head = $this->getHead();
			$head->appendContent('<title>' . $title . TITLE_TEXT . '</title>');
			$this->setHead($head);
		}

		// The function loads the sub views with html in them
		public function loadSubView($sub_view) {
			ob_start();
			include(path('/app/subviews/' . $sub_view . '.php'));
			$data = ob_get_contents();
			ob_end_clean();
			return $data;
		}

		// This function loads the control from the framework directory
		public function loadControl($control_name, $control_options) {
			$this->control_name = $control_name;
			$this->control_options = $control_options;

			ob_start();
			include(path('/framework/controls/' . $control_name . '/' . $control_name . '.php'));
			$data = ob_get_contents();
			ob_end_clean();

			$this->control_name = '';
			$this->control_options = array();

			return $data;
		}
	}

?>
