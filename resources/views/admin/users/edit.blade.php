@extends('admin.layouts.app')
@section('admin-styles')
	<link rel="stylesheet" type="text/css" href="{{ asset('css/bootstrap-datepicker.min.css') }}">
@endsection
@section('content')
	<h2>Edit User Details</h2>
	<hr>
	@include('notification')
	<div class="panel panel-default">
		<div class="panel-heading">
			<p class="bold">Edit {{$user->name}}'s record</p>
		</div>
		<div class="panel-body">
			<form class="form-horizontal" action="{{ url('admin/users/edit/'.$user->id) }}" method="POST">
				{{csrf_field()}}
				<div class="form-group">
					<label class="control-label col-md-2">Name</label>
					<div class="col-md-4{{ ($errors->has('name')) ? ' has-error' : '' }}">
						<input required type="text" class="form-control" name="name" value="{{ $user->name ? $user->name : old('name') }}"></input>
						@if($errors->has('name'))
							<span class="help-block">
								<strong>{{ $errors->first('name') }}</strong>
							</span>
						@endif
					</div>
					<label class="control-label col-md-2">Email</label>
					<div class="col-md-4{{ ($errors->has('email')) ? ' has-error' : '' }}">
						<input required type="email" class="form-control" name="email" value="{{ $user->email ? $user->email : old('email') }}" disabled>
						@if($errors->has('email'))
							<span class="help-block">
								<strong>{{ $errors->first('email') }}</strong>
							</span>
						@endif
					</div>
				</div>
				<div class="form-group">
					<label class="control-label col-md-2">Gender</label>
					<div class="col-sm-4{{ ($errors->has('gender')) ? ' has-error' : '' }}">
						<label class="radio-inline col-sm-5">
							<input type="radio" name="gender" value="M" {{ $user->gender == 'M' ? 'checked' : ''}}>&nbsp;&nbsp;Male
						</label>
						<label class="radio-inline col-sm-5">
							<input type="radio" name="gender" value="F" {{ $user->gender == 'F' ? 'checked' : ''}}>&nbsp;&nbsp;FeMale
						</label>
						@if($errors->has('gender'))
							<span class="help-block">
								<strong>{{ $errors->first('gender') }}</strong>
							</span>
						@endif
					</div>
					<label class="control-label col-md-2">Date of Birth</label>
					<div class="col-md-4{{ ($errors->has('dob')) ? ' has-error' : '' }}">
						<input id="birthday" type="text" class="inputbox datepicker form-col form-control" data-date-format="yyyy-mm-dd" data-provide="datepicker" name="dob" value="{{ $user->dob == '0000-00-00' ? '' : $user->dob }}">
						@if($errors->has('dob'))
							<span class="help-block">
								<strong>{{ $errors->first('dob') }}</strong>
							</span>
						@endif
					</div>
				</div>
				<div class="form-group">
					<div class="col-sm-12">
						<button type="submit" class="btn btn-success btn-block" id="btn-login">Save User</button>
					</div>
				</div>
			</form>
		</div>
	</div>
@endsection
@section('admin-scripts')
	<script type="text/javascript" src="{{ asset('js/datepicker/bootstrap-datepicker.min.js') }}"></script>
@endsection