<?php

$config = require 'production.php';

$config['phpSettings']['display_startup_errors'] = true;
$config['phpSettings']['display_errors']         = true;

$config['debug']['showExodusLinks'] = true;

$config['resources']['cacheManager']['service']['backend']['options']['cache_dir'] = APPLICATION_ROOT . '/cache';

unset($config['google']['analytics']['account']);
unset($config['services']['twitter']['oauth']);

return $config;