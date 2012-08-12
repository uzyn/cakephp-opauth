<?php
class UsersController extends AppController{
	
	public function opauth_complete() {
		$this->set('opauth_data', $this->data);
	}
	
}