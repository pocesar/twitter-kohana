<?php

require_once realpath(dirname(__FILE__) . '/vendor/twitteroauth/twitteroauth.php');

Route::set('twitter-auth', 'twitter/auth')
->defaults(array(
	'directory'  => 'Twitterauth',
	'controller' => 'Index',
	'action' => 'index'
));
