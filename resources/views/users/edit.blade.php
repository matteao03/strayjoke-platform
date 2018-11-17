@extends('layouts.app')
@section('title', '编辑个人信息')

@section('content')
    <div class="row edit-user">
    	<div class="col-lg-3 col-md-3 sidebar">基本信息</div>
    	<div class="col-lg-9 col-md-9">
    		<div class="panel-body">
    			<div class="form-group edit-user-group input-avater">
                    <img src="{{ $user->avater ?: asset('images/avater-default.png') }}" class="avater-default" id="user-avater">
                    <span class="btn-avater">
                    	<input type="file" class="input-hide-file" id="input-hide-file" name="files[]" data-url="{{ route('fileUpload') }}"><span id="fileupload-title">更改头像</span>
                    </span>
                </div>

	            <form action="{{ route('user.update', $user->id) }}" method="POST" accept-charset="UTF-8"  class="form-horizontal">
	                <input type="hidden" name="_method" value="PUT">
	                <input type="hidden" name="_token" value="{{ csrf_token() }}">
	                <div class="form-group edit-user-group">
	                    <label for="name-field" class="input-left">用户名</label>
	                    <input type="text" name="name" id="name-field" value="{{ old('name', $user->name) }}" /> 
	                </div>
					<div class="form-group edit-user-group">
					    <label for="name-field" class="input-left">手机号</label>
				    	<span>{{ $user->mobile }}</span>
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
                	$("#user-avater").attr('src', file.url);
            	});
	        	$('#fileupload-title').text('更改头像');
	           	$('.btn-avater').removeClass('upload-tips'); 
	        },

	        // 上传过程中的回调函数
	        progressall: function (e, data) {
	           $('#fileupload-title').text('上传中...');
	           $('.btn-avater').addClass('upload-tips');     
	        }
	    });
	});
    </script>

@endsection