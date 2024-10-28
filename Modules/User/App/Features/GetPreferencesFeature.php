<?php

namespace Modules\User\App\Features;

use App\Features\BaseFeature;
use App\Http\Responses\AppResponse;
use App\Models\User;
use Illuminate\Http\Request;
use Modules\User\App\Repositories\PreferencesRepository;

class GetPreferencesFeature extends BaseFeature
{
    function _doAction($user)
    {
        $this->response =  PreferencesRepository::getPreferencesPageResources($user);
    }



    function _handleApi(Request $request, User $user)
    {
        $this->request = $request;
        $this->_doAction($user);
        return new AppResponse($this->statusCode, $this->response, $this->message);
    }
}
