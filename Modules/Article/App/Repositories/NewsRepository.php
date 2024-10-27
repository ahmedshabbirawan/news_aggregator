<?php

namespace Modules\Article\App\Repositories;
use Modules\Article\App\Models\News;

class NewsRepository
{
    public static function getNewsByWhere($where){
        return News::where($where)->get();
    }
    public static function createNews($newsData){
        return News::create($newsData);
    }


    public static function getNewsBySearchFilter()
    {
        $articlesQuery = News::query();
        return $articlesQuery->with('source')
            ->orderBy('published_at', 'desc')
            ->paginate(10, ['*'], 'page');
    }


}
