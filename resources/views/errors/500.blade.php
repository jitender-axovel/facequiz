@extends('layouts.app')
@section('content')
    <div class="container main-content">
        <div class="row advertise-block">
            @include('includes.above-quizzes-widgets')
        </div>
        <div class="row text-center">
        	<h1 class="text-bold">Oops!</h1>
        	<h3>looks like you are on a wrong page.</h3>
        	<a href="{{ url('/') }}" class="btn btn-danger btn-lg"><i class="fa fa-home"></i>&nbsp;Go to HomePage</a>
        </div>
        <div class="row">
            @include('includes.below-quizzes-widgets')
        </div>
    </div>
@endsection