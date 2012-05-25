<?php
/**
 * CakePHP plugin for Opauth
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
				//unset($_SESSION['opauth']);
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
			echo '<strong style="color: red;">Authentication error: </strong> Opauth returns error auth response.'."<br>\n";
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
				echo '<strong style="color: red;">Invalid auth response: </strong>Missing key auth response components.'."<br>\n";
			}
			elseif (!($this->Opauth->validate(sha1(print_r($response['auth'], true)), $response['timestamp'], $response['signature'], $reason))){
				echo '<strong style="color: red;">Invalid auth response: </strong>'.$reason.".<br>\n";
			}
			else{
				echo '<strong style="color: green;">OK: </strong>Auth response is validated.'."<br>\n";

				/**
				 * It's all good. Go ahead with your application-specific authentication logic
				 */
			}
		}


		/**
		* Auth response dump
		*/
		echo "<pre>";
		print_r($response);
		echo "</pre>";
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