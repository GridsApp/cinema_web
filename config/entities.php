<?php

return [

    'times' => [
        'title' => 'Times',
        'slug' => 'times',
        'table' => 'times',
        'fields' => [
            'label'
        ],
        'pagination' => 20,
    ],

    'price-groups' => [
        'title' => 'Price Groups ',
        'pagination' => 20,
        'slug' => 'price-groups',
        'table' => 'price_groups',
        'fields' => [
            'label'
        ],
        'auto_create' => [
           'entity' => 'price-groups-zones',
           'values' => [
                'label' => 'Default',
                'color' => '#6b7280',
                'default' => 1,
                'price_group_id' => '{id}'
           ]
        ]
    ],

    'distributors' => [
        'title' => 'Distributors',
        'pagination' => 20,
        'slug' => 'distributors',
        'table' => 'distributors',
        'fields' => [
            // 'label',

        ]
    ],

    'price-groups-zones' => [
        'title' => 'Price Groups Zones',
        'pagination' => 20,
        'slug' => 'price-groups-zones',
        'table' => 'price_group_zones',
        'fields' => [
            'label',
            'color',
            'price',
            'price_groups',
            'default'

        ]
    ],

    'screen-types' => [
        'title' => 'Screen Types',
        'pagination' => 20,
        'table' => 'screen_types',
        'slug' => 'screen-types',
        'fields' => [
            'label',
            "display"
        ]
    ],

    'movie-genre' => [
        'title' => 'Genre',
        'pagination' => 20,
        'table' => 'movie_genres',
        'slug' => 'movie-genres',
        'fields' => [
            'label'
        ]
    ],





    'movie-casts' => [
        'title' => 'Cast',
        'pagination' => 20,
        'table' => 'movie_casts',
        'slug' => 'movie-casts',
        'fields' => [
            'name',
            'profile_image'
        ]
    ],







    'movie-languages' => [
        'title' => 'Languages',
        'pagination' => 20,
        'table' => 'movie_languages',
        'slug' => 'movie-languages',
        'fields' => [
            'label',

        ]
    ],





    'movie-age-ratings' => [
        'title' => 'Age Ratings',
        'pagination' => 20,
        'table' => 'movie_age_ratings',
        'slug' => 'movie-age-ratings',
        'fields' => [
            'label',

        ]
    ],





    'movie-director' => [
        'title' => 'Director',
        'pagination' => 20,
        'table' => 'movie_directors',
        'slug' => 'movie-directors',
        'fields' => [
            'name',

        ]
    ],

    'movies' => [
        'title' => 'Movies',
        'table' => 'movies',
        'form' => 'admin.forms.movie-form',
        'pagination' => 20,
        'slug' => 'movies',
        'fields' => [
            'movie_key',
            'name',
            'condensed_name',
            'description',
            'duration',
            'cast',
            'director',
            'genre',
            'language',
            'age_rating',
            'main_image',
            'cover_image',
            'youtube_video',
            'released_date',
            'imdb_rating',
            'imdb_vote',
            'youtube_video',




        ]


    ],

    'login' => [
        'title' => 'Login',
        'table' => 'movies',
        'form' => 'admin.forms.login-form',
        'pagination' => 20,
        'slug' => 'login',
        'fields' => [
            'first_name',
            'last_name',
            'email',
            'password',
          
        ]


    ],
    'movie-shows' => [
        'title' => 'Movie Shows',
        'form' => 'admin.forms.movie-show',
        'main' => 'pages.form',
        'table' => 'movie_shows',
        'pagination' => 20,
        'slug' => 'movie-shows',
        'fields' => [
            'movie',
            'date',
            'time',
            'screen_type',
            'theater'   ,
            'group',
            'movie_show_color'
        ]
    ],

    'branches' => [
        'title' => 'Branches',
        'table' => 'branches',
        'pagination' => 20,
        'slug' => 'branches',
        'fields' => [
            'label',

        ]


    ],

    'theaters' => [
        'title' => 'Theaters',
        'form' => 'admin.forms.theater-maps',
        'table' => 'theaters',
        'pagination' => 20,
        'slug' => 'theaters',
      
        'onsubmit'=>[
            [
                'name' => 'label',
                'value' => 'Theater {value}',
                'target' => 'hall_number'
            ]

        ],

        'fields' => [
            'label_hidden',
            'branch',
            'hall_number',
            'price_groups',

            'theater_map_json'

        ]


    ],







];
