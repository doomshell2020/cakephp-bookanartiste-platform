<?php
$baseDir = dirname(dirname(__FILE__));
return [
    'plugins' => [
        'Auth' => $baseDir . '/plugins/Auth/',
        'Bake' => $baseDir . '/vendor/cakephp/bake/',
        'CakeJs' => $baseDir . '/vendor/oldskool/cakephp-js/',
        'CsvView' => $baseDir . '/vendor/friendsofcake/cakephp-csvview/',
        'DebugKit' => $baseDir . '/vendor/cakephp/debug_kit/',
        'Migrations' => $baseDir . '/vendor/cakephp/migrations/',
        'SocialShare' => $baseDir . '/vendor/drmonkeyninja/cakephp-social-share/',
        'src' => $baseDir . '/plugins/src/'
    ]
];