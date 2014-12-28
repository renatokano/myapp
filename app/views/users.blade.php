@extends('layout')

@section('content')
<h2>Users!</h2>
<ul>
  @foreach($users as $user)
  <li><a href='profile/{{$user->id}}'>{{ $user->name }}</a></li>
  @endforeach
</ul>
@stop
