@extends('admin.layouts.app')
@section('title', $page)
@section('content')
	<h2>Add New Category</h2>
	<hr>
	@include('notification')
	<div class="panel panel-default">
		<div class="panel-heading">
			<p class="bold">Create New Category</p>
		</div>
		<div class="panel-body">
			<form action="{{ url('admin/category') }}" method="POST">
				{{csrf_field()}}
				<div class="form-group">
					<label class="control-label col-md-12">Category Name</label>
					<div class="col-md-12">
						<input type="text" class="form-control" name="title" value="{{ old('first_name') }}">
						@if($errors->has('title'))
							<span class="help-block">
								<strong>{{ $errors->first('title') }}</strong>
							</span>
						@endif
					</div>
					<label class="control-label col-md-12">Confirm Name</label>
					<div class="col-md-12">
						<input type="text" class="form-control" name="confirm_title" value="">
						@if($errors->has('confirm_title'))
							<span class="help-block">
								<strong>{{ $errors->first('confirm_title') }}</strong>
							</span>
						@endif
					</div>
				</div>
				<div class="form-group">
					<label class="control-label col-md-12">Category Description</label>
					<div class="col-md-12">
						<textarea class="form-control" name="description">{{ old('description') }}</textarea>
					</div>
				</div>
				<div class="form-group">
					<div class="col-md-12">
						<button type="submit" class="btn btn-default btn-lg btn-block" id="btn-login">Create Category</button>
					</div>
				</div>
			</form>
		</div>
	</div>
@endsection