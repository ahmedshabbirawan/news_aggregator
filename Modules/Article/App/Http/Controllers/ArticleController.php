<?php

namespace Modules\Article\App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Modules\Article\App\Features\GetNewsDetailFeature;
use Modules\Article\App\Features\GetNewsFeature;

class ArticleController extends Controller
{
    public function getNewsDetail(Request $request, int $id, GetNewsDetailFeature $feature)
    {
        return $feature->_handleApi($request, $id);
    }

    public function getNews(Request $request, GetNewsFeature $feature)
    {
        return $feature->_handleApi($request);
    }


}
