@extends('admin.layouts.app')
@section('title', $page)
@section('content')
<h2>Add New Quiz</h2>
<hr>
@include('notification')
<div class="panel panel-default">
    <div class="panel-heading">
        <p class="bold">Create New Quiz</p>
    </div>
    <div class="panel-body">
        <form action="{{ url('admin/quiz') }}" method="POST" class="form-horizontal" enctype="multipart/form-data">
            {{csrf_field()}}
            <div class="checkbox-inline col-sm-12">
                <label class="col-md-12">
                    <span class="col-sm-3">Make quiz visible to users? </span><span class="col-sm-2"><input type="checkbox" name="is_active" value="true"></span>
                </label>
            </div>
            <div class="form-group">
                <label class="control-label col-sm-2">Quiz Name</label>
                <div class="col-sm-10">
                    <input required type="text" class="form-control" name="title" value="{{ old('title') }}" placeholder="Enter Quiz Title">
                    @if($errors->has('title'))
                    <span class="help-block">
                        <strong>{{ $errors->first('title') }}</strong>
                    </span>
                    @endif
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-sm-2">Description (Optional)</label>
                <div class="col-sm-10">
                    <textarea class="form-control" name="description">{{ old('description') }}</textarea>
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-sm-2">Choose Template</label>
                <div class="col-sm-10">
                    <select required name="quiz_template_id" class="form-control" id="template-selector">
                        <option selected>Select Template</option>
                        @foreach($templates as $template)
                        <option value="{{$template->id}}">{{$template->name}}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div id="template-details" class="panel-body">
                <div class="col-md-2">Total images</div>
                <div class="col-md-1 template-images"></div>
                <div class="col-md-2">Total Textareas</div>
                <div class="col-md-1 template-textares"></div>
                <div class="col-md-2">Title block</div>
                <div class="col-md-1 template-title"></div>
                <div class="col-md-2">Image Caption</div>
                <div class="col-md-1 template-caption"></div>
            </div>
            <div class="form-group">
                <label class="control-label col-md-2">Background Image</label>
                <div class="col-md-10">
                    <input type="file" accept="image/*" name="background_image" onchange="backgroundPreview(this);" required>
                    <span id="helpBlock" class="help-block">If you want to use facts image as background then you may ignore this step.</span>
                    <fieldset class="text-center">
                        <legend>Image Preview</legend>
                        <div class="thumbnail" id="background-image-preview"></div>
                    </fieldset>
                </div>
            </div>
            <fieldset>
                <legend>Quiz Information to Show</legend>
                <div class="form-group">
                    <label class="control-label col-md-2">Total facts to show</label>
                    <div class="col-md-1">
                        <input type="number" name="total_facts" min="0" max="10" class="form-control" >
                    </div>
                    <label class="control-label col-md-2">Show Own Profile Image</label>
                    <div class="col-md-1">
                        <input type="checkbox" name="show_own_profile_picture" class="form-control" value="1">
                    </div>
                    <label class="control-label col-md-2">Show User Name</label>
                    <div class="col-md-1">
                        <input type="checkbox" name="show_user_name" class="form-control" value="1">
                    </div>
                    <label class="control-label col-md-2">Show Friends Pictures</label>
                    <div class="col-md-1">
                        <input type="checkbox" name="show_friend_pictures" class="form-control" value="1">
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-md-2">Show Friend Names</label>
                    <div class="col-md-1">
                        <input type="checkbox" name="show_friend_name" class="form-control" value="1">
                    </div>
                </div>
                <span id="helpBlock" class="help-block">Kindly set these options as per the requirements for the quiz. It will help scripts to set data on quiz.</span>
            </fieldset>
            <div id="quiz-form" class="form-group">
                <div class="fact-list-item">
                    <fieldset class="col-md-12">
                        <legend>Quiz Fact</legend>
                        <div class="col-sm-3">
                            <input required name="fact[title][]" class="form-control" placeholder="Title"></input>
                        </div>
                        <div class="col-sm-4">
                            <input required name="fact[description][]" class="form-control" placeholder="Description (Optional)"></input>
                        </div>
                        <input type="file" name="image[]" accept="image/*" class="col-sm-2" onchange="readURL(this);"></input>
                        <img height="100px" width="100px" src="" alt="Image Preview" />
                        <button type="button" class="add-form-element btn btn-warning"><i class="fa fa-plus"></i></button>
                        <button type="button" class="remove-form-element btn btn-danger"><i class="fa fa-minus"></i></button>
                    </fieldset>
                </div>
            </div>
            <div class="form-group">
                <div class="col-md-12">
                    <button type="submit" class="btn btn-default btn-lg btn-block" id="btn-login">Create Quiz</button>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection
@section('admin-scripts')
    <script type="text/javascript">
        function backgroundPreview(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();

                reader.onload = function (e) {
                    $("#background-image-preview").html('<img height="200" width="100%" ' + 'src="' + e.target.result + '">');
                }

                reader.readAsDataURL(input.files[0]);
            }
        }

        $(document).ready(function () {
            $('#template-details').hide();

            $('#template-selector').change(function () {
                $.ajax({
                    url: "{{url('get-template-details?ti=')}}" + $(this).val(),
                    type: "GET",
                    success: function (data) {
                        data = JSON.parse(data);
                        $('.template-images').html(data.total_images);
                        $('.template-textares').html(data.total_textareas);
                        $('.template-title').html(data.has_title);
                        $('.template-caption').html(data.has_image_caption);
                        $('#template-details').show();
                    }
                });
            });
        });
        
        $('.add-form-element').click(function () {
            $('.fact-list-item').first().clone(true,true).appendTo('#quiz-form');
        });

        $('.remove-form-element').click(function () {
            $('#quiz-form .fact-list-item').last().remove();
        });

        function readURL(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();

                reader.onload = function (e) {
                    $(":focus").next("img").attr('src', e.target.result);
                }

                reader.readAsDataURL(input.files[0]);
            }
        }
    </script>
@endsection