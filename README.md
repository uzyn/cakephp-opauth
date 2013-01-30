CakePHP plugin for Opauth
=========================

CakePHP 2.x plugin for [Opauth](https://github.com/uzyn/opauth).

Opauth is a multi-provider authentication framework.

This branch is for cakephp-composer with [**Composer**](http://getcomposer.org) support.  
For conventional non-Composer installation of cakephp-opauth, either check out the [master branch](https://github.com/uzyn/cakephp-opauth/tree/master) or [download](https://github.com/uzyn/cakephp-opauth/downloads) the CakePHP plugin directly.

Requirements
---------
CakePHP v2.x  
Composer

Using [Composer](http://getcomposer.org/)?
-----------
You can install CakePHP-Opauth plugin directly from Composer at [uzyn/cakephp-opauth](http://packagist.org/packages/uzyn/cakephp-opauth).  
It works for Opauth strategies too!

View notes and Composer-enabled plugin code at [composer branch](https://github.com/uzyn/cakephp-opauth/tree/composer).

Tutorial & sample app
----------
Check out [CakePHP bakery](http://bakery.cakephp.org/articles/uzyn/2012/06/25/simple_3rd-party_provider_authentication_with_opauth_plugin) for tutorial and the [sample branch](https://github.com/uzyn/cakephp-opauth/tree/sample) for a quick sample app.

How to use
----------
1. Setup Composer  
   If you do not yet have Composer installed on your system, we recommend [CakePHP Composer plugin](https://github.com/uzyn/cakephp-composer) for easy installation. [[Tutorial](http://bakery.cakephp.org/articles/uzyn/2012/06/20/composer_plugin_for_cakephp) from Bakery]
   
1. Install this plugin for your CakePHP app, via [uzyn/cakephp-opauth](http://packagist.org/packages/uzyn/cakephp-opauth) from Packagist.

   Add these to your `composer.json` residing at your CakePHP's `app/` directory

   ```bash
   {
       "require": {
           "uzyn/cakephp-opauth": "*"
       }
   }
   ```
   Run `composer install`.

1. Add this line to the bottom of your app's `Config/bootstrap.php`:

   ```php
   <?php
   CakePlugin::load('Opauth', array('routes' => true, 'bootstrap' => true));
   ```
   Overwrite any Opauth configurations you want after the above line.

1. Load [strategies](https://github.com/uzyn/opauth/wiki/list-of-strategies) directly via Composer.

   Using [Facebook strategy](http://packagist.org/packages/opauth/facebook) as an example.
   
   ```bash
   composer require opauth/facebook:*
   ```

   Append configuration for strategies at your app's `Config/bootstrap.php` as follows:
   ```php
   <?php
   CakePlugin::load('Opauth', array('routes' => true, 'bootstrap' => true));
   
   // Using Facebook strategy as an example
   Configure::write('Opauth.Strategy.Facebook', array(
       'app_id' => 'YOUR FACEBOOK APP ID',
       'app_secret' => 'YOUR FACEBOOK APP SECRET'
   ));
   ```

1. Go to `http://path_to_your_cake_app/auth/facebook` to authenticate with Facebook, and similarly for other strategies that you have loaded.

1. After validation, user will be redirected to `Router::url('/opauth-complete')` with validated auth response data retrievable available at `$this->data`.

   To route a controller to handle the response, at your app's `Config/routes.php`, add a connector, for example:

   ```php
   <?php
   Router::connect(
       '/opauth-complete/*', 
       array('controller' => 'users', 'action' => 'opauth_complete')
   );
   ```

   You can then work with the authentication data at, say `APP/Controller/UsersController.php` as follows:
   
   ```php
   <?php // APP/Controller/UsersController.php:
   class UsersController extends AppController {
       public function opauth_complete() {
           debug($this->data);
       }
   }
   ```

   Note that this CakePHP Opauth plugin already does auth response validation for you with its results available as a boolean value at `$this->data['validated']`.


### Note:
If your CakePHP app **does not** reside at DocumentRoot (eg. `http://localhost`), but at a directory below DocumentRoot (eg. `http://localhost/your-cake-app`),  
add this line to your app's `APP/Config/bootstrap.php`, replacing `your-cake-app` with your actual path :

```php
<?php // APP/Config/bootstrap.php
Configure::write('Opauth.path', '/your-cake-app/auth/');
```

Issues & questions
-------------------
- Discussion group: [Google Groups](https://groups.google.com/group/opauth)  
  _This is the primary channel for support, especially for user questions._
- Issues: [Github Issues](https://github.com/uzyn/cakephp-opauth/issues)  
- Twitter: [@uzyn](http://twitter.com/uzyn)  
- Email me: chua@uzyn.com  
- IRC: **#opauth** on [Freenode](http://webchat.freenode.net/?channels=opauth&uio=d4)

<p>Used this plugin in your CakePHP project? Let us know!</p>

License
---------
The MIT License  
Copyright © 2012-2013 U-Zyn Chua (http://uzyn.com)

Consultation
---------
U-Zyn Chua is the Principal Consultant at [Zynesis Consulting](http://zynesis.com), specializing in CakePHP.  
Looking for PHP web development solutions or consultation? [Drop me a mail](mailto:chua@uzyn.com).
