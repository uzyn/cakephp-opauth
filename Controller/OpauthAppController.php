<?php
/**
 * CakePHP plugin for Opauth
 */
class OpauthAppController extends AppController {
	var $uses = array();
	
	public function index(){
		$this->autoRender = false;
		
		App::import('Vendor', 'opauth/lib/Opauth/Opauth');
		$Opauth = new Opauth( Configure::read('Opauth.config') );
		
		return;
	}
}