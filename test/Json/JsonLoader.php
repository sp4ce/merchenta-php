<?php

class JsonLoader {

	const AUTH_FOLDER = '/Auth';
	const CAMPAIGN_FOLDER = '/Campaign';

	public static function getAccessTokenJson() {
		return file_get_contents(__DIR__ . self::AUTH_FOLDER . '/access_token.json');
	}

	public static function getCampaignsJson() {
		return file_get_contents(__DIR__ . self::CAMPAIGN_FOLDER . '/campaigns.json');
	}

	public static function getCampaignJson() {
		return file_get_contents(__DIR__ . self::CAMPAIGN_FOLDER . '/campaigns.json');
	}

	public static function getErrorJson() {
		return file_get_contents(__DIR__ . '/error.json');
	}
}
