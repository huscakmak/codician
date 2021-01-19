<?php

namespace App\Rules;

use Illuminate\Support\Facades\Validator;

class CustomRule
{
    public static function validate()
    {
        Validator::extend('alpha_num_tr', function ($attribute, $value) {
            return preg_match('/^[A-ZÖÇŞĞÜİa-zöçşğüı0-9+&?,.()\- ]+$/', $value);
        });

        Validator::extend('alpha_tr', function ($attribute, $value) {
            return preg_match('/^[A-ZÖÇŞĞÜİa-zöçşğüı ]+$/', $value);
        });
    }
}
