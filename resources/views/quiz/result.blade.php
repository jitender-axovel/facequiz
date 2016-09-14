@extends('layouts.app')
@section('og_url', url('quiz/'.$quiz->slug.'/landing/'.Auth::id().'/'.$version))
@section('og_title', $quiz->title)
@section('og_description', $quiz->description)
@section('og_author', Auth::user()->name)
@section('og_image', asset(config('image.quiz_result_url').$result->result_image))
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
                <div class="row">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <div class="panel-title heading text-center">{{ $quiz->title }}</div>
                        </div>
                        <div class="panel-body">
                            <div class="result-img col-md-10">
                                <div class="loading-image text-center">
                                    <img src="{{asset('images/loading.gif')}}">
                                    <span class="lead heading">&nbsp;{{ $languageStrings['Loading Results'] or 'Loading Results' }}</span>
                                </div>
                                <img class="media-object result-image" src="{{asset(config('image.quiz_result_url').$result->result_image)}}">
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
                            <div class="quiz-options">
                                <div class="col-md-3">
                                    <a id="shareBtn" class="share-facebook" title="{{ $languageStrings['Share on Facebook'] or 'Share on Facebook' }}"><i class="fa fa-facebook-official"></i> {{ $languageStrings['Share'] or 'Share' }}</a>
                                </div>
                                <div class="col-md-3">
                                    <a id="sendBtn" class="share-facebook" title="{{ $languageStrings['Send Private Message'] or 'Send Private Message' }}"><i class="fa fa-facebook-official"></i> {{ $languageStrings['Send'] or 'Send' }}</a>
                                </div>
                                <div class="col-md-3">
                                    <a id="copyBtn" class="share-facebook" title="{{ $languageStrings['Copy Link'] or 'Copy Link' }}"><i class="fa fa-link"></i> {{ $languageStrings['Copy Link'] or 'Copy Link' }}</a>
                                </div>
                                <div class="col-md-3">
                                    <a class="btn btn-warning" href="{{ url('quiz/'.$quiz->slug.'/start/'.md5(time())) }}" title="{{ $languageStrings['Try Again'] or 'Try Again' }}"><i class="fa fa-refresh fa-3x"></i> {{ $languageStrings['Retry'] or 'Retry' }}</a>
                                </div>
                            </div>
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
                                            <div class="heading"><a href="{{ url('quiz/'.$quizItem->slug.'/show') }}">{{$quizItem->title}}</a></div>
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
                <div class="row">
                    @if($sidebarQuizzes->count())
                        @foreach($sidebarQuizzes as $quizItem)
                            <div class="thumbnail content-img">
                                <a href="{{ url('quiz/'.$quizItem->slug.'/show') }}"><img src="{{ asset(config('image.quiz_template_url').$quizItem->template->og_image) }}"></a>
                                <div class="caption">
                                    <div class="heading"><a href="{{ url('quiz/'.$quizItem->slug.'/show') }}">{{ $quizItem->title }}</a></div>
                                </div>
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
                href: '{{ url("quiz/".$quiz->slug."/landing/".Auth::id())."/".md5(time()) }}',
            }, function(response){
                // if (typeof response !== 'undefined') {
                    /** the user shared the content on their Facebook, go ahead and continue to download **/
                    window.location="{{ url('quiz/'.$quiz->slug.'/summary') }}";
                // } else {
                //     * the cancelled the share process, do something, for example *
                    
                // }
            });
        }

        document.getElementById('sendBtn').onclick = function() {
            FB.ui({
              method: 'send',
              display: 'popup',
              // href: '{{ url("quiz/".$quiz->slug."/landing/".Auth::id())."/".md5(time()) }}',
              link: '{{ url("quiz/".$quiz->slug."/landing/".Auth::id())."/".md5(time()) }}',
            });
        }

        document.getElementById('copyBtn').onclick = function() {
            prompt('Copy this link', '{{ url("quiz/".$quiz->slug."/landing/".Auth::id())."/".md5(time()) }}');
        }

        $(document).ready(function() {
            $('.result-image').hide();
            $('.quiz-options').hide();
            $('.loading-image').show();

            setTimeout(function(){
                $('.loading-image').hide();
                $('.result-image').show();
                $('.quiz-options').show();
            },4000);
        });
    </script>
@endsection
