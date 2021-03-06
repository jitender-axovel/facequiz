@extends('admin.layouts.app')
@section('content')
<div class="row">
	<h2 class="user-heading">Users List</h2>
	<hr>
	@include('notification')
	<div class="row col-md-12">
		<div class="panel panel-success cust-user-lst">
			<div class="panel-heading">
				<div class="panel-title">Download Records</div>
			</div>
			<div class="panel-body">
				<h2 class="panel-heading">Choose data to show in csv</h2>
				<form class="form" action="{{ url('admin/users/download-csv') }}" method="POST">
					{{csrf_field()}}
					<div class="form-group form-inline col-md-2">
						<label class="control-label">Name</label>
							<input type="checkbox" class="form-control" name="name" value="name">
					</div>
					<div class="form-group form-inline col-md-2">
						<label>E-mail</label>
						<input type="checkbox" class="form-control" name="email" value="email">
					</div>
					<div class="form-group form-inline col-md-2">
						<label>Gender</label>
						<input type="checkbox" class="form-control" name="gender" value="gender">
					</div>
					<div class="form-group form-inline col-md-6 custom">
						<label class="">Limit</label>
						<input type="number" class="form-control " name="limit" value="{{old('limit')}}">
						<button class="btn btn-success" type="submit">Download</button>
					</div>
					
				</form>
			</div>
		</div>
	</div>
	<table id="users_list" class="display">
		<thead>
			<tr>
				<th>Name</th>
				<th>Email</th>
				<th>Role</th>
				<th>Gender</th>
				<th>Joined On</th>
				<th>Actions</th>
			</tr>
		</thead>
		<tbody>
			@foreach($users as $user)
			<tr>
				<td>{{ $user->name}}</td>
				<td>{{ $user->email }}</td>
				<td>{{ $user->role->name }}</td>
				<td>{{ $user->gender }}</td>
				<td>{{ date_format(date_create($user->created_at), 'F d, Y') }}</td>
				<td>
					<a class="btn btn-info" href="{{ url('admin/users/edit/'.$user->id) }}" title="Edit"><i class="fa fa-pencil"></i></a>
					<a class="btn btn-primary" href="{{ url('admin/users/view/'.$user->id) }}" title="View Info"><i class="fa fa-eye"></i></a>
					@if(!$user->isAdmin()) 
						@if($user->is_blocked == 0)
							<a class="btn btn-warning" onclick="blockUser('{{$user->id}}', '{{$user->name}}')" title="Block"><i class="fa fa-ban"></i></a>
						@else
							<a class="btn btn-success" onclick="unBlockUser('{{$user->id}}', '{{$user->name}}')" title="UnBlock"><i class="fa fa-unlock"></i></a>
						@endif
					@endif
				</td>
			</tr>
			@endforeach
		</tbody>
	</table>
	</div>
	<script type="text/javascript">
		$(document).ready( function () {
		    $('#users_list').DataTable();
		} );
	</script>
@endsection
@section('admin-scripts')
	<script type="text/javascript">
		function deleteUser(id, name)
		{
			swal({
				title: "Are you sure?",
				text: "You want to delete "+name,
				type: "warning",
				showCancelButton: true,
				confirmButtonColor: "#DD6B55",
				confirmButtonText: "Yes, delete it!",
				cancelButtonText: "No, cancel pls!",
				closeOnConfirm: false,
				closeOnCancel: false,
				allowEscapeKey: false,
			},
			function(isConfirm){
				if(isConfirm) {
					$.ajax({
						url: "{{ url('admin/users/delete') }}" + '/' + id,
						type: 'DELETE',
						success: function(data) {
							data = JSON.parse(data);
							if(data['status']) {
								swal({
									title: data['message'],
									text: "Press ok to continue",
									type: "success",
									showCancelButton: false,
									confirmButtonColor: "#DD6B55",
									confirmButtonText: "Ok",
									closeOnConfirm: false,
									allowEscapeKey: false,
								},
								function(isConfirm){
									if(isConfirm) {
										window.location.reload();
									}
								});
							} else {
								swal("Error", data['message'], "error");
							}
						}
					});
				} else {
					swal("Cancelled", name+"'s record will not be deleted.", "error");
				}
			});
		}

		function blockUser(id, name)
		{
			swal({
				title: "Are you sure?",
				text: "You want to block "+name,
				type: "warning",
				showCancelButton: true,
				confirmButtonColor: "#DD6B55",
				confirmButtonText: "Yes, block "+name+"!",
				cancelButtonText: "No, cancel pls!",
				closeOnConfirm: false,
				closeOnCancel: false,
				allowEscapeKey: false,
			},
			function(isConfirm){
				if(isConfirm) {
					$.ajax({
						url: "{{ url('admin/users/block') }}" + '/' + id,
						type: 'POST',
						success: function(data) {
							data = JSON.parse(data);
							if(data['status']) {
								swal({
									title: data['message'],
									text: "Press ok to continue",
									type: "success",
									showCancelButton: false,
									confirmButtonColor: "#DD6B55",
									confirmButtonText: "Ok",
									closeOnConfirm: false,
									allowEscapeKey: false,
								},
								function(isConfirm){
									if(isConfirm) {
										window.location.reload();
									}
								});
							} else {
								swal("Error", data['message'], "error");
							}
						}
					});
				} else {
					swal("Cancelled", name+"'s record will not be blocked.", "error");
				}
			});
		}

		function unBlockUser(id, name)
		{
			swal({
				title: "Are you sure?",
				text: "You want to unblock "+name,
				type: "warning",
				showCancelButton: true,
				confirmButtonColor: "#DD6B55",
				confirmButtonText: "Yes, unblock "+name+"!",
				cancelButtonText: "No, cancel pls!",
				closeOnConfirm: false,
				closeOnCancel: false,
				allowEscapeKey: false,
			},
			function(isConfirm){
				if(isConfirm) {
					$.ajax({
						url: "{{ url('admin/users/block') }}" + '/' + id,
						type: 'POST',
						success: function(data) {
							data = JSON.parse(data);
							if(data['status']) {
								swal({
									title: data['message'],
									text: "Press ok to continue",
									type: "success",
									showCancelButton: false,
									confirmButtonColor: "#DD6B55",
									confirmButtonText: "Ok",
									closeOnConfirm: false,
									allowEscapeKey: false,
								},
								function(isConfirm){
									if(isConfirm) {
										window.location.reload();
									}
								});
							} else {
								swal("Error", data['message'], "error");
							}
						}
					});
				} else {
					swal("Cancelled", name+"'s record could not been unblocked.", "error");
				}
			});
		}
	</script>
@endsection