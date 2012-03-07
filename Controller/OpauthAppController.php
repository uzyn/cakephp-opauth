<?php
/**
 * Opauth dummy plugin.
 * Passes all requests for plugin to handle
 */
class OpauthAppController extends AppController {
	
	public function index(){
		App::uses('Opauth', 'Vendor/Opauth');
	}
}