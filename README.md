CakePHP Opauth Plugin sample app
==================
This CakePHP app is meant as a sample implementation of [CakePHP Opauth plugin](https://github.com/uzyn/cakephp-opauth).

Requirement
-----------
CakePHP v2.x  
_(tested with CakePHP v2.1.3)_

How to set up
-------------
1. Install the latest CakePHP v2.x.

2. Replace the content of `app/` with this demo.

3. Go to `http://localhost` and you should see:  
   ![Demo homepage](https://github.com/uzyn/cakephp-opauth/raw/sample/webroot/img/demo/homepage.png)

4. Click on any of the authentication methods to try. Try with OpenID as it is configurationless.

5. Open `Config/bootstrap.php` and replace the dummy values with your own Facebook, Twitter or Google apps crentials:

   ```php
   // Configure Facebook strategy
   Configure::write('Opauth.Strategy.Facebook', array(
       'app_id' => 'YOUR FACEBOOK APP ID',
       'app_secret' => 'YOUR FACEBOOK APP SECRET'
   ));
   ```

6. After authentication, successful or otherwise, you should see the following screen:  
   ![Demo callback](https://github.com/uzyn/cakephp-opauth/raw/sample/webroot/img/demo/callback.png)

Issues & questions
-------------------
- Discussion group: [Google Groups](https://groups.google.com/group/opauth)  
  Feel free to post your questions to the discussion group. This is the primary channel for support.
- Issues: [Github Issues](https://github.com/uzyn/cakephp-opauth/issues)  
- Twitter: [@uzyn](http://twitter.com/uzyn)  
- Email me: chua@uzyn.com  
- IRC: **#opauth** on [Freenode](http://webchat.freenode.net/?channels=opauth&uio=d4)

Looking for CakePHP solution or consultation?  
<a href="mailto:chua@uzyn.com">Drop me a mail</a>. I do freelance consulting & development.

License
---------
The MIT License  
Copyright © 2012 U-Zyn Chua (http://uzyn.com)