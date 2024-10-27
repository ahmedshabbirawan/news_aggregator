<?php

namespace App\Features;

class BaseFeature
{
    protected $request;
    protected $user;
    protected $response = [];
    protected $statusCode = 200;
    protected $message = '';
}
