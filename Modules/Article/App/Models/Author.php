<?php

namespace Modules\Article\App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
class Author extends Model
{
    use HasFactory;
    public $timestamps = false;

    protected $fillable = [ 'name','slug' ];

    public function news(){
        return $this->belongsToMany(News::class);
    }
}
