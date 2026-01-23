<?php

use Cake\Core\Configure;
 
return [
    'HybridAuth' => [
        'providers' => [
            'Facebook' => [
                'enabled' => true,
                'keys' => [
                    'id' => '06868712828570',
                    'secret' => '041c83ce7984a6e5ceb0d2b63ac82f3c'
                ],
                'scope' => 'email, public_profile'
            ]
        ]
    ],
];

?>
