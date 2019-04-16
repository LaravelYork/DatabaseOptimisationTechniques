@extends('welcome')

@section('content')

   <p>{{ $sucessfullyCreatedTwoUsers ? 'Sucess' : 'Failed' }}</p>

   <p>{{ $emailsFound }}</p>


@endsection