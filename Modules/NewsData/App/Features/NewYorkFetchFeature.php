<?php

namespace Modules\NewsData\App\Features;

use App\Features\BaseFeature;
use App\Http\Responses\AppResponse;
use App\Utils\HttpClient;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Modules\Article\App\Models\Author;
use Modules\Article\App\Models\Source;
use Modules\Article\App\Repositories\AuthorRepository;
use Modules\Article\App\Repositories\NewsRepository;
use Modules\Article\App\Repositories\SourceRepository;
use Modules\User\App\Repositories\UserRepository;


class NewYorkFetchFeature extends BaseFeature
{
    function _doAction()
    {
        try {
            $nytimesAPIConfig = config('newsapi_source.newyorktimes');
            $apiKey = $nytimesAPIConfig['api_key'];
            $apiUrl = $nytimesAPIConfig['api_url'];
            $nytimesAPIUrl = $apiUrl . '?api-key=' . $apiKey;

            $nyTimesAPIHttp = HttpClient::get($nytimesAPIUrl);

            if (!$nyTimesAPIHttp->ok()) {
                throw new \Exception('Failed to fetch news from The New York Times');
            }

            $results = json_decode($nyTimesAPIHttp->body(), true);
            $data = [];
            /*******************    Source     ****************************/
            $sourceName = 'New York Times';
            $sourceSlug = Str::slug($sourceName);
            $sourceObject = SourceRepository::firstOrCreate(['name' => $sourceName], ['slug' => $sourceSlug, 'name' => $sourceName]);

            foreach ($results['response']['docs'] as $article) {
                $articleUrl = $article['web_url'];

                //Checking duplicate entries.
                $newsByUrl = NewsRepository::getNewsByWhere(['url' => $articleUrl])->first();
                if ($newsByUrl) {
                    continue;
                }

                $title = Arr::get($article, 'headline.main');
                $description = Arr::get($article, 'abstract');
                $thumbnail = '';
                if (!empty($article['multimedia'])) {
                    foreach ($article['multimedia'] as $media) {
                        if (Arr::get($media, 'format') === 'thumbnail') {
                            $thumbnail = $media['url'];
                            break;
                        }
                    }
                }


                /*******************    Author     ****************************/

                $authorString = Arr::get($article, 'byline.original');
                $authors = AuthorRepository::createAuthorsByString($authorString);
                $authorObj = ($authors) ? collect($authors)->map(function ($author) {
                    return $author->only(['id', 'name', 'slug']);
                }): null;



                $newsData = [
                    'title' => $title,
                    'slug' => Str::slug($title),
                    'description' => $description,
                    'url' => $articleUrl,
                    'image_url' => $thumbnail,
                    'published_at' => Carbon::parse($article['pub_date']),
                    'source_id' => $sourceObject->id,
                    'source_name' => $sourceObject->name,
                    'authors_object' => json_encode($authorObj)
                ];
                $news = NewsRepository::createNews($newsData, $authorObj);
                $data[] = $news;

                $data[] = $news;

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
