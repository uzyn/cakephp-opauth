<?php
/**
 * CakePHP plugin for Opauth
 * 
 * @copyright		Copyright © 2012 U-Zyn Chua (http://uzyn.com)
 * @link 			http://opauth.org
 * @license			MIT License
 */
class OpauthAppController extends AppController {
	public $uses = array();
	
	/**
	 * Opauth instance
	 */
	public $Opauth;
	
	/**
	 * {@inheritDoc}
	 */
	public function __construct($request = null, $response = null) {
		parent::__construct($request, $response);
		
		$this->autoRender = false;
	}
	
	/**
	 * Catch all for Opauth
	 */
	public function index(){
		
		$this->_loadOpauth();
		$this->Opauth->run();
		
		return;
	}
	
	/**
	 * Receives auth response and does validation
	 */
	public function callback(){
		$response = null;
		
		/**
		* Fetch auth response, based on transport configuration for callback
		*/
		switch(Configure::read('Opauth.callback_transport')){	
			case 'session':
				if (!isset($_SESSION)){
					session_start();
				}
				$response = $_SESSION['opauth'];
				unset($_SESSION['opauth']);
				break;
			case 'post':
				$response = unserialize(base64_decode( $_POST['opauth'] ));
				break;
			case 'get':
				$response = unserialize(base64_decode( $_GET['opauth'] ));
				break;
			default:
				echo '<strong style="color: red;">Error: </strong>Unsupported callback_transport.'."<br>\n";
				break;
		}
		
		/**
		 * Check if it's an error callback
		 */
		if (array_key_exists('error', $response)){
			// Error
			$response['plugin_validated'] = false;
		}

		/**
		 * Auth response validation
		 * 
		 * To validate that the auth response received is unaltered, especially auth response that 
		 * is sent through GET or POST.
		 */
		else{
			$this->_loadOpauth();
			
			if (empty($response['auth']) || empty($response['timestamp']) || empty($response['signature']) || empty($response['auth']['provider']) || empty($response['auth']['uid'])){
				$response['error'] = array(
					'provider' => $response['auth']['provider'],
					'code' => 'invalid_auth_missing_components',
					'message' => 'Invalid auth response: Missing key auth response components.'
				);
				$response['plugin_validated'] = false;
			}
			elseif (!($this->Opauth->validate(sha1(print_r($response['auth'], true)), $response['timestamp'], $response['signature'], $reason))){
				$response['error'] = array(
					'provider' => $response['auth']['provider'],
					'code' => 'invalid_auth_failed_validation',
					'message' => 'Invalid auth response: '.$reason
				);
				$response['plugin_validated'] = false;
			}
			else{
				$response['plugin_validated'] = true;
			}
		}
		
		/**
		 * Write after-validation response to CakePHP Configuration key: Auth.Opauth
		 */
		$configKey = Configure::read('Opauth._cakephp_plugin_config_key');
		if (empty($configKey)) $configKey = 'Auth.Opauth';
		Configure::write('Auth.Opauth', $response);
		
		
		/**
		 * Redirect user to /opauth-complete
		 */
		$completeUrl = Configure::read('Opauth._cakephp_plugin_complete_url');
		if (empty($completeUrl)) $completeUrl = Router::url('/opauth-complete');
		$this->redirect($completeUrl);
	}
	
	/**
	 * Instantiate Opauth
	 * 
	 * @param array $config User configuration
	 * @param boolean $run Whether Opauth should auto run after initialization.
	 */
	protected function _loadOpauth($config = null, $run = false){
		if (is_null($config)){
			$config = Configure::read('Opauth');
		}
		
		App::import('Vendor', 'Opauth.Opauth/lib/Opauth/Opauth');
		$this->Opauth = new Opauth( $config, $run );
	}
}