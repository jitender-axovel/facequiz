@extends('admin.layouts.app')
@section('title', $page)
@section('content')
	<div class="col-md-10 col-md-offset-1">
		<h2>Language</h2>
		@include('notification')
		@foreach($languages as $language)
			<div class="panel panel-default">
				<div class="panel-heading">
					<div class="panel-title">
						<span>{{$language->name}}</span>
						<a class="text-right" data-toggle="collapse" href="#english"><i class="fa fa-pencil"></i></a>
					</div>
				</div>
				<div id="english" class="panel-collapse collapse">
					<div class="panel-body">
						<form action="{{ url('admin/language/'.$language->id) }}" method="post">
							{{csrf_field()}}
							<div class="form-group">
								<label>Language Name</label>
								<input name="name" class="form-control" value="{{$language->name ? $language->name : old('name') }}">
							</div>
							<div class="form-group">
								<label>Language Code (example: en, es, etc.)</label>
								<input name="code" class="form-control" value="{{ $language->code ? $language->code : old('code') }}">
							</div>
							<div class="form-group">
								<label>Facebook Locale Code (example: en_US, es_ES, etc.)</label>
								<input name="fb_code" class="form-control" value="{{ $language->fb_code ? $language->fb_code : old('fb_code') }}">
							</div>
							<div class="form-group">
								<label>Direction</label>
								<select name="direction" class="form-control">
									<option value="ltr">Left to Right</option>
									<option value="rtl">Right to Left</option>
								</select>
							</div>
							<div class="panel panel-default">
								<div class="panel-heading">
									<div class="panel-title">Strings</div>
								</div>
								<div class="panel-body">
									@foreach(json_decode($language->strings,true) as $string)
										<div class="form-group">
											<label>'{{ $string }}'</label>
											<input name="{{ trans('strings.'.$string) }}" class="form-control" value="{{$string}}">
										</div>
									@endforeach
									@foreach(array_diff(trans('strings'), json_decode($language->strings,true)) as $string)
										<div class="form-group">
											<label>'{{ $string }}'</label>
											<input name="{{ $string }}" class="form-control" value="{{old($string)}}">
										</div>
									@endforeach
								</div>
							</div>
							<button type="submit" class="btn btn-lg btn-block">Save</button>
						</form>
					</div>
				</div>
			</div>
		@endforeach
                <a class="btn btn-warning" onclick="javascript:showLanguageForm();"><i class="fa fa-plus-circle"></i> Add new Language</a>
                <div class="language-form"></div>
	</div>
@endsection
@section('admin-scripts')
    <script type="text/javascript">
        $(document).ready(function() {
            
        });
        function showLanguageForm()
        {
            $.ajax({
                url: "{{url('admin/get-language-form')}}",
                type: "GET",
                success: function(data) {
                    $('.language-form').html(data);
                }
            });
        }
    </script>
@endsection