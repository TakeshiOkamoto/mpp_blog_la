@extends('layouts.app')

@section('title', "画像")

@section('content')

<p></p>
<h1>画像</h1>
<p></p>

<form action="{{ url('images') }}" method="get">
  <div class="input-group">
    <input type="search" name="filename" class="form-control" placeholder="検索したいファイル名を入力" value="{{ $filename }}">
    <span class="input-group-btn">
      <input type="submit" value="検索" class="btn btn-outline-info"> 
    </span>
  </div>
</form>

<p></p>
<a href="{{ url('images/create') }}" class="btn btn-primary">画像の新規登録</a>
<p></p>

<table class="table table-hover">
  <thead class="thead-default">
    <tr>
      <th class="pc">{{ trans('validation.attributes.created_at') }}</th>
      <th>画像</th>
      <th></th>  
    </tr>
  </thead>
  <tbody class="thead-default">
    @foreach ($items as $item)
    <tr>
      <td style="width: 120px;" class="pc">{{ $item->created_at }}</td>
      <td>
        <div style="width:320px;"  class="pc">
          {{ $item->filename }}<br>
          <a href="{{ url('images/' . $item->id) }}"><img src="{{ url('uploads/' .  $item->filename) }}" class="img-fluid" /></a>
          <p></p>
          <a href="{{ url('images/' . $item->id) }}" class="btn btn-info">表示</a>
          &nbsp;&nbsp;
          <a href="#" onclick="ajax_delete('「{{ $item->filename }}」を削除します。よろしいですか？','{{ url('images/' . $item->id) }}','{{ url('images') }}');return false;" class="btn btn-danger">削除</a>
       </div>   
        <div style="width:280px;"  class="sp">
          {{ $item->filename }}<br>
          <a href="{{ url('images/' . $item->id) }}"><img src="{{ url('uploads/' .  $item->filename) }}" class="img-fluid" /></a>
          <p></p>
          <a href="{{ url('images/' . $item->id) }}" class="btn btn-info">表示</a>
          &nbsp;&nbsp;
          <a href="#" onclick="ajax_delete('「{{ $item->filename }}」を削除します。よろしいですか？','{{ url('images/' . $item->id) }}','{{ url('images') }}');return false;" class="btn btn-danger">削除</a>
       </div>          
      </td>            
    </tr>    
    @endforeach
  </tbody>    
</table>

{{ $items->appends(['name' => $filename])->links() }}

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