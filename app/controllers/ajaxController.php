<?php

	/*
		You can do the following in the controller

		1. TO DISPLAY ERRORS :
				display_error("Calls to the function <strong>display_error($message)</strong> are displayed like this");
				display_warning("Calls to the function <strong>display_warning($message)</strong> are displayed like this");
				display_system("Calls to the function <strong>display_system($message)</strong> are displayed like this");
				display("Calls to the function <strong>display($message)</strong> are displayed like this");

		2. TO HANDLE DATABASES :
				If you have the following table
				CREATE TABLE IF NOT EXISTS `students` (
					`id` int(11) NOT NULL auto_increment,
					`name` varchar(64) NOT NULL,
					`phone` varchar(64) NOT NULL,
					`status` varchar(128) NOT NULL,
				PRIMARY KEY  (`id`)
				) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

				Then run php index.php generatrix preparedb

				This would create a class students and you can run
				$students = new students($this->getDb());
				$students_data = $students->select("*", "WHERE id=5");
				$students_data = $students->delete("WHERE id=5");
				$students_data = $students->update(array("name" => "sudhanshu"), "WHERE id=5");
				$students_data = $students->insert(array("name" => "sudhanshu", "phone" => "1234567890", "status" => "working on generatrix"));

		3. TO PASS VALUES TO THE VIEW :
				$this->set("sample", "This is sample content which was set in the controller");
				$this->set("students_data", $students_data);
	*/

	class ajaxController extends Controller {

		public function base() {

		}

		public function clear() {
			$this->isHtml(false);
			echo json_encode(array('result' => 'success'));
		}

		public function fetch() {
			$this->isHtml(false);

			$url = isset($_GET['domain']) ? $_GET['domain'] : false;
			$post = isset($_GET['post']) ? $_GET['post'] : false;

			$time = isset($_SESSION['time']) ? $_SESSION['time'] : false;
			if($time === false) {
				$time = time();
				$_SESSION['time'] = $time;
			}

			$c = new Curl();
			$c->setUserCookie('/app/cache/curl-cookie' . $time . '.txt');

			$data = '';
			if($post) {
				$data = $c->post($url, $post, 1);
			} else {
				$data = $c->get($url, 1);
			}

			echo json_encode(array('result' => 'success', 'value' => $data));
		}

	}

?>
