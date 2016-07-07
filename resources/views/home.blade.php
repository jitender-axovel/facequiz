@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            @include('notification')
        </div>
        <div class="row">
            <div class="col-md-10 col-md-offset-1">
                @foreach($quizzes as $quiz)
                    <div class="col-md-4 col-sm-6">
                        <div class="thumbnail">
                            <a href="{{ url('quiz/'.$quiz->slug.'/show') }}"><img src="{{ asset(config('image.quiz_template_url').$quiz->template->og_image) }}"></a>
                            <div class="caption">
                                <div class="heading"><a href="{{ url('quiz/'.$quiz->slug.'/show') }}">{{$quiz->title}}</a></div>
                                @if($quiz->description != "")
                                    <p>{{$quiz->description}}</p>
                                @endif
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
@endsection
