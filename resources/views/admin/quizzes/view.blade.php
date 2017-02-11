@extends('admin.layouts.app')
@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="panel panel-default">
            <div class="panel-heading">
                <div class="panel-title container-fluid">
                    <div class="col-md-11 text-left panel-heading">{{ $quiz->title }}</div>
                    <div class="col-md-1 text-right panel-heading">
                        <a href="{{ url('admin/quiz/'.$quiz->id.'/edit') }}">
                            <i class="fa fa-pencil-square-o fa-2x"></i>
                        </a>
                    </div>
                </div>
            </div>
            <div class="panel-body">
                <div class="col-sm-12">
                    <div class="col-md-3 heading">No. of Images</div>
                    <div class="col-md-9"><blockquote>{{ $quiz->template->total_images }}</blockquote></div>
                    <div class="col-md-3 heading">Has Quiz Title Section</div>
                    <div class="col-md-9"><blockquote>{{ $quiz->template->has_title ? 'Yes' : 'No' }}</blockquote></div>
                </div>
                <div class="v-img-sec">
                    <div class="col-md-6">
                        <div class="heading  bold"><u>Quiz Image</u></div>
                        <div class="text-center">
                            <img src="{{ asset(config('image.quiz_template_url')).'/'.$quiz->template->og_image }}" alt="No Introduction Image">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="heading  bold"><u>Quiz Background Image</u></div>
                        <div class="text-center">
                            <img src="{{ asset(config('image.quiz_background_url')).'/'.$quiz->id.'/'.$quiz->background_image }}" alt="No Background Image">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection