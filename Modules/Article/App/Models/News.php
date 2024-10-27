<?php

namespace Modules\Article\App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
class News extends Model
{
    use HasFactory;
    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'title','slug','description','url','image_url','content', 'published_at', 'api_source', 'source_id', 'source_name','authors_object'
    ];

    public function author(){
        return $this->belongsToMany(Author::class);
    }

    public function source(){
        return $this->belongsTo(Source::class, 'source_id', 'id');
    }

}
