<?php

class Controller_Twitterauth_Index extends Controller {

	function action_index()
	{
		if (!empty($_GET['oauth_token']) && !empty($_SESSION[Twitterauth::$token_name]) && $_GET['oauth_token'] === $_SESSION[Twitterauth::$token_name]['oauth_token'])
		{
			$tw = Twitterauth::factory()->init(true);
			$token = $tw->getAccessToken($_GET['oauth_verifier']);
			Cookie::set(Twitterauth::$cookie_name, json_encode($token, JSON_HEX_AMP | JSON_HEX_APOS | JSON_HEX_TAG | JSON_HEX_QUOT), Date::MONTH);
			unset($_SESSION[Twitterauth::$token_name]);
		}

		$this->response->body('<script>window.close();</script>');
	}
}
