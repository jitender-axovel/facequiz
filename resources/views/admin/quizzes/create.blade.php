@extends('admin.layouts.app')
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
            <fieldset class="jumbotron">
                <legend>Quiz Basic Introduction</legend>
                <div class="form-group">
                    <div class="checkbox-inline col-sm-12">
                        <label class="col-md-12">
                            <span class="col-sm-4">Make quiz visible to users? </span><span class="col-sm-1"><input type="checkbox" name="is_active" value="true" class="text-left"></span>
                        </label>
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-sm-12">Quiz Name</label>
                    <div class="col-sm-12">
                        <input required type="text" class="form-control" name="title" value="{{ old('title') }}" placeholder="Enter Quiz Title">
                        @if($errors->has('title'))
                            <span class="help-block">
                                <strong>{{ $errors->first('title') }}</strong>
                            </span>
                        @endif
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-sm-12">Language</label>
                    <div class="col-sm-12">
                        <select required class="form-control" name="locale">
                            <option value="">Select Language</option>
                            @foreach($languages as $language)
                                <option value="{{$language->code}}">{{$language->name}}</option>
                            @endforeach
                        </select>
                        @if($errors->has('locale'))
                            <span class="help-block">
                                <strong>{{ $errors->first('locale') }}</strong>
                            </span>
                        @endif
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-sm-12">Description (Optional)</label>
                    <div class="col-sm-12">
                        <textarea class="form-control" name="description">{{ old('description') }}</textarea>
                    </div>
                </div>
            </fieldset>
            <fieldset class="jumbotron">
                <legend>Set Template Properties</legend>
                <div class="form-group">
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
                        <input type="checkbox" class="form-control" name="has_title">
                    </div>
                    <label class="control-label col-sm-2">Has Image Caption</label>
                    <div class="col-md-1">
                        <input type="checkbox" class="form-control" name="has_image_caption">
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-md-12 col-sm-12">Input Html Code <a onclick="javascript:showInstruction();">Instructions <i class="fa fa-question-circle"></i></a></label>
                    <div class="col-md-12 col-sm-12 col-xs-12">
                        <textarea class="form-control" id="html-edit-box" name="html_data" rows="5"></textarea>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-12 col-sm-12 col-xs-12 control-label">Upload Introduction Image</label>
                    <div class="col-md-12 col-sm-12 col-xs-12">
                        <input type="file" accept="image/*" name="og_image" onchange="readTemplate(this);" id="upload-button">
                    </div>
                    <div class="col-md-12 col-sm-12 col-xs-12">
                        <fieldset class="text-center">
                            <legend>Image Preview</legend>
                            <div class="thumbnail" id="html-output"></div>
                        </fieldset>
                    </div>
                </div>
            </fieldset>
            <fieldset class="jumbotron">
                <legend>Quiz Information to Show</legend>
                <div class="form-group">
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
                    <label class="control-label col-md-2">Show Friend Names</label>
                    <div class="col-md-1">
                        <input type="checkbox" name="show_friend_name" class="form-control" value="1">
                    </div>
                </div>
                <span id="helpBlock" class="help-block">Kindly set these options as per the requirements for the quiz. It will help scripts to set data on quiz.</span>
            </fieldset>
            <fieldset class="jumbotron">
                <legend>Quiz Background Image</legend>
                <div class="form-group">
                    <label class="control-label col-md-12 col-sm-12 col-xs-12">Background Image</label>
                    <div class="col-md-12 col-sm-12 col-xs-12">
                        <input type="file" accept="image/*" name="background_image" onchange="backgroundPreview(this);" required>
                        <span id="helpBlock" class="help-block">If you want to use facts image as background then you may ignore this step.</span>
                    </div>
                    <div class="col-md-12 col-sm-12 col-xs-12">
                        <fieldset class="text-center">
                            <legend>Image Preview</legend>
                            <div class="thumbnail" id="background-image-preview"></div>
                        </fieldset>
                    </div>
                </div>
            </fieldset>
            <fieldset class="jumbotron">
                <legend>Quiz Fact</legend>
                <div id="quiz-form" class="form-group">
                    <div class="form-group">
                        <label class="control-label col-md-12 col-sm-12 col-xs-12">Total facts to show</label>
                        <div class="col-md-12 col-sm-12 col-xs-12">
                            <input type="number" name="total_facts" min="0" max="10" class="form-control" >
                        </div>
                    </div>
                    <div class="fact-list-item">
                        <div class="col-md-12 col-sm-12 col-xs-12">
                            <input required name="fact[title][]" class="form-control" placeholder="Title">
                        </div>
                        <div class="col-md-12 col-sm-12 col-xs-12">
                            <input required name="fact[description][]" class="form-control" placeholder="Description (Optional)">
                        </div>
                        <input type="file" name="image[]" accept="image/*" class="col-md-12 col-sm-12 col-xs-12" onchange="readFacts(this);">
                        <img height="100px" width="100px" src="" alt="Image Preview" />
                        <button type="button" class="add-form-element btn btn-warning"><i class="fa fa-plus"></i></button>
                        <button type="button" class="remove-form-element btn btn-danger"><i class="fa fa-minus"></i></button>
                    </div>
                </div>
            </fieldset>
            <div class="form-group">
                <button type="submit" class="form-control btn btn-success btn-block" id="btn-login">Create Quiz</button>
            </div>
        </form>
    </div>
</div>
<div class="modal fade bs-example-modal-lg" id="instructions-modal" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Instruction to create html template</h4>
            </div>
            <div class="modal-body">
                <h3>Follow below listed instructions to create html template:</h3>
                <p>{{ htmlspecialchars('Title: For title of the quiz you will use is_quiz_title. For example: <h1>is_quiz_title</h1>') }}</p>
                <p>{{ htmlspecialchars('Profile picture: To show user’s profile picture you will use "user_profile_pic" in src attribute. For example: <img src=”user_profile_pic”>') }}</p>
                <p>{{ htmlspecialchars('Friend profile picture: To show friends profile pictures you may use these in src attribute of img tag. "friend_profile_pic_1”,” friend_profile_pic_2 ...”. For example: <img src=”friend_profile_pic_1”>') }}</p>
                <p>{{ htmlspecialchars('User name: For user name you may use “user_name”. For example: <p>user_name</p>') }}</p>
                <p>{{ htmlspecialchars('Friend_name: To show friend’s name you may use “friend_name_1”, “friend_name_2 …”. For example: <p>friend_name_1</p>, <p>friend_name_2</p>') }}</p>
                <p>{{ htmlspecialchars('Fact Title: Your quiz may have multiple facts. So the title of each fact may go like this: “fact_1”, “fact_2.........”. For example: <span>fact_1</span>, <span>fact_2</span>') }}</p>
                <p>{{ htmlspecialchars('Fact description: If your fact has any description you may use following strings with respect of your fact title: “fact_desc_1”, “fact_desc_2.......”. For example: <span>fact_desc_1</span>') }}</p>
                <p>{{ htmlspecialchars('Fact_image: If your fact has any images you may use: “fact_image_1”, “fact_image_2 ...........”. For example: <img src=”fact_image_1”>') }}</p>
                <p>{{ htmlspecialchars('Background image: If quiz has a predefined background image you may use “quiz_background_image”. For example: <body style=”background-image:url(quiz_background_image)”>') }}</p>
</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
@endsection
@section('admin-scripts')
    <script type="text/javascript">
        function showInstruction()
        {
            $('#instructions-modal').modal('show');
        }
        
        function backgroundPreview(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();

                reader.onload = function (e) {
                    $("#background-image-preview").html('<img height="200" width="100%" ' + 'src="' + e.target.result + '">');
                }

                reader.readAsDataURL(input.files[0]);
            }
        }
        
        $('.add-form-element').click(function () {
            $('.fact-list-item').first().clone(true,true).appendTo('#quiz-form');
        });

        $('.remove-form-element').click(function () {
            $('#quiz-form .fact-list-item').last().remove();
        });

        function readFacts(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();

                reader.onload = function (e) {
                    $(":focus").next("img").attr('src', e.target.result);
                }

                reader.readAsDataURL(input.files[0]);
            }
        }
        function readTemplate(input) {
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