<?php
namespace Merchenta;

use Merchenta\Auth\MerchentaAuth;
use Merchenta\Services\CampaignService;
use Merchenta\Util\Config;

define('MERCHENTA_VERSION', '0.0.1');

/**
 * Exposes all implemented Merchenta API functionality.
 *
 * @package Merchenta
 * @version 0.0.1
 * @author Baptiste Pernet
 * @link http://support.perfectaudience.com/knowledgebase/topics/35920-api-documentation
 */
class Merchenta {

	/**
	 * Handles interaction with the reporting.
	 * @var CampaignService
	 */
	protected $campaignService;

	/**
	 * Class constructor
	 * Get the authentication service and initiate all the service objects.
	 * @param string $clientId - Merchenta user id.
	 * @param string $clientSecret - Merchenta user password.
	 */
	public function __construct($clientId, $clientSecret, $endpoint) {
		$config = new Config($endpoint);
		$auth = new MerchentaAuth($clientId, $clientSecret, $config);
		$this->campaignService = new CampaignService($auth, $config);
	}

	/**
	 * Get the status of the reporting.
	 * Use the data status service to check when new performance data is available.
	 * @params string $dataType - type of report we get the date: campaign_report, ad_report, conversion_report
	 * @return string - The UTC timestamp at which the data source was last updated.
	 */
	public function getCampaigns($dataType) {
		return $this->campaignService->get();
	}
}
