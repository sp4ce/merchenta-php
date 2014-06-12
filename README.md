Merchenta PHP SDK
===================
[![Build Status](https://secure.travis-ci.org/sp4ce/merchenta-php.png?branch=master)](http://travis-ci.org/sp4ce/merchenta-php
## Installation

### Manual Installation
1. Download and extract the project into an appropriate place in your application.
2. Require the SDK's autoloader. (note: the path to include the autoload may be different depending on the structure of your application)
```
require '/src/Merchenta/autoload.php'
```

## Usage
Once built in autoloader has been required, you can begin using the SDK.
```php
use Merchenta\Merchenta;
$merchenta = new Merchenta('user_id', 'user_pwd');

$campaigns = $merchenta->getCampaigns();
```
## Minimum Requirements
Use of this library requires PHP 5.3+, and PHP cURL extension (http://php.net/manual/en/book.curl.php)
