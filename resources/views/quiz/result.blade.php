@extends('layouts.app')
@section('title', $page)
@section('content')
    <div class="container">
        <div class="row">
            @include('includes.above-quizzes-widgets')
        </div>
        <div class="row">
            @include('notification')
        </div>
        <div class="row">
            <div class="col-md-8">
                <div class="row">
                    <div class="col-md-10 col-md-offset-1">
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <div class="panel-title">{{ $quiz->title }}</div>
                            </div>
                            <div class="panel-body">
                                <div class="thumbnail">
                                    {!! htmlspecialchars_decode($template) !!}
                                    <div class="caption">
                                        <a class="btn btn-primary btn-lg btn-block" href="javascript:void(0);">Share</a>
                                    </div>
                                </div>
                            </div>
                            <div class="panel-footer">
                                {{$quiz->description}}
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-10 col-md-offset-1">
                        @if($quizzes->count())
                            @foreach($quizzes as $quizItem)
                                <div class="col-md-4 col-sm-6">
                                    <div class="thumbnail">
                                        <a href="{{ url('quiz/'.$quizItem->slug) }}"><img src="{{ asset('images/templates/'.$quizItem->template->og_image) }}"></a>
                                        <div class="caption">
                                            <div class="heading"><a href="{{ url('quiz/'.$quizItem->slug) }}">{{$quizItem->title}}</a></div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        @else
                            <div class="heading">
                                <span>There are no more quizzes.</span>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                @include('includes.left-sidebar')
            </div>
        </div>
        <div class="row">
            @include('includes.below-quizzes-widgets')
        </div>
    </div>
@endsection