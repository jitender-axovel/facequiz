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
                <div class="row">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <h3 class="panel-title heading text-center">{{ $quiz->title }}</h3>
                        </div>
                        <div class="panel-body">
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
                            <div class="caption img-caption">
                                <a class="btn btn-primary btn-block" href="{{ url('quiz/'.$quiz->slug.'/start') }}">Start</a>
                            </div>
                            <span>You will be required to login with Facebook.</span>
                        </div>
                        <div class="panel-footer">
                            {{$quiz->description}}
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        @if($quizzes->count())
                            @foreach($quizzes as $quizItem)
                                <div class="col-md-6 col-sm-6">
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
            <div class="col-md-4 fb-widget">
                <div class="row">
                    @if(isset($fb_widget))
                        {!!$fb_like_button!!}
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