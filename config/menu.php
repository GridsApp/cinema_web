<?php

return [
  
    [
        'key' => 'dashbord',
        'display' => true,
        'label' => 'Dashboard',
        'icon' => '<i class="fa-regular fa-grid-2"></i>',
        'link' => "/cms",
        'entity' => 'dashbord',
        'permissions' => [
            [
                'label' => 'Create',
                'key' => 'cms-user-toggle'
            ]

        ]
    ],
    [
        'display' => true,
        'label' => 'Movie Settings',
        'icon' => '<i class="fa-light fa-screwdriver-wrench"></i>',
        'children' => [

            [

                'key' => 'movies',
                'label' => 'Movies',
                'link' => routeObject('entity', ['slug' => 'movies']),

            ],
            [
                'key' => 'movie-shows',
                'label' => 'Movie Shows',
                'link' => routeObject('entity', ['slug' => 'movie-shows']),
                'permissions' => [
                    [
                        'label' => 'Can drag',
                        'key' => 'can-drag'
                    ]

                ]
            ],
            [
                'key' => 'manage-shows',
                'label' => 'Manage Shows',
                'link' => "/cms/manage/bookings",
                'permissions' => [
                    [
                        'label' => 'Can Toggle Show',
                        'key' => 'can-toggle-show'
                    ]

                ]
            ],
            [
                // 'display' => false,
                'key' => 'distributors',
                'label' => 'Distributors',
                'link' => routeObject('entity', ['slug' => 'distributors'])

            ],

            [
                'key' => 'screen-type',
                'label' => 'Screen Types',
                'link' => routeObject('entity', ['slug' => 'screen-types'])
            ]
        ]

    ],

    [
        'display' => false,
        'label' => 'Account Settings',
        'icon' => '<i class="fa-regular fa-grid-2"></i>',
        'children' => [
            [
                'label' => 'Accounts',
                'link' => routeObject('entity', ['slug' => 'cms-users']),
                'key' => 'accounts',

            ],
        ]
    ],


    [

        'display' => true,
        'label' => 'Branch Settings',
        'icon' => '<i class="fa-light fa-sitemap"></i>',
        'children' => [
            [
                'key' => 'branches',
                'label' => 'Branches',
                'link' => routeObject('entity', ['slug' => 'branches'])
            ],

            [
                'key' => 'theaters',
                'label' => 'Theaters',
                'link' => routeObject('entity', ['slug' => 'theaters'])
            ],
            // [
            //     'key' => 'seat-types',
            //     'label' => 'Seat Types',
            //     'link' => routeObject('entity', ['slug' => 'seat-types'])
            // ],
            [
                'key' => 'price-groups',
                'label' => 'Price Groups',
                'link' => routeObject('entity', ['slug' => 'price-groups'])
            ],
            [
                'key' => 'price-group-zones',
                'display' => false,
                'label' => 'Price Group Zones',
                'link' => '/price-groups/{id}/zones',
                'permissions' => [
                    [
                        'label' => 'Edit Zone',
                        'key' => 'edit-zone'
                    ],
                    [
                        'label' => 'Delete Zone',
                        'key' => 'delete-zone'
                    ],
                 
                ]

            ]
        ],
    ],




    [
        'display' => true,
        'label' => 'User Settings',
        'icon' => '<i class="fa-duotone fa-solid fa-users"></i>',
        'children' => [
            [
                'key' => 'users',
                'label' => 'Users',
                'link' => routeObject('entity', ['slug' => 'users'])
            ],
            [
                'key' => 'manage-wallets',
                'label' => 'Manage Wallets',
                'link' => "/cms/manage/wallets",
                'permissions' => [
                    [
                        'label' => 'View Transaction',
                        'key' => 'view-transactions'
                    ],
                    [
                        'label' => 'Make Transaction',
                        'key' => 'make-transaction'
                    ]
                ]
            ],


        ]
    ],
    [
        'display' => true,
        'label' => 'Purchases',
        'icon' => '<i class="fa-solid fa-head-side-gear"></i>',
        'children' => [

            [
                'key' => 'payment-methods',
                'label' => 'Payment Methods',
                'link' => routeObject('entity', ['slug' => 'payment-methods'])
            ],


            [
                'key' => 'orders',
                'label' => 'Orders ',
                'link' => routeObject('entity', ['slug' => 'orders'])
            ],

        ]
    ],

    [
        'display' => true,
        'label' => 'Settings',
        'icon' => '<i class="fa-solid fa-head-side-gear"></i>',
        'children' => [
            [
                'key' => 'settings',
                'label' => 'Settings',
                'link' => routeObject('entity', ['slug' => 'settings'])
            ],
            [
                'key' => 'kiosk-users',
                'label' => 'Kiosk users',
                'link' => routeObject('entity', ['slug' => 'kiosk-users'])
            ],
            [
                'key' => 'pos-users',
                'label' => 'POS users',
                'link' => routeObject('entity', ['slug' => 'pos-users'])

            
            ],

            [
                'key' => 'rewards',
                'label' => 'Rewards',
                'link' => routeObject('entity', ['slug' => 'rewards'])
            ],

            [
                'key' => 'coupons',
                'label' => 'Coupons',
                'link' => routeObject('entity', ['slug' => 'coupons'])
            ],
            [
                'label' => 'Items',
                'link' => routeObject('entity', ['slug' => 'items'])
            ],
            [
                'key' => 'list-items',
                'label' => 'List Items',
                'link' => "/cms/items/list",
                'permissions' => [
                    [
                        'label' => 'Edit',
                        'key' => 'edit-list-items'
                    ],
                    [
                        'label' => 'Delete',
                        'key' => 'delete-list-items'
                    ]

                ]
            ],

        ]
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
        'label' => 'Website',
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
                'label' => 'Home Paragraph Banner',
                'link' => routeObject('entity', ['slug' => 'home-paragraph-banners'])

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


    [
        'display' => true,
        'label' => 'Permissions',
        'icon' => '<i class="fa-solid fa-head-side-gear"></i>',
        'children' => [
            [
                'label' => 'CMS User Roles',
                'link' => routeObject('entity', ['slug' => 'cms-user-roles'])
            ],
            [
                'label' => 'CMS Permissions',
                'link' => routeObject('entity', ['slug' => 'cms-permissions'])
            ],
            [
                'label' => 'CMS User Role Permission',
                'link' => routeObject('entity', ['slug' => 'cms-user-role-permission'])
            ],





        ]
    ],

    [
        'display' => true,
        'label' => 'Notifiactions',
        'icon' => '<i class="fa-solid fa-head-side-gear"></i>',
        'children' => [
            [
                'key' => 'cms-push-notification-templates',
                'label' => 'CMS Push Notification templates',
                'link' => routeObject('entity', ['slug' => 'cms-push-notification-templates'])
            ],
            [
                'key' => 'cms-sent-push-notifications',
                'label' => 'CMS Sent Push Notifications',
                'link' => routeObject('entity', ['slug' => 'cms-sent-push-notifications'])
            ],
          


        ]
    ],
];
