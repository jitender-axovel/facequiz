@extends('admin.layouts.app')
@section('title', $page)
@section('content')
	<h2>Categories</h2>
	<hr>
	@include('notification')
	<table id="categories_list" class="display">
		<thead>
			<tr>
				<th>Title</th>
				<th>Quiz count</th>
				<th>Created On</th>
				<th>Actions</th>
			</tr>
		</thead>
		<tbody>
			@foreach($categories as $category)
			<tr>
				<td>{{ $category->title}}</td>
				<td>{{ $category->quizzes()->count() }}</td>
				<td>{{ date_format(date_create($category->created_at), 'F d, Y') }}</td>
				<td>
					<a class="btn btn-info" href="{{ url('admin/category/'.$category->id.'/edit/') }}">Edit</a>
					<a class="btn btn-primary" href="{{ url('admin/category/'.$category->id) }}">View Info</a>
					<a class="btn btn-danger" onclick="deleteCategory('{{$category->id}}', '{{ $category->title }}')">Delete</a>
				</td>
			</tr>
			@endforeach
		</tbody>
	</table>
	<script type="text/javascript">
		$(document).ready( function () {
		    $('#categories_list').DataTable();
		} );
	</script>
@endsection
@section('admin-scripts')
	<script type="text/javascript">
		function deleteCategory(id, title)
		{
			swal({
				title: "Are you sure?",
				text: "You want to delete "+title+" category.",
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
						url: "{{ url('admin/category') }}" + '/' + id,
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
					swal("Cancelled", "Category "+title+" will not be deleted.", "error");
				}
			});
		}
	</script>
@endsection