<?php

use App\Models\MovieShow;
use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use \Illuminate\Support\Facades\File;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote')->hourly();


Artisan::command('twa:entities', function () {
    $this->comment("Started");

    $files = File::files(app_path('Entities'));
    $other_files = File::files(base_path('vendor/twa/cmsv2/src/Entities'));


    $files = [...$files , ...$other_files];
    // $files = \Illuminate\Support\Facades\File::files();

    $config = [];

    foreach ($files as $file) {

        $filePath = $file->getRealPath();
        $namespace = get_class_namespace($filePath);
        $class = get_class_name($filePath);

        if ($namespace && $class) {
            $fullClassName = $namespace . '\\' . $class;
            if (class_exists($fullClassName)) {
                $checkClass = new $fullClassName;

                if ($checkClass->slug) {
                    $config[$checkClass->slug] = $fullClassName;
                }
            }
        }
    }
    $configContent = "<?php\n\nreturn " . var_export($config, true) . ";\n";
    file_put_contents(__DIR__ . '/../config/entity-mapping.php', $configContent);

    $this->comment("Finished");
})
    ->purpose('Map Entities');



    Artisan::command('twa:migrate', function () {

        $this->comment("Started");
    
        (new twa\cmsv2\Http\Controllers\EntityController)->migrate();
    
        $this->comment("Finished");
    })->purpose('Migrating tables');

    



Artisan::command('twa:generatePermissions', function () {

    $this->comment("Started");

    (new twa\cmsv2\Http\Controllers\EntityController)->generatePermissions();

    $this->comment("Finished");
})->purpose('Permissions tables');


Artisan::command('twa:dataTransfer', function () {


    // Read users from the database of the live version
    // Create a user in the new database and get the new id.


    // calculate wallet balance from user_wallet_transactions and loyalty balance from user_loyalty_transactiions 
    // by the old user id.

    //create 1 transaction for each in the new table "Consolidated wallet/loyalty amount"


    // pos users
    // coupons

    //Manual

    // cinemas
    // theaters



})->purpose('Transfering tables');


Artisan::command('twa:EnableTodayMovieShows', function () {

    $this->comment("Started");

    $today = now()->format('Y-m-d');

    $count = MovieShow::whereDate('date', $today)
        ->where('visibility', 0) 
        ->update(['visibility' => 1]);


    $this->comment("Finished");
})->purpose('Enable Today Movie Shows')->dailyAt('01:00');