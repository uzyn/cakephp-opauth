<?php
class OpauthController extends OpauthAppController {

	public function beforeFilter() {
		// Allow access to Opauth methods for users of AuthComponent
		if (is_object($this->Auth) && method_exists($this->Auth, 'allow')) {
			if (version_compare(Configure::version(), '2.1.0', '>=')) {
				$this->Auth->allow();
			} else {
				// CakePHP 2.0
				$this->Auth->allow('*');
			}
		}
	}
}