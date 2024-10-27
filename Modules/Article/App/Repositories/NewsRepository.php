<?php

namespace Modules\Article\App\Repositories;
use Modules\Article\App\Models\News;

class NewsRepository
{
    public static function getNewsByWhere($where){
        return News::where($where)->get();
    }
    public static function createNews($newsData, $authors = null){
        $news =  News::create($newsData);
        if( count($authors) ){
            $authorIds = collect($authors)->pluck('id')->toArray();
            $news->author()->attach($authorIds);
        }
        return $news;
    }

    function attachedAuthors($news, $authorIds)
    {
        if ( count( $authorIds ) ) {
            $news->author()->attach($authorIds);
        }
    }


    public static function getNewsBySearchFilter($search, $authors, $sources)
    {
        $articlesQuery = News::query();

        self::applySearchFilters($articlesQuery, $search);
        self::applyAuthorFilters($articlesQuery, $authors);
        self::applySourceFilters($articlesQuery, $sources);

        return $articlesQuery->with('source')
            ->orderBy('published_at', 'desc')
            ->paginate(10, ['*'], 'page');
    }


    private static function applySearchFilters($query, $search)
    {
        if (!empty($search)) {
            $query->where(function ($subQuery) use ($search) {
                $subQuery->where('title', 'LIKE', "%{$search}%")
                    ->orWhere('description', 'LIKE', "%{$search}%");
            });
        }
    }

    private static function applyAuthorFilters($query, $authors)
    {
        if (count($authors)) {
            $query->whereHas('author', function ($subQuery) use ($authors) {
                $subQuery->whereIn('authors.id', $authors);
            });
        }
    }

    private static function applySourceFilters($query, $sources)
    {
        if (count($sources)) {
            $query->whereHas('source', function ($subQuery) use ($sources) {
                $subQuery->whereIn('sources.id', $sources);
            });
        }
    }

    public function getAuthors($search)
    {
        $authorsQuery = Author::query();

        $user = Auth::user();
        if ($user) {
            $preferredAuthorIds = $user->preferred_author_ids;

            if (is_array($preferredAuthorIds) && count($preferredAuthorIds)) {
                $authorsQuery->whereIn('id', $preferredAuthorIds);
            }
        }

        if (!empty($search)) {
            $authorsQuery->where('author_name', 'LIKE', "%{$search}%");
        }

        return $authorsQuery->orderBy('author_name')->simplePaginate(10, ['*']);
    }



}
