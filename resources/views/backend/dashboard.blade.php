@extends('backend.layout.app')
@section('title','Dashboard')
@section('content')
<section class="content">
    <div class="container-fluid">
      <div class="card text-center">
        <div class="card-header">
            <h3 class="">Play Game</h3>
            <a href="{{route('game.page1')}}"><img src="{{ asset('/storage/settings/default/game_image.png') }}" alt=""></a>
        </div>
      </div>
    </div><!-- /.container-fluid -->
  </section>
@endsection