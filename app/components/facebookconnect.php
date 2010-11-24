<?php

	// Create an application here - http://developers.facebook.com/setup/
	// More details on how to authenticate can be found here - http://developers.facebook.com/docs/authentication/#authenticating-users-in-a-web-application

	class FacebookConnect {
	
		private $client_id = FB_CLIENT_ID;
		private $client_secret = FB_CLIENT_SECRET;
		private $authorize_url = 'https://graph.facebook.com/oauth/authorize';
		private $accesstoken_url = 'https://graph.facebook.com/oauth/access_token';
		private $graph_url = 'https://graph.facebook.com/';
		private $redirect_url = FB_REDIRECT_URL;

		private $oauth_url;
		private $access_url;

		private $curl;

		public function __construct() {
			$params = '?client_id=' . $this->client_id . '&redirect_uri=' . $this->redirect_url;
			$this->oauth_url = $this->authorize_url . $params . '&scope=' . $this->extendedPermissions();
			$this->access_url = $this->accesstoken_url . $params . '&client_secret=' . $this->client_secret . '&code=';
			$this->curl = new Curl();
		}

		public function connect() {
			return "<a href='" . $this->oauth_url . "'><img src='" . href('/public/images/loginviafacebook.png') . "' /></a>";
		}

		public function getAccessToken() {
			$code = isset($_GET['code']) ? $_GET['code'] : false;
			if($code !== false) {
				$access_token = $this->curl->get($this->access_url . $code);
				return str_replace('access_token=', '', $access_token);
			} else {
				return false;
			}
		}

		public function getData($token, $what) {
			$api_url = $this->graph_url . $what . '?access_token=' . $token;
			$data = $this->curl->get($api_url);
			return json_decode($data, true);
		}
	
		private function extendedPermissions() {
			// Permissions can be found here - http://developers.facebook.com/docs/authentication/permissions
			$perms = array(
				'publish_stream',
				'offline_access',
				'user_birthday',
				'user_about_me',
				'user_hometown',
				'user_photo_video_tags',
				'user_photos',
				'user_videos',
				'friends_birthday',
				'friends_about_me',
				'friends_hometown',
				'friends_photo_video_tags',
				'friends_photos',
				'friends_videos',
				'email'
			);
			return implode(',', $perms);
		}

	}

?>
