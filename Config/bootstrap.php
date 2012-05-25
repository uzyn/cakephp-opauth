<?php
/**
 * Default bootstrap for Opauth CakePHP plugin.
 * 
 * Refer to https://github.com/uzyn/opauth/wiki/Opauth-configuration for configuration info
 * Overwrite any of these values at your app's Config/bootstrap.php _AFTER_
 * CakePlugin::load('Opauth', array('routes' => true, 'bootstrap' => true));
 */


/**
 * Path where Opauth is accessed.
 *  
 * Begins and ends with /
 * eg. if Opauth is reached via http://example.org/auth/, path is '/auth/'
 */
Configure::write('Opauth.path', '/auth/');

/**
 * Whether to view Opauth debug messages
 * Value is automatically set according to CakePHP's app debug value.
 */
Configure::write('Opauth.debug', (Configure::read('debug') !== 0));

/**
 * Callback URL: redirected to after authentication, successful or otherwise
 */
Configure::write('Opauth.callback_url', Configure::read('Opauth.path').'callback');

/**
 * Callback transport, for sending of $auth response
 * 
 * 'session': Default. Works best unless callback_url is on a different domain than Opauth
 * 'post'   : Works cross-domain, but relies on availability of client-side JavaScript.
 * 'get'    : Works cross-domain, but may be limited or corrupted by browser URL length limit 
 *            (eg. IE8/IE9 has 2083-char limit)
 */
Configure::write('Opauth.callback_transport', 'session');

/**
 * A random string used for signing of $auth response.
 * 
 * Sets to Security.salt's value by default
 */
Configure::write('Opauth.security_salt', Configure::read('Security.salt'));

/**
 * Higher value, better security, slower hashing;
 * Lower value, lower security, faster hashing.
 */
//Configure::write('Opauth.security_iteration', 300);

/**
 * Time limit for valid $auth response, starting from $auth response generation to validation.
 */
//Configure::write('Opauth.security_timeout', '2 minutes');

/**
 * Directory where Opauth strategies reside
 */
Configure::write('Opauth.strategy_dir', dirname(dirname(__FILE__)).'/Strategy/');

/**
 * Strategy
 * Refer to individual strategy's documentation on configuration requirements.
 * 
 * Add strategy configurations in your app's bootstrap.php in the following format:
 * 
 * Configure::write('Opauth.Strategy.Facebook', array(
 *     'app_id' => 'YOUR FACEBOOK APP ID',
 *     'app_secret' => 'YOUR FACEBOOK APP SECRET'
 * ));
 *
 */
Configure::write('Opauth.Strategy', array());