<?php

namespace App\Http\Controllers\WEBSITE;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ContactController extends Controller
{
    public function contact()
    {
        // $locale = app()->getLocale();
    
        // $settings = collect(config('settings'))->map(function ($setting) use ($locale) {
        //     $info = config('fields.' . $setting['field']);
    
        //     if (!$info) {
        //         return null;
        //     }
    
        //     $info['name'] = $setting['translatable'] ?? false ? 'value_' . $locale : 'value';
        //     $value = (new $info['type']($info))->display($setting);
    
        //     return [
        //         'key' => $setting['field'] ?? null,
        //         'value' => $value,
        //     ];
        // })->filter()->values()->toArray();
    
        // $settings_collection = collect($settings);
    

        $whatsapp_label = get_setting("whattsapp_label" , app()->getLocale());
        $whatsapp = get_setting("whattsapp" , app()->getLocale());
        $facebook = get_setting("facebook" , app()->getLocale());
        $facebook_label = get_setting("facebook_label" , app()->getLocale());
        $instagram = get_setting("instagram" , app()->getLocale());
        $instagram_label = get_setting("instagram_label" , app()->getLocale());
        $x_label = get_setting("x_label" , app()->getLocale());
        $x = get_setting("x" , app()->getLocale());
        $financial_phone = get_setting("financial_phone" , app()->getLocale());
        $financial_email = get_setting("financial_email" , app()->getLocale());
        $operator_phone = get_setting("operator_phone" , app()->getLocale());
        $operator_email = get_setting("operator_email" , app()->getLocale());
        $management_phone = get_setting("management_phone" , app()->getLocale());
        $management_email = get_setting("management_email" , app()->getLocale());

        // $whatsapp_label = $settings_collection->firstWhere('key', 'whattsapp_label')['value'] ?? null;
        // $whatsapp = $settings_collection->firstWhere('key', 'whattsapp')['value'] ?? null;
        // $facebook = $settings_collection->firstWhere('key', 'facebook')['value'] ?? null;
        // $facebook_label = $settings_collection->firstWhere('key', 'facebook_label')['value'] ?? null;
        // $instagram = $settings_collection->firstWhere('key', 'instagram')['value'] ?? null;
        // $instagram_label = $settings_collection->firstWhere('key', 'instagram_label')['value'] ?? null;
        // $x_label = $settings_collection->firstWhere('key', 'x_label')['value'] ?? null;
        // $x = $settings_collection->firstWhere('key', 'x')['value'] ?? null;
    
        return view('website.pages.contact-us', compact(
            'whatsapp_label',
            'whatsapp',
            'facebook',
            'facebook_label',
            'instagram',
            'instagram_label',
            'x_label',
            'x',
            'financial_phone',
            'financial_email',
            'operator_phone',
            'operator_email',
            'management_phone',
            'management_email',

        ));
    }
    
}
