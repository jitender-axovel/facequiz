@extends('admin.layouts.app')
@section('title', $page)
@section('content')
	<h2>Widgets List</h2>
	<hr>
	@include('notification')
	<div class="row col-md-12">
		<div class="panel panel-success">
			<div class="panel-heading">
				<div class="panel-title">Manage Widgets</div>
			</div>
			<div class="panel-body">
				<div class="row">
					<div class="col-md-6">
						<div class="panel panel-success">
							<div class="panel-heading">
								<div class="panel-title">
									Sidebar
								</div>
							</div>
							<div class="col-md-6"></div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
@endsection