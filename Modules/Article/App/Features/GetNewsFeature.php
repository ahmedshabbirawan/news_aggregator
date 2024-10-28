<?php

namespace Modules\Article\App\Features;

use App\Features\BaseFeature;
use App\Http\Responses\AppResponse;
use Illuminate\Http\Request;
use Modules\Article\App\Repositories\NewsRepository;

class GetNewsFeature extends BaseFeature
{
    function _doAction()
    {
        $search = $this->request->get('search','');
        $authors = $this->request->get('authors',[]);
        $sources = $this->request->get('sources',[]);

        $this->response = NewsRepository::getNewsBySearchFilter($search, $authors, $sources)->toArray();
    }

    function _handleApi(Request $request)
    {
        $this->request = $request;
        $this->_doAction();
        return new AppResponse($this->statusCode, $this->response, $this->message);
    }
}
