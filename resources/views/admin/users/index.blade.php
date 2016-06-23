@extends('admin.layouts.app')
@section('title', $page)
@section('content')
	<h2>Users List</h2>
	<hr>
	@include('notification')
	<table id="users_list" class="display">
		<thead>
			<tr>
				<th>Name</th>
				<th>Email</th>
				<th>Credits</th>
				<th>Gender</th>
				<th>Joined On</th>
				<th>Actions</th>
			</tr>
		</thead>
		<tbody>
			@foreach($users as $user)
			<tr>
				<td>{{ $user->first_name . ' ' . $user->last_name}}</td>
				<td>{{ $user->email }}</td>
				<td>{{ $user->credits }}</td>
				<td>{{ $user->gender }}</td>
				<td>{{ date_format(date_create($user->created_at), 'F d, Y') }}</td>
				<td>
					<a class="btn btn-info" href="{{ url('admin/users/edit/'.$user->id) }}">Edit</a>
					<a class="btn btn-primary" href="{{ url('admin/users/view/'.$user->id) }}">View Info</a>
					<a class="btn btn-danger" onclick="deleteUser('{{$user->id}}', '{{$user->first_name.' '.$user->last_name}}')">Delete</a>
				</td>
			</tr>
			@endforeach
		</tbody>
	</table>
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
	</script>
@endsection