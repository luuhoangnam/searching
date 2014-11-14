<?php

return [
    'default'     => 'elasticsearch',
    'connections' => [
        'elasticsearch' => [
            'driver' => 'elasticsearch',
            'hosts'  => [
                'localhost'
            ]
        ],
    ],
];