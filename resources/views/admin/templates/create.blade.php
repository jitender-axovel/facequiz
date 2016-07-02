@extends('admin.layouts.app')
@section('title', $page)
@section('content')
	<h2>Add New Category</h2>
	<hr>
	@include('notification')
	<div class="panel panel-default">
		<div class="panel-heading">
			<p class="bold">Create New Layout</p>
		</div>
		<div class="panel-body">
			<form id="layout-form" action="{{ url('admin/layout') }}" method="POST" class="form-horizontal">
				{{csrf_field()}}
				<div class="form-group">
					<label class="control-label col-sm-2">Layout Name</label>
					<div class="col-md-10">
						<input required type="text" class="form-control" name="name" value="{{ old('name') }}">
						@if($errors->has('name'))
							<span class="help-block">
								<strong>{{ $errors->first('name') }}</strong>
							</span>
						@endif
					</div>
				</div>
				<div class="form-group">
					<label class="control-label col-sm-2">Select Category</label>
					<div class="col-md-10">
						<select class="form-control" name="category_id">
							@foreach($categories as $category)
								<option value="{{ $category->id }}">{{ $category->title }}</option>
							@endforeach
						</select>
					</div>
				</div>
				<div class="form-group">
					<ul class="list-inline">
						<label class="control-label col-sm-2">Total Images</label>
						<div class="col-md-1">
							<input required type="text" class="form-control" name="total_images" value="{{ old('total_images') }}">
						</div>
						<label class="control-label col-sm-2">Total Textareas</label>
						<div class="col-md-1">
							<input required type="text" class="form-control" name="total_textareas" value="{{ old('total_textareas') }}">
						</div>
					
						<label class="control-label col-sm-2">Has Title</label>
						<div class="col-md-1">
							<input type="checkbox" class="form-control" name="has_title" value="true">
						</div>
						<label class="control-label col-sm-2">Has Image Caption</label>
						<div class="col-md-1">
							<input type="checkbox" class="form-control" name="has_image_caption" value="true">
						</div>
					</ul>
				</div>
				<div class="form-group">
					<label class="control-label col-sm-2">Input Html Code</label>
					<div class="col-md-10">
						<textarea class="form-control" id="html-edit-box" name="html_data" rows="5"></textarea>
					</div>
				</div>
				<div class="form-group">
					<label class="control-label col-sm-2">Image Preview</label>
					<div class="col-md-10">
						<div class="panel panel-default">
							<div class="panel-body">
								<div id="html-output"></div>
								<div hidden id="canvas"></div>
								<input type="hidden" name="og_image" id="input-file">
							</div>
						</div>
					</div>
				</div>
				<div class="form-group">
					<div class="col-sm-12">
						<button type="submit" class="btn btn-lg btn-block" id="btn-login">Create Layout</button>
					</div>
				</div>
			</form>
		</div>
	</div>
@endsection
@section('admin-scripts')
	<script type="text/javascript" src="{{ asset('js/html2canvas/build/html2canvas.js') }}"></script>
	<script type="text/javascript">
		$(document).ready(function() {
			$('#html-edit-box').bind('input propertychange', function() {
				$('#html-output').html($(this).val());
				
				$('#html-output').each(function() {
				    if ($(this).find('> img').length) {
				        if($(this).find('> img').hasClass('profile_pic'))
				        	$(this).find('> img').attr('src', window.location.protocol+'//'+window.location.host+'/facequiz/public/images/avatar.png');
				    }
				});
				
			});

			$('#layout-form').submit(function(e) {
				e.preventDefault();

				$('#html-output').html($('#html-edit-box').val());
				html2canvas([document.getElementById('html-output')], {
				    onrendered: function (canvas) {
				        document.getElementById('canvas').appendChild(canvas);
				        var data = canvas.toDataURL('image/png');
				        // AJAX call to send `data` to a PHP file that creates an image from the dataURI string and saves it to a directory on the server

				        var image = new Image();
				        image.src = data;
				        // document.getElementById('html-output').appendChild(image);
				        $('#html-output').html(image);
				        
				        var file= dataURLtoBlob(data);

						// Create new form data
						var fd = new FormData();
						fd.append('imageName', file);

						$.ajax({
						    url: "{{ url('admin/save-template-image') }}",
						    type: "POST",
						    data: fd,
						    processData: false,
    						contentType: false,
							success: function(data){
								$('#input-file').val(data['fileName']);
								document.getElementById("layout-form").submit();
							}
						});
				    }
				});
			});
			function dataURLtoBlob(dataURL) {
				// Decode the dataURL    
				var binary = atob(dataURL.split(',')[1]);
				// Create 8-bit unsigned array
				var array = [];
				for(var i = 0; i < binary.length; i++) {
				    array.push(binary.charCodeAt(i));
			 	}
				// Return our Blob object
				return new Blob([new Uint8Array(array)], {type: 'image/png'});
		 	}
		});
	</script>
@endsection