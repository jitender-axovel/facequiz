@extends('admin.layouts.app')
@section('title', $page)
@section('content')
	<h2>Edit Category</h2>
	<hr>
	@include('notification')
	<div class="panel panel-default">
		<div class="panel-heading">
			<p class="bold">Edit Category</p>
		</div>
		<div class="panel-body">
			<form action="{{ url('admin/category/'.$category->id) }}" method="POST">
				{{csrf_field()}}
				<input type="hidden" name="_method" value="put" />
				<div class="form-group">
					<label class="control-label col-md-12">Category Name</label>
					<div class="col-md-12">
						<input type="text" class="form-control" name="title" value="{{ $category->title ? $category->title : old('first_name') }}">
						@if($errors->has('title'))
							<span class="help-block">
								<strong>{{ $errors->first('title') }}</strong>
							</span>
						@endif
					</div>
					<label class="control-label col-md-12">Support Mail for Category</label>
					<div class="col-md-12">
						<input type="email" class="form-control" name="support_mail" value="{{ $category->support_mail ? $category->support_mail : old('support_mail') }}">
					</div>
				</div>
				<div class="form-group">
					<label class="control-label col-md-12">Category Description</label>
					<div class="col-md-12">
						<textarea class="form-control" name="description">{{ $category->description ? $category->description : old('description') }}</textarea>
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