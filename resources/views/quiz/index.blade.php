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
            <div class="col-md-8">
                <div class="panel panel-default">
                    <div class="panel-body text-center">
                        <div class="img-wrap col-md-10">
                            <img src="{{ asset(config('image.quiz_template_url').$quiz->template->og_image) }}">
                        </div>
                        <div class="fb-like-button">
                            @if(isset($fb_like_button))
                                {!!$fb_like_button!!}
                            @else
                                <div class="fb-like" data-href="https://www.facebook.com/robodoo.en" data-layout="button_count" data-action="like" data-size="small" data-show-faces="true" data-share="false"></div>
                            @endif
                        </div>
                        <h3 class="panel-title heading text-center">{{ $quiz->title }}</h3>
                        <p class="quiz-description">{{ $quiz->description }}</p>
                        <div class="caption img-caption">
                            <a class="btn btn-primary start-with-fb" href="{{ url('quiz/'.$quiz->slug.'/start/'.md5(time())) }}"><i class="fa fa-facebook-official"></i> {{ $languageStrings['Continue with Facebook'] or 'Continue with Facebook' }}</a>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        @if($quizzes->count())
                            @foreach($quizzes as $quizItem)
                                <div class="col-md-6 col-sm-6 padd-5">
                                    <div class="thumbnail content-img">
                                        <a href="{{ url('quiz/'.$quizItem->slug.'/show') }}"><img src="{{ asset(config('image.quiz_template_url').$quizItem->template->og_image) }}"></a>
                                        <div class="caption">
                                            <div class="heading"><a href="{{ url('quiz/'.$quizItem->slug.'/show') }}">{{ $quizItem->title }}</a></div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        @else
                            <div class="heading">
                                <span>{{ $languageStrings['There are no more quizzes.'] or 'There are no more quizzes.' }}</span>
                            </div>
                        @endif
                    </div>
                </div>
                <div class="row">
                    @include('includes.after-quiz-widgets')
                </div>
            </div>
            <div class="col-md-4 fb-widget">
                <div class="row">
                    @if(isset($fb_widget))
                        {!!$fb_widget!!}
                    @else
                        <div class="fb-page" data-href="https://www.facebook.com/robodoo.en" data-small-header="false" data-adapt-container-width="true" data-hide-cover="false" data-show-facepile="true"><blockquote cite="https://www.facebook.com/robodoo.en" class="fb-xfbml-parse-ignore"><a href="https://www.facebook.com/robodoo.en">Robodoo</a></blockquote></div>
                    @endif
                </div>
                @include('includes.left-sidebar')
            </div>
        </div>
        <div class="row">
            @include('includes.below-quizzes-widgets')
        </div>
    </div>
@endsection