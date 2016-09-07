@extends('layouts.app')
@section('content')
    <div class="main-content container">
        <div class="row">
            @include('notification')
        </div>
        <div class="row">
            @include('includes.above-quizzes-widgets')
        </div>
        <div class="row">
            @foreach($quizzes as $key=>$quiz)
                @if($key == 0)
                    <div class="top-section">
                        <div class="col-md-8 left-section col-sm-7 col-xs-12">
                            <div class="thumbnail item">
                                <div class="content-img">
                                    <a href="{{ url('quiz/'.$quiz->slug.'/show') }}"><img src="{{ asset(config('image.quiz_template_url').$quiz->template->og_image) }}">
                                    </a>
                                </div>
                                <div class="caption">
                                    <div class="bold"><a href="{{ url('quiz/'.$quiz->slug.'/show') }}">{{$quiz->title}}</a></div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4 col-sm-5 col-xs-12 right-section">
                @elseif($key > 0 && $key < 3)
                    <div class="thumbnail item">
                        <div class="content-img">
                            <a href="{{ url('quiz/'.$quiz->slug.'/show') }}"><img src="{{ asset(config('image.quiz_template_url').$quiz->template->og_image) }}">
                            </a>
                        </div>
                        <div class="caption">
                            <div class="bold"><a href="{{ url('quiz/'.$quiz->slug.'/show') }}">{{$quiz->title}}</a></div>
                        </div>
                    </div>
                @endif
                @if(($quizzes->count() == 1 || ($quizzes->count() == 2 && $key == 1)) || ($quizzes->count() > 2 && $key == 2))
                        </div>
                    </div>
                @endif
                @if($key > 2)
                    <div class="col-md-4 col-sm-6 padd-5">
                        <div class="thumbnail">
                            <div class="content-img">
                                <a href="{{ url('quiz/'.$quiz->slug.'/show') }}"><img src="{{ asset(config('image.quiz_template_url').$quiz->template->og_image) }}">
                                </a>
                            </div>
                            <div class="caption">
                                <div class="bold"><a href="{{ url('quiz/'.$quiz->slug.'/show') }}">{{$quiz->title}}</a></div>
                            </div>
                        </div>
                    </div>
                @endif
            @endforeach
        </div>
        <div class="pagination-links">
            {{$quizzes->links()}}
        </div>
        <div class="row">
            @include('includes.below-quizzes-widgets')
        </div>
    </div>
@endsection
