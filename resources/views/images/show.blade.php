@extends('layouts.app')

@section('title', '画像 - 表示')

@section('content')
<p></p>

<h1>{{ $item->filename }}</h1>
<p></p>

<p>
  <strong>イメージタグ</strong><br>
  {{ '<img src="'. url('/uploads/' .  $item->filename) .'" class="img-fluid" />' }}<br>
  <br>
  <span style="color:green;">上記のイメージタグを記事のHTMLで使用します。</span>
</p>

<p><a href="{{ url('/uploads/' .  $item->filename) }}">{{ $item->filename }}</a></p>
<div>
  <img src="{{ url('/uploads/' .  $item->filename) }}" class="img-fluid" />
</div>
<p></p>

<p>
  <strong>{{trans('validation.attributes.created_at')}} : </strong>
  {{$item->created_at}}
</p>

<a href="{{ url('images')}}">戻る</a>
<p></p>
@endsection
