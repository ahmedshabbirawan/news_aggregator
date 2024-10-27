<?php

namespace Modules\NewsData\App\Features;

use App\Features\BaseFeature;
use App\Http\Responses\AppResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Modules\Article\App\Repositories\NewsRepository;
use Modules\User\App\Repositories\UserRepository;

class GetNewsFeature extends BaseFeature
{
    function _doAction()
    {
        $this->response = NewsRepository::getNewsBySearchFilter()->toArray();
    }

    function _handleApi(Request $request)
    {
        $this->request = $request;
        $this->_doAction();
        return new AppResponse($this->statusCode, $this->response, $this->message);
    }
}
