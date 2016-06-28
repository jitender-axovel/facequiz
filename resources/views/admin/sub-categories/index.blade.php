@extends('admin.layouts.app')
@section('title', $page)
@section('content')
	<h2>Sub Categories</h2>
	<hr>
	@include('notification')
	<div class="text-right"><a class="btn btn-primary" href="{{ url('admin/sub-category/create') }}">Create Sub-Category</a></div>
	<table id="sub-categories_list" class="display">
		<thead>
			<tr>
				<th>Title</th>
				<th>Projects Count</th>
				<th>Created On</th>
				<th>Actions</th>
			</tr>
		</thead>
		<tbody>
			@foreach($subCategories as $subCategory)
			<tr>
				<td>{{ $subCategory->title}}</td>
				<td>{{ $subCategory->quizzes()->count() }}</td>
				<td>{{ date_format(date_create($subCategory->created_at), 'F d, Y') }}</td>
				<td>
					<a class="btn btn-info" href="{{ url('admin/sub-category/'.$subCategory->id.'/edit/') }}">Edit</a>
					<a class="btn btn-primary" href="{{ url('admin/sub-category/'.$subCategory->id) }}">View Info</a>
					<a class="btn btn-danger" onclick="deleteSubCategory('{{$subCategory->id}}', '{{ $subCategory->title }}')">Delete</a>
				</td>
			</tr>
			@endforeach
		</tbody>
	</table>
	<script type="text/javascript">
		$(document).ready( function () {
		    $('#sub-categories_list').DataTable();
		} );
	</script>
@endsection
@section('admin-scripts')
	<script type="text/javascript">
		function deleteSubCategory(id, title)
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
						url: "{{ url('admin/sub-category') }}" + '/' + id,
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
					swal("Cancelled", "Sub-Category "+title+" will not be deleted.", "error");
				}
			});
		}
	</script>
@endsection