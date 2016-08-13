@if(isset($widgets['sidebar']))
	@foreach($widgets['sidebar'] as $content)
		<div class="row">{!! htmlspecialchars_decode($content) !!}</div>
	@endforeach
@endif