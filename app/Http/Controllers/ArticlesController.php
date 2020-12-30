<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

// 追加分
use App\BlogArticle;
use App\BlogCategory;
use Illuminate\Support\Facades\DB;

class ArticlesController extends Controller
{    

//----------------------------------------------------------
// メソッド
//----------------------------------------------------------

    // カテゴリリストを取得する 
    public function getCategoriesList()
    {
        return BlogCategory::orderBy('sort', 'ASC')->get();
    }  

//----------------------------------------------------------
// ルーティング
//----------------------------------------------------------
             
    public function index(Request $request)
    {
        $items = BlogArticle::leftJoin('blog_categories', 'blog_articles.blog_category_id', '=','blog_categories.id')
                 ->select('blog_articles.*', 'blog_categories.name');        
        $title = Controller::trim($request->title);
           
        if ($title != ""){
            $arr = explode(' ', $title);
            for ($i=0; $i<count($arr); $i++){
                $keyword = str_replace('%', '\%', $arr[$i]);            
                $items = $items->where('title', 'like', "%$keyword%");
            }
        }
        $items = $items->orderBy('created_at','DESC')->paginate(25); 
        
        return view('articles.index', ['items' => $items, 'title'=> $title]);
    }

    public function create()
    {
        $categories = $this->getCategoriesList();  
        return view('articles.create', ['categories' => $categories]);
    }

    public function store(Request $request)
    {
        // パラメータ
        $param = [
            'blog_category_id' => $request->blog_category_id,
            'title'            => Controller::trim($request->title), 
            'keywords'         => Controller::trim($request->keywords), 
            'description'      => Controller::trim($request->description),
            'body'             => Controller::trim($request->body),
        ];
        $request->merge($param); 
        
        // バリデーション               
        $request->validate(BlogArticle::Rules());   
               
        // トランザクション
        DB::transaction(function () use ($param) {
            $article = new BlogArticle;
            $article->fill($param)->save();
        });

        // フラッシュ
        session()->flash('flash_flg', 1);
        session()->flash('flash_msg', '登録しました。'); 
        
        return redirect(url('articles'));
    }

    public function show($id)
    {
        $item = BlogArticle::leftJoin('blog_categories', 'blog_articles.blog_category_id', '=','blog_categories.id')
                 ->where('blog_articles.id', $id)
                 ->select('blog_articles.*', 'blog_categories.name')
                 ->get();                           
        if(count($item) === 1){
            return view('articles.show', ['item' => $item[0]]);
        }else{
           return redirect(url('/'));
        }
    }

    public function edit($id)
    {
        $item = BlogArticle::where('id', $id)->get();
        if(count($item) === 1){
           $categories = $this->getCategoriesList();  
           return view('articles.edit', ['item' => $item[0], 'categories' => $categories]);
        }else{
           return redirect(url('/'));
        }
    }

    public function update(Request $request, $id)
    {
        // パラメータ
        $param = [
            'blog_category_id' => $request->blog_category_id,
            'title'            => Controller::trim($request->title), 
            'keywords'         => Controller::trim($request->keywords), 
            'description'      => Controller::trim($request->description),
            'body'             => Controller::trim($request->body),
        ];
        $request->merge($param); 
        
        // 自分自身のtitleのユニークを確認しない
        $rules = BlogArticle::Rules();
        $rules['title'] = 'required|max:250|unique:blog_articles,title,' . $id . ',id';   

        // バリデーション     
        $request->validate($rules);  
         
        // トランザクション      
        DB::transaction(function () use ($param, $id) {
            BlogArticle::where('id', $id)->update($param);
        });
        
        // フラッシュ
        session()->flash('flash_flg', 1);
        session()->flash('flash_msg', '更新しました。');
        
        return redirect(url('articles'));
    }

    public function destroy($id)
    {
        // トランザクション
        DB::transaction(function () use ($id) {
            BlogArticle::where('id', $id)->delete();
        });
        
        // フラッシュ
        session()->flash('flash_flg', 0);
        session()->flash('flash_msg', '削除しました。');
    }
}
