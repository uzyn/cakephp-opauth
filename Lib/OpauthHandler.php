<?php

App::uses('CakeEventListener', 'Event');
App::uses('CakeSession', 'Model/Datasource');

App::import('Vendor', 'Opauth.Opauth/lib/Opauth/Opauth');

class OpauthHandler implements CakeEventListener {

/**
 * True when already handled, used to avoid multiple runs, for instance with CakeErrorController
 *
 * @var boolean
 */
	protected $_handled = false;

/**
 * Executed method on Controller.initialize event
 *
 * @param CakeEvent $event
 */
	public function auth(CakeEvent $event) {
		if (!$this->_handled) {
			$this->handle($event->subject()->request);
		}
	}

/**
 * Performs Opauth strategy run and callback handling
 *
 * @param CakeRequest $request
 * @return void
 */
	public function handle(CakeRequest $request) {
		if ($request->url == '/' || strpos($request->here, Configure::read('Opauth.path')) !== 0) {
			return false;
		}
		if (empty($request->params['pass'][0])){
			throw new BadRequestException('Missing strategy');
		}

		if ($request->params['pass'][0] !== 'callback') {
			$this->getOpauth()->run();
		}

		$request->data = $this->callback($request);
		$this->_handled = true;
	}

/**
 * Receives auth response and does validation
 *
 * @param CakeRequest $request
 * @return array callback data
 */
	public function callback(CakeRequest $request){
		$data = (array)$this->_readResponse($request);
		$data['validated'] = false;

		if (array_key_exists('error', $data)) {
			return $data;
		}

		if ($this->_missingKey($data)){
			$data['error'] = array(
				'provider' => !empty($data['auth']['provider']) ? $data['auth']['provider'] : 'unknown',
				'code' => 'invalid_auth_missing_components',
				'message' => 'Invalid auth response: Missing key auth response components.'
			);
			return $data;
		}

		if (!$this->getOpauth()->validate(sha1(print_r($data['auth'], true)), $data['timestamp'], $data['signature'], $reason)) {
			$data['error'] = array(
				'provider' => $data['auth']['provider'],
				'code' => 'invalid_auth_failed_validation',
				'message' => 'Invalid auth response: '.$reason
			);
			return $data;
		}
		$data['validated'] = true;
		return $data;
	}

/**
 * Gets data from callback response for all callback transport options
 *
 * @param CakeRequest $request
 * @return array Callback response data
 * @throws BadRequestException
 */
	protected function _readResponse(CakeRequest $request) {
		switch(Configure::read('Opauth.callback_transport')) {
			case 'session':
				$data = CakeSession::read('opauth');
				CakeSession::delete('opauth');
				return $data;
			case 'post':
				return unserialize(base64_decode($request->data('opauth')));
			case 'get':
				return unserialize(base64_decode($request->query['opauth']));
			default:
				throw new BadRequestException('Invalid callback_transport');
		}
	}

/**
 * Checks data for required keys
 *
 * @param type $data
 * @return boolean
 */
	protected function _missingKey($data) {
		return
			empty($data['auth']) ||
			empty($data['timestamp']) ||
			empty($data['signature']) ||
			empty($data['auth']['provider']) ||
			empty($data['auth']['uid']);
	}

/**
 * Creates and returns Opauth instance
 *
 * @return Opauth
 */
	public function getOpauth(){
		return new Opauth(Configure::read('Opauth'), false);
	}

/**
 * Returns the implemented events
 *
 * @return array
 */
	public function implementedEvents() {
		return array('Controller.initialize' => 'auth');
	}

}