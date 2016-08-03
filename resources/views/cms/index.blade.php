@extends('layouts.app')
@section('content')
	<div class="main-content container">
		<div class="row">{!! $cmsPage->content !!}</div>
	</div>
@endsection