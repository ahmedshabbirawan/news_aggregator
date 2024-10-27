<?php

namespace Modules\NewsData\App\Features;

use App\Features\BaseFeature;
use App\Http\Responses\AppResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Modules\User\App\Repositories\UserRepository;

class FetchNewsFeature extends BaseFeature
{
    function _doAction()
    {
        $apiOrg = app()->make(NewsApiFetchFeature::class)->_handle($this->request);
        $newYork = app()->make(NewYorkFetchFeature::class)->_handle($this->request);
        if( ($apiOrg['statusCode'] == 200) && ($newYork['statusCode'] == 200) ) {

            $this->response['news-api-org'] = [
                'count' => count($apiOrg['response'])
            ];
            $this->response['new-york-news'] = [
                'count' => count($newYork['response'])
            ];
            $this->statusCode = 200;
            $this->message = 'Fetched news data successfully';
        }else{
            $this->statusCode = 406;
            $this->message = 'Fetched news data failed';
        }
    }



    function _handleApi(Request $request)
    {
        $this->request = $request;
        $this->_doAction();
        return new AppResponse($this->statusCode, $this->response, $this->message);
    }
}
