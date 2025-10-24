<?php


// if (!function_exists('get_setting')) {
//     function get_setting($key, $default = null, $lang = false)
//     {
//         $settings = Cache::remember('business_settings', 86400, function () {
//             return BusinessSetting::all();
//         });

//         if ($lang == false) {
//             $setting = $settings->where('type', $key)->first();
//         } else {
//             $setting = $settings->where('type', $key)->where('lang', $lang)->first();
//             $setting = !$setting ? $settings->where('type', $key)->first() : $setting;
//         }
//         return $setting == null ? $default : $setting->value;
//     }
// }
