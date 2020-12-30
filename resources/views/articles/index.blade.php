@extends('layouts.app')

@section('title', "記事")

@section('content')

<p></p>
<h1>記事</h1>
<p></p>

<form action="{{ url('articles') }}" method="get">
  <div class="input-group">
    <input type="search" name="title" class="form-control" placeholder="検索したいタイトルを入力" value="{{ $title }}">
    <span class="input-group-btn">
      <input type="submit" value="検索" class="btn btn-outline-info"> 
    </span>
  </div>
</form>
<p></p>

<a href="{{ url('articles/create') }}" class="btn btn-primary">記事の新規登録</a>

<p></p>
<table class="table table-hover">
  <thead class="thead-default">
    <tr>
      <th style="width: 120px;" class="pc">{{ trans('validation.attributes.created_at') }}</th>
      <th>{{ trans('validation.attributes.title') }}</th>
      <th></th>  
    </tr>
  </thead>
  <tbody class="thead-default">
    @foreach ($items as $item)
    <tr>
      <td class="pc">{{ $item->created_at }}</td>    
      <td><a href="{{ url('articles/' . $item->id) }}">{{ $item->title }}</a><br><span class="badge badge-secondary">{{ $item->name }}</span>
      <div class="sp">
        <p></p>
        <a href="{{ url('articles/' . $item->id . '/edit') }}" class="btn btn-primary">編集</a>
        &nbsp;&nbsp;
        <a href="#" onclick="ajax_delete('「{{ $item->title }}」を削除します。よろしいですか？','{{ url('articles/' . $item->id) }}','{{ url('articles') }}');return false;" class="btn btn-danger">削除</a>
      </div>
      </td>          
      <td style="width:170px;" class="pc">
        <a href="{{ url('articles/' . $item->id . '/edit') }}" class="btn btn-primary">編集</a>
        &nbsp;&nbsp;
        <a href="#" onclick="ajax_delete('「{{ $item->title }}」を削除します。よろしいですか？','{{ url('articles/' . $item->id) }}','{{ url('articles') }}');return false;" class="btn btn-danger">削除</a>
      </td>            
    </tr>    
    @endforeach
  </tbody>    
</table>

{{ $items->appends(['title' => $title])->links() }}

@if (count($items) >0)
  <p>全{{ $items->total() }}件中 
       {{  ($items->currentPage() -1) * $items->perPage() + 1 }} - 
       {{ (($items->currentPage() -1) * $items->perPage() + 1) + (count($items) -1) }}件<span class="pc">のデータ</span>が表示されています。</p>
@else
  <p>データがありません。</p>
@endif 

<p><br></p>
<p></p>
@endsection