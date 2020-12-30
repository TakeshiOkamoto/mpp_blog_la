@extends('layouts.app')

@section('title', '記事 - 表示')

@section('content')
<p></p>

<h1>{{ $item->title }}</h1>
<p></p>

<p>
  <strong>{{ trans('validation.attributes.blog_category_id') }} : </strong>
  {{ $item->name }}
</p>

<p>
  <strong>{{ trans('validation.attributes.keywords') }} (keywords) : </strong>
  {{ $item->keywords }}
</p>

<p>
  <strong>{{ trans('validation.attributes.description') }} (description) : </strong>
  {{ $item->description }}
</p>

<p>
  <strong>{{ trans('validation.attributes.created_at') }}: </strong>
  {{ $item->created_at }}
</p>

<p>
  <strong>{{ trans('validation.attributes.updated_at') }}: </strong>
  {{ $item->updated_at }}
</p>

<br>
<span style="color:green;">以下はプレビューとなります。</span>
<br>
{!! $item->body !!}
<br>
<br>
<br>
<a href="{{ url('articles/' . $item->id . '/edit')}}">編集</a>&nbsp;&nbsp;|&nbsp;&nbsp;<a href="{{ url('articles')}}">戻る</a>
<p></p>
@endsection
