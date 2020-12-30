<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

// 追加分
use App\BlogImage;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class ImagesController extends Controller
{
    public function index(Request $request)
    {
        $items = BlogImage::whereRaw('1=1');
        $filename = Controller::trim($request->filename);
           
        if ($filename != ""){
            $arr = explode(' ', $filename);
            for ($i=0; $i<count($arr); $i++){
                $keyword = str_replace('%', '\%', $arr[$i]);            
                $items = $items->where('filename', 'like', "%$keyword%");
            }
        }
        $items = $items->orderBy('updated_at','DESC')->paginate(25); 
        
        return view('images.index', ['items' => $items, 'filename'=> $filename]);
    }

    public function create()
    {
        return view('images.create');
    }

    public function store(Request $request)
    {     
        // パラメータ
        $param = [
            'image'     => $request->file('image'), 
            'filename'  => $request->filename,  
        ];
        $request->merge($param); 
        
        // バリデーション               
        $request->validate(BlogImage::Rules());   
               
        // トランザクション
        DB::transaction(function () use ($request, $param) {
            $image = new BlogImage;
            unset($param['image']);
            $image->fill($param)->save();            
      
            // ファイルは標準だとstorage\app\に保存されるが、
            // config\filesystems.phpで設定を変えているのでpublic/uploadsに保存される
            $request->file('image')->storeAs('', $param['filename']);            
        });

        // フラッシュ
        session()->flash('flash_flg', 1);
        session()->flash('flash_msg', '登録しました。'); 
        
        return redirect(url('images'));
    }

    public function show($id)
    {
        $item = BlogImage::where('id', $id)->get();
        if(count($item) === 1){
            return view('images.show', ['item' => $item[0]]);
        }else{
           return redirect(url('/'));
        }
    }

    public function destroy($id)
    {
        $item = BlogImage::where('id', $id)->get();
        if(count($item) === 1){
                     
            // トランザクション
            DB::transaction(function () use ($item, $id) { 
                BlogImage::where('id', $id)->delete();
                Storage::delete($item[0]->filename);
            });
            
            // フラッシュ
            session()->flash('flash_flg', 0);
            session()->flash('flash_msg', '削除しました。');
        }
    }
}
