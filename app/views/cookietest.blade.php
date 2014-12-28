@extends('layout')
@section('content')
<p class="alert alert-success">Success Cookie Test</p>
Forever cookie: {{ $forever }} <br />
Temporary cookie: {{ $temporary }} <br />
Variable test: {{ $variableTest }}
@stop
