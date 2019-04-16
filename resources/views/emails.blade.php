@extends('welcome')

@section('content')

<dl>
@foreach($userViewContext as $user)
   <dt>{{ $user->id }}: {{ $user->name }} </dt>

   @foreach($user->emails as $email)

        <dd>{{ $email->created_at }}</dd>

   @endforeach

@endforeach
</dl>
@endsection