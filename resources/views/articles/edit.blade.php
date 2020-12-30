@extends('layouts.app')

@section('title', '記事 - 編集')

@section('content')
 
<p></p>
<p></p>
<h1>記事の編集</h1>
<p></p>

@include('articles._form', ['form_action' => url('articles/' . $item->id)])

<p></p>
<a href="{{ url('articles') }}">戻る</a>
<p></p>
@endsection