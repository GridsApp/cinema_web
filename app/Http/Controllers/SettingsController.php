<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SettingsController extends Controller
{
    public function render(){
        $data = [];


        $filePath = config_path('settings.php');
        if (file_exists($filePath)) {
            return view("pages.settings");
        }
      

        $configContent = "<?php\n\nreturn " . var_export($data, true) . ";\n";

        try {
            file_put_contents($filePath, $configContent);
        } catch (\Exception $e) {
           abort(400);
        }

        return view("pages.settings");
    }
}
