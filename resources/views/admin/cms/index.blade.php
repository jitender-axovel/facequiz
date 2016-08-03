@extends('admin.layouts.app')
@section('title', $page)
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
			@foreach($cmsPages as $page)
			<tr>
				<td>{{ $page->title}}</td>
				<td><a class="btn btn-success" href="{{ url('cms/'.$page->slug) }}">Visit</a></td>
				<td>{{ date_format(date_create($page->created_at), 'F d, Y') }}</td>
				<td>
					<a class="btn btn-primary" href="{{ url('admin/quiz/'.$page->id) }}">View Info</a>
					<a class="btn btn-warning" onclick="changeQuizStatus('{{$page->id}}', '{{$page->name}}')">{{$page->is_active == 1 ? 'Deactivate' : 'Activate'}}</a>
					<a class="btn btn-danger" onclick="deleteQuiz('{{$page->id}}', '{{$page->name}}')">Delete</a>
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