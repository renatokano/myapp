@extends('layout')

@section('content')
<p class="alert alert-success">Success Form Test</p>
<ul class="list-unstyled">
  <li>{{$input['name']}}</li>
  <li>{{$input['address']}}</li>
</ul>
@stop
