<?php

namespace Modules\Auth\App\Features;

use App\Features\BaseFeature;
use App\Http\Responses\AppResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginUserFeature extends BaseFeature
{
    function _doAction()
    {
        $loginData = $this->request->only('email', 'password');
        if(Auth::attempt($loginData)){
            $user = Auth::user();
            $user->tokens()->delete();
            $user->token = $user->createToken('API_TOKEN')->plainTextToken;
            $this->response = [
                'user' => $user
            ];
        }else{
            $this->statusCode = 406;
            $this->message = 'Unauthorized';
        }
    }

    function _handleApi(Request $request)
    {
        $this->request = $request;
        $this->_doAction();
        return new AppResponse($this->statusCode, $this->response, $this->message);
    }

}
