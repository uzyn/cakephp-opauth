<h2>CakePHP Opauth plugin demo</h2>

<h3>Authenticate with:</h3>
<ul>
	<li><?php echo $this->Html->link('Facebook', array('plugin' => 'Opauth', 'controller' => 'Opauth', 'action' => 'index', 'facebook')); ?></li>
	<li><?php echo $this->Html->link('Google', array('plugin' => 'Opauth', 'controller' => 'Opauth', 'action' => 'index', 'google')); ?></li>
	<li><?php echo $this->Html->link('Twitter', array('plugin' => 'Opauth', 'controller' => 'Opauth', 'action' => 'index', 'twitter')); ?></li>
	<li><?php echo $this->Html->link('OpenID', array('plugin' => 'Opauth', 'controller' => 'Opauth', 'action' => 'index', 'openid')); ?></li>
</ul>