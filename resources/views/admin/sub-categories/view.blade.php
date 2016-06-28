@extends('admin.layouts.app')
@section('title', $page)
@section('content')
	<div class="container">
		<div class="row">
			<div class="col-md-12">
				<div class="panel panel-default">
					<div class="panel-body">
						<div class="col-sm-10 col-md-offset-1">
							<dl class="dl-horizontal lead">
								<dt>Parent Category</dt>
								<dd><blockquote>{{ $subCategory->parentCategory->title }}</blockquote></dd>
								<dt>Title</dt>
								<dd><blockquote>{{ $subCategory->title }}</blockquote></dd>
								<dt>Description</dt>
								<dd><blockquote>{{ $subCategory->description }}</blockquote></dd>
							</dl>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
@endsection