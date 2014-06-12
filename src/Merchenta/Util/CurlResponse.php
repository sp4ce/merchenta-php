<?php

namespace Merchenta\Util;

/**
 * A CurlResponse object to be returned from a RestClientInterface implementation
 *
 * @package	 Util
 * @author	 Baptiste Pernet
 */
class CurlResponse {

	public $body;
	public $error;
	public $info;

	public static function create($body, $info, $error = null) {
		$curl = new CurlResponse();

		$curl->body = $body;
		$curl->info = $info;
		$curl->error = $error;

		return $curl;
	}
}
