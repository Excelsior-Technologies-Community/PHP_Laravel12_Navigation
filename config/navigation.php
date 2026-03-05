<?php

return [
    'items' => [
        [
            'title' => 'Home',
            'route' => 'home',
        ],
        [
            'title' => 'About',
            'route' => 'about',
        ],
        [
            'title' => 'Services',
            'route' => 'services',
            'children' => [
                [
                    'title' => 'Web Development',
                    'route' => 'services.web',
                ],
                [
                    'title' => 'Mobile App',
                    'route' => 'services.mobile',
                ],
            ],
        ],
        [
            'title' => 'Contact',
            'route' => 'contact',
        ],
    ],
];