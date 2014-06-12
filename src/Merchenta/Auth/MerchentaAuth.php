<?php
namespace Merchenta\Auth;

use Merchenta\Util\RestClient;
use Merchenta\Exceptions\AuthException;

/**
 * Class that implements necessary functionality to obtain an access token from a user
 *
 * @package Auth
 * @author  Baptiste Pernet
 */
class MerchentaAuth implements MerchentaAuthInterface {

	/**
	 * @var string $clientId the Merchenta user.
	 */
	public $clientId;

	/**
	 * @var string $clientSecret the password for the Perfect Audiance user.
	 */
	public $clientSecret;

	/**
	 * @var Config $config configuration of the access to the API.
	 */
	private $config;

	/**
	 * @var RestClientInterface $restClient - use to connect the API.
	 */
	private $restClient;

	/**
	 * @var DataStoreInterface $dataStore session store to save the token.
	 */
	private $dataStore;

	/**
	 * Build an authentication object.
	 * @param string $clientId - id of the client in the Merchenta API.
	 * @param string $clientSecret - secret access of the client in the Merchenta API.
	 * @param object $config - configuration of the access to the Merchenta API.
	 * @param object $restClient - optional, for testing purpose.
	 * @param object $dataStoreInterface - optional, for testing purpose.
	 */
	public function __construct($clientId, $clientSecret, $config, $restClient = null, $dataStore = null) {
		$this->clientId = $clientId;
		$this->clientSecret = $clientSecret;
		$this->config = $config;
		$this->restClient = ($restClient) ? $restClient : new RestClient();
		$this->dataStore = ($dataStore) ? $dataStore : new SessionDataStore();
	}

	/**
	 * Obtain an access token. This token is valid for two hours and need to be
	 * @return array
	 * @throws \Merchenta\Exceptions\Auth2Exception
	 */
	public function getAccessToken() {
		// The token that may be valid in the data store.

		$token = $this->dataStore->getAccessToken($this->clientId);
		if ($token) {
			return $token;
		}

		// Parameters to make a request.
		$params = array(
			'email' => $this->clientId,
			'password' => $this->clientSecret,
		);

		// Get the url to make the request.
		$url = $this->config->get('endpoints.base_url') . $this->config->get('endpoints.auth') . '?' . http_build_query($params);

		// Make the request and decode it.
		$response = $this->restClient->post($url);
		$responseBody = json_decode($response->body, true);

		// Handle the error case.
		if (array_key_exists('error_code', $responseBody)) {
			throw new AuthException($responseBody['error_code'] . ': ' . $responseBody['error_message']);
		}

		// Get the token.
		$token = $responseBody['token'];

		// Save the token in the datastore, with 2 hours expiration.
		$this->dataStore->addAccessToken($this->clientId, $token, time() + 120 * 60);

		// Return the token.
		return $token;
	}
}
