<?php

class Twitterauth_Core extends TwitterOAuth {
	public $request_token = array();
	public static $cookie_name = 'twitterauth_cookie';
	public static $token_name = 'twitterauth_tokens';
	public $config;

	function __construct($consumer_key = NULL, $consumer_secret = NULL, $oauth_token = NULL, $oauth_token_secret = NULL)
	{
		$this->config = Kohana::$config->load('twitterauth');

		parent::__construct($this->config->consumer_key, $this->config->consumer_secret);
	}

	public static function factory()
	{
		return new self();
	}

	function init($callback = false)
	{
		if (!Cookie::get(self::$cookie_name))
		{
			if (!$callback)
			{
				$this->request_token = parent::getRequestToken(URL::site(Route::get('twitter-auth')->uri(), Request::$current));
				$_SESSION[self::$token_name] = $this->request_token;
			}
			else
			{
				$token = $_SESSION[self::$token_name];
				$this->token = new OAuthConsumer($token['oauth_token'], $token['oauth_token_secret']);
			}
		}
		else
		{
			$token = json_decode(Cookie::get(self::$cookie_name), true);
			$this->token = new OAuthConsumer($token['oauth_token'], $token['oauth_token_secret']);
		}

		return $this;
	}

	function getAuthorizeURL($token = null, $sign_in_with_twitter = true)
	{
		$_SESSION['twitterauth_url'] = URL::site(Request::$current->detect_uri(), Request::$current);

		return parent::getAuthorizeURL($token ? : $this->request_token['oauth_token'], $sign_in_with_twitter);
	}

	public function getUser()
	{
		$user = $this->get('account/verify_credentials');
		if (!empty($user) && !empty($user->id))
		{
			return $user;
		}
		return false;
	}

}
