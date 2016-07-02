@extends('admin.layouts.app')
@section('title', $page)
@section('content')
	<div class="container">
		<div class="row">
			<div class="col-md-12">
				@include('notification')
				<div class="panel panel-default">
					<div class="panel-heading">
						<p class="bold">Create New Sub-Category</p>
					</div>
					<div class="panel-body">
						<form class="form-horizontal" action="{{ url('admin/sub-category/'.$subCategory->id) }}" method="POST">
							{{csrf_field()}}
							<input type="hidden" name="_method" value="put" />
							<div class="form-group">
								<label class="control-label col-sm-2">Parent Category</label>
								<div class="col-sm-10">
									<select class="form-control" name="project_category_id">
										@foreach($categories as $category)
											<option value="{{ $category->id }}" {{ ($category->id == $subCategory->project_category_id) ? 'selected' : '' }}>{{ $category->title }}</option>
										@endforeach
									</select>
								</div>
							</div>
							<div class="form-group">
								<label class="control-label col-sm-2">Sub-Category Name</label>
								<div class="col-sm-10">
									<input type="text" class="form-control" name="title" value="{{ $subCategory->title ? $subCategory->title : old('title') }}">
									@if($errors->has('title'))
										<span class="help-block">
											<strong>{{ $errors->first('title') }}</strong>
										</span>
									@endif
								</div>
							</div>
							<div class="form-group">
								<label class="control-label col-sm-2">Description (Optional)</label>
								<div class="col-sm-10">
									<textarea type="text" class="form-control" name="description">{{ $subCategory->description ? $subCategory->description : old('description') }}</textarea>
									@if($errors->has('description'))
										<span class="help-block">
											<strong>{{ $errors->first('description') }}</strong>
										</span>
									@endif
								</div>
							</div>
							<div class="form-group">
								<div class="col-sm-12">
									<button type="submit" class="btn btn-lg btn-block">Create Category</button>
								</div>
							</div>
						</form>
					</div>
				</div>
			</div>
		</div>
	</div>
@endsection