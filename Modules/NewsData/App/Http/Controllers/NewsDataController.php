<?php

namespace Modules\NewsData\App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Modules\NewsData\App\Features\FetchNewsFeature;
use Modules\NewsData\App\Features\GetNewsDetailFeature;
use Modules\NewsData\App\Features\GetNewsFeature;

class NewsDataController extends Controller
{

    public function newsFetch(Request $request, FetchNewsFeature $feature)
    {
        return $feature->_handleApi($request);
    }
    public function getNewsDetail(Request $request, int $id, GetNewsDetailFeature $feature)
    {
        return $feature->_handleApi($request, $id);
    }

    public function getNews(Request $request, GetNewsFeature $feature)
    {
        return $feature->_handleApi($request);
    }



}
