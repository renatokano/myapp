@extends('layout')

@section('content')
<h2>Test!</h2>
<p>
  <?php

    if (App::environment('production')){
      echo 'Ambiente de produção!';
    }
    else if (App::environment('local')) {
      echo 'Ambiente local de desenvolvimento!';
    }
    else {
      echo 'Indeterminado!';
    }
  ?>
</p>
<p>
  <?php
    echo $_ENV['PASS'];
  ?>
</p>

@stop
