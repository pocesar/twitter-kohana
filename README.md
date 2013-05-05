Kohana 3.3 OAuth Helper for Twitter
============

This module uses git://github.com/abraham/twitteroauth.git and provide an easier workflow for Twitter OAuth without many extra steps. 

# Usage:

### Set your APPPATH/config/twitterauth.php with

```php
return array(
  'consumer_key' => 'get it from dev.twitter.com',
  'consumer_secret' => 'get it from dev.twitter.com'
);
```

### In your controller, check if the user is already logged in:

```php
$twitter = Twitterauth::factory()->init();
if (!($user = $twitter->getUser()))
{
  // Not logged in or not authorize, send them to the authorize APP url
  HTTP::redirect($twitter->getAuthorizeURL()));
}
else
{
  // $user->screen_name
}
```

Done. The redirect should happen in a popup, since the callback calls `window.close()`. The module takes care of the cookies and session variables for you. 
If you want, overwrite the original `Controller_Twitterauth_Index` controller so you can control the denied / errors by yourself (currently it simply ignores it) or even override the callback Route using `Route::set('twitter-auth', 'your-route')`