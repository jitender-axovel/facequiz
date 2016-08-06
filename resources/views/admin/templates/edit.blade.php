@extends('admin.layouts.app')
@section('content')
    <h2>Edit {{ $template->name }}</h2>
    <hr>
    @include('notification')
    <div class="row">
        <div class="col-md-12">
            @include('notification')
            <div class="panel panel-default">
                <div class="panel-heading">
                    <p class="bold">Edit Template</p>
                </div>
                <div class="panel-body">
                    <form class="form-horizontal" action="{{ url('admin/layout/'.$template->id) }}" method="POST" enctype="multipart/form-data">
                        {{csrf_field()}}
                        <input type="hidden" name="_method" value="put" />
                        <div class="form-group">
                            <label class="control-label col-sm-2">Layout Name</label>
                            <div class="col-md-10">
                                <input required type="text" class="form-control" name="name" value="{{ $template->name ? $template->name : old('name') }}">
                                @if($errors->has('name'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('name') }}</strong>
                                </span>
                                @endif
                            </div>
                        </div>
                        <div class="form-group">
                            <ul class="list-inline">
                                <label class="control-label col-sm-2">Total Images</label>
                                <div class="col-md-1">
                                    <input required type="text" class="form-control" name="total_images" value="{{ $template->total_images ? $template->total_images : old('total_images') }}">
                                </div>
                                <label class="control-label col-sm-2">Total Textareas</label>
                                <div class="col-md-1">
                                    <input required type="text" class="form-control" name="total_textareas" value="{{ $template->total_textareas ? $template->total_textareas : old('total_textareas') }}">
                                </div>

                                <label class="control-label col-sm-2">Has Title</label>
                                <div class="col-md-1">
                                    <input type="checkbox" class="form-control" name="has_title" {{ $template->has_title ? 'checked' : '' }}>
                                </div>
                                <label class="control-label col-sm-2">Has Image Caption</label>
                                <div class="col-md-1">
                                    <input type="checkbox" class="form-control" name="has_image_caption" {{ $template->has_image_caption ? 'checked' : '' }}>
                                </div>
                            </ul>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-sm-2">Input Html Code</label>
                            <div class="col-md-10">
                                <textarea class="form-control" id="html-edit-box" name="html_data" rows="10">{{ $template->html_data ? $template->html_data : '' }}</textarea>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label">Upload Introduction Image</label>
                            <div class="col-md-10">
                                <input type="file" accept="image/*" name="og_image" onchange="readURL(this);" id="upload-button">

                                <fieldset class="text-center">
                                    <legend>Image Preview</legend>
                                    <div class="thumbnail" id="html-output"></div>
                                </fieldset>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-sm-12">
                                <button type="submit" class="btn btn-lg btn-block">Update Template</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('admin-scripts')
    <script type="text/javascript" src="{{ asset('js/html2canvas/build/html2canvas.js') }}"></script>
    <script type="text/javascript">
        $(document).ready(function() {
            $('#layout-form').submit(function() {
                var imgVal = $('#upload-button').val(); 
                var layout = $('#html-edit-box').val();
                if(layout == '') { 
                    swal('Warning', 'Kindly input html structure for quiz layouts.', 'error');
                    return false;
                } else if(imgVal == '') {
                    swal('Warning', 'Kindly upload an image for template.', 'error');
                    return false;
                }else {
                    document.getElementById("layout-form").submit();
                }
            });
        });
        function readURL(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();

                reader.onload = function (e) {
                    $("#html-output").html('<img height="400" width="100%" ' + 'src="' + e.target.result + '">');
                }

                reader.readAsDataURL(input.files[0]);
            }
        }
    </script>
@endsection