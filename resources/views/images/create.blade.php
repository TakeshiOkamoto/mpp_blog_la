@extends('layouts.app')

@section('title', "画像 - 新規登録")

@section('content')
<p></p>
<h1>新規登録 - 画像</h1>
<p></p>

@include('images._form', ['form_action' => url('images')])

<p></p>
<a href="{{ url('images') }}">戻る</a>
<p></p>
@endsection