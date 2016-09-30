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
                    <div class="panel-body text-center">
                        <div class="img-wrap col-md-10">
                            <img src="{{ asset(config('image.quiz_template_url').$quiz->template->og_image) }}">
                        </div>
                        @if(!$has_liked_page)
                            <div class="fb-like-button">
                                @if(isset($fb_like_button))
                                    {!!$fb_like_button!!}
                                @else
                                    <div class="fb-like" data-href="https://www.facebook.com/robodoo.en" data-layout="button_count" data-action="like" data-size="small" data-show-faces="true" data-share="false"></div>
                                @endif
                            </div>
                        @endif
                        <h3 class="panel-title heading text-center">{{ $quiz->title }}</h3>
                        <p class="quiz-description">{{ $quiz->description }}</p>
                        <div class="caption img-caption">
                            <a class="btn btn-primary start-with-fb" href="{{ url('quiz/'.$quiz->slug.'/start/'.md5(time())) }}"><i class="fa fa-facebook-official"></i> {{ $languageStrings['Continue with Facebook'] or 'Continue with Facebook' }}</a>
                        </div>
                        <div class="quiz-options">
                            <div class="col-md-4 col-sm-4 col-xs-4">
                                <a id="shareBtn" class="share-facebook" title="{{ $languageStrings['Share on Facebook'] or 'Share on Facebook' }}"><i class="fa fa-facebook-official"></i> {{ $languageStrings['Share'] or 'Share' }}</a>
                            </div>
                            <div class="col-md-4 col-sm-4 col-xs-4 send-button">
                                <a id="sendBtn" class="share-facebook" title="{{ $languageStrings['Send Private Message'] or 'Send Private Message' }}"><img src="{{ asset('images/facebook-messanger.png') }}" class="responsive"> {{ $languageStrings['Send'] or 'Send' }}</a>
                            </div>
                            <div class="col-md-4 col-sm-4 col-xs-4">
                                <a id="copyBtn" class="share-facebook" title="{{ $languageStrings['Copy Link'] or 'Copy Link' }}"><i class="fa fa-link"></i> {{ $languageStrings['Copy Link'] or 'Copy Link' }}</a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-12">
                    @if($quizzes->count())
                        @foreach($quizzes as $quizItem)
                            <div class="col-md-4 col-sm-6 col-xs-6 padd-5">
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
                            <div class="col-md-12 col-sm-4 col-xs-6 padd-5">
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
@section('scripts')
    <script>
        document.getElementById('shareBtn').onclick = function() {
            FB.ui({
                method: 'share',
                display: 'popup',
                href: '{{ url("quiz/".$quiz->slug."/show") }}',
            }, function(response){});
        }

        document.getElementById('sendBtn').onclick = function() {
            FB.ui({
              method: 'send',
              display: 'popup',
              // href: '{{ url("quiz/".$quiz->slug."/landing/".Auth::id())."/".md5(time()) }}',
              link: '{{ url("quiz/".$quiz->slug."/show") }}',
            });
        }

        document.getElementById('copyBtn').onclick = function() {
            prompt('Copy this link', '{{ url("quiz/".$quiz->slug."/landing/".Auth::id())."/".md5(time()) }}');
        }
    </script>
@endsection