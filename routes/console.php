<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote')->hourly();


Artisan::command('twa:entities', function () {
    $this->comment("Started");

    $files = \Illuminate\Support\Facades\File::files(app_path('Entities'));
    $config = [];

    foreach ($files as $file) {

        $filePath = $file->getRealPath();
        $namespace = get_class_namespace($filePath);
        $class = get_class_name($filePath);

        if ($namespace && $class) {
            $fullClassName = $namespace . '\\' . $class;
            if (class_exists($fullClassName)) {
                $checkClass = new $fullClassName;

                if($checkClass->slug) {
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

    (new App\Http\Controllers\EntityController)->migrate();

    $this->comment("Finished");

})->purpose('Migrating tables');
