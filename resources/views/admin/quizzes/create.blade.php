@extends('admin.layouts.app')
@section('title', $page)
@section('content')
<h2>Add New Quiz</h2>
<hr>
@include('notification')
<div class="panel panel-default">
	<div class="panel-heading">
		<p class="bold">Create New Quiz</p>
	</div>
	<div class="panel-body">
		<form action="{{ url('admin/quiz') }}" method="POST" class="form-horizontal">
			{{csrf_field()}}
			<div class="checkbox-inline col-sm-12">
				<label class="col-md-12">
					<span class="col-sm-3">Make quiz visible to users? </span><span class="col-sm-2"><input type="checkbox" name="active" value="true"></span>
				</label>
			</div>
			<div class="form-group">
				<label class="control-label col-sm-2">Quiz Name</label>
				<div class="col-sm-10">
					<input type="text" class="form-control" name="title" value="{{ old('title') }}" placeholder="Enter Quiz Title">
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
					<textarea class="form-control" name="description">{{ old('description') }}</textarea>
				</div>
			</div>
			<div class="form-group">
				<label class="control-label col-sm-2">Category</label>
				<div class="col-sm-10">
					<select name="category_id" id="category-selector" class="form-control" >
						<option selected>Select Category</option>
						@foreach($categories as $category)
							<option value="{{$category->id}}">{{$category->title}}</option>
						@endforeach
					</select>
				</div>
			</div>
			<div class="form-group">
				<label class="control-label col-sm-2">Sub-Category</label>
				<div class="col-sm-10">
					<select name="sub_category_id" class="form-control" id="sub-category-selector">
						<option selected>Select Sub-Category</option>
						@foreach($subCategories as $subCategory)
							<option value="{{$subCategory->id}}">{{$subCategory->title}}</option>
						@endforeach
					</select>
				</div>
			</div>
			<div class="form-group">
				<label class="control-label col-sm-2">Choose Template</label>
				<div class="col-sm-10">
					<select name="quiz_template_id" class="form-control">
						<option selected>Select Template</option>
						@foreach($templates as $template)
							<option value="{{$template->id}}">{{$template->name}}</option>
						@endforeach
					</select>
				</div>
			</div>
			<div class="form-group">
				<div class="col-md-12">
					<button type="submit" class="btn btn-default btn-lg btn-block" id="btn-login">Create Quiz</button>
				</div>
			</div>
		</form>
	</div>
</div>
@endsection
@section('admin-scripts')
	<script type="text/javascript">
		$(document).ready(function() {
			$('#sub-category-selector').attr('disabled', 'disabled');
			$('#category-selector').change(function() {
            	$.ajax({
            		url: "{{url('get-subcategories?ci=')}}" + $(this).val(),
            		type: "GET",
            		success: function(data) {
            			data = JSON.parse(data);
            			$("#sub-category-selector option").remove();
            			$("#sub-category-selector").append('<option selected>SubCategory (optional)</option>')
            			$.each(data, function(){
					        $("#sub-category-selector").append('<option value="'+ this.id +'">'+ this.title +'</option>')
					    });
					    $('#sub-category-selector').removeAttr('disabled');
            		}
            	});
            });
		});
	</script>
@endsection