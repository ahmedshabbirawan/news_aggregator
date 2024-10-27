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
use Modules\Article\App\Repositories\AuthorRepository;
use Modules\Article\App\Repositories\NewsRepository;
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

                /*******************    Source     ****************************/
                $source_slug = Arr::get($article, 'source.id');
                $source_name = Arr::get($article, 'source.name');
                if (empty($source_slug)) {
                    $source_slug = Str::slug($source_name);
                }

                $sourceObject = Source::firstOrCreate(['source_slug' => $source_slug],
                    ['source_slug' => $source_slug, 'source' => $source_name]);
                /*******************    Author     ****************************/

                $authorString = Arr::get($article, 'author');
                $authors = AuthorRepository::createAuthorsByString($authorString);
                $authorRaw = $authors->map(function ($author) {
                    return $author->only(['id', 'name', 'slug']);
                });



                $newsData = [
                    'title' => $title,
                    'slug' => Str::slug($title),
                    'description' => $description,
                    'url' => $articleUrl,
                    'image_url' => $thumbnail,
                    'published_at' => Carbon::parse($article['pub_date']),
                    'api_source' => 'NyTimes',
                    'source_id' => $sourceObject->id,
                    'raw_author' => json_encode($authorRaw)
                ];
                $news = NewsRepository::createNews($newsData);

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
