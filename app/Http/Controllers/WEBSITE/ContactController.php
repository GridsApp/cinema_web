<?php

namespace App\Http\Controllers\WEBSITE;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ContactController extends Controller
{
    public function contact()
    {
        $locale = app()->getLocale();
    
        $settings = collect(config('settings'))->map(function ($setting) use ($locale) {
            $info = config('fields.' . $setting['field']);
    
            if (!$info) {
                return null;
            }
    
            $info['name'] = $setting['translatable'] ?? false ? 'value_' . $locale : 'value';
            $value = (new $info['type']($info))->display($setting);
    
            return [
                'key' => $setting['field'] ?? null,
                'value' => $value,
            ];
        })->filter()->values()->toArray();
    
        $settings_collection = collect($settings);
    

        $whatsapp_label = get_setting("whattsapp_label" , app()->getLocale());

        // $whatsapp_label = $settings_collection->firstWhere('key', 'whattsapp_label')['value'] ?? null;
        $whatsapp = $settings_collection->firstWhere('key', 'whattsapp')['value'] ?? null;
        $facebook = $settings_collection->firstWhere('key', 'facebook')['value'] ?? null;
        $facebook_label = $settings_collection->firstWhere('key', 'facebook_label')['value'] ?? null;
        $instagram = $settings_collection->firstWhere('key', 'instagram')['value'] ?? null;
        $instagram_label = $settings_collection->firstWhere('key', 'instagram_label')['value'] ?? null;
        $x_label = $settings_collection->firstWhere('key', 'x_label')['value'] ?? null;
        $x = $settings_collection->firstWhere('key', 'x')['value'] ?? null;
    
        return view('website.pages.contact-us', compact(
            'whatsapp_label',
            'whatsapp',
            'facebook',
            'facebook_label',
            'instagram',
            'instagram_label',
            'x_label',
            'x'
        ));
    }
    
}
