@extends('admin.layouts.app')
@section('title', $page)
@section('content')
	<h2>Widgets List</h2>
	<hr>
	@include('notification')
	<div class="row col-md-12">
		<div class="panel panel-success">
			<div class="panel-heading">
				<div class="panel-title">Manage Widgets</div>
			</div>
			<div class="panel-body">
				@foreach($widgets as $widget)
					<div class="row">
						<div class="col-md-6">
							<div class="panel panel-success">
								<div class="panel-heading">
									<div class="panel-title">
										{{ $widget->name }}
									</div>
								</div>
								<div class="col-md-6">
									<h3>Preview Image</h3>
									<img src="{{ asset(config('image.widget_image_url').$widget->preview_image) }}">
								</div>
							</div>
						</div>
					</div>
				@endforeach
			</div>
		</div>
	</div>
@endsection