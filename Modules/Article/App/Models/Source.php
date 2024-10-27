<?php

namespace Modules\Article\App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
class Source extends Model
{
    use HasFactory;

    public $timestamps = false;
    protected $guarded = [];
    protected $fillable = [ 'name','slug' ];

    public function news(){
        return $this->hasMany(News::class);
    }
}
