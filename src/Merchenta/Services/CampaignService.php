<?php
namespace Merchenta\Services;

use Merchenta\Util\Config;

/**
 * Performs all actions pertaining to tthe campaign of Merchenta.
 *
 * @package Services
 * @author  Baptiste Pernet
 */
class CampaignService extends BaseService {

	/**
	 * Get the campaign specified by code, or all the campaigns when null.
	 * @param string $code - optional, null means all campaign, otherwise the specific campaign to retrieve
	 * @return object - The campaign object or a list of campaign object.
	 */
	public function get($code = null) {
		// Get the url to query.
		$url = $this->config->get('endpoints.base_url') . $this->config->get('endpoints.campaign');
		if (!is_null($code)) {
			$url .= $code;
		}

		// Do the query to the API and read the response.
		$response = $this->getRestClient()->get($url, $this->getHeaders());
		$jsonResponse = json_decode($response->body);

		// Return the object.
		return $jsonResponse;
	}
}
