@extends('admin.layouts.app')
@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="panel panel-default">
            <div class="panel-heading">
                <div class="panel-title">
                    <p>{{ $quiz->title }}</p>
                    <p class="text-right">
                        <a href="{{ url('admin/quiz/'.$quiz->id.'/edit') }}">
                            <i class="fa fa-pencil-square-o fa-2x"></i>
                        </a>
                    </p>
                </div>
            </div>
            <div class="panel-body">
                <div class="col-sm-12">
                    <div class="col-md-3 heading">No. of Images</div>
                    <div class="col-md-9"><blockquote>{{ $quiz->template->total_images }}</blockquote></div>
                    <div class="col-md-3 heading">Has Quiz Title Section</div>
                    <div class="col-md-9"><blockquote>{{ $quiz->template->has_title ? 'Yes' : 'No' }}</blockquote></div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="heading text-center bold"><u>Quiz Image</u></div>
                        <div class="">
                            <img src="{{ asset(config('image.quiz_template_url')).'/'.$quiz->template->og_image }}">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="heading text-center bold"><u>Quiz Background Image</u></div>
                        <div class="">
                            <img src="{{ asset(config('image.quiz_background_url')).'/'.$quiz->id.'/'.$quiz->background_image }}">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection