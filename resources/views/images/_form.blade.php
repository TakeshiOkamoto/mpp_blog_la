{{-- エラーメッセージ --}}
@if (count($errors) > 0)
<div id="error_explanation" class="text-danger">
  <ul>
     @foreach ($errors->all() as $error)
       <li>{{ $error }}</li>
     @endforeach
  </ul>
</div>
@endif

{{-- フォーム --}} 
<form action="{{ $form_action }}" method="post" enctype="multipart/form-data">
  @csrf
  
  {{-- 初期表示(編集) --}}
  @if(isset($item) && is_null(old('_token')))  
    <input type="hidden" name="id" value="{{ $item->id }}">
  {{-- 新規/編集 --}}    
  @else
    <input type="hidden" name="id" value="{{ old('id') }}">
  @endif
  
  <div class="form-group">    
    <label for="images_image">{{ trans('validation.attributes.image') }}</label><br>
    <input type="file" id="images_image" name="image" accept="image/*" onchange="getElementById('images_name').value = this.files[0].name;">
    <p style="color:green;">※画像ファイル(JPEG/PNG/BMP/GIF/SVG/WebP)に対応。</p>
  </div>
      
  <div class="form-group">
    <label for="images_name">{{ trans('validation.attributes.filename') }}</label>
    @error('filename')
      <input type="text" class="form-control is-invalid" id="images_name" name="filename" value="{{ old('filename') }}">
    @else
      @if(isset($item) && is_null(old('_token')))
        <input type="text" class="form-control" id="images_name" name="filename" value="{{ $item->filename }}">
      @else
        <input type="text" class="form-control" id="images_name" name="filename" value="{{ old('filename') }}">
      @endif
    @enderror  
    <p style="color:green;">※ファイルの拡張子も入力して下さい。</p>
  </div> 
    
  <p></p>  
  
  @if(isset($item))
    <input type="hidden" name="_method" value="PUT">
    <input type="submit" value="更新する" class="btn btn-primary">    
  @else
    <input type="submit" value="登録する" class="btn btn-primary">    
  @endif
</form>
