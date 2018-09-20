@extends('layout.index')
@section('content')

    <div class="row">
    <div class="col-md-4 col-xs-4">
    </div>
    <div class="col-md-8 col-xs-8">
        {{$text}}  <a class="hiperlacze" href="{{$link}}">{{$hiperlacze}}</a>
    </div>
    </div>
@endsection


