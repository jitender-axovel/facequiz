@if(isset($widgets['abovequizzes']))
	@foreach($widgets['abovequizzes'] as $content)
		<div class="row">{!!$content!!}</div>
	@endforeach
@endif