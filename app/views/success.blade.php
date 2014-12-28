@extends('layout')

@section('content')
<p class="alert alert-success">Success Form Test</p>
<ul class="list-unstyled">
  <li>{{$input['name']}}</li>
  <li>{{$input['address']}}</li>
</ul>
<?php
  // Attaching a new Cookie to a Response
  // $response = Response::make('Hello World');
  // $response->withCookie(Cookie::make('name', 'value', 2));
  $cookie = Cookie::forever('forever', 'success');
?>
@stop
