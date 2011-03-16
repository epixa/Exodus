<?php

return array(
    'begin' => array(
        'route' => 'begin/*',
        'defaults' => array(
            'module' => 'exodus',
            'controller' => 'index',
            'action' => 'index'
        ),
    ),
    'auth' => array(
        'route' => 'auth/*',
        'defaults' => array(
            'module' => 'exodus',
            'controller' => 'index',
            'action' => 'auth'
        ),
    ),
    'load' => array(
        'route' => 'u/:u',
        'defaults' => array(
            'module' => 'exodus',
            'controller' => 'index',
            'action' => 'load'
        ),
    ),
    'logout' => array(
        'route' => 'logout',
        'defaults' => array(
            'module' => 'exodus',
            'controller' => 'index',
            'action' => 'logout'
        ),
    )
);