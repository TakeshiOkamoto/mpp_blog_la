<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

// 追加分
use App\BlogCategory;
use Illuminate\Support\Facades\DB;

class CategoriesController extends Controller
{    
    
    public function index(Request $request)
    {
        $items = BlogCategory::whereRaw('1=1');
        $name = Controller::trim($request->name);
           
        if ($name != ""){
            $arr = explode(' ', $name);
            for ($i=0; $i<count($arr); $i++){
                $keyword = str_replace('%', '\%', $arr[$i]);            
                $items = $items->where('name', 'like', "%$keyword%");
            }
        }
        $items = $items->orderBy('sort','ASC')->paginate(25); 
        
        return view('categories.index', ['items' => $items, 'name'=> $name]);
    }

    public function create()
    {
        return view('categories.create');
    }

    public function store(Request $request)
    {
        // パラメータ
        $param = [
            'name'          => Controller::trim($request->name),  
            'description'   => Controller::trim($request->description),  
            'sort'          => $request->sort,      
        ];
        $request->merge($param); 
        
        // バリデーション               
        $request->validate(BlogCategory::Rules());   
               
        // トランザクション
        DB::transaction(function () use ($param) {
            $category = new BlogCategory;
            $category->fill($param)->save();
        });

        // フラッシュ
        session()->flash('flash_flg', 1);
        session()->flash('flash_msg', '登録しました。'); 
        
        return redirect(url('categories'));
    }

    public function show($id)
    {
        $item = BlogCategory::where('id', $id)->get();
        if(count($item) === 1){
            return view('categories.show', ['item' => $item[0]]);
        }else{
           return redirect(url('/'));
        }
    }

    public function edit($id)
    {
        $item = BlogCategory::where('id', $id)->get();
        if(count($item) === 1){
           return view('categories.edit', ['item' => $item[0]]);
        }else{
           return redirect(url('/'));
        }
    }

    public function update(Request $request, $id)
    {
        // パラメータ
        $param = [
            'name'          => Controller::trim($request->name),  
            'description'   => Controller::trim($request->description),  
            'sort'          => $request->sort,      
        ];
        $request->merge($param); 
        
        // 自分自身のnameのユニークを確認しない
        $rules = BlogCategory::Rules();
        $rules['name'] = 'required|max:20|unique:blog_categories,name,' . $id . ',id';   

        // バリデーション     
        $request->validate($rules);  
         
        // トランザクション      
        DB::transaction(function () use ($param, $id) {
            BlogCategory::where('id', $id)->update($param);
        });
        
        // フラッシュ
        session()->flash('flash_flg', 1);
        session()->flash('flash_msg', '更新しました。');
        
        return redirect(url('categories'));
    }

    public function destroy($id)
    {
        // トランザクション
        DB::transaction(function () use ($id) {
            BlogCategory::where('id', $id)->delete();
        });
        
        // フラッシュ
        session()->flash('flash_flg', 0);
        session()->flash('flash_msg', '削除しました。');
    }
}
