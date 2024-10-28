<?php

namespace Modules\User\App\Features;

use App\Features\BaseFeature;
use App\Http\Responses\AppResponse;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Modules\User\App\Repositories\PreferencesRepository;

class SaveUserPreferencesFeature extends BaseFeature
{
    function _doAction($user)
    {
        PreferencesRepository::savePreferences($user, $this->request->all());
        $this->response = Auth::user()->toArray();
    }



    function _handleApi(Request $request, User $user)
    {
        $this->request = $request;
        $this->_doAction($user);
        return new AppResponse($this->statusCode, $this->response, $this->message);
    }
}
