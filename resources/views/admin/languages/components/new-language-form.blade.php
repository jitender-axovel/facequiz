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
                                        @foreach(trans('strings') as $string)
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