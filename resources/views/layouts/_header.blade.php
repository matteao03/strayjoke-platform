<nav class="navbar navbar-default navbar-fixed-top">
  <div class="container">
    <div class="navbar-header">
      <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
      <a class="navbar-brand logo-name" href="#">风了</a>
    </div>

    <div class="collapse navbar-collapse">
      <ul class="nav navbar-nav">
        <li class="{{ active_class(if_route('articles')) }}"><a href="{{ route('articles') }}"><span>热点</span></a></li>
        <li class="{{ active_class(if_route('topics')) }}"><a href="{{ route('topics') }}"><span>论坛</span></a></li>
        <li><a href="#"><span>维权</span></a></li>
        <li><a href="#"><span>招聘</span></a></li>
      </ul>
      <form class="navbar-form navbar-left">
        <div class="form-group">
          <input type="text" class="form-control search-input" placeholder="搜索">
        </div>
        <button type="submit" class="btn btn-default btn-search">搜索</button>
      </form>
      <ul class="nav navbar-nav navbar-right">
        @if (Auth::check())
            <li><a href="#"><span class="glyphicon glyphicon-bell" aria-hidden="true"></span></a></li>
            <li class="dropdown">
              <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                {{ Auth::user()->name }} <b class="caret"></b>
              </a>
              <ul class="dropdown-menu">
                <li><a href="{{ route('user.info', Auth::user()->mobile) }}"><span class="glyphicon glyphicon-user" aria-hidden="true"></span>个人中心</a></li>
                <li role="separator" class="divider"></li>
                <li><a href="{{ route('logout') }}"><span class="glyphicon glyphicon-log-out" aria-hidden="true"></span>退出</a></li>
              </ul>
            </li>
          @else
            <li><a href="{{ route('login') }}">登录</a></li>
            <li><a href="{{ route('signup') }}">注册</a></li>
          @endif
      </ul>
    </div>
  </div>
</nav>