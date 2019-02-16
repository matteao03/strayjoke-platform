<nav class="navbar navbar-default navbar-fixed-top">
  <div class="container">
    <div class="navbar-header">
      <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#st-navbar" aria-expanded="false">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
      <a class="navbar-brand logo-name" href="#">风了</a>
    </div>

    <div class="collapse navbar-collapse" id="st-navbar">
      <ul class="nav navbar-nav">
        <li class="active"><a href="{{ route('articles') }}"><span>热点</span></a></li>
        <li><a href="#"><span>论坛</span></a></li>
        <li><a href="#"><span>维权</span></a></li>
        <li><a href="#"><span>招聘</span></a></li>
      </ul>
      
      <ul class="nav navbar-nav navbar-right">
        <div class="navbar-form navbar-left">
          <div class="form-group">
            <input type="text" class="form-control search-input" placeholder="搜索">
          </div>
          {{-- <button type="submit" class="btn btn-default btn-search">搜索</button> --}}
        </div>
        @if (Auth::check())
            <li>
                <a href="{{ route('articles.create')}}">
                    <i class="fa fa-plus"></i>
                </a>
            </li>
            <li><a href="#"><span class="glyphicon glyphicon-bell" aria-hidden="true"></span></a></li>
            <li class="dropdown">
              <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                  <img src="{{ Auth::user()->avatar ?: asset('images/avatar-default.png')}}"  width="25"/>
                {{ Auth::user()->nickname }} <b class="caret"></b>
              </a>
              <ul class="dropdown-menu">
                <li><a href="{{ route('users.show', Auth::user()->id) }}"><span class="glyphicon glyphicon-user" aria-hidden="true"></span>我的主页</a></li>
                <li role="separator" class="divider"></li>
                <li><a href="{{ route('logout') }}"><span class="glyphicon glyphicon-log-out" aria-hidden="true"></span>退出</a></li>
              </ul>
            </li>
          @else
            <li><a href="{{ route('login') }}">登录</a></li>
            <li><a href="{{ route('join') }}">注册</a></li>
          @endif
      </ul>
    </div>
  </div>
</nav>