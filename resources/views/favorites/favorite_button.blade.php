@if (Auth::user()->isFavorite($micropost))
    {!! Form::open(['route' => ['favorites.unfavorite', $micropost], 'method' => 'delete']) !!}
    {!! Form::submit('Unfavorite', ['class' => 'btn btn-success btn-sm']) !!}
    {!! Form::close() !!}
@else
    {!! Form::open(['route' => ['favorites.favorite', $micropost]]) !!}
    {!! Form::submit('Favorite', ['class' => 'btn btn-outline-success btn-sm']) !!}
    {!! Form::close() !!}
@endif
