<?php

use Merchenta\Services\CampaignService;
use Merchenta\Util\Config;
use Merchenta\Util\CurlResponse;

class CampaignServiceUnitTest extends PHPUnit_Framework_TestCase {

	private $restClient;
	private $auth;
	private $campaignService;

	public function setUp() {
		$this->restClient = $this->getMock('\Merchenta\Util\RestClientInterface');
		$this->auth = $this->getMock('\Merchenta\Auth\MerchentaAuthInterface');
		$this->campaignService = new CampaignService($this->auth, new Config('test'), $this->restClient);
	}

	public function testGetCampaigns() {
		// Mock the authentication
		$this->auth->expects($this->once())
			->method('getAccessToken')
			->with()
			->will($this->returnValue('token'));

		// Mock the reponse of the API.
		$curlResponse = CurlResponse::create(JsonLoader::getCampaignsJson(), array('http_code' => 200));
		$this->restClient->expects($this->once())
			->method('get')
			->with($this->equalTo('https://test/api/campaign/'), $this->anything())
			->will($this->returnValue($curlResponse));

		$campaigns = $this->campaignService->get();

		// TODO
//		$this->assertEquals(1, count($campaigns));
//		$this->assertEquals('941e29f625f97b74620000e7', $campaigns[0]->campaign_id);
	}

	public function testGetCampaign() {
		// Mock the authentication
		$this->auth->expects($this->once())
			->method('getAccessToken')
			->with()
			->will($this->returnValue('token'));

		// Mock the reponse of the API.
		$curlResponse = CurlResponse::create(JsonLoader::getCampaignJson(), array('http_code' => 200));
		$this->restClient->expects($this->once())
			->method('get')
			->with($this->equalTo('https://test/api/campaign/code'), $this->anything())
			->will($this->returnValue($curlResponse));

		$campaigns = $this->campaignService->get('code');

		// TODO
//		$this->assertEquals(2, count($campaigns));
//		$this->assertEquals('941e29f625f97b74620000e7', $campaigns[0]->campaign_id);
	}
}
