<?php



$languages = config('languages');
$firstLanguage = $languages[0]['prefix'] ?? '';
$channel = "channel" . uniqid();

return [

    "id" => [
        'id' => uniqid(),
        'livewire' => [
            'wire:model' => 'form.{name}',
        ],
        'type' => twa\uikit\FieldTypes\Id::class,
        'label' => 'ID',
        'placeholder' => 'ID',
        'name' => 'id'
    ],


    "slug" => [
        'id' => uniqid(),
        'livewire' => [
            'wire:model' => 'form.{name}',
        ],
        'type' => twa\uikit\FieldTypes\Textfield::class,
        'label' => 'Slug',
        'placeholder' => 'Slug',
        'name' => 'slug',
        'channel_type' => 'receiver',
        'channel' => $channel,
        'channel_language' => $firstLanguage
    ],

    'label' => [
        'id' => uniqid(),
        'livewire' => [
            'wire:model' => 'form.{name}',
        ],
        'type' => twa\uikit\FieldTypes\Textfield::class,
        'label' => 'Label',
        'placeholder' => 'Enter label',
        'name' => 'label',
        'container' => 'col-span-6',
        'channel_type' => 'sender',
        'channel' => $channel,
        'channel_language' => $firstLanguage
    ],

    'label_en' => [
        'id' => uniqid(),
        'livewire' => [
            'wire:model' => 'form.{name}',
        ],
        'type' => twa\uikit\FieldTypes\Textfield::class,
        'label' => 'Label',
        'placeholder' => 'Enter label',
        'name' => 'label_en',
        'container' => 'col-span-6',

    ],


    'attributes' => [
        'id' => uniqid(),
        'livewire' => [
            'wire:model' => 'form.{name}',
        ],
        'type' => twa\uikit\FieldTypes\Textarea::class,
        'label' => 'Attributes',
        'placeholder' => 'Attributes',
        'name' => 'attributes',
        'container' => 'col-span-6',

    ],




    'long_id' => [
        'id' => uniqid(),
        'livewire' => [
            'wire:model' => 'form.{name}',
        ],
        'type' => twa\uikit\FieldTypes\Textfield::class,
        'label' => 'Long Id',
        'placeholder' => 'Enter Long Id',
        'name' => 'long_id',

    ],

    "title" => [
        'id' => uniqid(),
        'livewire' => [
            'wire:model' => 'form.{name}',
        ],
        'type' => twa\uikit\FieldTypes\Textfield::class,
        'label' => 'Title',
        'placeholder' => 'Title',
        'name' => 'title',
    ],


    "member_position" => [
        'id' => uniqid(),
        'livewire' => [
            'wire:model' => 'form.{name}',
        ],
        'type' => twa\uikit\FieldTypes\Textfield::class,
        'label' => 'Position',
        'placeholder' => 'position',
        'name' => 'position',
    ],

    "iso" => [
        'id' => uniqid(),
        'livewire' => [
            'wire:model' => 'form.{name}',
        ],
        'type' => twa\uikit\FieldTypes\Textfield::class,
        'label' => 'ISO',
        'placeholder' => 'Enter ISO',
        'name' => 'iso',

        'channel_type' => 'receiver',
        'channel' => 'isoslug',
        'channel_language' => null
    ],



    "created_at" => [
        'id' => uniqid(),
        'livewire' => [
            'wire:model' => 'form.{name}',
        ],
        'type' => twa\uikit\FieldTypes\Datetime::class,
        'label' => 'Created',
        'placeholder' => 'Created at',
        'name' => 'created_at'
    ],

    "updated_at" => [
        'id' => uniqid(),
        'livewire' => [
            'wire:model' => 'form.{name}',
        ],
        'type' => twa\uikit\FieldTypes\Datetime::class,
        'label' => 'Updated',
        'placeholder' => 'Updated at',
        'name' => 'updated_at'
    ],


    "converted_at" => [
        'id' => uniqid(),
        'livewire' => [
            'wire:model' => 'form.{name}',
        ],
        'type' => twa\uikit\FieldTypes\Datetime::class,
        'label' => 'Converted',
        'placeholder' => 'Converted at',
        'name' => 'converted_at'
    ],

    "completed_at" => [
        'id' => uniqid(),
        'livewire' => [
            'wire:model' => 'form.{name}',
        ],
        'type' => twa\uikit\FieldTypes\Datetime::class,
        'label' => 'Completed',
        'placeholder' => 'Completed at',
        'name' => 'completed_at'

    ],

    "coming_soon" => [
        'id' => uniqid(),
        'livewire' => [
            'wire:model' => 'form.{name}',
        ],
        'type' => twa\uikit\FieldTypes\Toggle::class,
        'label' => 'Coming Soon',
        'placeholder' => 'Coming Soon',
        'name' => 'coming_soon'

    ],

    "display" => [
        'id' => uniqid(),
        'livewire' => [
            'wire:model' => 'form.{name}',
        ],
        'type' => twa\uikit\FieldTypes\Toggle::class,
        'label' => 'Display',
        'placeholder' => 'Display',
        'name' => 'display'
    ],
    "one_time_usage" => [
        'id' => uniqid(),
        'livewire' => [
            'wire:model' => 'form.{name}',
        ],
        'type' => twa\uikit\FieldTypes\Toggle::class,
        'label' => 'One Time Usage',
        'placeholder' => 'One Time Usage',
        'name' => 'one_time_usage'
    ],

    "movie_show_color" => [
        'id' => uniqid(),
        'livewire' => [
            'wire:model' => 'form.{name}',
        ],
        'type' =>  twa\uikit\FieldTypes\Colorpicker::class,
        'label' => 'Color',
        'placeholder' => 'Choose color',
        'name' => 'color'
    ],




    'action' => [
        'id' => uniqid(),
        'livewire' => [
            'wire:model' => 'form.{name}',
        ],

        'type' => twa\uikit\FieldTypes\Textfield::class,
        'label' => 'Action',
        'placeholder' => 'Enter Action',
        'name' => 'action',

        'container' => 'col-span-6',
    ],


    // 'theater_map' => [
    //     'id' => uniqid(),
    //     'livewire' => [
    //         'wire:model' => 'form.{name}',
    //     ],
    //     'type' => twa\uikit\FieldTypes\Map::class,
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
        'type' => twa\uikit\FieldTypes\Hidden::class,
        'label' => 'Group',
        'placeholder' => 'Enter Group',
        'name' => 'group'
    ],

    'family_group_id' => [
        'id' => uniqid(),
        'livewire' => [
            'wire:model' => 'form.{name}',
        ],
        'type' => twa\uikit\FieldTypes\Hidden::class,
        'label' => 'Family Group',
        'placeholder' => 'Enter Family Group',
        'name' => 'family_group_id'
    ],

    'label_hidden' => [
        'id' => uniqid(),
        'livewire' => [
            'wire:model' => 'form.{name}',
        ],
        'type' => twa\uikit\FieldTypes\Hidden::class,
        'label' => 'Label',
        'placeholder' => 'Enter label',
        'name' => 'label'
    ],

    'movie_key' => [
        'id' => uniqid(),
        'livewire' => [
            'wire:model' => 'form.{name}',
        ],
        'type' => twa\uikit\FieldTypes\Textfield::class,
        'label' => 'Movie Key (ex. tt3501632)',
        'placeholder' => 'Enter movie key',
        'name' => 'movie_key'
    ],


    'payment_ref' => [
        'id' => uniqid(),
        'livewire' => [
            'wire:model' => 'form.{name}',
        ],
        'type' => twa\uikit\FieldTypes\Textfield::class,
        'label' => 'Payment Reference',
        'placeholder' => 'Enter Payment Reference',
        'name' => 'payment_ref'
    ],




    'key' => [
        'id' => uniqid(),
        'livewire' => [
            'wire:model' => 'form.{name}',
        ],
        'type' => twa\uikit\FieldTypes\Textfield::class,
        'label' => 'Key',
        'placeholder' => 'Enter key',
        'name' => 'key'
    ],
    'movie_name' => [
        'id' => uniqid(),
        'livewire' => [
            'wire:model' => 'form.{name}',
        ],
        'type' => twa\uikit\FieldTypes\Textfield::class,
        'label' => 'Name',
        'placeholder' => 'Enter Movie Name',
        'name' => 'name'
    ],

    'name' => [
        'id' => uniqid(),
        'livewire' => [
            'wire:model' => 'form.{name}',
        ],
        'type' => twa\uikit\FieldTypes\Textfield::class,
        'label' => 'Name',
        'placeholder' => 'Enter Name',
        'name' => 'name'

    ],
    'movie_name' => [
        'id' => uniqid(),
        'livewire' => [
            'wire:model' => 'form.{name}',
        ],
        'type' => twa\uikit\FieldTypes\Textfield::class,
        'label' => 'Name',
        'placeholder' => 'Enter Name',
        'name' => 'name',
        'channel_type' => 'sender',
        'channel' => $channel,
        'channel_language' => $firstLanguage
    ],

    'condensed_name' => [
        'id' => uniqid(),
        'livewire' => [
            'wire:model' => 'form.{name}',
        ],
        'type' => twa\uikit\FieldTypes\Textfield::class,
        'label' => 'Condensed name',
        'placeholder' => 'Enter Movie Condensed Name',
        'name' => 'condensed_name',

    ],

    'condensed_label' => [
        'id' => uniqid(),
        'livewire' => [
            'wire:model' => 'form.{name}',
        ],
        'type' => twa\uikit\FieldTypes\Textfield::class,
        'label' => 'Condensed Label',
        'placeholder' => 'Enter Condensed Label',
        'name' => 'condensed_label',
        'channel_type' => 'sender',
        'channel' => 'isoslug',
        'channel_language' => null
    ],





    'description' => [
        'id' => uniqid(),
        'livewire' => [
            'wire:model' => 'form.{name}',
        ],
        'type' => twa\uikit\FieldTypes\Textarea::class,
        'label' => 'Description',
        'placeholder' => 'Enter description',
        'name' => 'description',
        'container' => 'col-span-12',
    ],


    'movie_description' => [
        'id' => uniqid(),
        'livewire' => [
            'wire:model' => 'form.{name}',
        ],
        'type' => twa\uikit\FieldTypes\Textarea::class,
        'label' => 'Description',
        'placeholder' => 'Enter description',
        'name' => 'description',
        'container' => 'col-span-12',
        'translatable' => true,
    ],


    'duration' => [
        'id' => uniqid(),
        'livewire' => [
            'wire:model' => 'form.{name}',
        ],
        'type' => twa\uikit\FieldTypes\Number::class,
        'label' => ' Duration in Minutes',
        'placeholder' => 'Enter duration',
        'name' => 'duration'
    ],


    'nb_seats' => [
        'id' => uniqid(),
        'livewire' => [
            'wire:model' => 'form.{name}',
        ],
        'type' => twa\uikit\FieldTypes\Number::class,
        'label' => 'NB  Seats ',
        'placeholder' => 'NB seats',
        'name' => 'nb_seats'
    ],

    'week' => [
        'id' => uniqid(),
        'livewire' => [
            'wire:model' => 'form.{name}',
        ],
        'type' => twa\uikit\FieldTypes\BigNumber::class,
        'label' => 'Week ',
        'placeholder' => 'Week',
        'name' => 'week'
    ],



    'date' => [
        'id' => uniqid(),
        'livewire' => [
            'wire:model' => 'form.{name}',
        ],
        'type' => twa\uikit\FieldTypes\Date::class,
        'label' => 'Date',
        'placeholder' => 'Enter date',
        'name' => 'date'
    ],






    'genre' => [
        'id' => uniqid(),
        'livewire' => [
            'wire:model' => 'form.{name}',
        ],
        'type' => twa\uikit\FieldTypes\Select::class,
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
            'field' => 'label_en'
        ]
    ],


    'predefined_item_id' => [
        'id' => uniqid(),
        'livewire' => [
            'wire:model' => 'form.{name}',
        ],
        'type' => twa\uikit\FieldTypes\Select::class,
        'label' => 'Item',
        'placeholder' => 'Select Item ',
        'name' => 'item_id',
        'multiple' => false,
        'visible_selections' => 3,
        'query_limit' => 50,
        'options' => [
            'type' => 'query',
            'table' => 'items',
            'field' => 'label'
        ]
    ],
    'branch_item_id' => [
        'id' => uniqid(),
        'livewire' => [
            'wire:model' => 'form.{name}',
        ],
        'type' => twa\uikit\FieldTypes\BigNumber::class,
        'label' => 'Branch Item',
        'placeholder' => 'Select Branch Item ',
        'name' => 'branch_item_id',
        'multiple' => false,
        'visible_selections' => 3,
        'query_limit' => 50,
        // 'options' => [
        //     'type' => 'query',
        //     'table' => 'branch_items',
        //     'field' => 'label'
        // ]
    ],


    'cms_user_role' => [
        'id' => uniqid(),
        'livewire' => [
            'wire:model' => 'form.{name}',
        ],
        'type' => twa\uikit\FieldTypes\Select::class,
        'label' => 'CMS User Role',
        'placeholder' => 'Select user role',
        'name' => 'cms_user_role_id',
        'multiple' => false,
        'visible_selections' => 3,
        'query_limit' => 50,
        'options' => [
            'type' => 'query',
            'table' => 'cms_user_roles',
            'field' => 'label'
        ]
    ],

    'cms_permission' => [
        'id' => uniqid(),
        'livewire' => [
            'wire:model' => 'form.{name}',
        ],
        'type' => twa\uikit\FieldTypes\Select::class,
        'label' => 'CMS Permission',
        'placeholder' => 'Select Cms Permission',
        'name' => 'cms_permission_id',
        'multiple' => false,
        'visible_selections' => 3,
        'query_limit' => 50,
        'options' => [
            'type' => 'query',
            'table' => 'cms_permissions',
            'field' => 'label'
        ]
    ],



    'language' => [
        'id' => uniqid(),
        'livewire' => [
            'wire:model' => 'form.{name}',
        ],
        'type' => twa\uikit\FieldTypes\Select::class,
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
        'type' => twa\uikit\FieldTypes\Select::class,
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
    'system_id' => [
        'id' => uniqid(),
        'livewire' => [
            'wire:model' => 'form.{name}',
        ],
        'type' => twa\uikit\FieldTypes\Select::class,
        'label' => 'Systems',
        'placeholder' => 'Select systems',
        'name' => 'system_id',
        'multiple' => false,
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
        'type' => twa\uikit\FieldTypes\Select::class,
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
        'type' => twa\uikit\FieldTypes\Select::class,
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
        'type' => twa\uikit\FieldTypes\FileUpload::class,
        'label' => 'Image',
        'placeholder' => 'Upload Image',
        'name' => 'image',
        'aspect_ratio' => 1 / 1,
        'multiple' => false
    ],

    'web_image' => [
        'id' => uniqid(),
        'livewire' => [
            'wire:model' => 'form.{name}',
        ],
        'type' => twa\uikit\FieldTypes\FileUpload::class,
        'label' => 'Web Image',
        'placeholder' => 'Web Image',
        'name' => 'web_image',
        'aspect_ratio' => 1 / 1,
        'multiple' => false
    ],


    'top_image' => [
        'id' => uniqid(),
        'livewire' => [
            'wire:model' => 'form.{name}',
        ],
        'type' => twa\uikit\FieldTypes\FileUpload::class,
        'label' => 'Top Image',
        'placeholder' => 'Top Image',
        'name' => 'top_image',
        'aspect_ratio' => 1 / 1,
        'multiple' => false
    ],
    'bottom_image' => [
        'id' => uniqid(),
        'livewire' => [
            'wire:model' => 'form.{name}',
        ],
        'type' => twa\uikit\FieldTypes\FileUpload::class,
        'label' => 'Bottom Image',
        'placeholder' => 'Bottom Image',
        'name' => 'bottom_image',
        'aspect_ratio' => 1 / 1,
        'multiple' => false
    ],


    'first_image' => [
        'id' => uniqid(),
        'livewire' => [
            'wire:model' => 'form.{name}',
        ],
        'type' => twa\uikit\FieldTypes\FileUpload::class,
        'label' => 'First Image',
        'placeholder' => 'First Image',
        'name' => 'first_image',
        'aspect_ratio' => 1 / 1,
        'multiple' => false
    ],


    'second_image' => [
        'id' => uniqid(),
        'livewire' => [
            'wire:model' => 'form.{name}',
        ],
        'type' => twa\uikit\FieldTypes\FileUpload::class,
        'label' => 'Second Image',
        'placeholder' => 'Second Image',
        'name' => 'second_image',
        'aspect_ratio' => 1 / 1,
        'multiple' => false
    ],


    'third_image' => [
        'id' => uniqid(),
        'livewire' => [
            'wire:model' => 'form.{name}',
        ],
        'type' => twa\uikit\FieldTypes\FileUpload::class,
        'label' => 'Third Image',
        'placeholder' => 'Third Image',
        'name' => 'third_image',
        'aspect_ratio' => 1 / 1,
        'multiple' => false
    ],
    'fourth_image' => [
        'id' => uniqid(),
        'livewire' => [
            'wire:model' => 'form.{name}',
        ],
        'type' => twa\uikit\FieldTypes\FileUpload::class,
        'label' => 'Fourth Image',
        'placeholder' => 'Fourth Image',
        'name' => 'fourth_image',
        'aspect_ratio' => 1 / 1,
        'multiple' => false
    ],


    'main_image' => [
        'id' => uniqid(),
        'livewire' => [
            'wire:model' => 'form.{name}',
        ],

        'type' => twa\uikit\FieldTypes\FileUpload::class,
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
        'type' => twa\uikit\FieldTypes\FileUpload::class,
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
        'type' => twa\uikit\FieldTypes\Textfield::class,
        'label' => 'Youtube Video',
        'placeholder' => 'Enter Youtube Video Link',
        'name' => 'youtube_video'
    ],
    'payment_method_id' => [
        'id' => uniqid(),
        'livewire' => [
            'wire:model' => 'form.{name}',
        ],
        'type' => twa\uikit\FieldTypes\BigNumber::class,
        'label' => 'Payment Method Id',
        'placeholder' => 'Enter Payment Method Id',
        'name' => 'payment_method_id'
    ],



    'release_date' => [
        'id' => uniqid(),
        'livewire' => [
            'wire:model' => 'form.{name}',
        ],
        'type' => twa\uikit\FieldTypes\Date::class,
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
        'type' => twa\uikit\FieldTypes\Textfield::class,
        'label' => 'IMDB Rating',
        'placeholder' => 'Enter movie imdb rating',
        'name' => 'imdb_rating'
    ],
    'imdb_vote' => [
        'id' => uniqid(),
        'livewire' => [
            'wire:model' => 'form.{name}',
        ],
        'type' => twa\uikit\FieldTypes\Textfield::class,
        'label' => 'IMDB Votes',
        'placeholder' => 'Enter movie imdb votes',
        'name' => 'imdb_vote'
    ],

    'payment_reference' => [
        'id' => uniqid(),
        'livewire' => [
            'wire:model' => 'form.{name}',
        ],
        'type' => twa\uikit\FieldTypes\Textfield::class,
        'label' => 'Payment Reference',
        'placeholder' => 'Enter payment reference',
        'name' => 'payment_reference'
    ],



    'profile_image' => [
        'id' => uniqid(),
        'livewire' => [
            'wire:model' => 'form.{name}',
        ],
        'type' => twa\uikit\FieldTypes\FileUpload::class,
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
        'type' => twa\uikit\FieldTypes\Select::class,
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
        'type' => twa\uikit\FieldTypes\Select::class,
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
            ],
            'conditions' => [
                [
                    'type' => 'where',
                    'column' => 'branches.id',
                    'operand' => null,
                    'value' => '{branch_id}',
                ],
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

    'zones' => [
        'id' => uniqid(),
        'livewire' => [
            'wire:model' => 'form.{name}',
        ],
        'type' => twa\uikit\FieldTypes\Select::class,
        'label' => 'Zones that will be redeemed',
        'placeholder' => 'Select Zone',
        'name' => 'zones',
        'multiple' => true,
        'visible_selections' => 5,
        'query_limit' => 50,
        'options' => [
            'type' => 'query',
            'table' => 'price_group_zones',
            'field' => 'condensed_label',
            'parent' => [
                'table' => 'price_groups',
                'key' => 'price_group_id',
                'field' => 'label',
            ]
        ]
    ],

    'user_reward_id' => [
        'id' => uniqid(),
        'livewire' => [
            'wire:model' => 'form.{name}',
        ],
        'type' => twa\uikit\FieldTypes\Select::class,
        'label' => 'User Reward',
        'placeholder' => 'Select User Reward',
        'name' => 'user_reward_id',
        'multiple' => false,
        'visible_selections' => 5,
        'query_limit' => 50,
        'options' => [
            'type' => 'query',
            'table' => 'user_rewards',
            'field' => 'title'
        ]

    ],



    'group_id' => [
        'id' => uniqid(),
        'livewire' => [
            'wire:model' => 'form.{name}',
        ],
        'type' => twa\uikit\FieldTypes\Select::class,
        'label' => 'Select Group',
        'placeholder' => 'Select Group',
        'name' => 'group_id',
        'multiple' => false,
        'visible_selections' => 5,
        'query_limit' => 50,
        'options' => [
            'type' => 'query',
            'table' => 'groups',
            'field' => 'label'
        ]

    ],

    

    'reward_code' => [
        'id' => uniqid(),
        'livewire' => [
            'wire:model' => 'form.{name}',
        ],
        'type' => twa\uikit\FieldTypes\Textfield::class,
        'label' => 'Reward Code',
        'placeholder' => 'Select Reward Code',
        'name' => 'reward_code',
    ],


    'payload' => [
        'id' => uniqid(),
        'livewire' => [
            'wire:model' => 'form.{name}',
        ],
        'type' => twa\uikit\FieldTypes\Textarea::class,
        'label' => 'Payload',
        'placeholder' => 'Select Payload',
        'name' => 'payload',
    ],

    'items' => [
        'id' => uniqid(),
        'livewire' => [
            'wire:model' => 'form.{name}',
        ],
        'type' => twa\uikit\FieldTypes\Select::class,
        'label' => 'Extras that will be redeemed',
        'placeholder' => 'Select Extras',
        'name' => 'items',
        'multiple' => true,
        'visible_selections' => 5,
        'query_limit' => 50,
        'options' => [
            'type' => 'query',
            'table' => 'items',
            'field' => 'label'
        ]
    ],

    'cast' => [
        'id' => uniqid(),
        'livewire' => [
            'wire:model' => 'form.{name}',
        ],
        'type' => twa\uikit\FieldTypes\Select::class,
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


    'movies' => [
        'id' => uniqid(),
        'livewire' => [
            'wire:model' => 'form.{name}',
        ],
        'type' => twa\uikit\FieldTypes\Select::class,
        'label' => 'Select Movies',
        'placeholder' => 'Select Movies',
        'name' => 'movie_ids',
        'multiple' => true,
        'visible_selections' => 2,
        'query_limit' => 50,
        // 'quick_add' => 'movie-casts',
        'options' => [
            'type' => 'query',
            'table' => 'movies',
            'field' => 'name'
        ]
    ],


    'director' => [
        'id' => uniqid(),
        'livewire' => [
            'wire:model' => 'form.{name}',
        ],
        'type' => twa\uikit\FieldTypes\Select::class,
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
    "visibility" => [
        'id' => uniqid(),
        'livewire' => [
            'wire:model' => 'form.{name}',
        ],
        'type' => twa\uikit\FieldTypes\Toggle::class,
        'label' => 'Visibility',
        'placeholder' => 'Visibility',
        'name' => 'visibility'
    ],

    "hide" => [
        'id' => uniqid(),
        'livewire' => [
            'wire:model' => 'form.{name}',
        ],
        'type' => twa\uikit\FieldTypes\Toggle::class,
        'label' => 'Hide',
        'placeholder' => 'Hide',
        'name' => 'hide'
    ],

    'branch' => [
        'id' => uniqid(),
        'livewire' => [
            'wire:model' => 'form.{name}',
        ],
        'type' => twa\uikit\FieldTypes\Select::class,
        'label' => 'Branch',
        'placeholder' => 'Select branch',
        'name' => 'branch_id',
        'multiple' => false,
        'visible_selections' => 3,
        'query_limit' => 50,
        'options' => [
            'type' => 'query',
            'table' => 'branches',
            'field' => 'label_en',
            'conditions' => [
                [
                    'type' => 'where',
                    'column' => 'branches.id',
                    'operand' => null,
                    'value' => 1,
                ],
            ]
        ],
        'required' => true
    ],





    'branch_attribute' => [
        'id' => uniqid(),
        'livewire' => [
            'wire:model' => 'form.{name}',
        ],
        'type' => twa\uikit\FieldTypes\Select::class,
        'label' => 'Branch',
        'placeholder' => 'Select branch',
        'name' => 'branch_id',
        'multiple' => false,
        'visible_selections' => 3,
        'query_limit' => 50,
        'options' => [
            'type' => 'query',
            'table' => 'branches',
            'field' => 'label_en',
            // 'conditions' => [
            //     [
            //         'type' => 'where',
            //         'column' => 'branches.id',
            //         'operand' => null,
            //         'value' => 3,
            //     ],
            // ]
        ],

    ],


    'item_branch' => [
        'id' => uniqid(),
        'livewire' => [
            'wire:model.live' => 'form.{name}',
        ],
        'type' => twa\uikit\FieldTypes\Select::class,
        'label' => 'Price per branch',
        'placeholder' => 'Select branch',
        'name' => 'branch_id',
        'multiple' => true,
        'visible_selections' => 3,
        'query_limit' => 50,
        'options' => [
            'type' => 'query',
            'table' => 'branches',
            'field' => 'label_en',
            'conditions' => [
                [
                    'type' => 'where',
                    'column' => 'branches.id',
                    'operand' => null,
                    'value' => 3,
                ],
            ]
        ],
        'required' => true,

        // 'events' => [

        //     '@input' => '$wire.loadPrices'
        // ]

        // 'dispatch' => [
        //     "init" => "branchselectedvalue",
        //     "change" =>  "branchchangedvalue"
        // ],
    ],
    'item_price' => [
        'id' => uniqid(),
        'livewire' => [
            'wire:model' => 'form.{name}',
        ],
        'type' => twa\uikit\FieldTypes\Number::class,
        'label' => 'Price',
        'placeholder' => 'Enter Price',
        'name' => 'price',
        // 'listen' =>  [
        //                 "change" =>  "branchchangedvalue"
        //             ]
    ],


    'hall_number' => [
        'id' => uniqid(),
        'livewire' => [
            'wire:model' => 'form.{name}',
        ],
        'type' => twa\uikit\FieldTypes\Textfield::class,
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
        'type' => twa\uikit\FieldTypes\Select::class,
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


    'theater_map_json' => [
        'id' => uniqid(),
        'livewire' => [
            'wire:model' => 'form.{name}',
        ],
        'type' => App\Entities\FieldTypes\TheaterMap::class,
        'label' => 'Theater Map',
        'placeholder' => 'Theater Map',
        'name' => 'theater_map',
        'required' => true,
        'listen' =>  [
            "init" => "pricegroupselectedvalue",
            "change" =>  "pricegroupchangedvalue"
        ],

    ],

    'color' => [
        'id' => uniqid(),
        'livewire' => [
            'wire:model' => 'form.{name}',
        ],
        'type' => twa\uikit\FieldTypes\Colorpicker::class,
        'label' => 'Color',
        'placeholder' => 'Enter Color',
        'name' => 'color'
    ],



    'price' => [
        'id' => uniqid(),
        'livewire' => [
            'wire:model' => 'form.{name}',
        ],
        'type' => twa\uikit\FieldTypes\Number::class,
        'label' => 'Price',
        'placeholder' => 'Enter Price',
        'name' => 'price'
    ],

    'total_price' => [
        'id' => uniqid(),
        'livewire' => [
            'wire:model' => 'form.{name}',
        ],
        'type' => twa\uikit\FieldTypes\Number::class,
        'label' => 'Total Price',
        'placeholder' => 'Enter Total Price',
        'name' => 'total_price'
    ],
    'imtiyaz_phone' => [
        'id' => uniqid(),
        'livewire' => [
            'wire:model' => 'form.{name}',
        ],
        'type' => twa\uikit\FieldTypes\Textfield::class,
        'label' => 'Imtiyaz Phone',
        'placeholder' => 'Enter Imtiyaz Phone',
        'name' => 'imtiyaz_phone'
    ],



    'default' => [
        'id' => uniqid(),
        'livewire' => [
            'wire:model' => 'form.{name}',
        ],
        'type' => twa\uikit\FieldTypes\Toggle::class,
        'label' => 'Default',
        'placeholder' => 'Default',
        'name' => 'default'
    ],



    'date_from' => [
        'id' => uniqid(),
        'livewire' => [
            'wire:model' => 'form.{name}',
        ],
        'type' => twa\uikit\FieldTypes\Date::class,
        'label' => 'Date From',
        'placeholder' => 'Select date From',
        'name' => 'date_from'
    ],
    'date_to' => [
        'id' => uniqid(),
        'livewire' => [
            'wire:model' => 'form.{name}',
        ],
        'type' => twa\uikit\FieldTypes\Date::class,
        'label' => 'Date To',
        'placeholder' => 'Select date to`',
        'name' => 'date_to'
    ],

    'end_time' => [
        'id' => uniqid(),
        'livewire' => [
            'wire:model' => 'form.{name}',
        ],
        'type' => twa\uikit\FieldTypes\Select::class,
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
            'field' => 'iso'
        ]

    ],

    'time' => [
        'id' => uniqid(),
        'livewire' => [
            'wire:model' => 'form.{name}',
        ],
        'type' => twa\uikit\FieldTypes\Select::class,

        // 'type' => twa\uikit\FieldTypes\Textfield::class,

        'label' => 'Time',
        'placeholder' => 'Select Times',
        'name' => 'time_id',
        'multiple' => false,
        'visible_selections' => 3,
        'query_limit' => 50,
        // 'quick_add' => "times",
        'options' => [
            'type' => 'query',
            'table' => 'times',
            'field' => 'iso'
        ]
    ],


    'show_times' => [
        'id' => uniqid(),
        'livewire' => [
            'wire:model' => 'form.{name}',
        ],
        'type' => twa\uikit\FieldTypes\Select::class,

        'label' => 'Show Times',
        'placeholder' => 'Select Show Times',
        'name' => 'time_ids',
        'multiple' => true,
        'visible_selections' => 3,
        'query_limit' => 50,
        'options' => [
            'type' => 'query',
            'table' => 'times',
            'field' => 'iso'
        ]
    ],

    'theaters' => [
        'id' => uniqid(),
        'livewire' => [
            'wire:model' => 'form.{name}',
        ],
        'type' => twa\uikit\FieldTypes\Select::class,
        'label' => 'Theatres',
        'placeholder' => 'Select Theatres',
        'name' => 'theater_ids',
        'multiple' => true,
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
            ],
            'conditions' => [
                [
                    'type' => 'where',
                    'column' => 'branches.id',
                    'operand' => null,
                    'value' => '{branch_id}',
                ],
            ]

        ],

    ],
    
    // BigNumber

    'screen_type' => [
        'id' => uniqid(),
        'livewire' => [
            'wire:model' => 'form.{name}',
        ],
        'type' => twa\uikit\FieldTypes\Select::class,
        'label' => 'Screen type',
        'placeholder' => 'Select movie Screen Type',
        'name' => 'screen_type_id',
        'multiple' => false,
        'visible_selections' => 2,
        'query_limit' => 50,
        // 'quick_add' => 'screen-types',
        'options' => [
            'type' => 'query',
            'table' => 'screen_types',
            'field' => 'label'
        ]
    ],


    'screen_type_condition' => [
        'id' => uniqid(),
        'livewire' => [
            'wire:model' => 'form.{name}',
        ],
        'type' => twa\uikit\FieldTypes\Select::class,
        'label' => 'Screen type Condition',
        'placeholder' => 'Select Screen Type',
        'name' => 'screen_type_id',
        'multiple' => true,
        'visible_selections' => 2,
        'hint' => 'Leave it empty if you would like it to be available for all screen types',
        'query_limit' => 50,
        // 'quick_add' => 'screen-types',
        'options' => [
            'type' => 'query',
            'table' => 'screen_types',
            'field' => 'label'
        ],

    ],

    'apply_date' => [
        'id' => uniqid(),
        'livewire' => [
            'wire:model' => 'form.{name}',
        ],
        'type' => twa\uikit\FieldTypes\Toggle::class,
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
        'type' => twa\uikit\FieldTypes\Toggle::class,
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
        'type' => twa\uikit\FieldTypes\Toggle::class,
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
        'type' => twa\uikit\FieldTypes\Toggle::class,
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
        'type' => twa\uikit\FieldTypes\Toggle::class,
        'label' => 'Apply',
        'placeholder' => 'Apply color',
        'name' => 'apply_color',
        'value' => true,
    ],

    'apply_week' => [
        'id' => uniqid(),
        'livewire' => [
            'wire:model' => 'form.{name}',
        ],
        'type' => twa\uikit\FieldTypes\Toggle::class,
        'label' => 'Apply',
        'placeholder' => 'Apply week',
        'name' => 'apply_week',
        'value' => true,
    ],

    


    "first_name" => [
        'id' => uniqid(),
        'livewire' => [
            'wire:model' => 'form.{name}',
        ],
        'type' => twa\uikit\FieldTypes\Textfield::class,
        'label' => 'First Name',
        'placeholder' => 'First Name',
        'name' => 'first_name'
    ],

    "logs_type" => [
        'id' => uniqid(),
        'livewire' => [
            'wire:model' => 'form.{name}',
        ],
        'type' => twa\uikit\FieldTypes\Textfield::class,
        'label' => 'Type',
        'placeholder' => 'Type',
        'name' => 'type'
    ],

    "last_name" => [
        'id' => uniqid(),
        'livewire' => [
            'wire:model' => 'form.{name}',
        ],
        'type' => twa\uikit\FieldTypes\Textfield::class,
        'label' => 'Last Name',
        'placeholder' => 'Last Name',
        'name' => 'last_name'
    ],


    "email" => [
        'id' => uniqid(),
        'livewire' => [
            'wire:model' => 'form.{name}',
        ],
        'type' => twa\uikit\FieldTypes\Email::class,
        'label' => 'Email',
        'placeholder' => 'Email',
        'name' => 'email'
    ],

    "password" => [
        'id' => uniqid(),
        'livewire' => [
            'wire:model' => 'form.{name}',
        ],
        'type' => twa\uikit\FieldTypes\Password::class,
        'label' => 'Password',
        'placeholder' => 'Password',
        'name' => 'password'
    ],




    'question' => [
        'id' => uniqid(),
        'livewire' => [
            'wire:model' => 'form.{name}',
        ],
        'type' => twa\uikit\FieldTypes\Textfield::class,
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
        'type' => twa\uikit\FieldTypes\Textarea::class,
        'label' => 'Answer',
        'placeholder' => 'Enter Answer',
        'name' => 'answer'
    ],

    'text' => [
        'id' => uniqid(),
        'livewire' => [
            'wire:model' => 'form.{name}',
        ],
        'type' => twa\uikit\FieldTypes\Textarea::class,
        'label' => 'Text',
        'placeholder' => 'Enter text',
        'name' => 'text'
    ],

    'cta_label' => [
        'id' => uniqid(),
        'livewire' => [
            'wire:model' => 'form.{name}',
        ],
        'type' => twa\uikit\FieldTypes\Textfield::class,
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
        'type' => twa\uikit\FieldTypes\Textfield::class,
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
        'type' => twa\uikit\FieldTypes\Textfield::class,
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
        'type' => twa\uikit\FieldTypes\Textfield::class,
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
        'type' => twa\uikit\FieldTypes\Number::class,
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
        'type' => twa\uikit\FieldTypes\Textfield::class,
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
        'type' => twa\uikit\FieldTypes\Editor::class,
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
        'type' => twa\uikit\FieldTypes\Textfield::class,
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
        'type' => twa\uikit\FieldTypes\Textfield::class,
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
        'type' => twa\uikit\FieldTypes\Textfield::class,
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
        'type' => twa\uikit\FieldTypes\Textfield::class,
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
        'type' => twa\uikit\FieldTypes\Textfield::class,
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
        'type' => twa\uikit\FieldTypes\Textfield::class,
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
        'type' => twa\uikit\FieldTypes\Textfield::class,
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
        'type' => twa\uikit\FieldTypes\Textfield::class,
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

        'type' => twa\uikit\FieldTypes\Textfield::class,

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

        'type' => twa\uikit\FieldTypes\Textfield::class,

        'label' => 'Username',
        'placeholder' => 'Enter Username',
        'name' => 'username',
        'container' => 'col-span-6',
    ],

    'passcode' => [
        'id' => uniqid(),
        'livewire' => [
            'wire:model' => 'form.{name}',
        ],
        'type' => twa\uikit\FieldTypes\Password::class,
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
        'type' => twa\uikit\FieldTypes\Select::class,
        'label' => 'Role',
        'placeholder' => 'Select role',
        'name' => 'role',
        'multiple' => false,
        'visible_selections' => 3,
        'query_limit' => 50,
        'options' => [
            'type' => 'static',
            'list' => [

                ['value' => 'cashier', 'label' => 'Cashier'],
                ['value' => 'manager', 'label' => 'Manager'],
            ]

        ]
    ],



    'user_role' => [
        'id' => uniqid(),
        'livewire' => [
            'wire:model' => 'form.{name}',
        ],
        'type' => twa\uikit\FieldTypes\Select::class,
        'label' => 'Roles',
        'placeholder' => 'Select roles',
        'name' => 'roles',
        'multiple' => true,
        'visible_selections' => 3,
        'query_limit' => 50,
        'options' => [
            'type' => 'query',
            'table' => 'cms_user_roles',
            'field' => 'label'
        ]
    ],
    'phone' => [
        'id' => uniqid(),
        'livewire' => [
            'wire:model' => 'form.{name}',
        ],
        'type' => twa\uikit\FieldTypes\Textfield::class,
        'label' => 'Phone',
        'placeholder' => 'Enter phone',
        'name' => 'phone',
        'container' => 'col-span-6',
    ],

    'phone_email_card_number' => [
        'id' => uniqid(),
        'livewire' => [
            'wire:model' => 'form.{name}',
        ],
        'type' => twa\uikit\FieldTypes\Textfield::class,
        'label' => 'Search by Phone/ Card Number/ Email / User id',
        'placeholder' => 'Enter Phone/ Card Number / Email',
        'name' => 'phone_email_card_number',
        'container' => 'col-span-6',
    ],




    'profile_picture' => [
        'id' => uniqid(),
        'livewire' => [
            'wire:model' => 'form.{name}',
        ],
        'type' => twa\uikit\FieldTypes\FileUpload::class,
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
        'type' => twa\uikit\FieldTypes\Select::class,
        'label' => 'Gender',
        'placeholder' => 'Select gender',
        'name' => 'gender',
        'multiple' => false,
        'visible_selections' => 3,
        'query_limit' => 50,
        'options' => [
            'type' => 'static',
            'list' => [

                ['value' => 'male', 'label' => 'Male'],
                ['value' => 'female', 'label' => 'Female'],
            ]

        ]
    ],
    'payment_type' => [
        'id' => uniqid(),
        'livewire' => [
            'wire:model' => 'form.{name}',
        ],
        'type' => twa\uikit\FieldTypes\Select::class,
        'label' => 'Select Payment Type',
        'placeholder' => 'Select Payment Type',
        'name' => 'payment_type',
        'multiple' => false,
        'visible_selections' => 3,
        'query_limit' => 50,
        'options' => [
            'type' => 'static',
            'list' => [

                ['value' => 'cc_dc', 'label' => 'Credit / Debit Card'],
                ['value' => 'op', 'label' => 'Online Payment'],
                ['value' => 'wp', 'label' => 'Wallet Payment'],
                ['value' => 'cash', 'label' => 'Cash Payment'],
            ]

        ]
    ],


    'position' => [
        'id' => uniqid(),
        'livewire' => [
            'wire:model' => 'form.{name}',
        ],
        'type' => twa\uikit\FieldTypes\Select::class,
        'label' => 'Position',
        'placeholder' => 'Select position',
        'name' => 'position',
        'multiple' => false,
        'visible_selections' => 3,
        'query_limit' => 50,
        'options' => [
            'type' => 'static',
            'list' => [

                ['value' => 'about', 'label' => 'About Page'],
                ['value' => 'home', 'label' => 'Home Page'],
            ]

        ]
    ],


    'marital_status' => [
        'id' => uniqid(),
        'livewire' => [
            'wire:model' => 'form.{name}',
        ],
        'type' => twa\uikit\FieldTypes\Select::class,
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

    'cms_user' => [
        'id' => uniqid(),
        'livewire' => [
            'wire:model' => 'form.{name}',
        ],
        'type' => twa\uikit\FieldTypes\Select::class,
        'label' => 'Cms User',
        'placeholder' => 'Select Cms user',
        'name' => 'cms_user_id',
        'multiple' => false,
        'visible_selections' => 3,
        'query_limit' => 50,
        'options' => [
            'type' => 'query',
            'table' => 'cms_users',
            'field' => 'name'
        ]
    ],


    'date_birth' => [
        'id' => uniqid(),
        'livewire' => [
            'wire:model' => 'form.{name}',
        ],
        'type' => twa\uikit\FieldTypes\Date::class,
        'label' => 'Date of Birth',
        'placeholder' => 'Enter date of birth',
        'name' => 'dob'
    ],

    'date_marriage' => [
        'id' => uniqid(),
        'livewire' => [
            'wire:model' => 'form.{name}',
        ],
        'type' => twa\uikit\FieldTypes\Date::class,
        'label' => 'Date of marriage',
        'placeholder' => 'Enter date of marriage',
        'name' => 'dom'
    ],


    'login_provider' => [
        'id' => uniqid(),
        'livewire' => [
            'wire:model' => 'form.{name}',
        ],
        'type' => twa\uikit\FieldTypes\Hidden::class,
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
        'type' => twa\uikit\FieldTypes\Hidden::class,
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
        'type' => twa\uikit\FieldTypes\Textfield::class,
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

        'type' => twa\uikit\FieldTypes\Textfield::class,

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

        'type' => twa\uikit\FieldTypes\Select::class,

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

        'type' => twa\uikit\FieldTypes\Select::class,

        'label' => 'User Id',
        'placeholder' => 'Enter user id',
        'name' => 'pos_user_id',
        'container' => 'col-span-6',
    ],


    'kiosk_user_id' => [
        'id' => uniqid(),
        'livewire' => [
            'wire:model' => 'form.{name}',
        ],

        'type' => twa\uikit\FieldTypes\Select::class,

        'label' => 'Kiosk Id',
        'placeholder' => 'Enter Kiosk id',
        'name' => 'kiosk_user_id',
        'container' => 'col-span-6',
    ],



    'item_id' => [
        'id' => uniqid(),
        'livewire' => [
            'wire:model' => 'form.{name}',
        ],

        'type' => twa\uikit\FieldTypes\Select::class,

        'label' => 'Item Id',
        'placeholder' => 'Enter item id',
        'name' => 'item_id',
        'container' => 'col-span-6',
    ],
    'order_id' => [
        'id' => uniqid(),
        'livewire' => [
            'wire:model' => 'form.{name}',
        ],

        'type' => twa\uikit\FieldTypes\BigNumber::class,

        'label' => 'Order Id',
        'placeholder' => 'Enter order id',
        'name' => 'order_id',
        'container' => 'col-span-6',
    ],


    'coupon_order_id' => [
        'id' => uniqid(),
        'livewire' => [
            'wire:model' => 'form.{name}',
        ],

        'type' => twa\uikit\FieldTypes\Hidden::class,

        'label' => 'Order Id',
        'placeholder' => 'Enter order id',
        'name' => 'order_id',
        'container' => 'col-span-6',
    ],





    'cart_id' => [
        'id' => uniqid(),
        'livewire' => [
            'wire:model' => 'form.{name}',
        ],

        'type' => twa\uikit\FieldTypes\Select::class,

        'label' => 'Cart Id',
        'placeholder' => 'Enter cart id',
        'name' => 'cart_id',
        'container' => 'col-span-6',
    ],
    'movie_show_id' => [
        'id' => uniqid(),
        'livewire' => [
            'wire:model' => 'form.{name}',
        ],

        'type' => twa\uikit\FieldTypes\Select::class,

        'label' => 'Movie Show Id',
        'placeholder' => 'Enter Movie Show Id',
        'name' => 'movie_show_id',
        'container' => 'col-span-6',
    ],

    'seat' => [
        'id' => uniqid(),
        'livewire' => [
            'wire:model' => 'form.{name}',
        ],

        'type' => twa\uikit\FieldTypes\Textfield::class,

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

        'type' => twa\uikit\FieldTypes\Select::class,

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

        'type' => twa\uikit\FieldTypes\Textfield::class,

        'label' => 'Code',
        'placeholder' => 'Enter Code',
        'name' => 'code',
        'container' => 'col-span-6',
    ],
    'discount_flat' => [
        'id' => uniqid(),
        'livewire' => [
            'wire:model' => 'form.{name}',
        ],

        'type' => twa\uikit\FieldTypes\Number::class,

        'label' => 'Discount Flat',
        'placeholder' => 'Enter Discount Flat',
        'name' => 'discount_flat',
        'container' => 'col-span-6',
    ],
    'percentage' => [
        'id' => uniqid(),
        'livewire' => [
            'wire:model' => 'form.{name}',
        ],

        'type' => twa\uikit\FieldTypes\Number::class,

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
        'type' => twa\uikit\FieldTypes\Datetime::class,

        'label' => 'Used At',
        'placeholder' => 'Enter Used At',
        'name' => 'used_at',
        'container' => 'col-span-6',
    ],


    'coupon_used_at' => [
        'id' => uniqid(),
        'livewire' => [
            'wire:model' => 'form.{name}',
        ],
        'type' => twa\uikit\FieldTypes\Hidden::class,

        'label' => 'Used At',
        'placeholder' => 'Enter Used At',
        'name' => 'used_at',
        'container' => 'col-span-6',
    ],


    'login_time' => [
        'id' => uniqid(),
        'livewire' => [
            'wire:model' => 'form.{name}',
        ],
        'type' => twa\uikit\FieldTypes\Datetime::class,

        'label' => 'Login Time',
        'placeholder' => 'Enter login time',
        'name' => 'login_time',
        'container' => 'col-span-6',
    ],

    'logout_time' => [
        'id' => uniqid(),
        'livewire' => [
            'wire:model' => 'form.{name}',
        ],
        'type' => twa\uikit\FieldTypes\Datetime::class,

        'label' => 'Login Time',
        'placeholder' => 'Enter Logout time',
        'name' => 'logout_time',
        'container' => 'col-span-6',
    ],

    'user_card_id' => [
        'id' => uniqid(),
        'livewire' => [
            'wire:model' => 'form.{name}',
        ],
        'type' => twa\uikit\FieldTypes\Select::class,
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
        'type' => twa\uikit\FieldTypes\Select::class,
        'label' => 'Payment Method Id',
        'placeholder' => 'Payment Method Id',
        'name' => 'payment_method_id',
        'container' => 'col-span-6',
    ],

    'payment_attempt_id' => [
        'id' => uniqid(),
        'livewire' => [
            'wire:model' => 'form.{name}',
        ],
        'type' => twa\uikit\FieldTypes\Select::class,
        'label' => 'Payment Attempt Id',
        'placeholder' => 'Payment Attempt Id',
        'name' => 'payment_attempt_id',
        'container' => 'col-span-6',
    ],

    'zone_id' => [
        'id' => uniqid(),
        'livewire' => [
            'wire:model' => 'form.{name}',
        ],
        'type' => twa\uikit\FieldTypes\Select::class,
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

        'type' => twa\uikit\FieldTypes\Textfield::class,

        'label' => 'Barcode',
        'placeholder' => 'Enter Barcode',
        'name' => 'barcode',
        'container' => 'col-span-6',
    ],

    'item_code' => [
        'id' => uniqid(),
        'livewire' => [
            'wire:model' => 'form.{name}',
        ],

        'type' => twa\uikit\FieldTypes\Textfield::class,

        'label' => 'Item Code',
        'placeholder' => 'Enter Item Code',
        'name' => 'item_code',
        'container' => 'col-span-6',
    ],
    'card_number' => [
        'id' => uniqid(),
        'livewire' => [
            'wire:model' => 'form.{name}',
        ],

        'type' => twa\uikit\FieldTypes\Textfield::class,

        'label' => 'Card Number',
        'placeholder' => 'Enter Card Number',
        'name' => 'card_number',
        'container' => 'col-span-6',
        'required' => true
    ],
    'coupon_id' => [
        'id' => uniqid(),
        'livewire' => [
            'wire:model' => 'form.{name}',
        ],
        'type' => twa\uikit\FieldTypes\Select::class,
        'label' => 'Coupon',
        'placeholder' => 'Select Coupon ',
        'name' => 'coupon_id',
        'multiple' => false,
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
        'type' => twa\uikit\FieldTypes\Textfield::class,

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
        'type' => twa\uikit\FieldTypes\Datetime::class,

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
        'type' => twa\uikit\FieldTypes\Datetime::class,
        'label' => 'Date of expiry',
        'placeholder' => 'Enter date of expiry',
        'name' => 'expires_at'
    ],

    'otp_expires_at' => [
        'id' => uniqid(),
        'livewire' => [
            'wire:model' => 'form.{name}',
        ],
        'type' => twa\uikit\FieldTypes\Datetime::class,
        'label' => 'Date of otp expiry',
        'placeholder' => 'Enter date of otp expiry',
        'name' => 'otp_expires_at'
    ],

    'token_expires_at' => [
        'id' => uniqid(),
        'livewire' => [
            'wire:model' => 'form.{name}',
        ],
        'type' => twa\uikit\FieldTypes\Datetime::class,
        'label' => 'Date of token expiry',
        'placeholder' => 'Enter date of token expiry',
        'name' => 'token_expires_at'
    ],



    'email_verified' => [
        'id' => uniqid(),
        'livewire' => [
            'wire:model' => 'form.{name}',
        ],
        'type' => twa\uikit\FieldTypes\Datetime::class,
        'label' => 'Email Verified',
        'placeholder' => 'Email Verified',
        'name' => 'email_verified'
    ],

    'email_verified_at' => [
        'id' => uniqid(),
        'livewire' => [
            'wire:model' => 'form.{name}',
        ],
        'type' => twa\uikit\FieldTypes\Datetime::class,
        'label' => 'Email Verified At',
        'placeholder' => 'Email Verified At',
        'name' => 'email_verified_at'
    ],

    'phone_verified' => [
        'id' => uniqid(),
        'livewire' => [
            'wire:model' => 'form.{name}',
        ],
        'type' => twa\uikit\FieldTypes\Datetime::class,
        'label' => 'Phone Verified',
        'placeholder' => 'Phone Verified',
        'name' => 'phone_verified'
    ],


    'phone_verified_at' => [
        'id' => uniqid(),
        'livewire' => [
            'wire:model' => 'form.{name}',
        ],
        'type' => twa\uikit\FieldTypes\Datetime::class,
        'label' => 'Phone Verified at',
        'placeholder' => 'Phone Verified at',
        'name' => 'phone_verified_at'
    ],



    'ip' => [
        'id' => uniqid(),
        'livewire' => [
            'wire:model' => 'form.{name}',
        ],

        'type' => twa\uikit\FieldTypes\Textfield::class,

        'label' => 'IP',
        'placeholder' => 'Enter ip',
        'name' => 'ip',
        'container' => 'col-span-6',
    ],



    'action' => [
        'id' => uniqid(),
        'livewire' => [
            'wire:model' => 'form.{name}',
        ],

        'type' => twa\uikit\FieldTypes\Textfield::class,

        'label' => 'Action',
        'placeholder' => 'Enter Action',
        'name' => 'action',
        'container' => 'col-span-6',
    ],

    'driver' => [
        'id' => uniqid(),
        'livewire' => [
            'wire:model' => 'form.{name}',
        ],
        'type' => twa\uikit\FieldTypes\Textfield::class,
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
        'type' => twa\uikit\FieldTypes\Textfield::class,
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
        'type' => twa\uikit\FieldTypes\Number::class,
        'label' => 'Amount',
        'placeholder' => 'Enter Amount',
        'name' => 'amount',
        'container' => 'col-span-12',
    ],


    'balance' => [
        'id' => uniqid(),
        'livewire' => [
            'wire:model' => 'form.{name}',
        ],
        'type' => twa\uikit\FieldTypes\Number::class,
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
        'type' => twa\uikit\FieldTypes\Textfield::class,
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
        'type' => twa\uikit\FieldTypes\Textfield::class,
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
        'type' => twa\uikit\FieldTypes\Textfield::class,
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
        'type' => twa\uikit\FieldTypes\Textfield::class,
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
        'type' => twa\uikit\FieldTypes\Number::class,
        'label' => ' Redeem Points',
        'placeholder' => 'Redeem Points',
        'name' => 'redeem_points'
    ],

    "one_time_usage" => [
        'id' => uniqid(),
        'livewire' => [
            'wire:model' => 'form.{name}',
        ],
        'type' => twa\uikit\FieldTypes\Toggle::class,
        'label' => 'One Time Usage',
        'placeholder' => 'One Time Usage',
        'name' => 'one_time_usage'
    ],



    "completed" => [
        'id' => uniqid(),
        'livewire' => [
            'wire:model' => 'form.{name}',
        ],
        'type' => twa\uikit\FieldTypes\Toggle::class,
        'label' => 'Completed',
        'placeholder' => 'Completed',
        'name' => 'completed'
    ],

    'final_price' => [
        'id' => uniqid(),
        'livewire' => [
            'wire:model' => 'form.{name}',
        ],
        'type' => twa\uikit\FieldTypes\Number::class,
        'label' => 'Price',
        'placeholder' => 'Enter Price',
        'name' => 'final_price'
    ],
    'gained_points' => [
        'id' => uniqid(),
        'livewire' => [
            'wire:model' => 'form.{name}',
        ],
        'type' => twa\uikit\FieldTypes\Number::class,
        'label' => 'Gained points',
        'placeholder' => 'Enter Gained points',
        'name' => 'gained_points'
    ],

    'discount' => [
        'id' => uniqid(),
        'livewire' => [
            'wire:model' => 'form.{name}',
        ],
        'type' => twa\uikit\FieldTypes\Number::class,
        'label' => 'Discount',
        'placeholder' => 'Enter Discount',
        'name' => 'discount'
    ],

    'refunded_cashier_id' => [
        'id' => uniqid(),
        'livewire' => [
            'wire:model' => 'form.{name}',
        ],

        'type' => twa\uikit\FieldTypes\Select::class,

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

        'type' => twa\uikit\FieldTypes\Select::class,

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
        'type' => twa\uikit\FieldTypes\Datetime::class,
        'label' => 'Refunded At',
        'placeholder' => 'Refunded at',
        'name' => 'refunded_at'
    ],

    'distributor' => [
        'id' => uniqid(),
        'livewire' => [
            'wire:model' => 'form.{name}',
        ],

        'type' => twa\uikit\FieldTypes\Select::class,

        'multiple' => false,
        'visible_selections' => 3,
        'query_limit' => 50,
        //        'quick_add' => 'movie-genres',
        'options' => [
            'type' => 'query',
            'table' => 'distributors',
            'field' => 'label'
        ],

        'label' => 'Distributor ',
        'placeholder' => 'Select distributor',
        'name' => 'distributor_id',
        'container' => 'col-span-12',



        'dispatch' => [
            "init" => "distributorselectedvalue",
            "change" =>  "distributorchangedvalue"
        ],
    ],

    'commission_settings' => [
        'id' => uniqid(),
        'livewire' => [
            'wire:model' => 'form.{name}',
        ],

        'type' => \App\Entities\FieldTypes\CommissionSettings::class,

        'label' => 'Commission Settings',
        'placeholder' => 'Commission Settings',
        'name' => 'commission_settings',
        'container' => 'col-span-12',
    ],
    'price_settings' => [
        'id' => uniqid(),
        'livewire' => [
            'wire:model' => 'form.{name}',
        ],

        'type' => \App\Entities\FieldTypes\PriceSettings::class,

        'label' => 'Price Settings',
        'placeholder' => 'Price Settings',
        'name' => 'price_settings',
        'container' => 'col-span-12',
    ],

    'distributor_commission_settings' => [
        'id' => uniqid(),
        'livewire' => [
            'wire:model' => 'form.{name}',
        ],

        'type' => \App\Entities\FieldTypes\CommissionSettings::class,

        'label' => 'Commission Settings',
        'placeholder' => 'Commission Settings',
        'name' => 'commission_settings',
        'container' => 'col-span-12',

        'listen' =>  [
            //            "init" => "distributorselectedvalue",
            "change" =>  "distributorchangedvalue"
        ]
    ],

    'transaction_type' => [
        'id' => uniqid(),
        'livewire' => [
            'wire:model' => 'form.{name}',
        ],
        'type' => twa\uikit\FieldTypes\Select::class,
        'label' => 'Type',
        'placeholder' => 'Select Type',
        'name' => 'transaction_type',
        'multiple' => false,
        'visible_selections' => 3,
        'query_limit' => 50,

        'options' => [
            'type' => 'static',
            'list' => [

                ['value' => 'topup', 'label' => 'Top-Up'],
                ['value' => 'deduct', 'label' => 'Deduct'],
            ]

        ],
        'container' => 'col-span-12',
    ],


    'transactionable_id' => [
        'id' => uniqid(),
        'livewire' => [
            'wire:model' => 'form.{name}',
        ],
        'type' => twa\uikit\FieldTypes\Textfield::class,
        'label' => 'Transactionable Id',
        'placeholder' => 'Enter Transactionable Id',
        'name' => 'transactionable_id'
    ],


    'transactionable_type' => [
        'id' => uniqid(),
        'livewire' => [
            'wire:model' => 'form.{name}',
        ],
        'type' => twa\uikit\FieldTypes\Textfield::class,
        'label' => 'Transactionable type',
        'placeholder' => 'Enter Transactionable Type',
        'name' => 'transactionable_type'
    ],



    'userable_id' => [
        'id' => uniqid(),
        'livewire' => [
            'wire:model' => 'form.{name}',
        ],
        'type' => twa\uikit\FieldTypes\Textfield::class,
        'label' => 'Userable Id',
        'placeholder' => 'Enter Userable Id',
        'name' => 'userable_id'
    ],

    'userable_model' => [
        'id' => uniqid(),
        'livewire' => [
            'wire:model' => 'form.{name}',
        ],
        'type' => twa\uikit\FieldTypes\Textfield::class,
        'label' => 'Userable Model',
        'placeholder' => 'Enter Userable Model',
        'name' => 'userable_model'
    ],




    'discount_type' => [
        'id' => uniqid(),
        'livewire' => [
            'wire:model' => 'form.{name}',
        ],
        'type' => twa\uikit\FieldTypes\Textfield::class,
        'label' => 'Discount type',
        'placeholder' => 'Enter Discount Type',
        'name' => 'discount_type'
    ],
    'minimum_topup_amount' => [
        'id' => uniqid(),
        'livewire' => [
            'wire:model' => 'form.{name}',
        ],
        'type' => twa\uikit\FieldTypes\Number::class,
        'label' => 'Minimum Topup Amount',
        'placeholder' => 'Minimum Topup Amount',
        'name' => 'minimum_topup_amount',
        'container' => 'col-span-6',
    ],
    'maximum_topup_amount' => [
        'id' => uniqid(),
        'livewire' => [
            'wire:model' => 'form.{name}',
        ],
        'type' => twa\uikit\FieldTypes\Number::class,
        'label' => 'Maximum Topup Amount',
        'placeholder' => 'Maximum Topup Amount',
        'name' => 'maximum_topup_amount',
        'container' => 'col-span-6',
    ],
    "printed_at" => [
        'id' => uniqid(),
        'livewire' => [
            'wire:model' => 'form.{name}',
        ],
        'type' => twa\uikit\FieldTypes\Datetime::class,
        'label' => 'Printed At',
        'placeholder' => 'Printed At',
        'name' => 'printed_at'
    ],


    'rate' => [
        'id' => uniqid(),
        'livewire' => [
            'wire:model' => 'form.{name}',
        ],

        'type' => twa\uikit\FieldTypes\Number::class,

        'label' => 'Rate',
        'placeholder' => 'Enter Rate',
        'name' => 'rate',
        'container' => 'col-span-6',
    ],
    'comment' => [
        'id' => uniqid(),
        'livewire' => [
            'wire:model' => 'form.{name}',
        ],
        'type' => twa\uikit\FieldTypes\Textarea::class,
        'label' => 'Commnent',
        'placeholder' => 'Enter comment',
        'name' => 'comment',
        'container' => 'col-span-12',
    ],



    'dist_share_percentage' => [
        'id' => uniqid(),
        'livewire' => [
            'wire:model' => 'form.{name}',
        ],
        'type' => twa\uikit\FieldTypes\Number::class,
        'label' => 'Distributor Share Percentage',
        'placeholder' => 'Enter distributor share percentage',
        'name' => 'dist_share_percentage',
        'container' => 'col-span-12',
    ],


    'dist_share_amount' => [
        'id' => uniqid(),
        'livewire' => [
            'wire:model' => 'form.{name}',
        ],
        'type' => twa\uikit\FieldTypes\Number::class,
        'label' => 'Distributor Share amnout',
        'placeholder' => 'Enter distibutor share amount',
        'name' => 'dist_share_amount',
        'container' => 'col-span-12',
    ],
    'signature' => [
        'id' => uniqid(),
        'livewire' => [
            'wire:model' => 'form.{name}',
        ],
        'type' => twa\uikit\FieldTypes\Textfield::class,
        'label' => 'Signature',
        'placeholder' => 'Enter signature',
        'name' => 'signature',
        'container' => 'col-span-12',
    ],
    'identifier' => [
        'id' => uniqid(),
        'livewire' => [
            'wire:model' => 'form.{name}',
        ],
        'type' => twa\uikit\FieldTypes\Textfield::class,
        'label' => 'Identifier',
        'placeholder' => 'Enter identifier',
        'name' => 'identifier',
        'container' => 'col-span-12',
    ],

    'financial_phone' => [
        'id' => uniqid(),
        'livewire' => [
            'wire:model' => 'form.{name}',
        ],
        'type' => twa\uikit\FieldTypes\Textfield::class,
        'label' => 'Financial Phone',
        'placeholder' => 'Enter Financial Phone',
        'name' => 'financial_phone',
        'container' => 'col-span-6',
        'translatable' => false,
    ],

    'financial_email' => [
        'id' => uniqid(),
        'livewire' => [
            'wire:model' => 'form.{name}',
        ],
        'type' => twa\uikit\FieldTypes\Textfield::class,
        'label' => 'Financial Email',
        'placeholder' => 'Enter Financial Email',
        'name' => 'financial_email',
        'container' => 'col-span-6',
        'translatable' => false,
    ],

    'operator_phone' => [
        'id' => uniqid(),
        'livewire' => [
            'wire:model' => 'form.{name}',
        ],
        'type' => twa\uikit\FieldTypes\Textfield::class,
        'label' => 'Operator Phone',
        'placeholder' => 'Enter Operator Phone',
        'name' => 'operator_phone',
        'container' => 'col-span-6',
        'translatable' => false,
    ],

    'operator_email' => [
        'id' => uniqid(),
        'livewire' => [
            'wire:model' => 'form.{name}',
        ],
        'type' => twa\uikit\FieldTypes\Textfield::class,
        'label' => 'Operator Email',
        'placeholder' => 'Enter Operator Email',
        'name' => 'operator_email',
        'container' => 'col-span-6',
        'translatable' => false,
    ],


    'management_email' => [
        'id' => uniqid(),
        'livewire' => [
            'wire:model' => 'form.{name}',
        ],
        'type' => twa\uikit\FieldTypes\Textfield::class,
        'label' => 'Managment Email',
        'placeholder' => 'Enter Managment Email',
        'name' => 'management_email',
        'container' => 'col-span-6',
        'translatable' => false,
    ],


    'management_phone' => [
        'id' => uniqid(),
        'livewire' => [
            'wire:model' => 'form.{name}',
        ],
        'type' => twa\uikit\FieldTypes\Textfield::class,
        'label' => 'Managment Phone',
        'placeholder' => 'Enter Managment Phone',
        'name' => 'management_phone',
        'container' => 'col-span-6',
        'translatable' => false,
    ],


    'currency' => [

        'id' => uniqid(),
        'livewire' => [
            'wire:model' => 'form.{name}',
        ],
        'type' => twa\uikit\FieldTypes\Textfield::class,
        'label' => 'Currency ISO',
        'placeholder' => 'Currency ISO',
        'name' => 'currency',
        'container' => 'col-span-12',
        'translatable' => false,
    ],

    'menu_type' => [
        'id' => uniqid(),
        'livewire' => [
            'wire:model' => 'form.{name}',
        ],
        'type' => twa\uikit\FieldTypes\Textfield::class,

        'label' => 'Type',
        'placeholder' => 'Enter type',
        'name' => 'type',
        'container' => 'col-span-6',
    ],


    'menu_key' => [
        'id' => uniqid(),
        'livewire' => [
            'wire:model' => 'form.{name}',
        ],
        'type' => twa\uikit\FieldTypes\Textfield::class,

        'label' => 'Menu Key',
        'placeholder' => 'Enter Menu Key',
        'name' => 'menu_key',
        'container' => 'col-span-6',
    ],



    // 'textfield_options' => [
    //     'id' => uniqid(),
    //     'livewire' => [
    //         'wire:model' => 'form.{name}',
    //     ],
    //     'type' => twa\uikit\FieldTypes\Select::class,
    //     'label' => '',
    //     'placeholder' => 'Select option',
    //     'name' => 'textfield_options',
    //     'multiple' => false,
    //     'visible_selections' => 3,
    //     'query_limit' => 50,
    //     'options' => [
    //         'type' => 'static',
    //         'list' => [

    //                 ['value' => 'topup' , 'label' => 'Top-Up'],
    //                 ['value' => 'deduct' , 'label' => 'Deduct'],
    //             ]

    //         ],
    //         'container' => 'col-span-12',
    // ],


    'player_id' => [
        'id' => uniqid(),
        'livewire' => [
            'wire:model' => 'form.{name}',
        ],
        'type' => twa\uikit\FieldTypes\Number::class,
        'label' => ' Player Id',
        'placeholder' => 'Enter Player Id',
        'name' => 'player_id'
    ],

    "survey_submitted" => [
        'id' => uniqid(),
        'livewire' => [
            'wire:model' => 'form.{name}',
        ],
        'type' => twa\uikit\FieldTypes\Toggle::class,
        'label' => 'Survey Submitted',
        'placeholder' => 'Survey Submitted',
        'name' => 'survey_submitted'
    ],

    "super_admin" => [
        'id' => uniqid(),
        'livewire' => [
            'wire:model' => 'form.{name}',
        ],
        'type' => twa\uikit\FieldTypes\Toggle::class,
        'label' => 'Super Admin',
        'placeholder' => 'Super Admin',
        'name' => 'super_admin'
    ],

    'rating_movie' => [
        'id' => uniqid(),
        'livewire' => [
            'wire:model' => 'form.{name}',
        ],
        'type' => twa\uikit\FieldTypes\Number::class,
        'label' => 'Rating Movie',
        'placeholder' => 'Enter rating Movie',
        'name' => 'rating_movie'
    ],

    'rating_popcorn_pepsi' => [
        'id' => uniqid(),
        'livewire' => [
            'wire:model' => 'form.{name}',
        ],
        'type' => twa\uikit\FieldTypes\Number::class,
        'label' => 'Rating popcorn pepsi',
        'placeholder' => 'Enter rating popcorn pepsi',
        'name' => 'rating_popcorn_pepsi'
    ],


    'rating_other_items' => [
        'id' => uniqid(),
        'livewire' => [
            'wire:model' => 'form.{name}',
        ],
        'type' => twa\uikit\FieldTypes\Number::class,
        'label' => 'Rating Other Items',
        'placeholder' => 'Enter Other Items',
        'name' => 'rating_other_items'
    ],


    'rating_ticketing_service' => [
        'id' => uniqid(),
        'livewire' => [
            'wire:model' => 'form.{name}',
        ],
        'type' => twa\uikit\FieldTypes\Number::class,
        'label' => 'Rating Ticketing Service',
        'placeholder' => 'Enter Ticketing Service',
        'name' => 'rating_ticketing_service'
    ],



    'rating_cafeteria_service' => [
        'id' => uniqid(),
        'livewire' => [
            'wire:model' => 'form.{name}',
        ],
        'type' => twa\uikit\FieldTypes\Number::class,
        'label' => 'Rating Cafeteria Service',
        'placeholder' => 'Enter Cafeteria Service',
        'name' => 'rating_cafeteria_service'
    ],



    'rating_users_service' => [
        'id' => uniqid(),
        'livewire' => [
            'wire:model' => 'form.{name}',
        ],
        'type' => twa\uikit\FieldTypes\Number::class,
        'label' => 'Rating Users Service',
        'placeholder' => 'Enter Users Service',
        'name' => 'rating_users_service'
    ],


    'rating_ticketing_friendliness' => [
        'id' => uniqid(),
        'livewire' => [
            'wire:model' => 'form.{name}',
        ],
        'type' => twa\uikit\FieldTypes\Number::class,
        'label' => 'Rating Ticketing Friendliness',
        'placeholder' => 'Enter Rating Ticketing Friendliness',
        'name' => 'rating_ticketing_friendliness'
    ],



    'rating_cafeteria_friendliness' => [
        'id' => uniqid(),
        'livewire' => [
            'wire:model' => 'form.{name}',
        ],
        'type' => twa\uikit\FieldTypes\Number::class,
        'label' => 'Rating Cafeteria Friendliness',
        'placeholder' => 'Enter Rating Cafeteria Friendliness',
        'name' => 'rating_cafeteria_friendliness'
    ],



    'rating_users_friendliness' => [
        'id' => uniqid(),
        'livewire' => [
            'wire:model' => 'form.{name}',
        ],
        'type' => twa\uikit\FieldTypes\Number::class,
        'label' => 'Rating Users Friendliness',
        'placeholder' => 'Enter Rating users Friendliness',
        'name' => 'rating_users_friendliness'
    ],


    'rating_ticketing_cleanliness' => [
        'id' => uniqid(),
        'livewire' => [
            'wire:model' => 'form.{name}',
        ],
        'type' => twa\uikit\FieldTypes\Number::class,
        'label' => 'Rating Ticketing Cleanliness',
        'placeholder' => 'Enter Ticketing Cleanliness',
        'name' => 'rating_ticketing_cleanliness'
    ],


    'rating_cafeteria_cleanliness' => [
        'id' => uniqid(),
        'livewire' => [
            'wire:model' => 'form.{name}',
        ],
        'type' => twa\uikit\FieldTypes\Number::class,
        'label' => 'Rating Cafeteria Cleanliness',
        'placeholder' => 'Enter Cafeteria Cleanliness',
        'name' => 'rating_cafeteria_cleanliness'
    ],


    'rating_users_cleanliness' => [
        'id' => uniqid(),
        'livewire' => [
            'wire:model' => 'form.{name}',
        ],
        'type' => twa\uikit\FieldTypes\Number::class,
        'label' => 'Rating Users Cleanliness',
        'placeholder' => 'Enter Users Cleanliness',
        'name' => 'rating_users_cleanliness'
    ],


    'rating_app' => [
        'id' => uniqid(),
        'livewire' => [
            'wire:model' => 'form.{name}',
        ],
        'type' => twa\uikit\FieldTypes\Number::class,
        'label' => 'Rating App',
        'placeholder' => 'Enter Rating App',
        'name' => 'rating_app'
    ],


    'message' => [
        'id' => uniqid(),
        'livewire' => [
            'wire:model' => 'form.{name}',
        ],
        'type' => twa\uikit\FieldTypes\Textarea::class,
        'label' => 'Message',
        'placeholder' => 'Enter Message',
        'name' => 'message'
    ],


    'filter_branch' => [
        'id' => uniqid(),
        'livewire' => [
            'wire:model' => 'form.{name}',
        ],
        'type' => twa\uikit\FieldTypes\Select::class,
        'label' => 'Branch',
        'placeholder' => 'Select branch',
        'name' => 'branch_id',
        'multiple' => false,
        'visible_selections' => 3,
        'query_limit' => 50,
        'container' => 'col-span-12',
        'options' => [
            'type' => 'query',
            'table' => 'branches',
            'field' => 'label_en',
            'conditions' => [
                [
                    'type' => 'where',
                    'column' => 'branches.id',
                    'operand' => null,
                    'value' => 1,
                ],
            ]

        ],


    ],


    'filter_movie' => [
        'id' => uniqid(),
        'livewire' => [
            'wire:model' => 'form.{name}',
        ],
        'type' => twa\uikit\FieldTypes\Select::class,
        'label' => 'Select Movie',
        'placeholder' => 'Select Movie',
        'name' => 'movie_id',
        'multiple' => false,
        'visible_selections' => 3,
        'query_limit' => 50,
        'options' => [
            'type' => 'query',
            'table' => 'movies',
            'field' => 'name',

        ],

        'container' => 'col-span-6',
    ],

    'filter_payment_method' => [
        'id' => uniqid(),
        'livewire' => [
            'wire:model' => 'form.{name}',
        ],
        'type' => twa\uikit\FieldTypes\Select::class,
        'label' => 'Select Payment Method',
        'placeholder' => 'Select Payment Method',
        'name' => 'payment_method_id',
        'multiple' => false,
        'visible_selections' => 3,
        'query_limit' => 50,
        'options' => [
            'type' => 'query',
            'table' => 'payment_methods',
            'field' => 'label',

        ],
        'container' => 'col-span-4',

    ],

    'filter_time' => [
        'id' => uniqid(),
        'livewire' => [
            'wire:model' => 'form.{name}',
        ],
        'type' => twa\uikit\FieldTypes\Select::class,
        'label' => 'Select Show Time',
        'placeholder' => 'Select Show Time',
        'name' => 'time_id',
        'multiple' => false,
        'visible_selections' => 3,
        'query_limit' => 50,
        'options' => [
            'type' => 'query',
            'table' => 'times',
            'field' => 'label',

        ],

        'container' => 'col-span-6',
    ],

    'filter_system' => [
        'id' => uniqid(),
        'livewire' => [
            'wire:model' => 'form.{name}',
        ],
        'type' => twa\uikit\FieldTypes\Select::class,
        'label' => 'Select System',
        'placeholder' => 'Select System',
        'name' => 'system_id',
        'multiple' => false,
        'visible_selections' => 3,
        'query_limit' => 50,
        'options' => [
            'type' => 'query',
            'table' => 'systems',
            'field' => 'label',

        ],
        'container' => 'col-span-12',

    ],


    'filter_distributor' => [
        'id' => uniqid(),
        'livewire' => [
            'wire:model' => 'form.{name}',
        ],
        'type' => twa\uikit\FieldTypes\Select::class,
        'label' => 'Select Distributor',
        'placeholder' => 'Select Distributor',
        'name' => 'distributor_id',
        'multiple' => false,
        'visible_selections' => 3,
        'query_limit' => 50,
        'options' => [
            'type' => 'query',
            'table' => 'distributors',
            'field' => 'label',

        ],
        'container' => 'col-span-4',

    ],


    'filter_pos_user' => [
        'id' => uniqid(),
        'livewire' => [
            'wire:model' => 'form.{name}',
        ],
        'type' => twa\uikit\FieldTypes\Select::class,
        'label' => 'Select Cashier',
        'placeholder' => 'Select Cashier',
        'name' => 'pos_user_id',
        'multiple' => false,
        'visible_selections' => 3,
        'query_limit' => 50,
        'options' => [
            'type' => 'query',
            'table' => 'pos_users',
            'field' => 'username',

        ],

        'container' => 'col-span-4',
    ],

    'filter_date' => [
        'id' => uniqid(),
        'livewire' => [
            'wire:model' => 'form.{name}',
        ],
        'type' => twa\uikit\FieldTypes\Date::class,
        'label' => 'Date',
        'placeholder' => 'Enter date',
        'name' => 'date',
        'required' => true,

        'events' => [
            '@input' => 'dateChanged'
        ],
        'container' => 'col-span-12'

    ],

    'filter_dist_date' => [
        'id' => uniqid(),
        'livewire' => [
            'wire:model' => 'form.{name}',
        ],
        'type' => twa\uikit\FieldTypes\Date::class,
        'label' => 'Date',
        'placeholder' => 'Enter date',
        'name' => 'date',
        'required' => true,
        'container' => 'col-span-12'

    ],

    'filter_start_date' => [
        'id' => uniqid(),
        'livewire' => [
            'wire:model' => 'form.{name}',
        ],
        'type' => twa\uikit\FieldTypes\Date::class,
        'label' => 'Start Date',
        'placeholder' => 'Select Start Date',
        'name' => 'start_date',
        'container' => 'col-span-6',
        'required'=>true

    ],


    'filter_end_date' => [
        'id' => uniqid(),
        'livewire' => [
            'wire:model' => 'form.{name}',
        ],
        'type' => twa\uikit\FieldTypes\Date::class,
        'label' => 'End Date',
        'placeholder' => 'Select End Date',
        'name' => 'end_date',
        'container' => 'col-span-6',
        'required'=>true
    ],


    'filter_reference' => [
        'id' => uniqid(),
        'livewire' => [
            'wire:model' => 'form.{name}',
        ],
        'type' => twa\uikit\FieldTypes\Textfield::class,
        'label' => 'Reference',
        'placeholder' => 'Enter Reference',
        'name' => 'reference',
        'container' => 'col-span-12',
    ],

    'filter_card_number' => [
        'id' => uniqid(),
        'livewire' => [
            'wire:model' => 'form.{name}',
        ],
        'type' => twa\uikit\FieldTypes\Textfield::class,
        'label' => 'Card Number',
        'placeholder' => 'Enter Card Number',
        'name' => 'card_number',
        'container' => 'col-span-12',
    ],



    'filter_amount_min' => [
        'id' => uniqid(),
        'livewire' => [
            'wire:model' => 'form.{name}',
        ],
        'type' => twa\uikit\FieldTypes\Textfield::class,
        'label' => 'Amount Minimum',
        'placeholder' => 'Amount Minimum',
        'name' => 'amount_min',
        'container' => 'col-span-6',
    ],


    'filter_amount_max' => [
        'id' => uniqid(),
        'livewire' => [
            'wire:model' => 'form.{name}',
        ],
        'type' => twa\uikit\FieldTypes\Textfield::class,
        'label' => 'Amount Maximum',
        'placeholder' => 'Amount Maximum',
        'name' => 'amount_max',
        'container' => 'col-span-6',
    ],


    'filter_user_phone' => [
        'id' => uniqid(),
        'livewire' => [
            'wire:model' => 'form.{name}',
        ],
        'type' => twa\uikit\FieldTypes\Textfield::class,
        'label' => 'Phone',
        'placeholder' => 'Enter Phone',
        'name' => 'phone',
        'container' => 'col-span-12',
    ],


    'filter_user_email' => [
        'id' => uniqid(),
        'livewire' => [
            'wire:model' => 'form.{name}',
        ],
        'type' => twa\uikit\FieldTypes\Textfield::class,
        'label' => 'Email',
        'placeholder' => 'Enter Email',
        'name' => 'email',
        'container' => 'col-span-6',
    ],


    'filter_ticket_status' => [
        'id' => uniqid(),
        'livewire' => [
            'wire:model' => 'form.{name}',
        ],
        'type' => twa\uikit\FieldTypes\Select::class,
        'label' => 'Ticket Status',
        'placeholder' => 'Select Ticket Status',
        'name' => 'ticket_status',
        'multiple' => false,
        'visible_selections' => 3,
        'query_limit' => 50,
        'options' => [
            'type' => 'static',
            'list' => [

                ['value' => 'sold_tickets', 'label' => 'Sold Tickets'],
                ['value' => 'refunded_tickets', 'label' => 'Refunded Tickets'],
            ]

        ],
        'container' => 'col-span-4',
    ],

    'category' => [
        'id' => uniqid(),
        'livewire' => [
            'wire:model' => 'form.{name}',
        ],
        'type' => twa\uikit\FieldTypes\Select::class,
        'label' => 'Categories',
        'placeholder' => 'Select Categories',
        'name' => 'category',
        'multiple' => false,
        'visible_selections' => 3,
        'query_limit' => 50,
        'options' => [
            'type' => 'static',
            'list' => [
                ['value' => 'glasses', 'label' => 'Glasses'],
                ['value' => 'others', 'label' => 'Others'],

            ]

        ]
    ],

    'filter_date_type' => [
        'id' => uniqid(),
        'livewire' => [
            'wire:model' => 'form.{name}',
        ],
        'type' => twa\uikit\FieldTypes\Select::class,
        'label' => 'Date Type',
        'placeholder' => 'Select Date Type',
        'name' => 'date_type',
        'multiple' => false,
        'visible_selections' => 3,
        'query_limit' => 50,
        'options' => [
            'type' => 'static',
            'list' => [
                ['value' => 'single', 'label' => 'Single'],

            ]

        ],
        'container' => 'col-span-12',
    ],


    'filter_wallet_status' => [
        'id' => uniqid(),
        'livewire' => [
            'wire:model' => 'form.{name}',
        ],
        'type' => twa\uikit\FieldTypes\Select::class,
        'label' => 'Status',
        'placeholder' => 'Select Status',
        'name' => 'status',
        'multiple' => false,
        'visible_selections' => 3,
        'query_limit' => 50,
        'options' => [
            'type' => 'static',
            'list' => [
                ['value' => 'expired', 'label' => 'Expired'],
                ['value' => 'valid', 'label' => 'valid'],
            ]

        ],
        'container' => 'col-span-12',
    ],




    'time_period' => [
        'id' => uniqid(),
        'livewire' => [
            'wire:model' => 'form.{name}',
        ],
        'type' => twa\uikit\FieldTypes\Textfield::class,
        'label' => 'Time Period',
        'placeholder' => 'Time Period',
        'name' => 'time_period',
        'container' => 'col-span-12',
    ],

    'timer_reset_card' => [
        'id' => uniqid(),
        'livewire' => [
            'wire:model' => 'form.{name}',
        ],
        'type' => twa\uikit\FieldTypes\Number::class,
        'label' => 'Time Reset Card',
        'placeholder' => 'Time Reset Card',
        'name' => 'timer_reset_card',
        'container' => 'col-span-12',
    ],




    'show_remove_time_offset' => [
        'id' => uniqid(),
        'livewire' => [
            'wire:model' => 'form.{name}',
        ],
        'type' => twa\uikit\FieldTypes\Number::class,
        'label' => 'Show remove time offset',
        'placeholder' => 'Show remove time offset',
        'name' => 'show_remove_time_offset',
        'container' => 'col-span-12',
    ],


    'distributor_contact_name' => [
        'id' => uniqid(),
        'livewire' => [
            'wire:model' => 'form.{name}',
        ],
        'type' => twa\uikit\FieldTypes\Textfield::class,
        'label' => 'Contact Name',
        'placeholder' => 'Enter Contact Name',
        'name' => 'contact_name'
    ],

    'distributor_contact_number' => [
        'id' => uniqid(),
        'livewire' => [
            'wire:model' => 'form.{name}',
        ],
        'type' => twa\uikit\FieldTypes\Textfield::class,
        'label' => 'Contact Number',
        'placeholder' => 'Enter Contact Number',
        'name' => 'contact_number'
    ],

    'distributor_contact_email' => [
        'id' => uniqid(),
        'livewire' => [
            'wire:model' => 'form.{name}',
        ],
        'type' => twa\uikit\FieldTypes\Textfield::class,
        'label' => 'Contact Email',
        'placeholder' => 'Enter Contact Email',
        'name' => 'contact_email'
    ],


    "status" => [
        'id' => uniqid(),
        'livewire' => [
            'wire:model' => 'form.{name}',
        ],
        'type' => twa\uikit\FieldTypes\Textfield::class,
        'label' => 'Status',
        'placeholder' => 'Status',
        'name' => 'status'
    ],

];
