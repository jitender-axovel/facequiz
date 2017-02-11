@extends('admin.layouts.app')
@section('content')
	<div class="container">
		<div class="row">
			<div class="col-md-12">
				<div class="panel panel-default">
					<div class="panel-body">
						<!-- <div class="col-sm-3">
							<div class="jumbotron"></div>
						</div> -->
						<div class="col-sm-12">
							<dl class="dl-horizontal lead u-view-sec">
								<div class="s-line">
									<dt>Name</dt>
									<dd><blockquote>{{ $user->name }}</blockquote></dd>
								</div>

								<div class="s-line">
									<dt>Email</dt>
									<dd><blockquote>{{ $user->email }}</blockquote></dd>
								</div>

								<div class="s-line">
									<dt>About User</dt>
									<dd><blockquote>{{ $user->about_me }}</blockquote></dd>
								</div>

								<div class="s-line">
									<dt>Credits</dt>
									<dd><blockquote>{{ $user->credits }}</blockquote></dd>
								</div>

								<div class="s-line">
									<dt>Gender</dt>
									<dd><blockquote>{{ $user->gender == 'M' ? 'Male' : 'Female' }}</blockquote></dd>
								</div>
								<div class="s-line">
									<dt>Date of Birth</dt>
									<dd><blockquote>{{ date_format(date_create($user->dob), 'F d, Y') }}</blockquote></dd>
								</div>
								<div class="s-line">
									<dt>Address</dt>
									<dd>
									<blockquote>
										<p>{{$user->address}}</p>
										<p>{{ ($user->city ? $user->city.', ' : '').($user->country ? $user->country : '') }}</p>
									</blockquote>
									</dd>
								</div>
							</dl>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
@endsection