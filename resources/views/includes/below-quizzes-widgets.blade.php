@if(isset($widgets['belowquizzes']))
	@foreach($widgets['belowquizzes'] as $content)
		<div class="row">{!! htmlspecialchars_decode($content) !!}</div>
	@endforeach
@endif