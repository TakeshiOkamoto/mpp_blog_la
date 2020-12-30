<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BlogArticle extends Model
{
   protected $guarded = array('id');

   public static function Rules()
   {
      return [
          'blog_category_id' => 'required|exists:blog_categories,id',
          'title'            => 'required|max:250|unique:blog_articles',
          'keywords'         => 'required|max:250', 
          'description'      => 'required|max:250', 
          'body'             => 'required|max:60000',                                        
          ];
   }
}
