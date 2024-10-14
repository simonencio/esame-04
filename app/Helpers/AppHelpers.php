<?php

namespace App\Helpers;

use Illuminate\Support\Arr;

class AppHelpers
{
    public static function aggiornaRegoleHelper($rules)
    {
        // $newRules = array();
        // foreach ($rules as $key => $value) {
        //     $newRules[$key] = str_replace("required|", "", $value);
        // }

        // Versione 9.x di laravel o successive
        // $newRules = Arr::map($rules, function ($value, $key) {
        //     return str_replace("required|", "", $value);
        // });

        $newRules = array_map(function ($value) {
            return str_replace("required|", "", $value);
        }, $rules);
        return $newRules;
    }


    public static function isAdmin($idRuolo)
    {
        return ($idRuolo == 1) ? true : false;
    }
}
