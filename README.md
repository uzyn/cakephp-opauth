CakePHP plugin for Opauth
=========================

CakePHP 2.x plugin for [Opauth](https://github.com/uzyn/opauth).

Opauth is a multi-provider authentication framework.

Notice
------
**Under development.**
**DO NOT USE**


How to use
----------
1. `APP` is the directory where your CakePHP app resides, it's usually `app/` from the base of CakePHP.
   ```bash
   cd APP/Plugin
   git clone git://github.com/uzyn/cakephp-opauth.git Opauth
   ```

2. Download Opauth library as a submodule
   ```bash
   git submodule init
   git submodule update
   ```

3. Add this line to the bottom of your app's `Config/bootstrap.php`:
   ```php
   <?php
   CakePlugin::load('Opauth', array('routes' => true, 'bootstrap' => true) );
   ```

4. Load [strategies] onto `Strategy/` directory.

5. Go to `http://path_to_your_cake_app/auth/facebook` to authenticate with Facebook, and similarly for other strategies that you have loaded.


