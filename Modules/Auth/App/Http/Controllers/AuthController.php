<?php

namespace Modules\Auth\App\Http\Controllers;

use App\Http\Controllers\Controller;
use Modules\Auth\App\Features\CreateUserFeature;
use Modules\Auth\App\Http\Requests\CreateUserRequest;
use Modules\Auth\App\Http\Requests\UserLoginRequest;
use Modules\Auth\App\Features\LoginUserFeature;

class AuthController extends Controller
{

    /**
     * Store a newly created resource in storage.
     */
    public function login(UserLoginRequest $request, LoginUserFeature $loginUserFeature)
    {
        return $loginUserFeature->_handleApi($request);
    }

    public function register(CreateUserRequest $request, CreateUserFeature $createUserFeature)
    {
        return $createUserFeature->_handleApi($request);
    }

}
