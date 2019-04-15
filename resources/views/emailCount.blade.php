@extends('welcome')

@section('content')
  <p>Before: {{ $verifiedEmailCountBefore }}</p>
  <p>After: {{ $verifiedEmailCountAfter }}</p>

  <p>Chunks: {{ var_dump($chunks) }}</p>

  <p>Missing: {{ var_dump($missingIds) }}</p>

@endsection