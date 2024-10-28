<?php

namespace Modules\Article\App\Repositories;
use Illuminate\Support\Str;
use Modules\Article\App\Models\Source;


class SourceRepository
{

   public static function firstOrCreate($where, $update = []){
       return Source::firstOrCreate($where, $update);
   }



}
