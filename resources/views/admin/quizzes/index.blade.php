@extends('admin.layouts.app')
@section('title', $page)
@section('content')
	<h2>Quizzes List</h2>
	<hr>
	@include('notification')
	<table id="users_list" class="display">
		<thead>
			<tr>
				<th>Name</th>
				<th>Template</th>
				<th>Images Count</th>
				<th>Total Facts</th>
				<th>Created On</th>
				<th>Actions</th>
			</tr>
		</thead>
		<tbody>
			@foreach($quizzes as $quiz)
			<tr>
				<td>{{ $quiz->title}}</td>
				<td>{{ $quiz->template->name }}</td>
				<td>{{ $quiz->template->total_images }}</td>
				<td>{{ $quiz->total_facts }}</td>
				<td>{{ date_format(date_create($quiz->created_at), 'F d, Y') }}</td>
				<td>
					<a class="btn btn-primary" href="{{ url('admin/quiz/'.$quiz->id) }}">View Info</a>
					<a class="btn btn-warning" onclick="changeQuizStatus('{{$quiz->id}}', '{{$quiz->name}}')">{{$quiz->is_active == 1 ? 'Deactivate' : 'Activate'}}</a>
					<a class="btn btn-danger" onclick="deleteQuiz('{{$quiz->id}}', '{{$quiz->name}}')">Delete</a>
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
		function deleteQuiz(id, name)
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
						url: "{{ url('admin/quiz') }}" + '/' + id,
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
					swal("Cancelled", name+" quiz will not be deleted.", "error");
				}
			});
		}

		function changeQuizStatus(id, name)
		{
			swal({
				title: "Are you sure?",
				text: "You want to change status for "+name,
				type: "warning",
				showCancelButton: true,
				confirmButtonColor: "#DD6B55",
				confirmButtonText: "Yes, change status for "+name+"!",
				cancelButtonText: "No, cancel pls!",
				closeOnConfirm: false,
				closeOnCancel: false,
				allowEscapeKey: false,
			},
			function(isConfirm){
				if(isConfirm) {
					$.ajax({
						url: "{{ url('admin/quiz/change-status') }}" + '/' + id,
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
					swal("Cancelled", name+"'s status will no be changed.", "error");
				}
			});
		}
	</script>
@endsection