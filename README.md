CakePHP plugin for Opauth
=========================

CakePHP 2.x plugin for [Opauth](https://github.com/uzyn/opauth).

Opauth is a multi-provider authentication framework.

Requirements
---------
CakePHP v2.x  
Opauth >= v0.2 _(submoduled with this package)_

How to use
----------
1. Install this plugin for your CakePHP app.   
   Assuming `APP` is the directory where your CakePHP app resides, it's usually `app/` from the base of CakePHP.

   ```bash
   cd APP/Plugin
   git clone git://github.com/uzyn/cakephp-opauth.git Opauth
   ```

2. Download Opauth library as a submodule.

   ```bash
   git submodule init
   git submodule update
   ```

3. Add this line to the bottom of your app's `Config/bootstrap.php`:

   ```php
   <?php
   CakePlugin::load('Opauth', array('routes' => true, 'bootstrap' => true));
   ```
   Overwrite any Opauth configurations you want after the above line.

4. Load [strategies](https://github.com/uzyn/opauth/wiki/list-of-strategies) onto `Strategy/` directory.

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

5. Go to `http://path_to_your_cake_app/auth/facebook` to authenticate with Facebook, and similarly for other strategies that you have loaded.

6. After validation, user will be redirected to `Router::url('/opauth-complete')` with validated auth response data retrievable available at `$this->data`.

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

7. _(optional)_ The submoduled Opauth core library may not be of the latest build, to update to the latest:  
   ```bash
   git submodule foreach git pull origin master
   ```

Issues & questions
-------------------
- Issues: [Github Issues](hhttps://github.com/uzyn/cakephp-opauth/issues)  
- Discussion group: [Google Groups](https://groups.google.com/group/opauth)
- Twitter: [@uzyn](http://twitter.com/uzyn)  
- Email me: chua@uzyn.com  
- IRC: **#opauth** on [Freenode](http://webchat.freenode.net/?channels=opauth&uio=d4)

<p>Used this plugin in your CakePHP project? Let us know!</p>

License
---------
The MIT License  
Copyright © 2012 U-Zyn Chua (http://uzyn.com)


Footnote
---------
U-Zyn Chua is a Principal Consultant at [gladlyCode](http://gladlycode.com), a premier PHP web development firm.  
If you need consultation in web technologies and services, feel free to [talk to us](mailto:we@gladlycode.com).
