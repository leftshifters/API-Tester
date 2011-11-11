<?php

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
			$file = isset($_GET['file']) ? $_GET['file'] : false;
			$agent = isset($_GET['agent']) ? $_GET['agent'] : false;
			$header = isset($_GET['header']) ? $_GET['header'] : false;

			if($file === false) {
				$file = substr(md5(time() . 'rand'), 0, 6);
			}

			$c = new Curl();
			$c->setUserCookie('/app/cache/curl-cookie-' . $file . '.txt');

			if($agent) {
				$c->setUserAgent($agent);
			}

			if($header) {
				$c->setHeader($header);
			}

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
