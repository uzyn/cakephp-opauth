<?php
/**
 * Opauth dummy plugin.
 * Passes all requests for plugin to handle
 */
class OpauthAppController extends AppController {
	
	public function index(){
		$this->autoRender = false;
		App::import('Vendor', 'Opauth/opauth');
		$Opauth = new Opauth;
		
		return;
	}
}