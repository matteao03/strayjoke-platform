<div class="thumbnail info">
    <a href="{{ route('users.show', $user->id)}}">
        <img class="media-object avatar-default" src="{{ $user->avatar ?: asset('images/avatar-default.png') }}">
    </a>
    <div class="caption">
        <a href="{{ route('users.show', $user->id)}}">
            <h3 class="name">{{ $user->nickname }}</h3>
            <div>{{$user->lawyer->name}} @ {{$user->lawyer->org}}</div>
        </a>
      @if($user->id != Auth::id())
      <p><a href="#" class="btn btn-default " role="button">关注</a></p>
      @endif
    </div>
</div>
