<?php

namespace Modules\Media\App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Media\Database\factories\MediaFactory;

class Media extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [];
    
    protected static function newFactory(): MediaFactory
    {
        //return MediaFactory::new();
    }
}
