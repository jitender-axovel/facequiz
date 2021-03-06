@extends('layouts.app')
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
                        <div class="panel-title heading text-center">{{ $quiz->title }}</div>
                    </div>
                    <div class="panel-body">
                        <div class="fb-like-button">
                            @if(!$has_liked_page)
                                <div class="loading-image">
                                    <span class="lead heading">
                                        {{ $languageStrings['Kindly Like us on Facebook'] or 'Kindly Like us on Facebook' }}
                                        <i class="fa fa-arrow-right"></i>
                                        @if(isset($fb_like_button))
                                            {!!$fb_like_button!!}
                                        @else
                                            <div class="fb-like" data-href="https://www.facebook.com/robodoo.en" data-layout="button_count" data-action="like" data-size="small" data-show-faces="true" data-share="false"></div>
                                        @endif
                                    </span>
                                </div>
                            @endif
                            <div class="text-center row caption">
                                <a class="btn btn-success btn-lg" href="{{ url('quiz/'.$quiz->slug.'/start/'.md5(time())) }}"><i class="fa fa-refresh"></i> {{ $languageStrings['Try Again'] or 'Try Again' }}</a>
                                @if($quizzes->count())
                                    <a class="btn btn-warning btn-lg" href="{{ url('quiz/'.$quizzes->first()->slug.'/show') }}"><i class="fa fa-angle-double-right"></i>{{ $languageStrings['Try Next'] or 'Try Next' }}</a>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-12">
                    @if($quizzes->count())
                        @foreach($quizzes as $quizItem)
                            <div class="col-md-4 col-sm-4 col-xs-6 padd-5">
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
                <div class="col-md-12 col-sm-12">
                    @if($sidebarQuizzes->count())
                        @foreach($sidebarQuizzes as $quizItem)
                            <div class="col-md-12 col-sm-6 col-xs-6 padd-5">
                                @include('sections.quiz-item')
                            </div>
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