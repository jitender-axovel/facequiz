@extends('admin.layouts.app')
@section('title', $page)
@section('content')
	<div class="row">
		<div class="col-md-12">
			<div class="panel panel-default">
				<div class="panel-heading">
					<div class="panel-title">
						<div>
                                                    <p class="text-left">{{ $template->name }}</p>
                                                    <p class="text-right">
                                                        <a href="{{ url('admin/layout/'.$template->id.'/edit') }}">
                                                            <i class="fa fa-pencil-square-o fa-2x"></i>
                                                        </a>
                                                    </p>
                                                </div>
					</div>
				</div>
				<div class="panel-body">
					<div class="col-sm-12">
						<div class="col-md-3 heading">Name</div>
						<div class="col-md-9"><blockquote>{{ $template->name }}</blockquote></div>
						<div class="col-md-3 heading">No. of Images</div>
						<div class="col-md-9"><blockquote>{{ $template->total_images }}</blockquote></div>
                                                <div class="col-md-3 heading">Has Quiz Title Section</div>
						<div class="col-md-9"><blockquote>{{ $template->has_title ? 'Yes' : 'No' }}</blockquote></div>
					</div>
					<div class="row">
						<div class="heading text-center bold"><u>Template Image</u></div>
						<div class="">
							<img src="{{ asset(config('image.quiz_template_url')).'/'.$template->og_image }}">
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
@endsection