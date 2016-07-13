@if(isset($widgets['belowquizview']))
	@foreach($widgets['belowquizview'] as $content)
		<div class="col-md-4">{!!$content!!}</div>
	@endforeach
@endif