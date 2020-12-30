@extends('layouts.app')

@section('title', "Laravel + Vue.jsで作るSPAのブログシステム")

@section('content')
  <div id="app">
    <main-component></main-component>
  </div>
  <script src="{{ url('js/app.js') }}"></script>
@endsection  