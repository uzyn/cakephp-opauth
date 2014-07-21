<?php
class OpauthController extends OpauthAppController {

	public function __construct($request = null, $response = null) {
		parent::__construct($request, $response);
		$this->modelClass = null;
	}

	public function beforeFilter() {
		// Allow access to Opauth methods for users of AuthComponent
		if (is_object($this->Auth) && method_exists($this->Auth, 'allow')) {
			$this->Auth->allow();
		}

		//Disable Security for the plugin actions in case that Security Component is active
		if (is_object($this->Security)) {
			$this->Security->validatePost = false;
			$this->Security->csrfCheck = false;	
		}
		// allow parent (e.g. AppController) to have a say!
		parent::beforeFilter();
	}
}
