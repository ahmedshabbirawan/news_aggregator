<?php

namespace Modules\Auth\App\Features;

use App\Features\BaseFeature;
use App\Http\Responses\AppResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Modules\User\App\Repositories\UserRepository;

class CreateUserFeature extends BaseFeature
{
    function _doAction()
    {
        $userData = $this->request->only('name', 'email', 'password');
        $userData['password'] = Hash::make($userData['password']);
        $user = UserRepository::createUser($userData);
        $user->token = $user->createToken("API_TOKEN")->plainTextToken;
        $this->response = [
            'user' => $user
        ];
    }

    function _handleApi(Request $request)
    {
        $this->request = $request;
        $this->_doAction();
        return new AppResponse($this->statusCode, $this->response);
    }

}
