<?php
namespace Merchenta\Util;

/**
 * Configuration class to hold endpoints, urls, errors messages etc.
 *
 * @package	 Util
 * @author	 Baptiste Pernet
 */
class Config {

	/**
	 * @var array - array of configuration properties
	 */
	private $props = array(

		/**
		 * REST endpoints, ENDPOINT is replaced with the
		 * according enpoint provided at initialization of the library.
		 */
		'endpoints' => array(
			'base_url' => 'https://ENDPOINT/api/',
			'auth' => 'auth/',
			'campaign' => 'campaign/',
		),
	);

	/**
	 * @var string - endpoint to use.
	 */
	private $endpoint;

	/**
	 * Build the configuration with the given enpoint. The endpoint is specific to the user
	 * and is provided by Merchenta support. You can have a sandbox enpoint or a porduction endpoint.
	 * @param string $endpoint - endpoint to use.
	 */
	public function __construct($endpoint) {
		$this->endpoint = $endpoint;
	}

	/**
	 * Get a configuration property given a specified location, example usage: Config::get('auth.token_endpoint')
	 * @param $index - location of the property to obtain
	 * @return string
	 */
	public function get($index) {
		$index = explode('.', $index);
		$value = $this->getValue($index, $this->props);
		return str_replace('ENDPOINT', $this->endpoint, $value);
	}

	/**
	 * Navigate through a config array looking for a particular index
	 * @param array $index The index sequence we are navigating down
	 * @param array $value The portion of the config array to process
	 * @return mixed
	 */
	private function getValue($index, $value) {
		if (is_array($index) && count($index)) {
			$current_index = array_shift($index);
		}
		if (is_array($index) && count($index) && is_array($value[$current_index]) && count($value[$current_index])) {
			return $this->getValue($index, $value[$current_index]);
		} else {
			return $value[$current_index];
		}
	}
}
