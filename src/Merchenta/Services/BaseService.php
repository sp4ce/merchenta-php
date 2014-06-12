<?php
namespace Merchenta\Services;

use Merchenta\Util\MerchentaAuth;
use Merchenta\Util\RestClient;
use Merchenta\Util\RestClientInterface;

/**
 * Super class for all services
 *
 * @package Services
 * @author  Baptiste Pernet
 */
abstract class BaseService
{
	/**
	 * RestClient Implementation to use for HTTP requests
	 * @var RestClientInterface $restClient - Used to query the API over http.
	 */
	protected $restClient;

	/**
	 * Authentication service to get the token to make request.
	 * @var MerchentaAuth $auth - Provide authentication to the API.
	 */
	protected $auth;

	/**
	 * @var Config $config - configuration to access to the API.
	 */
	protected $config;

	/**
	 * Constructor with the option to to supply an alternative rest client to be used
	 * @param MerchentaAuth $auth - Merchenta authentication service.
	 * @param Config $config - configuration to access the API.
	 * @param RestClientInterface $restClient - RestClientInterface implementation to be used in the service
	 */
	public function __construct($auth, $config, $restClient = null) {
		$this->auth = $auth;
		$this->config = $config;
		$this->restClient = ($restClient) ? $restClient : new RestClient();
	}

	/**
	 * Build a URL from a base url and optional array of query parameters to append to the url. URL query parameters
	 * should not be URL encoded and this method will handle that.
	 * @param $url
	 * @param array $queryParams
	 * @return string
	 */
	public function buildUrl($url, array $queryParams = null) {
		if ($queryParams) {
			$params = $queryParams;
		} else {
			$params = array();
		}

		return $url . '?' . http_build_query($params, '', '&');
	}

	/**
	 * Get the rest client being used by the service
	 * @return RestClientInterface - RestClientInterface implementation being used
	 */
	public function getRestClient() {
		return $this->restClient;
	}

	/**
	 * Set the rest client being used by the service
	 * @params $restClient - RestClientInterface implementation being used
	 */
	public function setRestClient(RestClientInterface $restClient) {
		$this->restClient = $restClient;
	}

	/**
	 * Helper function to return required headers for making an http request with Merchenta
	 * @return array - authorization headers
	 */
	protected function getHeaders() {
		// Get the token.
		$accessToken = $this->auth->getAccessToken();

		// Return the headers.
		return array(
			'Content-Type: application/json',
			'Accept: application/json',
			'Authorization: ' . $accessToken
		);
	}
}
