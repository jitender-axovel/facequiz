@extends('admin.layouts.app')
@section('title', $page)
@section('content')
	<h2>Templates List</h2>
	<hr>
	@include('notification')
	<div class="text-right"><a class="btn btn-primary" href="{{ url('admin/layout/create') }}">Create New Template</a></div>
	<table id="template_list" class="display">
		<thead>
			<tr>
				<th>Category</th>
				<th>Title</th>
				<th>Total Images</th>
				<th>Total Textareas</th>
				<th>Has Title</th>
				<th>Has Image Caption</th>
				<th>Created On</th>
				<th>Actions</th>
			</tr>
		</thead>
		<tbody>
			@foreach($templates as $template)
			<tr>
				<td>{{ $template->category->title }}</td>
				<td>{{ $template->name }}</td>
				<td>{{ $template->total_images }}</td>
				<td>{{ $template->total_textareas }}</td>
				<td>{{ $template->has_title }}</td>
				<td>{{ $template->has_image_caption }}</td>
				<td>{{ date_format(date_create($template->created_at), 'F d, Y') }}</td>
				<td>
					<a class="btn btn-info" href="{{ url('admin/layout/'.$template->id.'/edit/') }}">Edit</a>
					<a class="btn btn-primary" href="{{ url('admin/layout/'.$template->id) }}">View Info</a>
					<a class="btn btn-danger" onclick="deleteTemplate('{{$template->id}}', '{{ $template->name }}')">Delete</a>
				</td>
			</tr>
			@endforeach
		</tbody>
	</table>
	<script type="text/javascript">
		$(document).ready( function () {
		    $('#template_list').DataTable();
		} );
	</script>
@endsection
@section('admin-scripts')
	<script type="text/javascript">
		function deleteTemplate(id, title)
		{
			swal({
				title: "Are you sure?",
				text: "You want to delete "+title+" template.",
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
						url: "{{ url('admin/layout') }}" + '/' + id,
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
					swal("Cancelled", "Template "+title+" will not be deleted.", "error");
				}
			});
		}
	</script>
@endsection