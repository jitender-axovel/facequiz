@if(isset($widgets['belowquizzes']))
	@foreach($widgets['belowquizzes'] as $content)
		<div class="row">{!!$content!!}</div>
	@endforeach
@endif