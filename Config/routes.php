<?php
/**
 * Routing for Opauth
 */
Router::connect('/auth/*', array('plugin' => 'Opauth', 'controller' => 'Opauth', 'action' => 'index'));
