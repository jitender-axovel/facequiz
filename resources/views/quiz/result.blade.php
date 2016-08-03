@extends('layouts.app')
@section('title', $page)
@section('og_url', url('quiz/'.$quiz->slug.'/landing/'.Auth::id()))
@section('og_title', $quiz->title)
@section('og_description', $quiz->description)
@section('og_author', Auth::user()->name)
@section('og_image', asset(config('image.quiz_result_url').$result->result_image))
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
                    <div class="col-md-10 col-md-offset-1">
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <div class="panel-title">{{ $quiz->title }}</div>
                            </div>
                            <div class="panel-body">
                                <div class="thumbnail">
                                    <img class="media-object" src="{{asset(config('image.quiz_result_url').$result->result_image)}}">
                                    <div class="caption">
                                        <a id="shareBtn" class="btn btn-primary btn-block"><i class="fa fa-facebook-official"></i> Share</a>
                                    </div>
                                </div>
                            </div>
                            <div class="panel-footer">
                                {{$quiz->description}}
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-10 col-md-offset-1">
                        @if($quizzes->count())
                            @foreach($quizzes as $quizItem)
                                <div class="col-md-4 col-sm-6">
                                    <div class="thumbnail">
                                        <a href="{{ url('quiz/'.$quizItem->slug) }}"><img src="{{ asset(config('image.quiz_template_url').$quizItem->template->og_image) }}"></a>
                                        <div class="caption">
                                            <div class="heading"><a href="{{ url('quiz/'.$quizItem->slug) }}">{{$quizItem->title}}</a></div>
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
@section('scripts')
    <script>
        document.getElementById('shareBtn').onclick = function() {
            FB.ui({
                method: 'share',
                display: 'popup',
                href: '{{ url("quiz/".$quiz->slug."/landing/".Auth::id()) }}',
            }, function(response){});
        }
    </script>
@endsection