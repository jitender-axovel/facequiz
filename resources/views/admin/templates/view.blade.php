@extends('admin.layouts.app')
@section('title', $page)
@section('content')
	<div class="row">
		<div class="col-md-12">
			<div class="panel panel-default">
				<div class="panel-heading">
					<div class="panel-title">
						<div class="text-left">{{ $template->name }}</div>
						<div class="text-right"><i class="fa fa-pencil-square-o"></i></div>
					</div>
				</div>
				<div class="panel-body">
					<div class="col-sm-12">
						<div class="col-md-3 heading">Name</div>
						<div class="col-md-9"><blockquote>{{ $template->name }}</blockquote></div>
						<div class="col-md-3 heading">Category</div>
						<div class="col-md-9"><blockquote>{{ $template->category->title }}</blockquote></div>
						<div class="col-md-3 heading">No. of Images</div>
						<div class="col-md-9"><blockquote>{{ $template->total_images }}</blockquote></div>
					</div>
					<div class="row">
						<div class="heading text-center bold"><u>Layout</u></div>
						<div class="">
							<img src="{{ asset('images').'/'.$template->og_image }}">
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
@endsection