@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            @include('notification')
        </div>
        <div class="row">
            @include('includes.above-quizzes-widgets')
        </div>
        <div class="row">
            @foreach($quizzes as $quiz)
                <div class="col-md-4 col-sm-6">
                    <div class="thumbnail">
                        <a href="{{ url('quiz/'.$quiz->slug.'/show') }}"><img src="{{ asset(config('image.quiz_template_url').$quiz->template->og_image) }}"></a>
                        <div class="caption">
                            <div class="bold"><a href="{{ url('quiz/'.$quiz->slug.'/show') }}">{{$quiz->title}}</a></div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
        <div class="row">
            @include('includes.below-quizzes-widgets')
        </div>
    </div>
@endsection
