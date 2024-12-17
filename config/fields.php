<?php

return [

    "id" => [
        'id' => uniqid(),
        'livewire' => [
            'wire:model' => 'form.{name}',
        ],
        'type' => \twa\cmsv2\Entities\FieldTypes\Textfield::class,
        'label' => 'ID',
        'placeholder' => 'ID',
        'name' => 'id'
    ],


    "slug" => [
        'id' => uniqid(),
        'livewire' => [
            'wire:model' => 'form.{name}',
        ],
        'type' => \twa\cmsv2\Entities\FieldTypes\Textfield::class,
        'label' => 'Slug',
        'placeholder' => 'Slug',
        'name' => 'slug',
    ],


    "title" => [
        'id' => uniqid(),
        'livewire' => [
            'wire:model' => 'form.{name}',
        ],
        'type' => \twa\cmsv2\Entities\FieldTypes\Textfield::class,
        'label' => 'Title',
        'placeholder' => 'Title',
        'name' => 'title',
    ],



    "created_at" => [
        'id' => uniqid(),
        'livewire' => [
            'wire:model' => 'form.{name}',
        ],
        'type' => \twa\cmsv2\Entities\FieldTypes\Datetime::class,
        'label' => 'Created',
        'placeholder' => 'Created at',
        'name' => 'created_at'
    ],

    "updated_at" => [
        'id' => uniqid(),
        'livewire' => [
            'wire:model' => 'form.{name}',
        ],
        'type' => \twa\cmsv2\Entities\FieldTypes\Datetime::class,
        'label' => 'Updated',
        'placeholder' => 'Updated at',
        'name' => 'updated_at'
    ],


    "converted_at" => [
        'id' => uniqid(),
        'livewire' => [
            'wire:model' => 'form.{name}',
        ],
        'type' => \twa\cmsv2\Entities\FieldTypes\Datetime::class,
        'label' => 'Converted',
        'placeholder' => 'Converted at',
        'name' => 'converted_at'
    ],

    "completed_at" => [
        'id' => uniqid(),
        'livewire' => [
            'wire:model' => 'form.{name}',
        ],
        'type' => \twa\cmsv2\Entities\FieldTypes\Datetime::class,
        'label' => 'Completed',
        'placeholder' => 'Completed at',
        'name' => 'completed_at'

    ],


    "display" => [
        'id' => uniqid(),
        'livewire' => [
            'wire:model' => 'form.{name}',
        ],
        'type' => \twa\cmsv2\Entities\FieldTypes\Toggle::class,
        'label' => 'Display',
        'placeholder' => 'Display',
        'name' => 'display'
    ],
    "one_time_usage" => [
        'id' => uniqid(),
        'livewire' => [
            'wire:model' => 'form.{name}',
        ],
        'type' => \twa\cmsv2\Entities\FieldTypes\Toggle::class,
        'label' => 'One Time Usage',
        'placeholder' => 'One Time Usage',
        'name' => 'one_time_usage'
    ],

    "movie_show_color" => [
        'id' => uniqid(),
        'livewire' => [
            'wire:model' => 'form.{name}',
        ],
        'type' =>  \twa\cmsv2\Entities\FieldTypes\Colorpicker::class,
        'label' => 'Color',
        'placeholder' => 'Choose color',
        'name' => 'color'
    ],

    'label' => [
        'id' => uniqid(),
        'livewire' => [
            'wire:model' => 'form.{name}',
        ],
        // 'type' => \twa\cmsv2\Entities\FieldTypes\Textfield::class,

        'type' => \twa\cmsv2\Entities\FieldTypes\Textfield::class,

        'label' => 'Label',
        'placeholder' => 'Enter label',
        'name' => 'label',

        'container' => 'col-span-6',
    ],


    'action' =>[
        'id' => uniqid(),
        'livewire' => [
            'wire:model' => 'form.{name}',
        ],

        'type' => \twa\cmsv2\Entities\FieldTypes\Textfield::class,
        'label' => 'Action',
        'placeholder' => 'Enter Action',
        'name' => 'action',

        'container' => 'col-span-6',
    ],

    'theater_map_json' => [
        'id' => uniqid(),
        'livewire' => [
            'wire:model' => 'form.{name}',
        ],
        'type' => \twa\cmsv2\Entities\FieldTypes\TheaterMap::class,
        'label' => 'Theater Map',
        'placeholder' => 'Theater Map',
        'name' => 'theater_map',
        'listen' =>  [
            "init" => "pricegroupselectedvalue",
            "change" =>  "pricegroupchangedvalue"
        ],

    ],
    // 'theater_map' => [
    //     'id' => uniqid(),
    //     'livewire' => [
    //         'wire:model' => 'form.{name}',
    //     ],
    //     'type' => \twa\cmsv2\Entities\FieldTypes\Map::class,
    //     'label' => 'Theater Map',
    //     'placeholder' => 'Theater Map',
    //     'name' => 'theater_map',
    //     'listen' =>  [
    //         "init" => "pricegroupselectedvalue",
    //         "change" =>  "pricegroupchangedvalue"
    //     ]
    // ],

    'group' => [
        'id' => uniqid(),
        'livewire' => [
            'wire:model' => 'form.{name}',
        ],
        'type' => \twa\cmsv2\Entities\FieldTypes\Hidden::class,
        'label' => 'Group',
        'placeholder' => 'Enter Group',
        'name' => 'group'
    ],

    'label_hidden' => [
        'id' => uniqid(),
        'livewire' => [
            'wire:model' => 'form.{name}',
        ],
        'type' => \twa\cmsv2\Entities\FieldTypes\Hidden::class,
        'label' => 'Label',
        'placeholder' => 'Enter label',
        'name' => 'label'
    ],

    'movie_key' => [
        'id' => uniqid(),
        'livewire' => [
            'wire:model' => 'form.{name}',
        ],
        'type' => \twa\cmsv2\Entities\FieldTypes\Textfield::class,
        'label' => 'Movie Key (ex. tt3501632)',
        'placeholder' => 'Enter movie key',
        'name' => 'movie_key'
    ],
    'key' => [
        'id' => uniqid(),
        'livewire' => [
            'wire:model' => 'form.{name}',
        ],
        'type' => \twa\cmsv2\Entities\FieldTypes\Textfield::class,
        'label' => 'Key',
        'placeholder' => 'Enter key',
        'name' => 'key'
    ],
    'movie_name' => [
        'id' => uniqid(),
        'livewire' => [
            'wire:model' => 'form.{name}',
        ],
        'type' => \twa\cmsv2\Entities\FieldTypes\Textfield::class,
        'label' => 'Name',
        'placeholder' => 'Enter Movie Name',
        'name' => 'name'
    ],

    'name' => [
        'id' => uniqid(),
        'livewire' => [
            'wire:model' => 'form.{name}',
        ],
        'type' => \twa\cmsv2\Entities\FieldTypes\Textfield::class,
        'label' => 'Name',
        'placeholder' => 'Enter Name',
        'name' => 'name'
    ],

    'condensed_name' => [
        'id' => uniqid(),
        'livewire' => [
            'wire:model' => 'form.{name}',
        ],
        'type' => \twa\cmsv2\Entities\FieldTypes\Textfield::class,
        'label' => 'Condensed name',
        'placeholder' => 'Enter Movie Condensed Name',
        'name' => 'condensed_name'
    ],

    'description' => [
        'id' => uniqid(),
        'livewire' => [
            'wire:model' => 'form.{name}',
        ],
        'type' => \twa\cmsv2\Entities\FieldTypes\Textarea::class,
        'label' => 'Description',
        'placeholder' => 'Enter description',
        'name' => 'description'
    ],
    'duration' => [
        'id' => uniqid(),
        'livewire' => [
            'wire:model' => 'form.{name}',
        ],
        'type' => \twa\cmsv2\Entities\FieldTypes\Number::class,
        'label' => ' Duration in Minutes',
        'placeholder' => 'Enter duration',
        'name' => 'duration'
    ],


    'nb_seats' => [
        'id' => uniqid(),
        'livewire' => [
            'wire:model' => 'form.{name}',
        ],
        'type' => \twa\cmsv2\Entities\FieldTypes\Number::class,
        'label' => 'NB  Seats ',
        'placeholder' => 'NB seats',
        'name' => 'nb_seats'
    ],

    'date' => [
        'id' => uniqid(),
        'livewire' => [
            'wire:model' => 'form.{name}',
        ],
        'type' => \twa\cmsv2\Entities\FieldTypes\Date::class,
        'label' => 'Date',
        'placeholder' => 'Enter date',
        'name' => 'date'
    ],



    'genre' => [
        'id' => uniqid(),
        'livewire' => [
            'wire:model' => 'form.{name}',
        ],
        'type' => \twa\cmsv2\Entities\FieldTypes\Select::class,
        'label' => 'Genres',
        'placeholder' => 'Select movie genre',
        'name' => 'genre_id',
        'multiple' => true,
        'visible_selections' => 3,
        'query_limit' => 50,
        'quick_add' => 'movie-genres',
        'options' => [
            'type' => 'query',
            'table' => 'movie_genres',
            'field' => 'label'
        ]
    ],
    'cast' => [
        'id' => uniqid(),
        'livewire' => [
            'wire:model' => 'form.{name}',
        ],
        'type' => \twa\cmsv2\Entities\FieldTypes\Select::class,
        'label' => 'Cast',
        'placeholder' => 'Select movie casts',
        'name' => 'cast_id',
        'multiple' => true,
        'visible_selections' => 2,
        'query_limit' => 50,
        'quick_add' => 'movie-casts',
        'options' => [
            'type' => 'query',
            'table' => 'movie_casts',
            'field' => 'name'
        ]
    ],
    'director' => [
        'id' => uniqid(),
        'livewire' => [
            'wire:model' => 'form.{name}',
        ],
        'type' => \twa\cmsv2\Entities\FieldTypes\Select::class,
        'label' => 'Director',
        'placeholder' => 'Select movie director',
        'name' => 'director_id',
        'multiple' => false,
        'visible_selections' => 3,
        'query_limit' => 50,
        'quick_add' => 'movie-directors',
        'options' => [
            'type' => 'query',
            'table' => 'movie_directors',
            'field' => 'name'
        ]
    ],
    'language' => [
        'id' => uniqid(),
        'livewire' => [
            'wire:model' => 'form.{name}',
        ],
        'type' => \twa\cmsv2\Entities\FieldTypes\Select::class,
        'label' => 'Language',
        'placeholder' => 'Select movie language',
        'name' => 'language_id',
        'multiple' => false,
        'visible_selections' => 3,
        'query_limit' => 50,
        'quick_add' => 'movie-languages',
        'options' => [
            'type' => 'query',
            'table' => 'movie_languages',
            'field' => 'label'
        ]
    ],
    'system' => [
        'id' => uniqid(),
        'livewire' => [
            'wire:model' => 'form.{name}',
        ],
        'type' => \twa\cmsv2\Entities\FieldTypes\Select::class,
        'label' => 'Systems',
        'placeholder' => 'Select systems',
        'name' => 'system_id',
        'multiple' => true,
        'visible_selections' => 3,
        'query_limit' => 50,
        'quick_add' => null,
        'options' => [
            'type' => 'query',
            'table' => 'systems',
            'field' => 'label'
        ]
    ],
    'age_rating' => [
        'id' => uniqid(),
        'livewire' => [
            'wire:model' => 'form.{name}',
        ],
        'type' => \twa\cmsv2\Entities\FieldTypes\Select::class,
        'label' => 'Age Rating',
        'placeholder' => 'Select age',
        'name' => 'age_rating_id',
        'multiple' => false,
        'query_limit' => 50,
        'quick_add' => 'movie-age-ratings',
        'options' => [
            'type' => 'query',
            'table' => 'movie_age_ratings',
            'field' => 'label'
        ]
    ],

    'price_group_zone' => [
        'id' => uniqid(),
        'livewire' => [
            'wire:model' => 'form.{name}',
        ],
        'type' => \twa\cmsv2\Entities\FieldTypes\Select::class,
        'label' => 'Zone',
        'placeholder' => 'Select zone',
        'name' => 'price_group_zone_id',
        'multiple' => true,
        'visible_selections' => 5,
        'options' => [
            'type' => 'query',
            'table' => 'price_group_zones',
            'parent' => [
                'table' => 'price_groups',
                'key' => 'price_group_id',
                'field' => 'label',
            ],
            'field' => 'label'
        ]
    ],

    'image' => [
        'id' => uniqid(),
        'livewire' => [
            'wire:model' => 'form.{name}',
        ],
        'type' => \twa\cmsv2\Entities\FieldTypes\FileUpload::class,
        'label' => 'Image',
        'placeholder' => 'Upload Image',
        'name' => 'image',
        'aspect_ratio' => 1 / 1,
        'multiple' => false
    ],
    'main_image' => [
        'id' => uniqid(),
        'livewire' => [
            'wire:model' => 'form.{name}',
        ],
        'type' => \twa\cmsv2\Entities\FieldTypes\FileUpload::class,
        'label' => 'Main Image',
        'placeholder' => 'Upload Image',
        'name' => 'main_image',
        'aspect_ratio' => 2 / 3,
        'multiple' => false
    ],

    'cover_image' => [
        'id' => uniqid(),
        'livewire' => [
            'wire:model' => 'form.{name}',
        ],
        'type' => \twa\cmsv2\Entities\FieldTypes\FileUpload::class,
        'label' => 'Cover Image',
        'placeholder' => 'Upload Image',
        'aspect_ratio' => 3 / 2,
        'quality' => 50,
        'name' => 'cover_image',
        'multiple' => false
    ],
    'youtube_video' => [
        'id' => uniqid(),
        'livewire' => [
            'wire:model' => 'form.{name}',
        ],
        'type' => \twa\cmsv2\Entities\FieldTypes\Textfield::class,
        'label' => 'Youtube Video',
        'placeholder' => 'Enter Youtube Video Link',
        'name' => 'youtube_video'
    ],
    'payment_method_id' => [
        'id' => uniqid(),
        'livewire' => [
            'wire:model' => 'form.{name}',
        ],
        'type' => \twa\cmsv2\Entities\FieldTypes\Select::class,
        'label' => 'Payment Method Id',
        'placeholder' => 'Enter Payment Method Id',
        'name' => 'payment_method_id'
    ],

    'release_date' => [
        'id' => uniqid(),
        'livewire' => [
            'wire:model' => 'form.{name}',
        ],
        'type' => \twa\cmsv2\Entities\FieldTypes\Date::class,
        'label' => 'Release Date ',
        'placeholder' => 'Enter date',
        'name' => 'release_date',
        'format' => 'd-m-Y'
    ],

    'imdb_rating' => [
        'id' => uniqid(),
        'livewire' => [
            'wire:model' => 'form.{name}',
        ],
        'type' => \twa\cmsv2\Entities\FieldTypes\Textfield::class,
        'label' => 'IMDB Rating',
        'placeholder' => 'Enter movie imdb rating',
        'name' => 'imdb_rating'
    ],
    'imdb_vote' => [
        'id' => uniqid(),
        'livewire' => [
            'wire:model' => 'form.{name}',
        ],
        'type' => \twa\cmsv2\Entities\FieldTypes\Textfield::class,
        'label' => 'IMDB Votes',
        'placeholder' => 'Enter movie imdb votes',
        'name' => 'imdb_vote'
    ],



    'profile_image' => [
        'id' => uniqid(),
        'livewire' => [
            'wire:model' => 'form.{name}',
        ],
        'type' => \twa\cmsv2\Entities\FieldTypes\FileUpload::class,
        'label' => 'Profile Image',
        'placeholder' => 'Upload Image',
        'aspect_ratio' => 1 / 1,
        'name' => 'profile_image',
        'multiple' => false
    ],

    'movie' => [
        'id' => uniqid(),
        'livewire' => [
            'wire:model' => 'form.{name}',
        ],
        'type' => \twa\cmsv2\Entities\FieldTypes\Select::class,
        'label' => 'Movie',
        'placeholder' => 'Select Movie',
        'name' => 'movie_id',
        'multiple' => false,
        'visible_selections' => 3,
        'query_limit' => 50,
        'options' => [
            'type' => 'query',
            'table' => 'movies',
            'field' => 'name'
        ]
    ],


    'theater' => [
        'id' => uniqid(),
        'livewire' => [
            'wire:model' => '{name}',
        ],
        'type' => \twa\cmsv2\Entities\FieldTypes\Select::class,
        'label' => 'Theatre',
        'placeholder' => 'Select Theatre',
        'name' => 'theater_id',
        'multiple' => false,
        'visible_selections' => 3,
        'query_limit' => 50,
        'options' => [
            'type' => 'query',
            'table' => 'theaters',
            'field' => 'label',
            'parent' => [
                'table' => 'branches',
                'key' => 'branch_id',
                'field' => 'label_en',
            ]
        ],

        'events' => [
            '@input' => 'theaterChanged'
        ],

        'dispatch' => [
            "init" => "theaterselectedvalue",
            "change" =>  "theaterchangedvalue"
        ],

    ],



    "visibility" => [
        'id' => uniqid(),
        'livewire' => [
            'wire:model' => 'form.{name}',
        ],
        'type' => \twa\cmsv2\Entities\FieldTypes\Toggle::class,
        'label' => 'Visibility',
        'placeholder' => 'Visibility',
        'name' => 'visibility'
    ],

    'branch' => [
        'id' => uniqid(),
        'livewire' => [
            'wire:model' => 'form.{name}',
        ],
        'type' => \twa\cmsv2\Entities\FieldTypes\Select::class,
        'label' => 'Branch',
        'placeholder' => 'Select branch',
        'name' => 'branch_id',
        'multiple' => false,
        'visible_selections' => 3,
        'query_limit' => 50,
        'options' => [
            'type' => 'query',
            'table' => 'branches',
            'field' => 'label_en'
        ]
    ],

    'hall_number' => [
        'id' => uniqid(),
        'livewire' => [
            'wire:model' => 'form.{name}',
        ],
        'type' => \twa\cmsv2\Entities\FieldTypes\Number::class,
        'label' => 'Hall Number',
        'placeholder' => 'Enter Hall Number',
        'prefix' => 'Theater',
        'name' => 'hall_number'
    ],

    'price_groups' => [
        'id' => uniqid(),
        'livewire' => [
            'wire:model' => 'form.{name}',
        ],
        'type' => \twa\cmsv2\Entities\FieldTypes\Select::class,
        'label' => 'Type',
        'placeholder' => 'Select Type',
        'name' => 'price_group_id',
        'multiple' => false,
        'visible_selections' => 3,
        'query_limit' => 50,
        'quick_add' => 'price-groups',
        'options' => [
            'type' => 'query',
            'table' => 'price_groups',
            'field' => 'label'
        ],
        'dispatch' => [
            "init" => "pricegroupselectedvalue",
            "change" =>  "pricegroupchangedvalue"
        ],
    ],


    'color' => [
        'id' => uniqid(),
        'livewire' => [
            'wire:model' => 'form.{name}',
        ],
        'type' => \twa\cmsv2\Entities\FieldTypes\Colorpicker::class,
        'label' => 'Color',
        'placeholder' => 'Enter Color',
        'name' => 'color'
    ],



    'price' => [
        'id' => uniqid(),
        'livewire' => [
            'wire:model' => 'form.{name}',
        ],
        'type' => \twa\cmsv2\Entities\FieldTypes\Number::class,
        'label' => 'Price',
        'placeholder' => 'Enter Price',
        'name' => 'price'
    ],


    'default' => [
        'id' => uniqid(),
        'livewire' => [
            'wire:model' => 'form.{name}',
        ],
        'type' => \twa\cmsv2\Entities\FieldTypes\Toggle::class,
        'label' => 'Default',
        'placeholder' => 'Default',
        'name' => 'default'
    ],



    'date_from' => [
        'id' => uniqid(),
        'livewire' => [
            'wire:model' => 'form.{name}',
        ],
        'type' => \twa\cmsv2\Entities\FieldTypes\Date::class,
        'label' => 'Date From',
        'placeholder' => 'Select date From',
        'name' => 'date_from'
    ],
    'date_to' => [
        'id' => uniqid(),
        'livewire' => [
            'wire:model' => 'form.{name}',
        ],
        'type' => \twa\cmsv2\Entities\FieldTypes\Date::class,
        'label' => 'Date To',
        'placeholder' => 'Select date to`',
        'name' => 'date_to'
    ],

    'end_time' => [
        'id' => uniqid(),
        'livewire' => [
            'wire:model' => 'form.{name}',
        ],
        'type' => \twa\cmsv2\Entities\FieldTypes\Select::class,
        'label' => 'Time',
        'placeholder' => 'Select Times',
        'name' => 'end_time_id',
        'multiple' => false,
        'visible_selections' => 3,
        'query_limit' => 50,
        'quick_add' => "times",
        'options' => [
            'type' => 'query',
            'table' => 'times',
            'field' => 'label'
        ]

    ],

    'time' => [
        'id' => uniqid(),
        'livewire' => [
            'wire:model' => 'form.{name}',
        ],
        'type' => \twa\cmsv2\Entities\FieldTypes\Select::class,

        // 'type' => \twa\cmsv2\Entities\FieldTypes\Textfield::class,

        'label' => 'Time',
        'placeholder' => 'Select Times',
        'name' => 'time_id',
        'multiple' => false,
        'visible_selections' => 3,
        'query_limit' => 50,
        'quick_add' => "times",
        'options' => [
            'type' => 'query',
            'table' => 'times',
            'field' => 'label'
        ]
    ],
    'screen_type' => [
        'id' => uniqid(),
        'livewire' => [
            'wire:model' => 'form.{name}',
        ],
        'type' => \twa\cmsv2\Entities\FieldTypes\Select::class,
        'label' => 'Screen type',
        'placeholder' => 'Select movie Screen Type',
        'name' => 'screen_type_id',
        'multiple' => false,
        'visible_selections' => 2,
        'query_limit' => 50,
        'quick_add' => 'screen-types',
        'options' => [
            'type' => 'query',
            'table' => 'screen_types',
            'field' => 'label'
        ]
    ],

    'apply_date' => [
        'id' => uniqid(),
        'livewire' => [
            'wire:model' => 'form.{name}',
        ],
        'type' => \twa\cmsv2\Entities\FieldTypes\Toggle::class,
        'label' => 'Apply',
        'placeholder' => 'Apply date',
        'name' => 'apply_date',
        'value' => true,
    ],

    'apply_time' => [
        'id' => uniqid(),
        'livewire' => [
            'wire:model' => 'form.{name}',
        ],
        'type' => \twa\cmsv2\Entities\FieldTypes\Toggle::class,
        'label' => 'Apply',
        'placeholder' => 'Apply',
        'name' => 'apply_time',
        'value' => true,
    ],

    'apply_system' => [
        'id' => uniqid(),
        'livewire' => [
            'wire:model' => 'form.{name}',
        ],
        'type' => \twa\cmsv2\Entities\FieldTypes\Toggle::class,
        'label' => 'Apply',
        'placeholder' => 'Apply',
        'name' => 'apply_system',
        'value' => true,
    ],


    'apply_screen_type' => [
        'id' => uniqid(),
        'livewire' => [
            'wire:model' => 'form.{name}',
        ],
        'type' => \twa\cmsv2\Entities\FieldTypes\Toggle::class,
        'label' => 'Apply',
        'placeholder' => 'Apply Screen type',
        'name' => 'apply_screen_type',
        'value' => true,
    ],
    'apply_color' => [
        'id' => uniqid(),
        'livewire' => [
            'wire:model' => 'form.{name}',
        ],
        'type' => \twa\cmsv2\Entities\FieldTypes\Toggle::class,
        'label' => 'Apply',
        'placeholder' => 'Apply color',
        'name' => 'apply_color',
        'value' => true,
    ],


    "first_name" => [
        'id' => uniqid(),
        'livewire' => [
            'wire:model' => 'form.{name}',
        ],
        'type' => \twa\cmsv2\Entities\FieldTypes\Textfield::class,
        'label' => 'First Name',
        'placeholder' => 'First Name',
        'name' => 'first_name'
    ],

    "last_name" => [
        'id' => uniqid(),
        'livewire' => [
            'wire:model' => 'form.{name}',
        ],
        'type' => \twa\cmsv2\Entities\FieldTypes\Textfield::class,
        'label' => 'Last Name',
        'placeholder' => 'Last Name',
        'name' => 'last_name'
    ],


    "email" => [
        'id' => uniqid(),
        'livewire' => [
            'wire:model' => 'form.{name}',
        ],
        'type' => \twa\cmsv2\Entities\FieldTypes\Email::class,
        'label' => 'Email',
        'placeholder' => 'Email',
        'name' => 'email'
    ],

    "password" => [
        'id' => uniqid(),
        'livewire' => [
            'wire:model' => 'form.{name}',
        ],
        'type' => \twa\cmsv2\Entities\FieldTypes\Password::class,
        'label' => 'Password',
        'placeholder' => 'Password',
        'name' => 'password'
    ],




    'question' => [
        'id' => uniqid(),
        'livewire' => [
            'wire:model' => 'form.{name}',
        ],
        'type' => \twa\cmsv2\Entities\FieldTypes\Textfield::class,
        'label' => 'Question',
        'placeholder' => 'Enter Question',
        'name' => 'question',
        'container' => 'col-span-6',
    ],


    'answer' => [
        'id' => uniqid(),
        'livewire' => [
            'wire:model' => 'form.{name}',
        ],
        'type' => \twa\cmsv2\Entities\FieldTypes\Textarea::class,
        'label' => 'Answer',
        'placeholder' => 'Enter Answer',
        'name' => 'answer'
    ],

    'text' => [
        'id' => uniqid(),
        'livewire' => [
            'wire:model' => 'form.{name}',
        ],
        'type' => \twa\cmsv2\Entities\FieldTypes\Textarea::class,
        'label' => 'Text',
        'placeholder' => 'Enter text',
        'name' => 'text'
    ],

    'cta_label' => [
        'id' => uniqid(),
        'livewire' => [
            'wire:model' => 'form.{name}',
        ],
        'type' => \twa\cmsv2\Entities\FieldTypes\Textfield::class,
        'label' => 'CTA Label',
        'placeholder' => 'Enter CTA label',
        'name' => 'cta_label',
        'container' => 'col-span-6',
    ],
    'cta_link' => [
        'id' => uniqid(),
        'livewire' => [
            'wire:model' => 'form.{name}',
        ],
        'type' => \twa\cmsv2\Entities\FieldTypes\Textfield::class,
        'label' => 'CTA Link',
        'placeholder' => 'Enter CTA Link',
        'name' => 'cta_link',
        'container' => 'col-span-6',
    ],


    'latitude' => [
        'id' => uniqid(),
        'livewire' => [
            'wire:model' => 'form.{name}',
        ],
        'type' => \twa\cmsv2\Entities\FieldTypes\Textfield::class,
        'label' => 'Latitude',
        'placeholder' => 'Enter Latitude',
        'name' => 'latitude',
        'container' => 'col-span-6',
    ],


    'longitude' => [
        'id' => uniqid(),
        'livewire' => [
            'wire:model' => 'form.{name}',
        ],
        'type' => \twa\cmsv2\Entities\FieldTypes\Textfield::class,
        'label' => 'Longitude',
        'placeholder' => 'Enter Longitude',
        'name' => 'longitude',
        'container' => 'col-span-6',
    ],


    'number' => [
        'id' => uniqid(),
        'livewire' => [
            'wire:model' => 'form.{name}',
        ],
        'type' => \twa\cmsv2\Entities\FieldTypes\Textfield::class,
        'label' => 'Number',
        'placeholder' => 'Enter Number',
        'name' => 'number',
        'container' => 'col-span-6',
    ],

    'web_prefix' => [
        'id' => uniqid(),
        'livewire' => [
            'wire:model' => 'form.{name}',
        ],
        'type' => \twa\cmsv2\Entities\FieldTypes\Textfield::class,
        'label' => 'Web Prefix',
        'placeholder' => 'Enter Web Prefix',
        'name' => 'web_prefix',
        'container' => 'col-span-6',
    ],

    'content' => [
        'id' => uniqid(),
        'livewire' => [
            'wire:model' => 'form.{name}',
        ],
        'type' => \twa\cmsv2\Entities\FieldTypes\Editor::class,
        'label' => 'Content',
        'placeholder' => 'Enter Content',
        'name' => 'content',
        'container' => 'col-span-6',
    ],


    'facebook' => [
        'id' => uniqid(),
        'livewire' => [
            'wire:model' => 'form.{name}',
        ],
        'type' => \twa\cmsv2\Entities\FieldTypes\Textfield::class,
        'label' => 'Facebook URL',
        'placeholder' => 'Enter Facebook URL',
        'name' => 'facebook',
        'container' => 'col-span-6',
    ],

    'facebook_label' => [
        'id' => uniqid(),
        'livewire' => [
            'wire:model' => 'form.{name}',
        ],
        'type' => \twa\cmsv2\Entities\FieldTypes\Textfield::class,
        'label' => 'Facebook Label',
        'placeholder' => 'Enter Facebook Label',
        'name' => 'facebook_label',
        'container' => 'col-span-6',
        'translatable' => true,
    ],
    'instagram_label' => [
        'id' => uniqid(),
        'livewire' => [
            'wire:model' => 'form.{name}',
        ],
        'type' => \twa\cmsv2\Entities\FieldTypes\Textfield::class,
        'label' => 'Instagram Label',
        'placeholder' => 'Enter Instagram Label',
        'name' => 'instagram_label',
        'container' => 'col-span-6',
        'translatable' => true,
    ],
    'instagram' => [
        'id' => uniqid(),
        'livewire' => [
            'wire:model' => 'form.{name}',
        ],
        'type' => \twa\cmsv2\Entities\FieldTypes\Textfield::class,
        'label' => 'Instagram URL',
        'placeholder' => 'Enter Instagram URL',
        'name' => 'instagram',
        'container' => 'col-span-6',
    ],
    'whattsapp_label' => [
        'id' => uniqid(),
        'livewire' => [
            'wire:model' => 'form.{name}',
        ],
        'type' => \twa\cmsv2\Entities\FieldTypes\Textfield::class,
        'label' => 'Whattsapp Label',
        'placeholder' => 'Enter Whattsapp Label',
        'name' => 'whattsapp_label',
        'container' => 'col-span-6',
        'translatable' => true,
    ],
    'whattsapp' => [
        'id' => uniqid(),
        'livewire' => [
            'wire:model' => 'form.{name}',
        ],
        'type' => \twa\cmsv2\Entities\FieldTypes\Textfield::class,
        'label' => 'Whattsapp Number',
        'placeholder' => 'Enter Whattsapp Number',
        'name' => 'whattsapp',
        'container' => 'col-span-6',
    ],

    'x_label' => [
        'id' => uniqid(),
        'livewire' => [
            'wire:model' => 'form.{name}',
        ],
        'type' => \twa\cmsv2\Entities\FieldTypes\Textfield::class,
        'label' => 'X Label',
        'placeholder' => 'Enter X Label',
        'name' => 'x_label',
        'container' => 'col-span-6',
        'translatable' => true,
    ],
    'x' => [
        'id' => uniqid(),
        'livewire' => [
            'wire:model' => 'form.{name}',
        ],
        'type' => \twa\cmsv2\Entities\FieldTypes\Textfield::class,
        'label' => 'X URL',
        'placeholder' => 'Enter X URL',
        'name' => 'x',
        'container' => 'col-span-6',
    ],

    'full_name' => [
        'id' => uniqid(),
        'livewire' => [
            'wire:model' => 'form.{name}',
        ],

        'type' => \twa\cmsv2\Entities\FieldTypes\Textfield::class,

        'label' => 'Full Name',
        'placeholder' => 'Enter full name',
        'name' => 'full_name',
        'container' => 'col-span-6',
    ],
    
    'username' => [
        'id' => uniqid(),
        'livewire' => [
            'wire:model' => 'form.{name}',
        ],

        'type' => \twa\cmsv2\Entities\FieldTypes\Textfield::class,

        'label' => 'Username',
        'placeholder' => 'Enter Username',
        'name' => 'username',
        'container' => 'col-span-6',
    ],

    'passcode' =>[
        'id' => uniqid(),
        'livewire' => [
            'wire:model' => 'form.{name}',
        ],
        'type' => \twa\cmsv2\Entities\FieldTypes\Textfield::class,
        'label' => 'Passcode',
        'placeholder' => 'Enter passcode',
        'name' => 'passcode',
        'container' => 'col-span-6',
    ],

    'role' => [
        'id' => uniqid(),
        'livewire' => [
            'wire:model' => 'form.{name}',
        ],
        'type' => \twa\cmsv2\Entities\FieldTypes\Select::class,
        'label' => 'Role',
        'placeholder' => 'Select role',
        'name' => 'role',
        'multiple' => false,
        'visible_selections' => 3,
        'query_limit' => 50,
        'options' => [
            'type' => 'static',
            'list' => [

                    ['value' => 'cashier' , 'label' => 'Cashier'],
                    ['value' => 'manager' , 'label' => 'Manager'],
                ]
            
        ]
    ],

    'phone' => [
        'id' => uniqid(),
        'livewire' => [
            'wire:model' => 'form.{name}',
        ],
        'type' => \twa\cmsv2\Entities\FieldTypes\Textfield::class,
        'label' => 'Phone',
        'placeholder' => 'Enter phone',
        'name' => 'phone',
        'container' => 'col-span-6',
    ],


    'profile_picture' => [
        'id' => uniqid(),
        'livewire' => [
            'wire:model' => 'form.{name}',
        ],
        'type' => \twa\cmsv2\Entities\FieldTypes\FileUpload::class,
        'label' => 'Profile Picture',
        'placeholder' => 'Profile Picture',
        'name' => 'profile_picture',
        'aspect_ratio' => 1 / 1,
        'multiple' => false
    ],







    'gender' => [
        'id' => uniqid(),
        'livewire' => [
            'wire:model' => 'form.{name}',
        ],
        'type' => \twa\cmsv2\Entities\FieldTypes\Select::class,
        'label' => 'Gender',
        'placeholder' => 'Select gender',
        'name' => 'gender_id',
        'multiple' => false,
        'visible_selections' => 3,
        'query_limit' => 50,
        'options' => [
            'type' => 'query',
            'table' => 'genders',
            'field' => 'label'
        ]
    ],
    
    'marital_status' => [
        'id' => uniqid(),
        'livewire' => [
            'wire:model' => 'form.{name}',
        ],
        'type' => \twa\cmsv2\Entities\FieldTypes\Select::class,
        'label' => 'Marital Status',
        'placeholder' => 'Select Marital Statu',
        'name' => 'marital_status_id',
        'multiple' => false,
        'visible_selections' => 3,
        'query_limit' => 50,
        'options' => [
            'type' => 'query',
            'table' => 'marital_status',
            'field' => 'label'
        ]
    ],
    

    'date_birth' => [
        'id' => uniqid(),
        'livewire' => [
            'wire:model' => 'form.{name}',
        ],
        'type' => \twa\cmsv2\Entities\FieldTypes\Date::class,
        'label' => 'Date of Birth',
        'placeholder' => 'Enter date of birth',
        'name' => 'date_birth'
    ],

    'date_marriage' => [
        'id' => uniqid(),
        'livewire' => [
            'wire:model' => 'form.{name}',
        ],
        'type' => \twa\cmsv2\Entities\FieldTypes\Date::class,
        'label' => 'Date of marriage',
        'placeholder' => 'Enter date of marriage',
        'name' => 'date_marriage'
    ],


    'login_provider' => [
        'id' => uniqid(),
        'livewire' => [
            'wire:model' => 'form.{name}',
        ],
        'type' => \twa\cmsv2\Entities\FieldTypes\Hidden::class,
        'label' => 'Login Provider',
        'placeholder' => 'Enter Login Provider',
        'name' => 'login_provider'
    ],

    // UserVerifyTokens : token, otp , address , user_id , expires_at , ip
    'token' => [
        'id' => uniqid(),
        'livewire' => [
            'wire:model' => 'form.{name}',
        ],
        'type' => \twa\cmsv2\Entities\FieldTypes\Textfield::class,
        'label' => 'Token',
        'placeholder' => 'Enter token',
        'name' => 'token',
        'container' => 'col-span-6',
    ],

    'access_token' => [
        'id' => uniqid(),
        'livewire' => [
            'wire:model' => 'form.{name}',
        ],
        'type' => \twa\cmsv2\Entities\FieldTypes\Textfield::class,
        'label' => 'Token',
        'placeholder' => 'Enter token',
        'name' => 'access_token',
        'container' => 'col-span-6',
    ],

    'otp' => [
        'id' => uniqid(),
        'livewire' => [
            'wire:model' => 'form.{name}',
        ],

        'type' => \twa\cmsv2\Entities\FieldTypes\Textfield::class,

        'label' => 'Otp',
        'placeholder' => 'Enter otp',
        'name' => 'otp',
        'container' => 'col-span-6',
    ],
    'user_id' => [
        'id' => uniqid(),
        'livewire' => [
            'wire:model' => 'form.{name}',
        ],

        'type' => \twa\cmsv2\Entities\FieldTypes\Select::class,

        'label' => 'User Id',
        'placeholder' => 'Enter user id',
        'name' => 'user_id',
        'container' => 'col-span-6',
    ],

    'pos_user_id' => [
        'id' => uniqid(),
        'livewire' => [
            'wire:model' => 'form.{name}',
        ],

        'type' => \twa\cmsv2\Entities\FieldTypes\Select::class,

        'label' => 'User Id',
        'placeholder' => 'Enter user id',
        'name' => 'pos_user_id',
        'container' => 'col-span-6',
    ],

    'item_id'=>[
        'id' => uniqid(),
        'livewire' => [
            'wire:model' => 'form.{name}',
        ],

        'type' => \twa\cmsv2\Entities\FieldTypes\Select::class,

        'label' => 'Item Id',
        'placeholder' => 'Enter item id',
        'name' => 'item_id',
        'container' => 'col-span-6',
    ],
    'order_id'=>[
        'id' => uniqid(),
        'livewire' => [
            'wire:model' => 'form.{name}',
        ],

        'type' => \twa\cmsv2\Entities\FieldTypes\Select::class,

        'label' => 'Order Id',
        'placeholder' => 'Enter order id',
        'name' => 'order_id',
        'container' => 'col-span-6',
    ],
    'cart_id'=>[
        'id' => uniqid(),
        'livewire' => [
            'wire:model' => 'form.{name}',
        ],

        'type' => \twa\cmsv2\Entities\FieldTypes\Select::class,

        'label' => 'Cart Id',
        'placeholder' => 'Enter cart id',
        'name' => 'cart_id',
        'container' => 'col-span-6',
    ],
    'movie_show_id'=>[
        'id' => uniqid(),
        'livewire' => [
            'wire:model' => 'form.{name}',
        ],

        'type' => \twa\cmsv2\Entities\FieldTypes\Select::class,

        'label' => 'Movie Show Id',
        'placeholder' => 'Enter Movie Show Id',
        'name' => 'movie_show_id',
        'container' => 'col-span-6',
    ],

    'seat'=>[
        'id' => uniqid(),
        'livewire' => [
            'wire:model' => 'form.{name}',
        ],

        'type' => \twa\cmsv2\Entities\FieldTypes\Textfield::class,

        'label' => 'Seat',
        'placeholder' => 'Enter Seat',
        'name' => 'seat',
        'container' => 'col-span-6',
    ],

    'reward_id' => [
        'id' => uniqid(),
        'livewire' => [
            'wire:model' => 'form.{name}',
        ],

        'type' => \twa\cmsv2\Entities\FieldTypes\Select::class,

        'label' => 'Reward Id',
        'placeholder' => 'Enter reward id',
        'name' => 'reward_id',
        'container' => 'col-span-6',
    ],

    'code' => [
        'id' => uniqid(),
        'livewire' => [
            'wire:model' => 'form.{name}',
        ],

        'type' => \twa\cmsv2\Entities\FieldTypes\Textfield::class,

        'label' => 'Code',
        'placeholder' => 'Enter Code',
        'name' => 'code',
        'container' => 'col-span-6',
    ],
    'flat' => [
        'id' => uniqid(),
        'livewire' => [
            'wire:model' => 'form.{name}',
        ],

        'type' => \twa\cmsv2\Entities\FieldTypes\Textfield::class,

        'label' => 'Flat',
        'placeholder' => 'Enter Flat',
        'name' => 'flat',
        'container' => 'col-span-6',
    ],
    'percentage' => [
        'id' => uniqid(),
        'livewire' => [
            'wire:model' => 'form.{name}',
        ],

        'type' => \twa\cmsv2\Entities\FieldTypes\Textfield::class,

        'label' => 'Percentage',
        'placeholder' => 'Enter Percentage',
        'name' => 'percentage',
        'container' => 'col-span-6',
    ],


    'used_at' => [
        'id' => uniqid(),
        'livewire' => [
            'wire:model' => 'form.{name}',
        ],
        'type' => \twa\cmsv2\Entities\FieldTypes\Datetime::class,

        'label' => 'Used At',
        'placeholder' => 'Enter Used At',
        'name' => 'used_at',
        'container' => 'col-span-6',
    ],
    'user_card_id' => [
        'id' => uniqid(),
        'livewire' => [
            'wire:model' => 'form.{name}',
        ],
        'type' => \twa\cmsv2\Entities\FieldTypes\Select::class,
        'label' => 'User Card Id',
        'placeholder' => 'Enter user card id',
        'name' => 'user_card_id',
        'container' => 'col-span-6',
    ],
    'payment_method_id' => [
        'id' => uniqid(),
        'livewire' => [
            'wire:model' => 'form.{name}',
        ],
        'type' => \twa\cmsv2\Entities\FieldTypes\Select::class,
        'label' => 'Payment Method Id',
        'placeholder' => 'Payment Method Id',
        'name' => 'payment_method_id',
        'container' => 'col-span-6',
    ],

    'zone_id' => [
        'id' => uniqid(),
        'livewire' => [
            'wire:model' => 'form.{name}',
        ],
        'type' => \twa\cmsv2\Entities\FieldTypes\Select::class,
        'label' => 'Zone',
        'placeholder' => 'Zone',
        'name' => 'zone_id',
        'container' => 'col-span-6',
    ],

    'barcode' => [
        'id' => uniqid(),
        'livewire' => [
            'wire:model' => 'form.{name}',
        ],

        'type' => \twa\cmsv2\Entities\FieldTypes\Textfield::class,

        'label' => 'Barcode',
        'placeholder' => 'Enter Barcode',
        'name' => 'barcode',
        'container' => 'col-span-6',
    ],
    'card_number' => [
        'id' => uniqid(),
        'livewire' => [
            'wire:model' => 'form.{name}',
        ],

        'type' => \twa\cmsv2\Entities\FieldTypes\Textfield::class,

        'label' => 'Card Number',
        'placeholder' => 'Enter Card Number',
        'name' => 'card_number',
        'container' => 'col-span-6',
    ],
    'coupon_id' => [
        'id' => uniqid(),
        'livewire' => [
            'wire:model' => 'form.{name}',
        ],
        'type' => \twa\cmsv2\Entities\FieldTypes\Select::class,
        'label' => 'Coupon',
        'placeholder' => 'Select Coupon ',
        'name' => 'coupon_id',
        'multiple' => true,
        'visible_selections' => 3,
        'query_limit' => 50,
        'options' => [
            'type' => 'query',
            'table' => 'coupons',
            'field' => 'label'
        ]
    ],

    


    'type' => [
        'id' => uniqid(),
        'livewire' => [
            'wire:model' => 'form.{name}',
        ],
        'type' => \twa\cmsv2\Entities\FieldTypes\Textfield::class,

        'label' => 'Type',
        'placeholder' => 'Enter type',
        'name' => 'type',
        'container' => 'col-span-6',
    ],

    'disabled_at' => [
        'id' => uniqid(),
        'livewire' => [
            'wire:model' => 'form.{name}',
        ],
        'type' => \twa\cmsv2\Entities\FieldTypes\Datetime::class,

        'label' => 'Disabled At',
        'placeholder' => 'Enter Disabled At',
        'name' => 'disabled_at',
        'container' => 'col-span-6',
    ],




    'expires_at' => [
        'id' => uniqid(),
        'livewire' => [
            'wire:model' => 'form.{name}',
        ],
        'type' => \twa\cmsv2\Entities\FieldTypes\Datetime::class,
        'label' => 'Date of expiry',
        'placeholder' => 'Enter date of expiry',
        'name' => 'expires_at'
    ],

    'otp_expires_at' => [
        'id' => uniqid(),
        'livewire' => [
            'wire:model' => 'form.{name}',
        ],
        'type' => \twa\cmsv2\Entities\FieldTypes\Datetime::class,
        'label' => 'Date of otp expiry',
        'placeholder' => 'Enter date of otp expiry',
        'name' => 'otp_expires_at'
    ],

    'token_expires_at' => [
        'id' => uniqid(),
        'livewire' => [
            'wire:model' => 'form.{name}',
        ],
        'type' => \twa\cmsv2\Entities\FieldTypes\Datetime::class,
        'label' => 'Date of token expiry',
        'placeholder' => 'Enter date of token expiry',
        'name' => 'token_expires_at'
    ],

    'email_verified' => [
        'id' => uniqid(),
        'livewire' => [
            'wire:model' => 'form.{name}',
        ],
        'type' => \twa\cmsv2\Entities\FieldTypes\Datetime::class,
        'label' => 'Email Verified',
        'placeholder' => 'Email Verified',
        'name' => 'email_verified'
    ],

    'phone_verified' => [
        'id' => uniqid(),
        'livewire' => [
            'wire:model' => 'form.{name}',
        ],
        'type' => \twa\cmsv2\Entities\FieldTypes\Datetime::class,
        'label' => 'Phone Verified',
        'placeholder' => 'Phone Verified',
        'name' => 'phone_verified'
    ],



    'ip' => [
        'id' => uniqid(),
        'livewire' => [
            'wire:model' => 'form.{name}',
        ],

        'type' => \twa\cmsv2\Entities\FieldTypes\Textfield::class,

        'label' => 'IP',
        'placeholder' => 'Enter ip',
        'name' => 'ip',
        'container' => 'col-span-6',
    ],

    'driver' => [
        'id' => uniqid(),
        'livewire' => [
            'wire:model' => 'form.{name}',
        ],
        'type' => \twa\cmsv2\Entities\FieldTypes\Textfield::class,
        'label' => 'Driver',
        'placeholder' => 'Enter Driver',
        'name' => 'driver',
        'container' => 'col-span-6',
    ],
    'address' => [
        'id' => uniqid(),
        'livewire' => [
            'wire:model' => 'form.{name}',
        ],
        'type' => \twa\cmsv2\Entities\FieldTypes\Textfield::class,
        'label' => 'Address',
        'placeholder' => 'Enter Address',
        'name' => 'address',
        'container' => 'col-span-6',
    ],


    'amount' => [
        'id' => uniqid(),
        'livewire' => [
            'wire:model' => 'form.{name}',
        ],
        'type' => \twa\cmsv2\Entities\FieldTypes\Number::class,
        'label' => 'Amount',
        'placeholder' => 'Enter Amount',
        'name' => 'amount',
        'container' => 'col-span-6',
    ],


    'balance' => [
        'id' => uniqid(),
        'livewire' => [
            'wire:model' => 'form.{name}',
        ],
        'type' => \twa\cmsv2\Entities\FieldTypes\Number::class,
        'label' => 'Balance',
        'placeholder' => 'Enter Balance',
        'name' => 'balance',
        'container' => 'col-span-6',
    ],


    'reference' => [
        'id' => uniqid(),
        'livewire' => [
            'wire:model' => 'form.{name}',
        ],
        'type' => \twa\cmsv2\Entities\FieldTypes\Textfield::class,
        'label' => 'Reference',
        'placeholder' => 'Enter Reference',
        'name' => 'reference',
        'container' => 'col-span-6',
    ],


    'gateway_reference' => [
        'id' => uniqid(),
        'livewire' => [
            'wire:model' => 'form.{name}',
        ],
        'type' => \twa\cmsv2\Entities\FieldTypes\Textfield::class,
        'label' => 'Gateway Reference',
        'placeholder' => 'Enter Gateway Reference',
        'name' => 'gateway_reference',
        'container' => 'col-span-6',
    ],

    'pincode' => [
        'id' => uniqid(),
        'livewire' => [
            'wire:model' => 'form.{name}',
        ],
        'type' => \twa\cmsv2\Entities\FieldTypes\Textfield::class,
        'label' => 'Pincode',
        'placeholder' => 'Enter Pincode',
        'name' => 'pincode',
        'container' => 'col-span-6',
    ],

    'type' => [
        'id' => uniqid(),
        'livewire' => [
            'wire:model' => 'form.{name}',
        ],
        'type' => \twa\cmsv2\Entities\FieldTypes\Textfield::class,
        'label' => 'Type',
        'placeholder' => 'Enter Type',
        'name' => 'type',
        'container' => 'col-span-6',
    ],

    'redeem_points' => [
        'id' => uniqid(),
        'livewire' => [
            'wire:model' => 'form.{name}',
        ],
        'type' => \twa\cmsv2\Entities\FieldTypes\Number::class,
        'label' => ' Redeem Points',
        'placeholder' => 'Redeem Points',
        'name' => 'redeem_points'
    ],

    "one_time_usage" => [
        'id' => uniqid(),
        'livewire' => [
            'wire:model' => 'form.{name}',
        ],
        'type' => \twa\cmsv2\Entities\FieldTypes\Toggle::class,
        'label' => 'One Time Usage',
        'placeholder' => 'One Time Usage',
        'name' => 'one_time_usage'
    ],

    "completed" => [
        'id' => uniqid(),
        'livewire' => [
            'wire:model' => 'form.{name}',
        ],
        'type' => \twa\cmsv2\Entities\FieldTypes\Toggle::class,
        'label' => 'Completed',
        'placeholder' => 'Completed',
        'name' => 'completed'
    ],

    'final_price' => [
        'id' => uniqid(),
        'livewire' => [
            'wire:model' => 'form.{name}',
        ],
        'type' => \twa\cmsv2\Entities\FieldTypes\Number::class,
        'label' => 'Price',
        'placeholder' => 'Enter Price',
        'name' => 'final_price'
    ],
    'gained_points' => [
        'id' => uniqid(),
        'livewire' => [
            'wire:model' => 'form.{name}',
        ],
        'type' => \twa\cmsv2\Entities\FieldTypes\Number::class,
        'label' => 'Gained points',
        'placeholder' => 'Enter Gained points',
        'name' => 'gained_points'
    ],

    'discount' => [
        'id' => uniqid(),
        'livewire' => [
            'wire:model' => 'form.{name}',
        ],
        'type' => \twa\cmsv2\Entities\FieldTypes\Number::class,
        'label' => 'Discount',
        'placeholder' => 'Enter Discount',
        'name' => 'discount'
    ],
    
    'refunded_cashier_id' => [
        'id' => uniqid(),
        'livewire' => [
            'wire:model' => 'form.{name}',
        ],

        'type' => \twa\cmsv2\Entities\FieldTypes\Select::class,

        'label' => 'refunded Cashier ',
        'placeholder' => 'Enter refunded Cashier',
        'name' => 'refunded_cashier_id',
        'container' => 'col-span-6',
    ],
    'refunded_manager_id' => [
        'id' => uniqid(),
        'livewire' => [
            'wire:model' => 'form.{name}',
        ],

        'type' => \twa\cmsv2\Entities\FieldTypes\Select::class,

        'label' => 'refunded Manager ',
        'placeholder' => 'Enter refunded Manager',
        'name' => 'refunded_manager_id',
        'container' => 'col-span-6',
    ],

    "refunded_at" => [
        'id' => uniqid(),
        'livewire' => [
            'wire:model' => 'form.{name}',
        ],
        'type' => \twa\cmsv2\Entities\FieldTypes\Datetime::class,
        'label' => 'Refunded At',
        'placeholder' => 'Refunded at',
        'name' => 'refunded_at'
    ],

];


