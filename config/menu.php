<?php

return [

    [
        'display' => true,
        'label' => 'Dashboard',
        'icon' => '<i class="fa-regular fa-grid-2"></i>',
        'link' => "/",
    ],




    [
        'display' => false,
        'label' => 'Account Settings',
        'icon' => '<i class="fa-regular fa-grid-2"></i>',
        'children' => [
            [
                'label' => 'Accounts',
                'link' => routeObject('entity', ['slug' => 'cms-users'])

            ],
            // [
            //     'label' => 'Manage Passwords',
            //     'link' => "/cms-user/manage-passwords"
            // ],
            [
                'label' => 'Roles & Permissions',
                'link' => "/cms-user/roles-permissions"
            ]
        ]

    ],




    [
        'display' => true,
        'label' => 'Movie Settings',
        'icon' => '<i class="fa-light fa-screwdriver-wrench"></i>',
        'children' => [
            [
                'label' => 'Distributors',
                'link' => routeObject('entity', ['slug' => 'distributors'])

            ],
            [
                'label' => 'Screen Types',
                'link' => routeObject('entity', ['slug' => 'screen-types'])
            ],
            [
                'label' => 'Movies',
                'link' => routeObject('entity', ['slug' => 'movies'])
            ],
            [
                'label' => 'Movie Shows',
                'link' => routeObject('entity', ['slug' => 'movie-shows'])
            ]
        ]

    ],
    [
        'display' => true,
        'label' => 'Branch Settings',
        'icon' => '<i class="fa-light fa-sitemap"></i>',
        'children' => [
            [
                'label' => 'Branches',
                'link' => routeObject('entity', ['slug' => 'branches'])
            ],
            [
                'label' => 'Price Groups',
                'link' => routeObject('entity', ['slug' => 'price-groups'])
            ],
            [
                'label' => 'Price Group Zones',
                'link' => routeObject('entity', ['slug' => 'price-group-zones'])
            ],
            [
                'label' => 'Theaters',
                'link' => routeObject('entity', ['slug' => 'theaters'])
            ],
            // [
            //     'label' => 'Systems',
            //     'link' => routeObject('entity' , ['slug'=> 'systems'])
            // ],

            // [
            //     'label' => 'Concessions',
            //     'link' => routeObject('entity' , ['slug'=> 'concessions'])
            // ],
            // [
            //     'label' => 'Cashiers',
            //     'link' => routeObject('entity' , ['slug'=> 'cashiers'])
            // ],
            // [
            //     'label' => 'Self Service Users',
            //     'link' => routeObject('entity' , ['slug'=> 'self-service-users'])
            // ]
        ],


    ],

    [
        'display' => true,
        'label' => 'Content',
        'icon' => '<i class="fa-solid fa-head-side-gear"></i>',
        'children' => [
            [
                'label' => 'Slideshows',
                'link' => routeObject('entity', ['slug' => 'slideshows'])
            ],
            [
                'label' => 'Faqs',
                'link' => routeObject('entity', ['slug' => 'faqs'])
            ],
            [
                'label' => 'Informative Pages',
                'link' => routeObject('entity', ['slug' => 'informative-pages'])
            ],



        ]
    ],
    [
        'display' => true,
        'label' => 'Settings',
        'icon' => '<i class="fa-regular fa-grid-2"></i>',
        'link' => "/settings",
    ],
    [
        'display' => true,
        'label' => 'Users',
        'icon' => '<i class="fa-duotone fa-solid fa-users"></i>',
        'link' => "/users",
    ],

    [
        'display' => true,
        'label' => 'Cinema Settings',
        'icon' => '<i class="fa-solid fa-head-side-gear"></i>',
        'children' => [
            [
                'label' => 'Rewards',
                'link' => routeObject('entity', ['slug' => 'rewards'])
            ],
           
            [
                'label' => 'Coupons',
                'link' => routeObject('entity', ['slug' => 'coupons'])
            ],
            [
                'label' => 'Items',
                'link' => routeObject('entity', ['slug' => 'items'])
            ],
           
        ]
    ],

    [
        'display' => true,
        'label' => 'POS Settings',
        'icon' => '<i class="fa-solid fa-head-side-gear"></i>',
        'children' => [
            [
                'label' => 'POS users',
                'link' => routeObject('entity', ['slug' => 'pos-users'])
            ],
            [
                'label' => 'Payment Methods',
                'link' => routeObject('entity', ['slug' => 'payment-methods'])
            ],
           



        ]
    ],





    
    // [
    //    'display' => true,
    //     'label' => 'Customer Settings',
    //     'icon' => '<i class="fa-solid fa-head-side-gear"></i>',
    //     'children' => [
    //         [
    //             'label' => 'Customers',
    //             'link' => routeObject('entity' , ['slug'=> 'customers'])
    //         ],
    //         [
    //             'label' => 'Cinema Cards',
    //             'link' => routeObject('entity' , ['slug'=> 'cinema-cards'])
    //         ],

    //     ]
    // ]


];
