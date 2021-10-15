@if (Auth::id() != $user->id)
    @if (Auth::user()->isFollowing($user))
        {{-- アンフォローボタンのフォーム --}}
        {!! Form::open(['route' => ['user.unfollow', $user], 'method' => 'delete']) !!}
        {!! Form::submit('Unfollow', ['class' => 'btn btn-danger btn-block']) !!}
        {!! Form::close() !!}
    @else
        {{-- フォローボタンのフォーム --}}
        {!! Form::open(['route' => ['user.follow', $user]]) !!}
        {!! Form::submit('Follow', ['class' => 'btn btn-primary btn-block']) !!}
        {!! Form::close() !!}
    @endif
@endif
