<?php

namespace App\Utils;
use Illuminate\Support\Facades\Http;
class HttpClient
{
    public static function get($url, $options = [])
    {
        return Http::withOptions($options)->get($url);
    }
}
