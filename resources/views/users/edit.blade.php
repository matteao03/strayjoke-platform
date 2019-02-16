@extends('layouts.app')
@section('title', '编辑个人信息')

@section('content')
    <div class="row edit-user">
        <div class="col-lg-3 col-md-3 sidebar">
            <ul class="list-group">
                <li class="list-group-item active">
                    <i class="fas fa-list-ul"></i> 个人信息
                </li>
                <li class="list-group-item">
                    @if($user->lawyer)
                    <a href="{{ route('lawyers.edit', $user->lawyer->id)}}">
                    @else
                    <a href="{{ route('lawyers.create') }}">
                    @endif
                        <i class="fas fa-gavel"></i> 律师认证
                    </a>
                </li>
                <li class="list-group-item">
                    <i class="far fa-file-alt"></i> 社交账号
                </li>
                <li class="list-group-item">
                     <i class="fas fa-lock"></i> 修改密码
                </li>
            </ul>
        </div>
        
    	<div class="col-lg-9 col-md-9">
            <div class="panel-body">
                <div class="form-group edit-user-group input-avatar">
                    <img src="{{ $user->avatar ?: asset('images/avatar-default.png') }}" class="avatar-default" id="user-avatar">
                    <span class="btn-avatar">
                        <input type="file" class="input-hide-file" id="input-hide-file" name="files[]" data-url="{{ route('fileUpload') }}"><span id="fileupload-title">更改头像</span>
                    </span>
                </div>

                <form action="{{ route('users.update', $user->id) }}" method="POST" accept-charset="UTF-8"  class="form-horizontal">
                    <input type="hidden" name="_method" value="PATCH">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                    <div class="form-group edit-user-group">
                        <label for="name-field" class="input-left">用户名</label>
                        <input type="text" name="name" id="name-field" value="{{ old('name', $user->name) }}" /> 
                    </div>
                    <div class="form-group edit-user-group">
                        <label for="name-field" class="input-left">昵称</label>
                        <input type="text" name="nickname" id="name-field" value="{{ old('name', $user->nickname) }}" /> 
                    </div>
                    <div class="form-group edit-user-group">
                        <label for="name-field" class="input-left">手机</label>
                        <bind-mobile mobile="{{ $user->mobile }}"></</bind-mobile>
                    </div>
                    <button type="submit" class="btn btn-primary btn-update-user">保存</button>
                </form>
            </div>
    	</div>
    </div>
@endsection

@section('scripts')
    <script type="text/javascript"  src="{{ asset('js/jquery_file_upload/js/vendor/jquery.ui.widget.js') }}"></script>
    <script type="text/javascript"  src="{{ asset('js/jquery_file_upload/js/jquery.fileupload.js') }}"></script>
    <script type="text/javascript"  src="{{ asset('js/jquery_file_upload/js/jquery.iframe-transport.js') }}"></script>

    <script type="text/javascript">
    $(function () {
	    $('#input-hide-file').fileupload({
	        dataType: 'json',
	        // 上传完成后的执行逻辑
	        done: function (e, data) {
	        	$.each(data.result.files, function (index, file) {
                	$("#user-avatar").attr('src', file.url);
            	});
	        	$('#fileupload-title').text('更改头像');
	           	$('.btn-avatar').removeClass('upload-tips'); 
	        },

	        // 上传过程中的回调函数
	        progressall: function (e, data) {
	           $('#fileupload-title').text('上传中...');
	           $('.btn-avatar').addClass('upload-tips');     
	        }
	    });
	});
    </script>

@endsection