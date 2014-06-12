<?php
require_once('SplClassLoader.php');

// Load the Merchenta namespace
$loader = new \Merchenta\SplClassLoader('Merchenta', dirname(__DIR__));
$loader->register();
