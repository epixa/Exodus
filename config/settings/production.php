<?php

return array(
    'phpSettings' => array(
        'display_startup_errors' => false,
        'display_errors' => false,
        'date' => array(
            'timezone' => 'America/New_York'
        )
    ),
    'bootstrap' => array(
        'path' => APPLICATION_PATH . '/Bootstrap.php'
    ),
    'resources' => array(
        'frontController' => array(
            'moduleDirectory' => APPLICATION_PATH,
            'env' => APPLICATION_ENV,
            'actionHelperPaths' => array(
                'Epixa\\Controller\\Helper\\' => 'Epixa/Controller/Helper'
            )
        ),
        'modules' => array(),
        'router' => array(
            'file' => APPLICATION_ROOT . '/config/routes.php'
        ),
        'view' => array(),
        'layout' => array(
            'layoutPath' => APPLICATION_ROOT . '/layouts',
            'layout' => 'default'
        ),
        'cacheManager' => array(
            'service' => array(
                'frontend' => array(
                    'name' => 'Core',
                    'options' => array(
                        'lifetime' => 7200,
                        'automatic_serialization' => true
                    )
                ),
                'backend' => array(
                    'name' => 'File',
                    'options' => array()
                )
            )
        )
    ),
    'google' => array(
        'analytics' => array(
            'account' => '' // UA-XXXXXXX-X
        )
    ),
    'debug' => array(
        'renderExceptions' => false, // enable to render any exceptions to screen: do NOT enable in production
        'showExodusLinks' => false // enable to show an exodus link for each person on friends table
    ),
    'services' => array(
        'twitter' => array(
            'url' => 'https://api.twitter.com',
            'cache' => array(
                'friends' => 43200 // 12 hours
            ),
            'oauth' => array( // remove or unset entire oauth array to disable
                'callbackUrl' => 'http://CURRENT_DOMAIN/begin',
                'siteUrl' => 'https://api.twitter.com/oauth',
                'consumerKey' => 'TWITTER_CONSUMER_KEY',
                'consumerSecret' => 'TWITTER_CONSUMER_SECRET'
            )
        ),
        'identica' => array(
            'url' => 'http://identi.ca/api',
            'cache' => array(
                'userFound' => null, // indefinitely
                'userNotFound' => 21600 // 6 hours
            )
        )
    )
);