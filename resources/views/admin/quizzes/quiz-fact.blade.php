<div class="fact-list-item panel-body panel">
    <div class="col-md-12">
        <div  class="col-md-6 col-sm-6 col-xs-12">
            <input required name="fact[title][]" class="form-control" placeholder="Title">
        </div>
        <input type="file" name="image[]" accept="image/*" class="col-md-3 col-sm-3 col-xs-6 fact-image" onchange="readFacts(this);">
        <img height="100px" width="100px" src="" alt="Image Preview" />
    </div>
    <div class="col-md-12">
        <div class="col-md-10 col-sm-10 col-xs-12">
            <input name="fact[description][]" class="form-control" placeholder="Description (Optional)">
        </div>
        <button type="button" onclick="javascript:addFact();" class="add-form-element btn btn-warning"><i class="fa fa-plus"></i></button>
        <button type="button" class="remove-form-element btn btn-danger"><i class="fa fa-minus"></i></button>
    </div>
</div>