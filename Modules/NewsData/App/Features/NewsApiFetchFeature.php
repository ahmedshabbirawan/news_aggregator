<?php

namespace Modules\NewsData\App\Features;

use App\Features\BaseFeature;
use App\Utils\HttpClient;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use Modules\Article\App\Models\Source;
use Modules\Article\App\Repositories\AuthorRepository;
use Modules\Article\App\Repositories\NewsRepository;


class NewsApiFetchFeature extends BaseFeature
{
    function _doAction()
    {

        try {
            $newsAPIConfig = config('newsapi_source.newsapi');
            $apiKey = $newsAPIConfig['api_key'];
            $baseUrl = $newsAPIConfig['api_url'];
            $newsAPIUrl = $baseUrl .'?country=us&pageSize=30&apiKey=' . $apiKey;

            $newsAPIHttp = HttpClient::get($newsAPIUrl);

            if (!$newsAPIHttp->ok()) {
                throw new \Exception('Failed to fetch news from NewsAPI.');
            }

            $results = json_decode($newsAPIHttp->body(), true);
            $data = [];
            foreach ($results['articles'] as $article) {
                $article_url = $article['url'];
                $newsByUrl =  NewsRepository::getNewsByWhere(['url' => $article_url])->first();
                if ($newsByUrl) {
                    continue;
                }

                /*******************    Source     ****************************/
                $source_slug = Arr::get($article, 'source.id');
                $source_name = Arr::get($article, 'source.name');
                if (empty($source_slug)) {
                    $source_slug = Str::slug($source_name);
                }

                $sourceObject = Source::firstOrCreate(['slug' => $source_slug],
                    ['slug' => $source_slug, 'name' => $source_name]);
                /*******************    Author     ****************************/

                $authorString = Arr::get($article, 'author');
                $authors = AuthorRepository::createAuthorsByString($authorString);
                $authorObj = null;
                if(count($authors)){
                    $authorObj = collect($authors)->map(function ($author) {
                        return $author->only(['id', 'name', 'slug']);
                    });
                }



                $newsData = [
                    'title' => $article['title'],
                    'slug' => Str::slug($article['title']),
                    'description' => $article['description'],
                    'url' => $article['url'],
                    'image_url' => $article['urlToImage'],
                    'content' => $article['content'],
                    'published_at' => Carbon::parse($article['publishedAt']),
                    'source_id' => $sourceObject->id,
                    'source_name' => $sourceObject->name,
                    'authors_object' => json_encode($authorObj)
                ];
                $news = NewsRepository::createNews($newsData, $authorObj);
                $data[] = $news;
            }
            $this->response = $data;
        } catch (\Exception $e) {
            dd($e);
            $this->statusCode = 500;
            $this->message = $e->getMessage();
        }
    }

    function _handle(Request $request)
    {
        $this->request = $request;
        $this->_doAction();
        return [
            'statusCode' => $this->statusCode,
            'response' => $this->response,
            'message' => $this->message,
        ];

    }



}
