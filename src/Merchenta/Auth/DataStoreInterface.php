<?php
namespace Merchenta\Auth;

interface DataStoreInterface {

	/**
	 * Add a new token to the data store. We have the expiration of 2 hours.
	 * @params string $username - Merchenta username.
	 * @params string $token - Token return by the authentication call.
	 * @params number $expire - time when the the token will expire.
	 */
	public function addAccessToken($username, $token, $expire);

	/**
	 * Get an existing token from the data store
	 * @params string $username - Merchenta username
	 */
	public function getAccessToken($username);
}
