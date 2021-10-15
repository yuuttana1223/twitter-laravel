@if (Auth::id() == $micropost->user_id)
    {!! Form::open(['route' => ['microposts.destroy', $micropost], 'method' => 'delete']) !!}
    {!! Form::submit('Delete', ['class' => 'btn btn-danger btn-sm']) !!}
    {!! Form::close() !!}
@endif
