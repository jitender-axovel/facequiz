@if(isset($widgets['abovequizzes']))
	@foreach($widgets['abovequizzes'] as $content)
		<div class="row">{!!htmlspecialchars_decode($content)!!}</div>
	@endforeach
@endif