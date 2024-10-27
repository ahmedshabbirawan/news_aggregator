<?php

namespace Modules\Article\App\Repositories;
use Illuminate\Support\Str;
use Modules\Article\App\Models\Author;
use Modules\Article\App\Models\News;

class AuthorRepository
{

    public static function createAuthorsByString($authorString){
        $authorsArr = [];
        if ( ! empty( $authorString ) ) {
            $authors = explode(',',str_replace( ['|', 'and', ';'] ,',', $authorString));
            $authors = array_filter($authors);
            foreach ( $authors as $author ) {
                $author_slug = Str::slug($author);
                $authorsArr[] = Author::firstOrCreate(['slug' => $author_slug], ['slug' => $author_slug, 'name' => $author]);
            }
        }
        return $authorsArr;
    }



}
