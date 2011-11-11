<?php
	
	require_once(DISK_ROOT . '/framework/library/controller.php');
	require_once(DISK_ROOT . '/framework/library/view.php');

	class cacheManifestController extends Controller {

		public function base() {
			$this->isHtml(false);
		}

	}

	class cacheManifestView extends View {

		public function base() {

			if(USE_MANIFEST == true) {

				header('Content-Type: text/cache-manifest');

				$cache = array(
					'CACHE MANIFEST',
					'# ver 2',
					'NETWORK:',
					'*',
					'/default',
					'CACHE:',
					'/public/javascript/modernizr-1.6.min.js',
					'/public/style/generatrix-reset.css',
					'/public/style/generatrix.css',
					'/public/javascript/jquery-1.4.4.min.js'
				);

				foreach($cache as $file) {
					echo $file . "\n";
				}
			} else {
				header("HTTP/1.1 404 Not Found");
			}
		}

	}

?>
