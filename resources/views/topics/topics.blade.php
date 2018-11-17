@extends('layouts.app')
@section('title', '论坛')

@section('content')
<div class="row">
	<div class="col-lg-9 col-md-9 topic-detail">
		<div class="panel panel-default">
			<div class="panel-body">
				@include('topics._topic_list', ['topics'=>$topics])
				{!! $topics->render() !!}
			</div>
		</div>
	</div>
	<div class="col-lg-3 col-md-3 sidebar">456</div>
</div>
@endsection