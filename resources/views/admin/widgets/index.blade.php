@extends('admin.layouts.app')
@section('content')
	<h2 class="user-heading">Widgets List</h2>
	<hr>
	@include('notification')
	<div class="row col-md-12 widget-sec">
		<div class="panel panel-primary">
			<div class="panel-heading">
				<div class="panel-title">Manage Widgets</div>
			</div>
			<div class="panel-body">
				<form method="POST" action="{{url('admin/widget')}}">
					{{csrf_field()}}
					@foreach($widgets as $k => $widget)
						<div class="row">
							<div class="col-md-7">
								<div class="panel panel-primary">
									<div class="panel-heading">
										<div class="panel-title">
											{{ $widget->name }}
										</div>
									</div>
									<div class="panel-body" id="{{$widget->slug}}">
										@if(!empty($widget->widgets))
											@foreach($widget->widgets as $widgetItem)
												@include('admin.widgets.components.widget-form', array(
													'slug' => $widget->slug,
													'widgetTitle' => $widgetItem['title'],
													'widgetContent' => $widgetItem['content']
												))
											@endforeach
										@endif
									</div>
									<div class="panel-footer">
										<button type="button" class="btn btn-default" onclick="addWidgetForm('{{$widget->slug}}')"><i class="fa fa-plus"></i> Add Widget</button>
									</div>
								</div>
							</div>
							<div class="col-md-5">
								<h3>Preview Image</h3>
								<img src="{{ asset(config('image.widget_image_url').$widget->preview_image) }}">
							</div>
						</div>
					@endforeach
					<button type="submit" class="btn btn-success">Save Changes</button>
				</form>
			</div>
		</div>
	</div>
@endsection
@section('admin-head-script')
	<script src="{{ asset('js/tinymce/tinymce.min.js') }}"></script>
    <script src="{{ asset('js/tinymce/jquery.tinymce.min.js') }}"></script>
    <script type="text/javascript">
    	function loadEditor()
        {
        	tinymce.init({
	            selector: 'textarea',
	            menu: {
					view: {title: 'Enter Code', items: 'code'}
				},
				plugins: 'code, textpattern, textcolor',
				toolbar: [
					'undo redo | styleselect | bold italic | link image | alignleft aligncenter alignright alignjustify | fontselect | forecolor | backcolor'
				],
				theme_advanced_fonts: 'Arial=arial,helvetica,sans-serif;Courier New=courier new,courier,monospace;AkrutiKndPadmini=Akpdmi-n',
	        });
        }
    </script>
@endsection
@section('admin-scripts')
	<script type="text/javascript">
		$(document).ready(function() {
			loadEditor();
		});
		function addWidgetForm(slug)
		{
			$.ajax({
				url:"{{url('get-widget-form')}}" + '/' + slug,
				async: false,
				dataType: 'html',
				success: function(data) {
					$('#' + slug).append(data);
				}
			});
		}
		$(document).on('click', '.collapse-toggle', function(){
			var parent = $(this).parents('.panel-default');
			parent.children('.panel-body').collapse('toggle');
			loadEditor();
			loadWidgetForm();
		});
		
		function loadWidgetForm()
		{
			$(document).on('click', '.delete-button', function(){
				$(this).parents('.panel-default').remove();
			});
		}
	</script>
@endsection