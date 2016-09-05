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
                    <div class="col-md-8">
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
                @elseif($key > 0 && $key < 3)
                    <div class="col-md-4">
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
                @else
                    <div class="col-md-4 col-sm-6">
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
