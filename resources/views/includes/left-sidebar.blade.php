@if(isset($widgets['sidebar']))
	@foreach($widgets['sidebar'] as $content)
		<div class="row">{!!$content!!}</div>
	@endforeach
@endif