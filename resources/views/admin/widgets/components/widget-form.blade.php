<div class="panel panel-default">
	<div class="panel-heading">
		<div class="col-md-9 text-left">
			<div class="panel-title">{{isset($widgetTitle) ? $widgetTitle : 'New Widget'}}</div>
		</div>
		<div class="col-ma-3 text-right">
			<a data-toggle="collapse" class="collapse-toggle"><i class="fa fa-pencil-square-o fa-2x"></i></a>
		</div>
	</div>
	<div class="panel-body collapse">
		<div class="form-group">
			<label>Widget Title</label>
			<div>
				<input type="text" name="{{$slug}}Widget[Title][]" class="form-control" value="{{isset($widgetTitle) ? $widgetTitle : 'New Widget'}}">
				<span id="helpBlock" class="help-block">This will not be displayed to user. It is only for your reference.</span>
			</div>
		</div>
		<div class="form-group">
			<label>Widget Content</label>
			<div>
				<textarea name="{{$slug}}Widget[Content][]" class="form-control">{{isset($widgetContent) ? $widgetContent : ''}}</textarea>
			</div>
		</div>
		<div class="form-group">
			<button type="submit" class="btn btn-success"><i class="fa fa-save"></i> Save Changes</button>
			<button type="button" class="btn btn-danger delete-button"><i class="fa fa-"></i> Delete</button>
		</div>
	</div>
</div>