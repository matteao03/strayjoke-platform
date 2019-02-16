@extends('layouts.app')
@section('title', '编辑个人信息')

@section('content')
    <div class="row edit-user">
        <div class="col-lg-3 col-md-3 sidebar">
            <ul class="list-group">
                <li class="list-group-item active">
                    <i class="fas fa-gavel"></i> 律师信息
                </li>
                <li class="list-group-item">
                    <a href="{{route('articles.create')}}">
                        <i class="far fa-file-alt"></i> 写文章
                    </a>
                </li>
                <li class="list-group-item">
                     <i class="fas fa-list"></i> 维权
                </li>
            </ul>
        </div>
        
    	<div class="col-lg-9 col-md-9">
            <div class="panel-body">
                @if($lawyer->id)
                <form action="{{ route('lawyers.update', $lawyer->id) }}" method="POST" accept-charset="UTF-8"  class="form-horizontal">
                    <input type="hidden" name="_method" value="PUT">
                @else
                <form action="{{ route('lawyers.store') }}" method="POST" accept-charset="UTF-8"  class="form-horizontal">
                @endif
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                    <div class="form-group edit-user-group">
                        <label for="name-field" class="input-left">真实姓名</label>
                        <input type="text" name="name" id="name-field" value="{{ old('name', $lawyer->name) }}" /> 
                    </div>
                    <div class="form-group edit-user-group">
                        <label for="org-field" class="input-left">所在公司</label>
                        <input type="text" name="org" id="org-field" value="{{ old('org', $lawyer->org) }}" /> 
                    </div>
                    <div class="form-group edit-user-group">
                        <label for="tel-field" class="input-left">联系方式</label>
                        <input type="text" name="tel" id="tel-field" value="{{ old('tel', $lawyer->tel) }}" /> 
                    </div>
                    <div class="form-group edit-user-group">
                        <label for="description-field" class="input-left">简介</label>
                        <textarea rows="3" style="overflow: hidden; overflow-wrap: break-word; resize: none;" cols="50" name="description" id="description-field">{{ old('tel', $lawyer->description) }}</textarea> 
                    </div>
                    <button type="submit" class="btn btn-primary btn-update-user">保存</button>
                </form>
            </div>
    	</div>
    </div>
@endsection