@extends('admin.layouts.app')
@section('content')
	<div class="col-md-10 col-md-offset-1">
		<h2>Language</h2>
		@include('notification')
		@foreach($languages as $language)
			<div class="panel panel-default">
				<div class="panel-heading">
					<div class="panel-title container-fluid">
						<div class="col-md-10 text-left">{{$language->name}}</div>
						<div class="col-md-2 text-right">
							<a class="btn btn-primary" data-toggle="collapse" href="#{{$language->name}}" title="Edit"><i class="fa fa-pencil-square-o"></i></a>
							<a class="btn btn-danger" onclick="javascript:deleteLanguage({{$language->id}}, '{{ $language->name }}');" title="Delete"><i class="fa fa-trash"></i></a>
						</div>
					</div>
				</div>
				<div id="{{ $language->name }}" class="panel-collapse collapse">
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
                                <label>Facebook Page ID</label>
                                <input name="fb_page_code" class="form-control" value="{{ $language->fb_page_code ? $language->fb_page_code : old('fb_page_code') }}">
                        	</div>
							<div class="form-group">
								<label>Facebook Like Button Code</label>
								<input name="fb_like" class="form-control" value="{{ $language->fb_like ? $language->fb_like : old('fb_like') }}"></input>
							</div>
							<div class="form-group">
								<label>Facebook Widget Code</label>
								<input name="fb_widget" class="form-control" value="{{ $language->fb_widget ? $language->fb_widget : old('fb_widget') }}"></input>
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
									@foreach(json_decode($language->strings,true) as $k => $string)
										<div class="form-group">
											<label>'{{ $k }}'</label>
											<input name="strings[{{ $k }}]" class="form-control" value="{{$string}}">
										</div>
									@endforeach
									@foreach(array_diff_key(trans('strings'), json_decode($language->strings,true)) as $k => $string)
										<div class="form-group">
											<label>'{{ $k }}'</label>
											<input name="strings[{{ $k }}]" class="form-control" value="{{old($string)}}">
										</div>
									@endforeach
								</div>
							</div>
							<button type="submit" class="btn btn-success btn-lg btn-block">Save</button>
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
        $.ajaxSetup({
		        headers: {
		            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
		        }
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

		function deleteLanguage(id, name)
		{
			swal({
				title: "Are you sure?",
				text: "You want to delete "+name,
				type: "warning",
				showCancelButton: true,
				confirmButtonColor: "#DD6B55",
				confirmButtonText: "Yes, delete it!",
				cancelButtonText: "No, cancel pls!",
				closeOnConfirm: false,
				closeOnCancel: false,
				allowEscapeKey: false,
			},
			function(isConfirm){
				if(isConfirm) {
					$.ajax({
						url: "{{ url('admin/language') }}" + '/' + id + '/delete',
						type: 'DELETE',
						success: function(data) {
							data = JSON.parse(data);
							if(data['status']) {
								swal({
									title: data['message'],
									text: "Press ok to continue",
									type: "success",
									showCancelButton: false,
									confirmButtonColor: "#DD6B55",
									confirmButtonText: "Ok",
									closeOnConfirm: false,
									allowEscapeKey: false,
								},
								function(isConfirm){
									if(isConfirm) {
										window.location.reload();
									}
								});
							} else {
								swal("Error", data['message'], "error");
							}
						}
					});
				} else {
					swal("Cancelled", name+" quiz will not be deleted.", "error");
				}
			});
		}
    </script>
@endsection
