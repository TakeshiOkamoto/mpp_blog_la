<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BlogImage extends Model
{
   protected $guarded = array('id');

   public static function Rules()
   {
      return [
          'image'     => 'required|image',
          'filename'  => 'required|max:100|unique:blog_images',
          ];
   }
}
