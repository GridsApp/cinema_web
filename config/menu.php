<?php

return [

    [
        'display' => true,
        'label' => 'Dashboard',
        'icon' => '<i class="fa-regular fa-grid-2"></i>',
        'link' => "/cms",
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
        
            [
                'label' => 'Roles & Permissions',
                'link' => "/cms/cms-user/roles-permissions"
            ]
        ]

    ],




    [
        'display' => true,
        'label' => 'Movie Settings',
        'icon' => '<i class="fa-light fa-screwdriver-wrench"></i>',
        'children' => [

            [
                'label' => 'Movies',
                'link' => routeObject('entity', ['slug' => 'movies'])
            ],
            [
                'label' => 'Movie Shows',
                'link' => routeObject('entity', ['slug' => 'movie-shows'])
            ],
            [
                'label' => 'Manage Shows',
                'link' => "/cms/manage/bookings"
            ],
            [
                'label' => 'Distributors',
                'link' => routeObject('entity', ['slug' => 'distributors'])

            ],
        
            [
                'label' => 'Screen Types',
                'link' => routeObject('entity', ['slug' => 'screen-types'])
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
                'label' => 'Theaters',
                'link' => routeObject('entity', ['slug' => 'theaters'])
            ],
            [
                'label' => 'Price Groups',
                'link' => routeObject('entity', ['slug' => 'price-groups'])
            ],
            [
                'label' => 'Price Group Zones',
                'link' => routeObject('entity', ['slug' => 'price-group-zones'])
            ]
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
        'label' => 'User Settings',
        'icon' => '<i class="fa-duotone fa-solid fa-users"></i>',
        'children' => [
            [
                'label' => 'Users',
                'link' => routeObject('entity', ['slug' => 'users'])
            ],
            [
                'label' => 'Manage Wallets',
                'link' => "/cms/manage/wallets", 
            ]
        ]
    ],

    [
        'display' => true,
        'label' => 'Settings',
        'icon' => '<i class="fa-solid fa-head-side-gear"></i>',
        'children' => [
            [
                'label' => 'Settings',
                'link' => routeObject('entity', ['slug' => 'settings'])
            ],
            [
                'label' => 'Kiosk users',
                'link' => routeObject('entity', ['slug' => 'kiosk-users'])
            ],
            [
                'label' => 'POS users',
                'link' => routeObject('entity', ['slug' => 'pos-users'])
            ],
         
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
            [
                'label' => 'Payment Methods',
                'link' => routeObject('entity', ['slug' => 'payment-methods'])
            ],
           
        ]
    ],


    [
        'display' => true,
        'label' => 'About Section',
        'icon' => '<i class="fa-regular fa-grid-2"></i>',
        'children' => [

            [
                'label' => 'Cinema Statistics',
                'link' => routeObject('entity', ['slug' => 'cinema-statistics'])

            ],
            [
                'label' => 'Banners',
                'link' => routeObject('entity', ['slug' => 'about-banners'])

            ],
            [
                'label' => 'Paragraphs',
                'link' => routeObject('entity', ['slug' => 'about-paragraphs'])

            ],
            [
                'label' => 'Company Purposes',
                'link' => routeObject('entity', ['slug' => 'company-purposes'])

            ],

            [
                'label' => 'Cinema Founders',
                'link' => routeObject('entity', ['slug' => 'cinema-founders'])

            ],
            [
                'label' => 'Cinema Growth Plans',
                'link' => routeObject('entity', ['slug' => 'cinema-growth-plans'])

            ],
            [
                'label' => 'Board Members',
                'link' => routeObject('entity', ['slug' => 'board-members'])

            ],


           
        
        
        ]

    ],

  

];
