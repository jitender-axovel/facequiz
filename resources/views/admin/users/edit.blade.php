@extends('admin.layouts.app')
@section('title', $page)
@section('admin-styles')
	<link rel="stylesheet" type="text/css" href="{{ asset('css/bootstrap-datepicker.min.css') }}">
@endsection
@section('content')
	<h2>Edit User Details</h2>
	<hr>
	@include('notification')
	<div class="panel panel-default">
		<div class="panel-heading">
			<p class="bold">Edit {{$user->first_name.' '.$user->last_name}}'s record</p>
		</div>
		<div class="panel-body">
			<form action="{{ url('admin/users/edit/'.$user->id) }}" method="POST">
				{{csrf_field()}}
				<div class="form-group">
					<label class="control-label col-md-12">First Name</label>
					<div class="col-md-12">
						<input type="text" class="form-control" name="first_name" value="{{ $user->first_name ? $user->first_name : old('first_name') }}"></input>
						@if($errors->has('first_name'))
							<span class="help-block">
								<strong>{{ $errors->first('first_name') }}</strong>
							</span>
						@endif
					</div>
					<label class="control-label col-md-12">Last Name</label>
					<div class="col-md-12">
						<input type="text" class="form-control" name="last_name" value="{{ $user->last_name ? $user->last_name : old('last_name') }}"></input>
						@if($errors->has('last_name'))
							<span class="help-block">
								<strong>{{ $errors->first('last_name') }}</strong>
							</span>
						@endif
					</div>
				</div>
				<div class="form-group">
					<label class="control-label col-md-12">Email</label>
					<div class="col-md-12">
						<input type="email" class="form-control" name="email" value="{{ $user->email ? $user->email : old('email') }}" />
						@if($errors->has('email'))
							<span class="help-block">
								<strong>{{ $errors->first('email') }}</strong>
							</span>
						@endif
					</div>
					<label class="control-label col-md-12">Gender</label>
					<div class="col-sm-12">
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
				</div>
				<div class="form-group">
					<label class="control-label col-md-12">Date of Birth</label>
					<div class="col-md-12">
						<input id="birthday" type="text" class="inputbox datepicker form-col form-control" data-date-format="yyyy-mm-dd" data-provide="datepicker" name="dob" value="{{ $user->dob == '0000-00-00' ? '' : $user->dob }}">
						@if($errors->has('dob'))
							<span class="help-block">
								<strong>{{ $errors->first('dob') }}</strong>
							</span>
						@endif
					</div>
					<label class="control-label col-md-12">Address</label>
					<div class="col-md-12">
						<textarea name="address" class="form-control">{{ $user->address ? $user->address : '' }}</textarea>
						@if($errors->has('address'))
							<span class="help-block">
								<strong>{{ $errors->first('address') }}</strong>
							</span>
						@endif
					</div>
				</div>
				<div class="form-group">
					<label class="control-label col-md-12">City</label>
					<div class="col-md-12">
						<input type="text" class="form-control" name="city" value="{{ $user->city ? $user->city : '' }}">
						@if($errors->has('city'))
							<span class="help-block">
								<strong>{{ $errors->first('city') }}</strong>
							</span>
						@endif
					</div>
					<label class="control-label col-md-12">Country</label>
					<div class="col-md-12">
						<input type="text" class="form-control" name="country" value="{{ $user->country ? $user->country : '' }}">
						@if($errors->has('country'))
							<span class="help-block">
								<strong>{{ $errors->first('country') }}</strong>
							</span>
						@endif
					</div>
				</div>
				<div class="form-group">
					<label class="control-label col-md-12">About Me</label>
					<div class="col-md-12">
						<textarea class="form-control" name="about_me">{{ $user->about_me ? $user->about_me : ''}}</textarea>
					</div>
				</div>
				<div class="form-group">
					<div class="col-sm-12">
						<button type="submit" class="btn btn-default btn-lg btn-block" id="btn-login">Save User</button>
					</div>
				</div>
			</form>
		</div>
	</div>
@endsection
@section('admin-scripts')
	<script type="text/javascript" src="{{ asset('js/datepicker/bootstrap-datepicker.min.js') }}"></script>
@endsection