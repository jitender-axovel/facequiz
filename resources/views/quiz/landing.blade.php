@extends('layouts.app')
@section('og_title', $quiz->title)
@section('og_description', $quiz->description)
@section('og_author', $quizAttempt->user->name)
@section('og_image', asset(config('image.quiz_result_url').$quizAttempt->result_image))
@section('content')
    <div class="container main-content">
        <div class="row advertise-block">
            @include('includes.above-quizzes-widgets')
        </div>
        <div class="row">
            @include('notification')
        </div>
        <div class="row">
            <div class="col-md-9">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h3 class="panel-title heading text-center">{{ $quiz->title }}</h3>
                    </div>
                    <div class="panel-body">
                        <div class="img-wrap col-md-10">
                            <img src="{{ asset(config('image.quiz_template_url').$quiz->template->og_image) }}">
                        </div>
                        <div class="caption img-caption">
                            <a class="btn btn-primary btn-block" href="{{ url('quiz/'.$quiz->slug.'/start/'.md5(time())) }}">{{ $languageStrings['Start'] or 'Start' }}</a>
                        </div>
                        <span>{{ $languageStrings['You will be required to login with Facebook.'] or 'You will be required to login with Facebook.' }}</span>
                    </div>
                    <div class="panel-footer">
                        {{$quiz->description}}
                    </div>
                </div>
                <div class="col-md-12">
                    @if($quizzes->count())
                        @foreach($quizzes as $quizItem)
                            <div class="col-md-4 col-sm-6 col-xs-12 padd-5">
                                @include('sections.quiz-item')
                            </div>
                        @endforeach
                    @else
                        <div class="heading">
                            <span>{{ $languageStrings['There are no more quizzes.'] or 'There are no more quizzes.' }}</span>
                        </div>
                    @endif
                </div>
                <div class="col-md-12">
                    @include('includes.after-quiz-widgets')
                </div>
            </div>
            <div class="col-md-3 fb-widget">
                <div class="col-md-12">
                    @if(isset($fb_widget))
                        {!!$fb_widget!!}
                    @else
                        <div class="fb-page" data-href="https://www.facebook.com/robodoo.en" data-small-header="false" data-adapt-container-width="true" data-hide-cover="false" data-show-facepile="true"><blockquote cite="https://www.facebook.com/robodoo.en" class="fb-xfbml-parse-ignore"><a href="https://www.facebook.com/robodoo.en">Robodoo</a></blockquote></div>
                    @endif
                </div>
                @include('includes.left-sidebar')
                <div class="col-md-12">
                    @if($sidebarQuizzes->count())
                        @foreach($sidebarQuizzes as $quizItem)
                            @include('sections.quiz-item')
                        @endforeach
                    @endif
                </div>
            </div>
        </div>
        <div class="row">
            @include('includes.below-quizzes-widgets')
        </div>
    </div>
@endsection