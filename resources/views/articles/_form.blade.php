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
<form action="{{ $form_action }}" method="post">
  @csrf
  
  {{-- 初期表示(編集) --}}
  @if(isset($item) && is_null(old('_token')))  
    <input type="hidden" name="id" value="{{ $item->id }}">
  {{-- 新規/編集 --}}    
  @else
    <input type="hidden" name="id" value="{{ old('id') }}">
  @endif
      
  @php
    if(isset($item) && is_null(old('_token'))){
      $val = $item->blog_category_id;
    }else{
      $val = old('blog_category_id');
    }
  @endphp  

  <div class="form-group">
    <label for="articles_blog_category_id">{{ trans('validation.attributes.blog_category_id') }}</label>
    @error('debit_account_id')
      <select id="articles_blog_category_id" class="form-control is-invalid col-sm-3" name="blog_category_id">  
    @else   
      <select id="articles_blog_category_id" class="form-control col-sm-3" name="blog_category_id">  
    @enderror 
        <option value= "">選択して下さい。</option>  
        @foreach ($categories as $category)
          <option value= "{{ $category->id }}" {!! ($val ==  $category->id) ? 'selected="selected"' : '' !!}>{{ $category->name }}</option>
        @endforeach
      </select>
  </div>   
        
  <div class="form-group">
    <label for="articles_title">{{ trans('validation.attributes.title') }}</label>
    @error('title')
      <input type="text" class="form-control is-invalid" id="articles_title" name="title" value="{{ old('title') }}">
    @else
      @if(isset($item) && is_null(old('_token')))
        <input type="text" class="form-control" id="articles_title" name="title" value="{{ $item->title }}">
      @else
        <input type="text" class="form-control" id="articles_title" name="title" value="{{ old('title') }}">
      @endif
    @enderror  
  </div> 
  
  <div class="form-group">
    <label for="articles_keywords">{{ trans('validation.attributes.keywords') }} (keywords) <span style="color:green;">※半角カンマで区切る</span></label>
    @error('keywords')
      <input type="text" class="form-control is-invalid" id="articles_keywords" name="keywords" value="{{ old('keywords') }}">
    @else
      @if(isset($item) && is_null(old('_token')))
        <input type="text" class="form-control" id="articles_keywords" name="keywords" value="{{ $item->keywords }}">
      @else
        <input type="text" class="form-control" id="articles_keywords" name="keywords" value="{{ old('keywords') }}">
      @endif
    @enderror  
  </div>   

  <div class="form-group">
    <label for="articles_description">{{ trans('validation.attributes.description') }} (description)</label>
    @error('description')
      <input type="text" class="form-control is-invalid" id="articles_description" name="description" value="{{ old('description') }}">
    @else
      @if(isset($item) && is_null(old('_token')))
        <input type="text" class="form-control" id="articles_description" name="description" value="{{ $item->description }}">
      @else
        <input type="text" class="form-control" id="articles_description" name="description" value="{{ old('description') }}">
      @endif
    @enderror  
  </div>        

  <div class="form-group">
    <label for="articles_body">{{ trans('validation.attributes.body')}} <span style="color:green;">※HTMLで記述する</span></label>
    @error('body')
      <textarea rows="30" class="form-control is-invalid" id="articles_body" name="body">{{ old('body') }}</textarea>
    @else
      @if(isset($item) && is_null(old('_token')))
        <textarea rows="30" class="form-control" id="articles_body" name="body">{{ $item->body }}</textarea>
      @else
        <textarea rows="30" class="form-control" id="articles_body" name="body">{{ old('body') }}</textarea>
      @endif      
    @enderror
  </div>
  <p></p>  
  
  @if(isset($item))
    <input type="hidden" name="_method" value="PUT">
    <input type="submit" value="更新する" class="btn btn-primary">    
  @else
    <input type="submit" value="登録する" class="btn btn-primary">    
  @endif
</form>
