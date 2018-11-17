@extends('layouts.app')
@section('title', '个人中心')

@section('content')
    <div class="row user">
        <div class="col-lg-9 col-md-9">
            <div class="media user-info">
                <div class="media-left media-middle">
                    <a href="#">
                        <img class="media-object avater-default" src="{{ $user->avater ?: asset('images/avater-default.png') }}">
                    </a>
                </div>
                <div class="media-body info">
                    <div class="media-heading user-name">
                        <span class="name">{{ $user->name }}</span>
                        <a href="{{ route('user.edit', Auth::user()->mobile ) }}" class="edit-info">编辑个人信息</a>
                    </div>
                    <ul>
                        <li>
                            <a href="{{ route('user.topics', Auth::user()->mobile) }}">
                                <p class="info-count" >10</p>
                                帖子
                                <i class="fa fa-angle-right fa-lg" aria-hidden="true"></i>
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('user.comments', Auth::user()->mobile) }}">
                                <p class="info-count" >10</p>
                                评论
                                <i class="fa fa-angle-right fa-lg" aria-hidden="true"></i>
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
            <ul class="nav nav-pills user-part-nav">
                <li role="presentation" class="{{ active_class(if_route('user.topics')) }}">
                    <a href="{{ route('user.topics', Auth::user()->mobile) }}">
                        <i class="fa fa-pencil-square-o" aria-hidden="true"></i> 帖子
                    </a>
                </li>
                <li role="presentation" class="{{ active_class(if_route('user.comments')) }}">
                    <a href="{{ route('user.comments', Auth::user()->mobile) }}">
                        <i class="fa fa-commenting" aria-hidden="true"></i> 评论
                    </a>
                </li>
            </ul>
            @yield('user_part')
        </div>
        <div class="col-lg-3 col-md-3 sidebar">创建帖子</div>
    </div>
@endsection