<?php

use App\Models\MovieShow;
use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use \Illuminate\Support\Facades\File;

// Artisan::command('inspire', function () {
//     $this->comment(Inspiring::quote());
// })->purpose('Display an inspiring quote')->hourly();


Artisan::command('twa:entities', function () {
    $this->comment("Started");

    $files = File::files(app_path('Entities'));


    $other_files = File::files(base_path('vendor/twa/cmsv2/src/Entities'));


    $files = [...$files, ...$other_files];
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





Artisan::command('twa:EnableTodayMovieShows', function () {

    $this->comment("Started");

    $today = now()->format('Y-m-d');

    $count = MovieShow::whereDate('date', $today)
        ->where('visibility', 0)
        ->update(['visibility' => 1]);


    $this->comment("Finished");
})->purpose('Enable Today Movie Shows')->dailyAt('01:00');


Artisan::command('twa:updateVite', function () {



    $assets = get_assets();

    $viteConfigPath = base_path('vite.config.js');

    if (!file_exists($viteConfigPath)) {
        return;
    }

    $content = file_get_contents($viteConfigPath);

    $content = preg_replace('/\s*,?\s*"vendor\/twa\/uikit\/dist\/.*?"\s*/', '', $content);
    $content = preg_replace('/,\s*([\]\}])/', '$1', $content);

    $pattern = "/input:\s*\[([^\]]*)\]/";

    foreach ($assets as $asset) {

        $newInput1 = '"' . $asset . '"';

        if (preg_match($pattern, $content, $matches)) {
            $existingInputs = trim($matches[1]);
            $updatedInputs = $existingInputs ? "$existingInputs, $newInput1" : $newInput1;
            $content = preg_replace($pattern, "input: [$updatedInputs]", $content);
        } else {
        }
    }

    file_put_contents($viteConfigPath, $content);
});


Artisan::command('twa:dataTransfer', function () {

    $this->comment("Started");

    //    (new \App\Http\Controllers\MigrationsController)->migrateUsers($limit , $this);

    (new \App\Http\Controllers\MigrationsController)->migrateCoupons();



    $this->comment("Finished");
})->purpose('Transfering tables');




Artisan::command('twa:calculateDistShare {limit}', function ($limit) {

    $this->comment("Started");

    //    (new \App\Http\Controllers\MigrationsController)->migrateUsers($limit , $this);

    (new \App\Http\Controllers\MigrationsController)->calculateDistShare($limit, $this);



    $this->comment("Finished");
})->purpose('Transfering tables');








Artisan::command('twa:addReservedSeatsFromOrdersSeat', function () {

    $this->comment("Started");


    (new \App\Http\Controllers\MigrationsController)->addReservedSeatsFromOrdersSeata();

    $this->comment("Finished");
})->purpose('Transfering tables');





Artisan::command('twa:treatJsonReferences', function () {

    $this->comment("Started");

    //    (new \App\Http\Controllers\MigrationsController)->migrateUsers($limit , $this);

    (new \App\Http\Controllers\MigrationsController)->treatJsonReferences();



    $this->comment("Finished");
})->purpose('Transfering tables');
