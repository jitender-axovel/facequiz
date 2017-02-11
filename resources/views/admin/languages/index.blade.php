@extends('admin.layouts.app')
@section('content')
	<div class="col-md-10 col-md-offset-1">
		<div id="ajax-loading-section">
        	<div class="loading-overlay"></div>
        	<div class="loading-image">
        		<img src="{{ asset('images/tla-loader.gif') }}">
        		<span class="loading-text"> Loading....</span>
        	</div>
        </div>
		<h2 class="user-heading">Language</h2>
		@include('notification')
		<div id="language-list">
			@include('admin.languages.language-list', array('languages' => $languages))
		</div>
        <a class="btn btn-warning" onclick="javascript:showLanguageForm();"><i class="fa fa-plus-circle"></i> Add new Language</a>
        <div class="language-form"></div>
	</div>
@endsection
@section('admin-scripts')
    <script type="text/javascript">
        $.ajaxSetup({
	        headers: {
	            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
	        }
		});

		$(document).ajaxStart(function() {
            $("#ajax-loading-section").show();
        });
        $(document).ajaxStop(function() {
            $("#ajax-loading-section").hide();
        });

        function showLanguageForm()
        {
            $.ajax({
                url: "{{url('admin/get-language-form')}}",
                type: "GET",
                success: function(data) {
                    $('.language-form').html(data);
                }
            });
        }

        function changeOrder(id, order)
        {
        	$.ajax({
        		url: "{{ url('admin/language') }}" + '/' + id + '/order/' + order,
        		type: "GET",
        		success: function(data) {
        			$("#language-list").html(data);
        		}
        	});
        }

		function deleteLanguage(id, name)
		{
			swal({
				title: "Are you sure?",
				text: "You want to delete "+name,
				type: "warning",
				showCancelButton: true,
				confirmButtonColor: "#DD6B55",
				confirmButtonText: "Yes, delete it!",
				cancelButtonText: "No, cancel pls!",
				closeOnConfirm: false,
				closeOnCancel: false,
				allowEscapeKey: false,
			},
			function(isConfirm){
				if(isConfirm) {
					$.ajax({
						url: "{{ url('admin/language') }}" + '/' + id + '/delete',
						type: 'DELETE',
						success: function(data) {
							data = JSON.parse(data);
							if(data['status']) {
								swal({
									title: data['message'],
									text: "Press ok to continue",
									type: "success",
									showCancelButton: false,
									confirmButtonColor: "#DD6B55",
									confirmButtonText: "Ok",
									closeOnConfirm: false,
									allowEscapeKey: false,
								},
								function(isConfirm){
									if(isConfirm) {
										window.location.reload();
									}
								});
							} else {
								swal("Error", data['message'], "error");
							}
						}
					});
				} else {
					swal("Cancelled", name+" quiz will not be deleted.", "error");
				}
			});
		}
    </script>
@endsection
