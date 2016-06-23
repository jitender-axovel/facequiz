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
			<form action="{{ url('admin/quiz') }}" method="POST">
				{{csrf_field()}}
                                <div class="form-group">
					<label class="control-label col-md-12">Make quiz visible to users?</label>
					<div class="col-md-12">
                                                <input type="checkbox" class="form-control" name="active" value="true">
					</div>
				</div>
                                <div class="form-group">
					<label class="control-label col-md-12">Category</label>
					<div class="col-md-12">
                                            <select name="category_id" class="form-control" >
                                                        @foreach($categories as $category)
                                                                <option value="{{$category->id}}">{{$category->title}}</option>
                                                        @endforeach
                                                </select>
					</div>
				</div>
				<div class="form-group">
					<label class="control-label col-md-12">Quiz Name</label>
					<div class="col-md-12">
						<input type="text" class="form-control" name="title" value="{{ old('first_name') }}">
						@if($errors->has('title'))
							<span class="help-block">
								<strong>{{ $errors->first('title') }}</strong>
							</span>
						@endif
					</div>
				</div>
				<div class="form-group">
					<label class="control-label col-md-12">Description</label>
					<div class="col-md-12">
						<textarea class="form-control" name="description">{{ old('description') }}</textarea>
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