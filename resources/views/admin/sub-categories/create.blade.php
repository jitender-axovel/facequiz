@extends('admin.layouts.app')
@section('title', $page)
@section('content')
	<h2>Add New Category</h2>
	<hr>
	@include('notification')
	<div class="panel panel-default">
		<div class="panel-heading">
			<p class="bold">Create New Sub-Category</p>
		</div>
		<div class="panel-body">
			<form action="{{ url('admin/sub-category') }}" method="POST" class="form-horizontal">
				{{csrf_field()}}
				<div class="form-group">
					<label class="control-label col-sm-2">Parent Category</label>
					<div class="col-md-10">
						<select class="form-control" name="category_id">
							@foreach($categories as $category)
								<option value="{{ $category->id }}">{{ $category->title }}</option>
							@endforeach
						</select>
					</div>
				</div>
				<div class="form-group">
					<label class="control-label col-sm-2">Sub-Category Name</label>
					<div class="col-md-10">
						<input type="text" class="form-control" name="title" value="{{ old('title') }}">
						@if($errors->has('title'))
							<span class="help-block">
								<strong>{{ $errors->first('title') }}</strong>
							</span>
						@endif
					</div>
				</div>
				<div class="form-group">
					<label class="control-label col-sm-2">Confirm Name</label>
					<div class="col-md-10">
						<input type="text" class="form-control" name="confirm_title" value="{{ old('confirm_title') }}">
						@if($errors->has('confirm_title'))
							<span class="help-block">
								<strong>{{ $errors->first('confirm_title') }}</strong>
							</span>
						@endif
					</div>
				</div>
				<div class="form-group">
					<label class="control-label col-sm-2">Description</label>
					<div class="col-md-10">
						<textarea type="text" class="form-control" name="description" value="{{ old('description') }}"></textarea>
					</div>
				</div>
				<div class="form-group">
					<div class="col-sm-12">
						<button type="submit" class="btn btn-lg btn-block" id="btn-login">Create Category</button>
					</div>
				</div>
			</form>
		</div>
	</div>
@endsection