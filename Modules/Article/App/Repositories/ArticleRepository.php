<?php

namespace Modules\Article\App\Repositories;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Article\Database\factories\ArticleFactory;

class ArticleRepository extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [];

    protected static function newFactory(): ArticleFactory
    {
        //return ArticleFactory::new();
    }
}
