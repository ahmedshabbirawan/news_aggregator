<?php

namespace Modules\NewsData\App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Modules\NewsData\App\Features\FetchNewsFeature;

class NewsDataController extends Controller
{

    public function newsFetch(Request $request, FetchNewsFeature $feature)
    {
        return $feature->_handleApi($request);
    }

}
