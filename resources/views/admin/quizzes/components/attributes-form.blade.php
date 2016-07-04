<div class="form-group fact-list-item">
	<div class="col-sm-3">
		<input required name="fact[title][]" class="form-control" placeholder="Title"></input>
	</div>
	<div class="col-sm-4">
		<input required name="fact[description][]" class="form-control" placeholder="Description (Optional)"></input>
	</div>
	<input type="file" name="image[]" accept="image/*" class="col-sm-2" onchange="readURL(this);"></input>
	<img height="100px" width="100px" src="#" alt="" />
	<button type="button" class="add-form-element btn btn-warning"><i class="fa fa-plus"></i></button>
	<button type="button" class="remove-form-element btn btn-danger"><i class="fa fa-minus"></i></button>
</div>
<script type="text/javascript">
	$('.add-form-element').click(function() {
    	$('.fact-list-item').first(true).clone().appendTo('#quiz-form');
    });

    $('.remove-form-element').click(function() {
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