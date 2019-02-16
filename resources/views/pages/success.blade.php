@extends('layouts.app')
@section('title', '操作成功')

@section('content')
  <div class="card">
    <div class="card-header">操作成功</div>
    <div class="card-body text-center">
      <h1>{{ $msg }}</h1>
    </div>
  </div>
@endsection