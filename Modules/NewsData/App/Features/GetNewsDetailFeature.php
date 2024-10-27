<?php

namespace Modules\NewsData\App\Features;

use App\Features\BaseFeature;
use App\Http\Responses\AppResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Modules\Article\App\Repositories\NewsRepository;
use Modules\User\App\Repositories\UserRepository;

class GetNewsDetailFeature extends BaseFeature
{
    function _doAction(int $id)
    {
        $news = NewsRepository::getNewsByWhere([
            'id' =>  $id
        ])->first();

        if( $news ) {
            $this->statusCode = 200;
            $this->response = $news->toArray();
        }else{
            $this->statusCode = 404;
            $this->message = 'No record found!';
        }

    }



    function _handleApi(Request $request, int $id)
    {
        $this->request = $request;
        $this->_doAction($id);
        return new AppResponse($this->statusCode, $this->response, $this->message);
    }
}
