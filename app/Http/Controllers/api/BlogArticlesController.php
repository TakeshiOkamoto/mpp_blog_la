<?php

// ネームスペース名を変更
namespace App\Http\Controllers\api;

use Illuminate\Http\Request;

// 追加分
use App\Http\Controllers\Controller;
use App\BlogArticle;
use App\BlogCategory;
use Illuminate\Support\Facades\DB;

class BlogArticlesController extends Controller
{
    public function index(Request $request)
    {   
        // 1件のみデータを取得する
        $item = BlogArticle::leftJoin('blog_categories', 'blog_articles.blog_category_id', '=','blog_categories.id')
                   ->where('blog_articles.id', $request->id)
                   ->select('blog_articles.id',
                            'blog_articles.title',
                            'blog_articles.keywords',
                            'blog_articles.description',
                            'blog_articles.body',
                            'blog_articles.created_at',     
                            'blog_categories.id AS category_id',
                            'blog_categories.name AS category_name'
                           )
                   ->get(); 

        // JSONを返す
        return $item->toArray(); 
    
        // JSONは次のような形式となる
        //
        //  [
        //    0: {"id": 12, "title": "中性子星(パルサー)が放つパルス状..." ,,,  }
        //  ]    
    }
}
