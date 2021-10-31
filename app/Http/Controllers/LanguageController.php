<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
//use Illuminate\Http\Response;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Cookie;


class LanguageController extends Controller
{
    public function switchLang($lang)
    {
        //App::setLocale('ar');
        if (array_key_exists($lang, Config::get('languages'))) {
            return Redirect::back()->withCookie(cookie()->forever('applocale', $lang));
        }
    }
}
