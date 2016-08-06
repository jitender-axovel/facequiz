@extends('admin.layouts.app')
@section('content')
	<h2>Cms Pages List</h2>
	<hr>
	@include('notification')
	<table id="quizzes_list" class="display">
		<thead>
			<tr>
				<th>Title</th>
				<th>Url</th>
				<th>Created On</th>
				<th>Actions</th>
			</tr>
		</thead>
		<tbody>
			@foreach($cmsPages as $cmsPage)
			<tr>
				<td>{{ $cmsPage->title}}</td>
				<td><a class="btn btn-success" href="{{ url('cms/'.$cmsPage->slug) }}">Visit</a></td>
				<td>{{ date_format(date_create($cmsPage->created_at), 'F d, Y') }}</td>
				<td>
					<a class="btn btn-primary" href="{{ url('admin/cms/'.$cmsPage->id.'/edit') }}">Edit</a>
				</td>
			</tr>
			@endforeach
		</tbody>
	</table>
	<script type="text/javascript">
		$(document).ready( function () {
		    $('#quizzes_list').DataTable();
		});
	</script>
@endsection