<?php
namespace Merchenta\Auth;

/**
 * Implementation of a datastroe that uses session for access token storage
 *
 * @package Auth
 * @author Baptiste Pernet
 */
class SessionDataStore implements DataStoreInterface {

	/**
	 * Start the session and initialize the datastore in the the session.
	 */
	public function __construct() {
		if(session_id() == '') {
			session_start();
		}

		if (!isset($_SESSION['merchenta_datastore'])) {
			$_SESSION['merchenta_datastore'] = array();
		}
	}

	/**
	 * Add a new token to the data store. We have the expiration of 2 hours.
	 * @params string $username - Merchenta username.
	 * @params string $token - Token return by the authentication call.
	 * @params number $expire - time when the the token will expire.
	 */
	public function addAccessToken($username, $token, $expire) {
		$_SESSION['merchenta_datastore'][$username] = array(
			'value' => $token,
			'expire' => $expire,
		);
	}

	/**
	 * Get an existing token from the data store
	 * @params string $username - Merchenta username
	 */
	public function getAccessToken($username) {
		if (array_key_exists($username, $_SESSION['merchenta_datastore'])) {
			$token = $_SESSION['merchenta_datastore'][$username];
			if (time() < $token['expire']) {
				return $token['value'];
			}
		}

		return false;
	}
}
