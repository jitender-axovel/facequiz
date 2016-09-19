@extends('admin.layouts.app')
@section('content')
<h2>Edit - {{$quiz->title}}</h2>
<hr>
@include('notification')
<div class="row">
    @if (count($errors) > 0)
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
</div>
<div class="panel panel-default">
    <div class="panel-body">
        <form action="{{ url('admin/quiz/'.$quiz->id) }}" method="POST" class="form-horizontal" enctype="multipart/form-data">
            {{csrf_field()}}
            <input type="hidden" name="_method" value="PUT">
            <fieldset class="jumbotron">
                <legend>Quiz Basic Introduction</legend>
                <div class="form-group">
                    <label class="control-label col-sm-2">Quiz Name</label>
                    <div class="col-sm-10">
                        <input required type="text" class="form-control" name="title" value="{{ $quiz->title or old('title') }}" placeholder="Enter Quiz Title">
                        @if($errors->has('title'))
                            <span class="help-block">
                                <strong>{{ $errors->first('title') }}</strong>
                            </span>
                        @endif
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-sm-2">Language</label>
                    <div class="col-sm-10">
                        <select required class="form-control" name="locale">
                            <option value="">Select Language</option>
                            @foreach($languages as $language)
                                <option value="{{$language->code}}" {{$language->code == $quiz->locale ? 'selected' : ''}}>{{$language->name}}</option>
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
                    <label class="control-label col-sm-2">Description (Optional)</label>
                    <div class="col-sm-10">
                        <textarea class="form-control" name="description">{{ $quiz->description or old('description') }}</textarea>
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-sm-2">Answer Description (Optional)</label>
                    <div class="col-sm-10">
                        <textarea class="form-control" name="answer_description">{{ $quiz->answer_description or old('answer_description') }}</textarea>
                    </div>
                </div>
            </fieldset>
            <fieldset class="jumbotron">
                <legend>Set Template Properties</legend>
                <div class="form-group">
                    <label class="control-label col-sm-2">Total Images</label>
                    <div class="col-md-1">
                        <input required type="text" class="form-control" name="total_images" value="{{ $quiz->template->total_images or old('total_images') }}">
                    </div>
                    <label class="control-label col-sm-2">Total Textareas</label>
                    <div class="col-md-1">
                        <input required type="text" class="form-control" name="total_textareas" value="{{ $quiz->template->total_textareas or old('total_textareas') }}">
                    </div>

                    <label class="control-label col-sm-2">Has Title</label>
                    <div class="col-md-1">
                        <input type="checkbox" {{$quiz->template->has_title ? 'checked' : ''}} class="form-control" name="has_title">
                    </div>
                    <label class="control-label col-sm-2">Has Image Caption</label>
                    <div class="col-md-1">
                        <input type="checkbox" class="form-control" {{$quiz->template->has_image_caption ? 'checked' : ''}} name="has_image_caption">
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-sm-2">Input Html Code</label>
                    <div class="col-md-10">
                        <textarea class="form-control" id="html-edit-box" name="html_data" rows="10">{{ $quiz->template->html_data or '' }}</textarea>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-3 control-label">Upload Introduction Image</label>
                    <div class="col-md-9">
                        <input type="file" accept="image/*" name="og_image" onchange="readTemplate(this);" id="upload-button">
                    </div>
                    <div class="col-md-10 col-md-offset-2">
                        <fieldset class="text-center">
                            <legend>Image Preview</legend>
                            <div class="thumbnail" id="html-output">
                                <img src="{{asset(config('image.quiz_template_url').'/'.$quiz->template->og_image)}}" width="100%" height="200">
                            </div>
                        </fieldset>
                    </div>
                </div>
            </fieldset>
            <fieldset class="jumbotron">
                <legend>Quiz Information to Show</legend>
                <div class="form-group">
                    <label class="control-label col-md-2">Show Own Profile Image</label>
                    <div class="col-md-1">
                        <input type="checkbox" {{$quiz->show_own_profile_picture ? 'checked' : ''}} name="show_own_profile_picture" class="form-control" value="1">
                    </div>
                    <label class="control-label col-md-2">Show User Name</label>
                    <div class="col-md-1">
                        <input type="checkbox" {{$quiz->show_user_name ? 'checked' : ''}} name="show_user_name" class="form-control" value="1">
                    </div>
                    <label class="control-label col-md-2">Show Friends Pictures</label>
                    <div class="col-md-1">
                        <input type="checkbox" name="show_friend_pictures" class="form-control" value="1" {{$quiz->show_friend_pictures ? 'checked' : ''}}>
                    </div>
                    <label class="control-label col-md-2">Show Friend Names</label>
                    <div class="col-md-1">
                        <input type="checkbox" name="show_friend_name" class="form-control" value="1" {{$quiz->show_friend_name ? 'checked' : ''}}>
                    </div>
                </div>
                <span id="helpBlock" class="help-block">Kindly set these options as per the requirements for the quiz. It will help scripts to set data on quiz.</span>
            </fieldset>
            <fieldset class="jumbotron">
                <legend>Quiz Background Image</legend>
                <div class="form-group">
                    <label class="control-label col-md-3">Background Image</label>
                    <div class="col-md-9">
                        <input type="file" accept="image/*" name="background_image" onchange="backgroundPreview(this);">
                        <span id="helpBlock" class="help-block">If you want to use facts image as background then you may ignore this step.</span>
                    </div>
                    <div class="col-md-10 col-md-offset-2">
                        <fieldset class="text-center">
                            <legend>Image Preview</legend>
                            <div class="thumbnail" id="background-image-preview">
                                @if($quiz->background_image != '')
                                <img src="{{asset(config('image.quiz_background_url').'/'.$quiz->id.'/'.$quiz->background_image)}}" width="100%" height="200">
                                @endif
                            </div>
                        </fieldset>
                    </div>
                </div>
            </fieldset>
            <fieldset class="jumbotron">
                <legend>Quiz Fact</legend>
                <div id="quiz-form" class="form-group">
                    <div class="form-group">
                        <label class="control-label col-md-2">Total facts to show</label>
                        <div class="col-md-2">
                            <input type="number" name="total_facts" min="0" max="10" class="form-control" value="{{$quiz->total_facts or ''}}">
                        </div>
                        <div class="col-md-3 col-sm-3 col-xs-12 col-md-offset-1">
                            <button type="button" onclick="javascript:addFact();" class="btn btn-warning">Add New Fact</button>
                        </div>
                    </div>
                    <span class="help-block">There are a total of {{$quiz->facts->count()}} facts.</span>
                    @foreach($quiz->facts as $fact)
                        <div class="fact-list-item panel-body panel">
                            <div class="col-md-12">
                                <div  class="col-md-6 col-sm-6 col-xs-12">
                                    <input required name="fact[title][{{$fact->id}}]" class="form-control" value="{{ $fact->title }}">
                                </div>
                                <input type="file" name="image[{{$fact->id}}]" accept="image/*" class="col-md-3 col-sm-3 col-xs-6 fact-image" onchange="readFacts(this);">
                                <img height="100px" width="100px" src="{{ asset(config('image.quiz_facts_url').$quiz->id.'/'.$fact->image) }}" alt="Image Preview" />
                            </div>
                            <div class="col-md-12">
                                <div class="col-md-10 col-sm-10 col-xs-12">
                                    <input name="fact[description][{{$fact->id}}]" class="form-control" placeholder="Description (Optional)" value="{{ $fact->description }}">
                                </div>
                                <button type="button" onclick="javascript:addFact();" class="add-form-element btn btn-warning"><i class="fa fa-plus"></i></button>
                                <button type="button" class="remove-form-element btn btn-danger"><i class="fa fa-minus"></i></button>
                            </div>
                        </div>
                    @endforeach
                </div>
            </fieldset>
            <div class="form-group">
                <button type="submit" class="form-control btn btn-success btn-block" id="btn-login">Update Quiz</button>
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
        
        function addFact()
        {
            $.ajax({
                url: "{{ url('get-quiz-fact') }}",
                type: "GET",
                cache: false,
                success: function(data) {
                    $('#quiz-form').append(data);
                    activateRemoveButton();
                }
            })
        }

        function activateRemoveButton()
        {
            $('.remove-form-element').click(function () {
                $('.remove-form-element:focus').closest('.fact-list-item').remove();
            });
        }

        $(document).ready(function() {
            activateRemoveButton();
        });

        function readFacts(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();
                reader.fileName = input.files[0].name;
                reader.onload = function (e) {
                    $('input[type=file]').each(function(){
                        if (e.target.fileName === jQuery(this).val()) {
                            jQuery(this).next('img').attr('src', e.target.result);
                        }
                    })
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