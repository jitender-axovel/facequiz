@extends('admin.layouts.app')
@section('title', $page)
@section('admin-styles')
	<link rel="stylesheet" type="text/css" href="{{ asset('css/bootstrap-datepicker.min.css') }}">
@endsection
@section('content')
	<h2>Edit {{$cmsPage->title}} Content</h2>
	<hr>
	@include('notification')
	<div class="panel panel-default">
		<div class="panel-heading">
			<p class="bold">{{$cmsPage->title}}</p>
		</div>
		<div class="panel-body">
			<form action="{{ url('admin/cms/'.$cmsPage->id) }}" method="POST" class="form-horizontal">
				{{csrf_field()}}
				<input type="hidden" name="_method" value="PUT"></input>
				
				<div class="form-group">
					<label class="col-md-12">Edit Content</label>
					<div class="col-md-12">
						<textarea class="form-control" rows="15" name="content">{{ $cmsPage->content ? $cmsPage->content : ''}}</textarea>
					</div>
				</div>
				<div class="form-group">
					<div class="col-sm-12">
						<button type="submit" class="btn btn-success btn-lg btn-block" id="btn-login">Save</button>
					</div>
				</div>
			</form>
		</div>
	</div>
@endsection
@section('admin-head-script')
	<script src="{{ asset('js/tinymce/tinymce.min.js') }}"></script>
    <script src="{{ asset('js/tinymce/jquery.tinymce.min.js') }}"></script>
    <script type="text/javascript">
        	tinymce.init({
	            selector: 'textarea',
	            menu: {
					view: {title: 'Enter Code', items: 'code'}
				},
				plugins: 'code'
	        });
    </script>
@endsection