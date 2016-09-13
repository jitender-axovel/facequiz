<div class="panel panel-default">
        <div class="panel-heading">
                <div class="panel-title">Language Name</div>
        </div>
        <div class="panel-body">
                <form action="{{ url('admin/language') }}" method="post">
                        {{csrf_field()}}
                        <div class="form-group">
                                <label>Language Name</label>
                                <input name="name" class="form-control" value="{{ old('name') }}">
                        </div>
                        <div class="form-group">
                                <label>Language Code (example: en, es, etc.)</label>
                                <input name="code" class="form-control" value="{{ old('code') }}">
                        </div>
                        <div class="form-group">
                                <label>Facebook Page ID</label>
                                <input name="fb_page_code" class="form-control" value="{{ old('fb_page_code') }}">
                        </div>
                        <div class="form-group">
                                <label>Facebook Like Button Code</label>
                                <textarea name="fb_like" class="form-control" >{{ old('fb_like') }}</textarea>
                        </div>
                        <div class="form-group">
                                <label>Facebook Widget Code</label>
                                <textarea name="fb_widget" class="form-control">{{ old('fb_widget') }}</textarea>
                        </div>
                        <div class="form-group">
                                <label>Facebook Locale Code (example: en_US, es_ES, etc.)</label>
                                <input name="fb_code" class="form-control" value="{{ old('fb_code') }}">
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
                                        @foreach(trans('strings') as $k => $string)
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