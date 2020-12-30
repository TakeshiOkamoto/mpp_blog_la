@extends('layouts.app')

@section('title', 'カテゴリ - 編集')

@section('content')
 
<p></p>
<p></p>
<h1>カテゴリの編集</h1>
<p></p>

@include('categories._form', ['form_action' => url('categories/' . $item->id)])

<p></p>
<a href="{{ url('categories') }}">戻る</a>
<p></p>
@endsection