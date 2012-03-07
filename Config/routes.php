<?php
/**
 * Routing for Opauth
 */
	//Router::connect('/opauth/:controller/:action/*', array('plugin' => 'Opauth'));
	//Router::connect('/opauth/:controller/*', array('plugin' => 'Opauth'));
	Router::connect('/opauth/*', array('plugin' => 'Opauth', 'controller' => 'Opauth', 'action' => 'index'));
