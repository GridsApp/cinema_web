<?php

use App\Helpers\Timezone\TimezoneMapper;
use App\Http\Controllers\UploadController;
use App\Models\PaymentAttemptLog;
use Illuminate\Support\Facades\File;
use Livewire\Livewire;
use Carbon\Carbon;

if (!function_exists('get_timezone')) {
    function get_timezone($lat, $lng, $fallback = null)
    {
        return (new TimezoneMapper)->mapCoordinates(latitude: $lat, longitude: $lng, fallback: $fallback);
    }
}

if (!function_exists('get_date_range')) {
    function get_date_range($date)
    {
        $searchDate = Carbon::parse($date);
        $searchDay = strtolower($searchDate->format('l'));

        $lastThursday = $searchDay != "thursday" ? Carbon::createFromTimeStamp(strtotime("last Thursday", $searchDate->timestamp)) : $searchDate;

        $nextWednesday = $searchDay != "wednesday" ? Carbon::createFromTimeStamp(strtotime("next Wednesday", $searchDate->timestamp)) : $searchDate;

        $thursday = (string)$lastThursday;
        $wednesday = (string)$nextWednesday;
        $wednesday = str_replace("00:00:00", "23:59:59", $wednesday);

        $first_thursday = Carbon::parse("first thursday of this year");
        $week_nb = ($first_thursday->diffInDays($lastThursday) / 7) + 1;

        return [
            "week_nb" => $week_nb,
            "range" => [$thursday, $wednesday]
        ];
    }
}



if (!function_exists('get_setting')) {
    function get_setting($key, $locale = "en")
    {

        $setting = collect(config('settings'))->where('field', $key)->first();


        if (!$setting) {
            return null;
        }


        $info = config('fields.' . $setting['field']);

        if (!$info) {
            return null;
        }

        $info['name'] = $setting['translatable'] ?? false ? 'value_' . $locale : 'value';
        $value = (new $info['type']($info))->display($setting);


        return $value;
    }
}


if (!function_exists('get_user_field_from_type')) {
    function get_user_field_from_type($type)
    {
        switch ($type) {
            case 'USER':
                return "user_id";
            case "POS":
                return "pos_user_id";
        }

        throw new Exception("Error Processing Field From User Type");
    }
}


if (!function_exists('get_system_from_type')) {
    function get_system_from_type($type)
    {
        switch ($type) {
            case 'USER':
                return 1;
            case "POS":
                return 2;
        }

        throw new Exception("Error Processing Field From User Type");
    }
}

if (!function_exists('currency_format')) {
    function currency_format($value, $prefix = "")
    {
        return [
            "value" => (float) $value,
            "display" => $prefix . number_format($value, 0, ".", ",")  . ' IQD'
        ];
    }
}


if (!function_exists('create_payment_log')) {
    function create_payment_log($message, $payload, $payment_attempt_id, $type = "error")
    {
        $payment_attempt_log = new PaymentAttemptLog();
        $payment_attempt_log->message = $message;
        $payment_attempt_log->payload = $payload;
        $payment_attempt_log->type = $type;
        $payment_attempt_log->payment_attempt_id = $payment_attempt_id;
        $payment_attempt_log->save();

        return $payment_attempt_log;
    }
}

if (!function_exists('get_header_access_token')) {
    function get_header_access_token()
    {
        return request()->header('access-token');
    }
}


if (!function_exists('clean_request')) {
    function clean_request($rules = [])
    {
        $formData = request()->all();

        // dd($formData);

        foreach ($rules as $key => $value) {

            if (!isset($formData[$key])) {
                continue;
            }

            switch ($value) {
                case "phone":
                    $formData[$key] = str($formData['phone'])->replace(' ', '')->toString();
                    break;
                case "email":
                    $formData[$key] = str($formData['email'])->replace(' ', '')->lower()->toString();
                    break;
            }
        }

        return $formData;
    }
}



if (!function_exists('get_class_namespace')) {
    function get_class_namespace($filePath)
    {
        $lines = file($filePath);

        foreach ($lines as $line) {
            if (preg_match('/^namespace\s+(.+?);$/', $line, $matches)) {
                return $matches[1];
            }
        }

        return null;
    }
}

if (!function_exists('get_class_name')) {
    function get_class_name($filePath)
    {
        $lines = file($filePath);
        foreach ($lines as $line) {
            if (preg_match('/^class\s+(\w+)/', $line, $matches)) {
                return $matches[1];
            }
        }
        return null;
    }
}

if (!function_exists('get_entity')) {
    function get_entity($slug)
    {

        if (!$slug) {
            return null;
        }

        $className = config('entity-mapping.' . $slug);

        return new $className;
    }
}

// if (!function_exists('get_field_modal')) {
//     function get_field_modal($field)
//     {
//         return str_replace("{name}" , $field['name'] , $field['livewire']['wire:model'] ?? ($field['livewire']['wire:model.live'] ?? ""));
//     }
// }

if (!function_exists('convertTo12HourFormat')) {
    function convertTo12HourFormat($time24h)
    {
        $dateTime = DateTime::createFromFormat('H:i', $time24h);
        if ($dateTime) {
            return $dateTime->format('g:i A');
        } else {
            return "Invalid time format";
        }
    }
}



if (!function_exists('compare_values')) {
    function compare_values($var1, $op, $var2)
    {



        switch ($op) {
            case "=":
                return $var1 == $var2;
            case "!=":
                return $var1 != $var2;
            case ">=":
                return $var1 >= $var2;
            case "<=":
                return $var1 <= $var2;
            case ">":
                return $var1 >  $var2;
            case "<":
                return $var1 <  $var2;
            default:
                return true;
        }
    }
}



if (!function_exists('field_value')) {
    function field_value($field, $form, $debug = false)
    {

        return (new $field['type']($field))->value($form);

        if (!$field) {
            return null;
        }

        switch ($field['type'] ?? null) {


            case "toggle":
                return $form[$field['name']];

            case "theater-map":

                return json_encode($form[$field['name']]);

            case "file-upload":

                $files = [];
                $already_uploaded = [];


                if (isset($field['multiple']) && $field['multiple']) {
                    foreach ($form[$field['name']] ?? [] as $file) {

                        if (!$file) {
                            continue;
                        }

                        if ($file['progress'] == 102) {
                            $already_uploaded[] = $file['uploaded'];
                            continue;
                        }


                        $files[] = [
                            'file' => $file['uploaded'],
                            'crop' => isset($file['cropping']) ? [
                                'x' => $file['cropping']['x'],
                                'y' => $file['cropping']['y'],
                                'width' => $file['cropping']['width'],
                                'height' => $file['cropping']['height']
                            ] : null
                        ];
                    }


                    $upload_files = (new UploadController($field))->uploadFiles($files);

                    return json_encode([...$already_uploaded, ...$upload_files]);
                } else {

                    $file = $form[$field['name']];
                    if (!$file) {
                        return null;
                    }

                    if ($file['progress'] == 102) {
                        return $file['uploaded'];
                    }

                    return (new UploadController($field))->uploadFile([
                        'file' => $file['uploaded'],
                        'crop' => isset($file['cropping']) ? [
                            'x' => $file['cropping']['x'],
                            'y' => $file['cropping']['y'],
                            'width' => $file['cropping']['width'],
                            'height' => $file['cropping']['height']
                        ] : null
                    ]);
                }

                // return $form[$field['name']];

            case "select":
                if (isset($field['multiple']) && $field['multiple']) {

                    return is_array($form[$field['name']]) ? json_encode($form[$field['name']]) : null;
                } else {
                    return $form[$field['name']] ?? null;
                }

            default:
                return $form[$field['name']] ?? null;
        }
    }
}

if (!function_exists('field_init')) {
    function field_init($field, $data = null)
    {
        return (new $field['type']($field))->initalValue($data);
    }
}

// if (!function_exists('field')) {
//     function field($field, $container = null)
//     {
//         if (is_string($field)) {
//             $field = config('fields.' . $field);

//         }


//         if (!$field) {
//             return null;
//         }


//         if (!(isset($field['livewire']) && $field['livewire'])) {
//             $field['livewire'] = [
//                 "wire:model" => $field['name']
//             ];
//         } else {
//             $field['livewire'] = collect($field['livewire'])->map(function ($value) use ($field) {
//                 return str_replace('{name}', $field['name'], $value);
//             })->toArray();
//         }

//         if(!isset($field['index'])){
//             $field['index'] = 999;
//         }


//         $params = [
//             "info" => $field,
//             ...$field['livewire']
//         ];

//         if(isset($field['translatable']) && $field['translatable']){

//             $render = view("CMSView::components.form.language", ['info' => $field]);

//             $container = $field['container'] ?? $container;

//             if ($container) {
//                 return "<div class='" . $container . "'>" . $render . "</div>";
//             }else{
//                 return $render;
//             }
//         }

//         $path = (new $field['type']($field))->component();

//         $render = Livewire::mount($path, $params, "component_" . uniqid());

//         $container = $field['container'] ?? $container;

//         if ($container) {
//             return "<div class='" . $container . "'>" . $render . "</div>";
//         }

//         return $render;
//     }
// }

if (!function_exists('generateField')) {

    function generateField($filter)
    {
        // dd($filter)
        // return field([

        // ]);
    }
}


if (!function_exists('button')) {
    function button($label, $type, $grid = null, $role = "submit", $classes = '', $handler = null)
    {

        // $directory = base_path('/src/Resources/views/components/buttons'); // Path to the views directory
        // $files = collect(File::allFiles($directory))->map(function ($file) {
        //     return str_replace(".blade.php", "", $file->getFilename());
        // })->toArray();


        // if (!in_array($type, $files)) {
        //     $type = "primary";
        // }

        $type = "primary";

        $render = view('CMSView::components.buttons.' . $type, ['label' => $label, 'role' => $role, 'classes' => $classes, 'handler' => $handler])->render();

        return $grid ? "<div class='" . $grid . "'>" . $render . "</div>" : $render;
    }
}

if (!function_exists('get_formatted_week_range')) {
    function get_formatted_week_range($date)
    {
        $date = Carbon::parse($date);
        $startOfWeek = $date->copy()->startOfWeek(Carbon::THURSDAY);
        $endOfWeek = $startOfWeek->copy()->endOfWeek(Carbon::WEDNESDAY);

        $weekNumber = $startOfWeek->isoWeek(); // ISO week number (can use ->week() if you prefer)
        $formattedStart = $startOfWeek->format('D d-M');
        $formattedEnd = $endOfWeek->format('D d-M');

        return "Week {$weekNumber} Range: {$formattedStart} - {$formattedEnd}";
    }
}


if (!function_exists('get_range_date')) {
    function get_range_date($date)
    {
        $date = Carbon::parse($date);
        $startOfWeek = $date->startOfWeek(Carbon::THURSDAY);  // Start of the week (Thursday)
        $endOfWeek = $startOfWeek->copy()->endOfWeek(Carbon::WEDNESDAY);  // End of the week (Wednesday)

        return ['start' => $startOfWeek, 'end' => $endOfWeek];
    }
}
if (!function_exists('link_button')) {
    function link_button($label, $href, $type, $grid = null)
    {



        $type = "primary";

        $render = view('CMSView::components.buttons.' . $type, ['label' => $label, 'href' => $href])->render();

        return $grid ? "<div class='" . $grid . "'>" . $render . "</div>" : $render;
    }
}

if (!function_exists('get_breadcrumbs_link')) {
    function get_breadcrumbs_link($array, $path = [])
    {
        $result = [];

        foreach ($array as $key => $item) {

            if (isset($item['link'])) {
                $item['link'] = is_string($item['link']) ? $item['link'] : parse_url(route($item['link']['name'], $item['link']['params']), PHP_URL_PATH);
                $result[$item['link']] = array_merge($path, [$key]);
            }

            if (isset($item['children'])) {
                $result = array_merge($result, get_breadcrumbs_link($item['children'], array_merge($path, [$key])));
            }
        }

        return $result;
    }
}

if (!function_exists('get_breadcrumbs_items')) {
    function get_breadcrumbs_items($menu, $array, $routePath)
    {

        $result = [];
        $current = $menu;

        foreach ($array as $index) {
            if (isset($current[$index]) || isset($current["children"][$index])) {
                $current = $current[$index] ?? $current["children"][$index];

                if (isset($current['link'])) {
                    // dd($current['link']);


                }
                $result[] = $current;
            } else {
                $current = null;
                break;
            }
        }


        return $result;
    }
}

if (!function_exists('get_breadcrumbs')) {
    function get_breadcrumbs()
    {
        $explode = explode("/", request()->path());
        $routePath = "/" . $explode[0];
        $menu = config('menu');
        $result = get_breadcrumbs_link($menu);
        $indexes = $result[$routePath] ?? null;
        if (!$indexes) {
            return [];
        }

        $breadcrumbs = get_breadcrumbs_items($menu, $indexes, $routePath);

        unset($explode[0]);

        $explodes = collect(array_values($explode))->filter()->values()->toArray();
        foreach ($explodes as $explode) {
            // dd($explodes);
            $breadcrumbs[] = [
                "label" => ucfirst($explode),
                'link' => ""
            ];
        }
        return $breadcrumbs;
    }
}





if (!function_exists('validate_movie_show')) {
    function validate_movie_show($theater, $targetDate, $targetTimeId, $slots, $except = [])
    {

        $existing_movie_shows =  \App\Models\MovieShow::query()
            ->where('theater_id', $theater)
            ->where('date', $targetDate)
            ->whereNull('deleted_at')
            ->whereNotIn('id', $except)
            ->get();


        foreach ($existing_movie_shows as $existing_movie_show) {
            $currentHead = $targetTimeId;
            $currentTail = $targetTimeId + $slots - 1;

            if ($currentHead >= $existing_movie_show->time_id && $currentHead  <= $existing_movie_show->end_time_id) {

                return false;
            }


            if ($currentTail >= $existing_movie_show->time_id && $currentTail  <= $existing_movie_show->end_time_id) {
                return false;
            }


            if ($currentHead < $existing_movie_show->time_id && $currentTail > $existing_movie_show->end_time_id) {
                return false;
            }
        }

        return true;
    }
}


if (!function_exists('routeObject')) {
    function routeObject($name, $params = [])
    {

        return [
            'name' => $name,
            'params' => $params
        ];
    }
}

if (!function_exists('get_route_object_link')) {
    function get_route_object_link($menuItemLink)
    {
        if (!$menuItemLink) {
            return "";
        }

        if (is_array($menuItemLink)) {
            return route($menuItemLink['name'], $menuItemLink['params']);
        }

        if (!str_starts_with($menuItemLink, '/') && !str_starts_with($menuItemLink, 'http')) {
            return '/' . $menuItemLink;
        } else {

            return $menuItemLink;
        }
    }
}


if (!function_exists('getActiveMenuIndex')) {
    function getActiveMenuIndex()
    {
        $routeCurrent = '/' . request()->path();

        foreach (config('menu') as $index => $menuItem) {

            if (isset($menuItem['link']) && is_array($menuItem['link'])) {
                $route = route($menuItem['link']['name'], $menuItem['link']['params']);
            } elseif (isset($menuItem['link'])) {
                $route = $menuItem['link'];
            } else {
                $route = null;
            }

            if (!is_null($route) && $route == $routeCurrent) {
                return [$index];
            }

            if (isset($menuItem['children']) && is_array($menuItem['children'])) {
                foreach ($menuItem['children'] as $index_child => $childMenuItem) {
                    if (isset($childMenuItem['link']) && is_array($childMenuItem['link'])) {
                        $route = parse_url(route($childMenuItem['link']['name'], $childMenuItem['link']['params']), PHP_URL_PATH);
                    } elseif (isset($childMenuItem['link'])) {
                        $route = $childMenuItem['link'];
                    } else {
                        $route = null;
                    }

                    if (!is_null($route) && $route == $routeCurrent) {
                        return [$index, $index_child];
                    }
                }
            }
        }
    }
}


if (!function_exists('getActiveMenuChildren')) {

    function getActiveMenuChildren()
    {
        $index = getActiveMenuIndex();
        $menu = config('menu');
        $result = [];

        if (!isset($index[0])) {
            return [];
        }
        $item = $menu[$index[0]] ?? null;
        if (!$item) {
            return [];
        }
        $result[] = $item;
        if (!isset($index[1])) {
            return $result;
        }
        $item = $menu[$index[0]]['children'][$index[1]] ?? null;
        if (!$item) {
            return $result;
        }
        foreach ($result[0]['children'] as $childs)
            $parent = collect($result[0]['children'])->map(function ($child, $i) use ($index) {
                $child['active'] = $i == $index[1];
                return $child;
            })->toArray();

        $result[0]['children'] = $parent;


        $result[] = $item;


        return $result;
    }
}




if (!function_exists('get_image')) {
    function get_image($image, $type = null)
    {

        if (empty($image)) {
            return null;
        }


        [$folder, $extension] = explode(".", $image);

        if ($type == 'thumb') {
            return env('DATA_URL') . "/data/" . $folder . '/thumb.webp';
        }

        if ($type == 'original') {
            return env('DATA_URL') . "/data/" . $folder . '/original.' . $extension;
        }

        return env('DATA_URL') . "/data/" . $folder . '/image.webp';
    }
}


if (!function_exists('notification')) {
    function notification($action = null)
    {
        return (new twa\cmsv2\Classes\Notification($action));
    }
}




if (!function_exists('get_images')) {
    function get_images($images, $type = null)
    {

        if (!is_array($images)) {
            return [];
        }

        $result = [];
        foreach ($images as $image) {
            $image_url =  get_image($image, $type);

            if (!$image_url) {
                continue;
            }

            $result[] = $image_url;
        }

        return $result;
    }
}


if (!function_exists('minutes_to_human')) {
    function minutes_to_human($minutes)
    {
        $hours = floor($minutes / 60);
        $minutes = $minutes % 60;
        return $minutes == 0 ? $hours == 0 ? "0m" : "{$hours}h" : ($hours == 0 ? "{$minutes}m" : "{$hours}h {$minutes}m");
    }

    if (!function_exists('generate_unique_token')) {
        function generate_unique_token()
        {
            return md5(uniqid() . env('APP_KEY')) . md5(uniqid() . env('APP_KEY') . now()->timestamp);
        }
    }




    if (!function_exists('round_time')) {
        function round_time($time)
        {

            $arr = explode(":", $time);

            $minutes = (int) $arr[1];

            if ($minutes < 15) {
                return $arr[0] . ":00";
            } elseif ($minutes < 30) {
                return $arr[0] . ":15";
            } elseif ($minutes < 45) {
                return $arr[0] . ":30";
            } else {
                return $arr[0] . ":45";
            }
        }
    }

    if (!function_exists('taxCalculation')) {
        function taxCalculation($amount, $inclusive = false)
        {
            $perc = 5;

            if ($inclusive) {
                return $amount - ($amount / (1 + $perc / 100));
            } else {
                return $amount * ($perc / 100);
            }
        }
    }

    if (!function_exists('generateLongId')) {
        function generateLongId($id)
        {
            return date("Y") . "-" . date("m") . '-' . str_pad($id, 6, '0', STR_PAD_LEFT);
        }
    }

    if (!function_exists('calculate_share_amount')) {
        function calculate_share_amount($amount , $share_perc , $tax){
            return (((100 - $tax) / 100) * $amount) * ($share_perc / 100);
        }
    }

}
