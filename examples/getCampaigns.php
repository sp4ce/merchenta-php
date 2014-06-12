<!DOCTYPE HTML>
<html>
<head>
    <title>Merchenta API v1 Display data status example</title>
    <link href="//netdna.bootstrapcdn.com/twitter-bootstrap/2.3.1/css/bootstrap-combined.min.css" rel="stylesheet">
</head>

<?php
// Load the library.
require_once '../src/Merchenta/autoload.php';

use Merchenta\Merchenta;
use Merchenta\Exceptions\MerchentaException;

// Enter here your access to Merchenta
define('CLIENT_ID', 'ENTER YOUR API KEY');
define('CLIENT_SECRET', 'ENTER YOUR ACCESS TOKEN');

$pa = new Merchenta(CLIENT_ID, CLIENT_SECRET);

try {
	$campaignStatus = $pa->getCampaigns();
} catch(MerchentaException $e) {
	$error = $e->getMessage();
}
?>

<?php if (isset($error)) { ?>
<div><?=$error?></div>
<?php } else { ?>
<ul>
	<?php foreach ($campaigns as $campaign) { ?>
	<li>
		Code: <?=$campaign->code?>
		<ul>
			<li><?=$campaign->mediaType?></li>
			<li><?=$campaign->creativeFile?></li>
		</ul>
	</li>
	<?php } ?>
</ul>
<?php } ?>