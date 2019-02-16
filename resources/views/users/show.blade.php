@extends('layouts.app')
@section('title', '我的主页')

@section('content')
    <div class="row user">
        <div class="col-lg-2 col-md-2 sidebar">
            <ul class="list-group">
                <li class="list-group-item active">
                    <i class="fas fa-user"></i> 基本资料
                </li>
                <li class="list-group-item">
                    <i class="far fa-file-alt"></i> 我的文章
                </li>
                <li class="list-group-item">
                     <i class="fas fa-list-ul"></i> 我的帖子
                </li>
                <li class="list-group-item">
                    <i class="fas fa-gavel"></i> 我的维权
                </li>
            </ul>
            
            <ul class="list-group">
                <li class="list-group-item">
                    <i class="far fa-comment"></i> 我的回复
                </li>
                <li class="list-group-item">
                    <i class="far fa-comment"></i> 我的收藏
                </li>
                <li class="list-group-item">
                    <i class="fas fa-thumbs-up"></i> 我的点赞
                </li>
                <li class="list-group-item">
                    <i class="fas fa-gift"></i> 我的打赏
                </li>
            </ul>
            <ul class="list-group">
                <li class="list-group-item">
                    <i class="fas fa-eye"></i> 我的关注
                </li>
                <li class="list-group-item">
                    <i class="far fa-smile"></i> 我的粉丝
                </li>
            </ul>
        </div>
        <div class="col-lg-7 col-md-7 sidebar">
            1234567
        </div>
        <div class="col-lg-3 col-md-3 sidebar">
            <div class="thumbnail info">
                <img class="media-object avatar-default" src="{{ $user->avatar ?: asset('images/avatar-default.png') }}">
                <div class="caption">
                  @if($user->lawyer)
                  <div class="row info-item">
                      <div class="col-lg-3 col-md-3">
                          <div>文章</div>
                          <div class="count">0</div>
                      </div>
                      <div class="col-lg-3 col-md-3">
                          <div>回复</div>
                          <div class="count">0</div>
                      </div>
                      <div class="col-lg-3 col-md-3">
                          <div>粉丝</div>
                          <div class="count">0</div>
                      </div>
                      <div class="col-lg-3 col-md-3">
                          <div>喜欢</div>
                          <div class="count">0</div>
                      </div>
                  </div>
                  <h3 class="name">{{ $user->nickname }}</h3>
                  <div>{{$user->lawyer->name}} @ {{$user->lawyer->org}}</div>
                  @else
                  <div class="row info-item">
                      <div class="col-lg-3 col-md-3">
                          <div>帖子</div>
                          <div class="count">0</div>
                      </div>
                      <div class="col-lg-3 col-md-3">
                          <div>回复</div>
                          <div class="count">0</div>
                      </div>
                      <div class="col-lg-3 col-md-3">
                          <div>粉丝</div>
                          <div class="count">0</div>
                      </div>
                      <div class="col-lg-3 col-md-3">
                          <div>喜欢</div>
                          <div class="count">0</div>
                      </div>
                  </div>
                  <h3 class="name">{{ $user->nickname }}</h3>
                  <p><a href="#" class="btn btn-default" role="button">认证律师</a></p>
                  @endif
                  <p><a href="{{ route('users.edit', $user->id) }}" class="btn btn-default " role="button">编辑个人资料</a></p>
                </div>
            </div>
        </div>
    </div>
@endsection