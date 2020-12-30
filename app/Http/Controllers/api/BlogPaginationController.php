<?php

// ネームスペース名を変更
namespace App\Http\Controllers\api;

use Illuminate\Http\Request;

// 追加分
use App\Http\Controllers\Controller;
use App\BlogArticle;
use App\BlogCategory;
use Illuminate\Support\Facades\DB;

class BlogPaginationController extends Controller
{
    public function index(Request $request)
    {   
        // [ページネーション]現在のページ(番号)
        $page = 1;
        if(isset($request->page)){
            if (Controller::isNumeric($request->page)){
                $page = $request->page;
            }
        }
        
        // [ページネーション]データの表示件数
        $per = 5;
        if(isset($request->per)){
            if (Controller::isNumeric($request->per)){
                $per = $request->per;
            } 
        }
        
        // データの取得
        $articles = BlogArticle::leftJoin('blog_categories', 'blog_articles.blog_category_id', '=','blog_categories.id');
        if ($request->category_id == "-1"){            
            $record_count_all = BlogArticle::count();
        }else{
            $articles = $articles->where('blog_category_id', $request->category_id);                               
            $record_count_all = BlogArticle::where('blog_category_id', $request->category_id)->count();
        }
        
        $articles = $articles
                      ->orderBy('created_at','DESC')
                      ->select('blog_articles.id',
                               'blog_articles.title',
                               'blog_articles.description',
                               'blog_articles.created_at',     
                               'blog_categories.id AS category_id',
                               'blog_categories.name AS category_name'
                               )
                      ->paginate($per);
            
        return response()->json([
                                 // 記事ID、タイトル、説明、登録日時、カテゴリID、カテゴリ名
                                 'articles'  => $articles->items(), 
                                 // [ページネーション]現在のページ(番号)
                                 'page' => $page,
                                 // [ページネーション]データの表示件数  
                                 'per'  => $per,
                                 // [ページネーション]全ページ数   
                                 'total_pages'  => $articles->lastPage(),
                                 // レコード件数   
                                 'record_count' => count($articles),      
                                 // レコード件数(全て)  
                                 'record_count_all' => $record_count_all,
                                 ]);                

        // JSONは次のような形式となる  ※per=  3の場合      
        /* ----------------------------------------------------

        {
          articles:[
            0:{
              id:12
              title:タイトル
              description:宇宙の神秘をテーマに...
              created_at:2020-08-05 07:12:56
              category_id:3
              category_name:政治・経済・生活
            }
            1:{
              id:11
              title:PolyWorldの使い方 [Unity]
              description:Unityアセットストアにある...
              created_at:2020-08-05 07:08:48
              category_id:1
              category_name:プログラミング
            }
            2:{
              id:10
              title:LZW圧縮アルゴリズム
              description:LZ78を改良した...
              created_at:2020-08-05 07:01:30
              category_id:1
              category_name:プログラミング
            }
          ]
          page:1
          per:3
          total_pages:4
          record_count:3
          record_count_all:12
        } 
        
        ---------------------------------------------------- */ 
    }
}
