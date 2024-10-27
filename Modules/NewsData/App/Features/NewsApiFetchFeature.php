<?php

namespace Modules\NewsData\App\Features;

use App\Features\BaseFeature;
use App\Utils\HttpClient;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
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
                $newsData = [
                    'title' => $article['title'],
                    'slug' => Str::slug($article['title']),
                    'description' => $article['description'],
                    'url' => $article['url'],
                    'image_url' => $article['urlToImage'],
                    'content' => $article['content'],
                    'published_at' => Carbon::parse($article['publishedAt']),
                    'api_source' => 'NewsAPI',
                ];
                $data[] = NewsRepository::createNews($newsData);
            }
            $this->response = $data;
        } catch (\Exception $e) {
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
