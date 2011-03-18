<?php

$config = require 'production.php';

$config['phpSettings']['display_startup_errors'] = true;
$config['phpSettings']['display_errors']         = true;

$config['debug']['showExodusLinks'] = true;

unset($config['google']['analytics']['account']);

return $config;