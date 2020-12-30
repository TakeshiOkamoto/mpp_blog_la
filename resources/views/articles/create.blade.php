@extends('layouts.app')

@section('title', "記事 - 新規登録")

@section('content')
<p></p>
<h1>新規登録 - 記事</h1>
<p></p>

@include('articles._form', ['form_action' => url('articles')])

<p></p>
<a href="{{ url('articles') }}">戻る</a>
<p></p>
@endsection