@extends('admin.layouts.app')
@section('title', $page)
@section('content')
	<div class="container">
		<div class="row">
			<div class="col-md-12">
				<div class="panel panel-default">
					<div class="panel-body">
						<div class="col-sm-3">
							<div class="jumbotron"></div>
						</div>
						<div class="col-sm-9">
							<dl class="dl-horizontal lead">
								<dt>Name</dt>
								<dd><blockquote>{{ $user->first_name.' '.$user->last_name }}</blockquote></dd>
								<dt>Email</dt>
								<dd><blockquote>{{ $user->email }}</blockquote></dd>
								<dt>About User</dt>
								<dd><blockquote>{{ $user->about_me }}</blockquote></dd>
								<dt>Credits</dt>
								<dd><blockquote>{{ $user->credits }}</blockquote></dd>
								<dt>Gender</dt>
								<dd><blockquote>{{ $user->gender == 'M' ? 'Male' : 'Female' }}</blockquote></dd>
								<dt>Date of Birth</dt>
								<dd><blockquote>{{ date_format(date_create($user->dob), 'F d, Y') }}</blockquote></dd>
								<dt>Address</dt>
								<dd>
									<blockquote>
										<p>{{$user->address}}</p>
										<p>{{ ($user->city ? $user->city.', ' : '').($user->country ? $user->country : '') }}</p>
									</blockquote>
								</dd>
							</dl>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
@endsection