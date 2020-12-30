@extends('layouts.app')

@section('title', 'カテゴリ - 表示')

@section('content')
<p></p>

<h1>{{$item->name}}</h1>
<p></p>

<p>
  <strong>{{ trans('validation.attributes.description') }} : </strong>
  {{ $item->description }}
</p>

<p>
  <strong>{{ trans('validation.attributes.sort') }} : </strong>
  {{ $item->sort }}
</p>

<a href="{{ url('categories/' . $item->id . '/edit')}}">編集</a>&nbsp;&nbsp;|&nbsp;&nbsp;<a href="{{ url('categories')}}">戻る</a>
<p></p>
@endsection
