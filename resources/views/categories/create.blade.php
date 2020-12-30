@extends('layouts.app')

@section('title', "カテゴリ - 新規登録")

@section('content')
<p></p>
<h1>新規登録 - カテゴリ</h1>
<p></p>

@include('categories._form', ['form_action' => url('categories')])

<p></p>
<a href="{{ url('categories') }}">戻る</a>
<p></p>
@endsection