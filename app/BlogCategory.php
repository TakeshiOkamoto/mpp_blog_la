<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BlogCategory extends Model
{
   protected $guarded = array('id');

   public static function Rules()
   {
      return [
          'name'        => 'required|max:20|unique:blog_categories',
          'description' => 'required|max:255', 
          'sort'        => 'required|integer|max:1000', 
          ];
   }
}
