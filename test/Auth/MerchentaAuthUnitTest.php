<?php

use Merchenta\Auth\MerchentaAuth;
use Merchenta\Util\Config;
use Merchenta\Util\CurlResponse;

class MerchentaAuth2UnitTest extends PHPUnit_Framework_TestCase {

	private $restClient;
	private $dataStore;
	private $merchentaAuth;
	private $clientId = "clientId";
	private $clientSecret = "clientSecret";

	public function setUp() {
		$this->restClient = $this->getMock('Merchenta\Util\RestClientInterface');
		$this->dataStore = $this->getMock('Merchenta\Auth\DataStoreInterface');
		$this->merchentaAuth = new MerchentaAuth($this->clientId, $this->clientSecret, new Config('test'), $this->restClient, $this->dataStore);
	}

	public function testGetAccessTokenFromAPI() {
		// Mock the response from the data store to get the token, false, so trigger the API.
		$this->dataStore->expects($this->once())
			->method('getAccessToken')
			->with($this->equalTo($this->clientId))
			->will($this->returnValue(false));

		// Mock the response of the API.
		$curlResponse = CurlResponse::create(JsonLoader::getAccessTokenJson(), array('http_code' => 200));
		$this->restClient->expects($this->once())
			->method('post')
			->with()
			->will($this->returnValue($curlResponse));

		// Save the token in the API.
		$this->dataStore->expects($this->once())
			->method('addAccessToken')
			->with(
				$this->equalTo($this->clientId),
				$this->equalTo('7180b331d590d95cfb1592489fb818b3d412d578'),
				$this->greaterThan(time() + 118 * 60));

		// Call the method to test.
        $token = $this->merchentaAuth->getAccessToken();

		// Assert the token value.
        $this->assertEquals('7180b331d590d95cfb1592489fb818b3d412d578', $token);
    }

    public function testGetAccessTokenFromStore() {
    	// Mock the response from the data store to get the token, false, so trigger the API.
		$this->dataStore->expects($this->once())
			->method('getAccessToken')
			->with($this->equalTo($this->clientId))
			->will($this->returnValue('token_value'));

		// Mock the response of the API.
		$this->restClient->expects($this->never())
			->method('post');

		// Save the token in the API.
		$this->dataStore->expects($this->never())
			->method('addAccessToken');

		// Call the method to test.
        $token = $this->merchentaAuth->getAccessToken();

		// Assert the token value.
        $this->assertEquals('token_value', $token);
    }

    public function testGetAccessTokenException() {
    	// Mock the response from the data store to get the token, false, so trigger the API.
		$this->dataStore->expects($this->once())
			->method('getAccessToken')
			->with($this->equalTo($this->clientId))
			->will($this->returnValue(false));

		// Mock the response of the API.
		$curlResponse = CurlResponse::create(JsonLoader::getErrorJson(), array('http_code' => 400));
		$this->restClient->expects($this->once())
			->method('post')
			->with()
			->will($this->returnValue($curlResponse));

		// Call the method to test.
		try {
			$token = $this->merchentaAuth->getAccessToken();
			$this->fail('\Merchenta\Exceptions\AuthException was expected.');
		} catch (\Merchenta\Exceptions\AuthException $e) {
			$this->assertEquals("UNKNOWN_DATA_TYPE: The data type 'not_a_real_data_type' is not recognized.", $e->getMessage());
		}
    }
}
