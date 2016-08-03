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
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <h3 class="panel-title heading text-center">{{ $quiz->title }}</h3>
                        </div>
                        <div class="panel-body">
                                <img src="{{ asset(config('image.quiz_template_url').$quiz->template->og_image) }}">
                                <div class="caption">
                                    <a class="btn btn-primary btn-block" href="{{ url('quiz/'.$quiz->slug.'/start') }}">Start</a>
                                </div>
                                <span>You will be required to login with Facebook.</span>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-10 col-md-offset-1">
                        @if($quizzes->count())
                            @foreach($quizzes as $quizItem)
                                <div class="col-md-4 col-sm-6">
                                    <div class="thumbnail">
                                        <a href="{{ url('quiz/'.$quizItem->slug.'/show') }}"><img src="{{ asset(config('image.quiz_template_url').$quizItem->template->og_image) }}"></a>
                                        <div class="caption">
                                            <div class="heading"><a href="{{ url('quiz/'.$quizItem->slug.'/show') }}">{{$quizItem->title}}</a></div>
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
                <div class="row">
                    @include('includes.after-quiz-widgets')
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