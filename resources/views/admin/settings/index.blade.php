
@extends('admin.layouts.app')

@section('page-css')
<style type="text/css">
	a{
		text-decoration: none;
	}
	.table-text-center th{
		text-align: center;
	}
	.table-text-center td{
		text-align: center;
	}
	tr:nth-child(even) {
		background-color: #dddddd;
	}
	.dataTables_filter{
		float: right;
	}
	.dataTables_paginate{
		float: right;
	}
</style>

@endsection

@section('content')

<!-- messages -->
<section class="content-header" style="margin-top: 0px">
	<div class="row">
		<div class="col-md-12">
			@if($errors->count() > 0 )

			<div class="alert alert-danger">
				<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
				<h6>The following errors have occurred:</h6>
				<ul>
					@foreach( $errors->all() as $message )
					<li>{{ $message }}</li>
					@endforeach
				</ul>
			</div>
			@endif

			@if(Session::has('message'))
			<div class="alert alert-info" role="alert">
				<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
				{{ Session::get('message') }}
			</div> 
			@endif

			@if(Session::has('errormessage'))
			<div class="alert alert-danger" role="alert">
				<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
				{{ Session::get('errormessage') }}
			</div>
			@endif

		</div>
	</div>
</section>
<!-- end messages -->

<!-- Main content -->
<section class="content">
	<div class="row">

		<div class="col-md-7">
			<div class="box box-success">
				<div class="box-header with-border"><h4 class="box-title">Website Settings</h4></div>
				<div class="box-body">
					
					<form class="form-horizontal" action="{{Route('settings.store')}}" method="post" enctype="multipart/form-data">
						<input type="hidden" name="_token" value="{{csrf_token()}}">
						<input type="hidden" name="id" id="id" value="1">
						<div class="form-group">
							<label class="col-sm-3 control-label">Site Name</label>
							<div class="col-sm-9">
								<input type="text" name="site_name" class="form-control" value="@if(!empty($setting->site_name)){{$setting->site_name}}@endif">
								<small>eg. Prothom Alo</small>
							</div>
						</div>
						<div class="form-group">
							<label class="col-sm-3 control-label">Logo</label>
							<div class="col-sm-9">
								<input type="file" name="logo" class="form-control">
							<img src="{{asset('logo')}}/{{setting()->logo}}" alt="logo" height="100px">
							</div>
						</div>
						<div class="form-group">
							<label class="col-sm-3 control-label">Favicon</label>
							<div class="col-sm-9">
								<input type="file" name="favicon" class="form-control">
								<img src="{{asset('favicon')}}/{{setting()->favicon}}" alt="favicon" height="50px">
							</div>
						</div>
						<div class="form-group">
							<label class="col-sm-3 control-label">Water Mark Image</label>
							<div class="col-sm-9">
								<input type="file" name="water_mark" class="form-control">
								<img src="{{asset('water_mark')}}/{{setting()->water_mark}}" alt="water_mark" height="50px">
							</div>
						</div>

						<div class="box-header with-border"><h4 class="box-title">SEO Settings</h4></div>

						<div class="form-group">
							<label class="col-sm-3 control-label">Meta Title</label>
							<div class="col-sm-9">
								<input type="text" name="meta_title" class="form-control" value="@if(!empty($setting->meta_title)){{$setting->meta_title}}@endif">
							</div>
						</div>
						<div class="form-group">
							<label class="col-sm-3 control-label">Meta description</label>
							<div class="col-sm-9">
								<textarea class="form-control" name="meta_description" cols="30" rows="10">@if(!empty($setting->meta_description)){{$setting->meta_description}}@endif</textarea>
							</div>
						</div>
						<div class="form-group">
							<label class="col-sm-3 control-label">Meta keywords</label>
							<div class="col-sm-9">
							<textarea class="form-control" name="meta_keywords" cols="30" rows="10">@if(!empty($setting->meta_keywords)){{$setting->meta_keywords}}@endif</textarea>
							</div>
						</div>

						<div class="box-footer">
							<button type="submit" class="btn btn-primary pull-right">Save</button>
						</div>
					</form>

				</div>
			</div>
		</div>

	</div>
</section>
<!-- /.content -->


@endsection

@section('page-scripts')

<script type="text/javascript">

	/*#############################
    ## Edit Category
    #############################*/
    $(document).on("click", ".openEditModal", function () {
    	var id = $(this).data('id');
    	var category_name = $(this).data('category');
    	$(".modal-body #id").val( id );
    	$(".modal-body #category_name").val( category_name );
    });

    /*###########################
	# Confirm Box
	#############################
	*/ 
	jQuery(function(){
		jQuery('.confirm_box').click(function(){
			var confirm_url = jQuery(this).data('confirm-url');
			console.log(confirm_url);
			if (confirm("Do You Want To Delete ?") == true) {
				window.location.href=confirm_url;
			}
		});
	});

	/*##########################################
	# change status
	############################################
	*/

	jQuery(function(){
		jQuery('.changeStatus').click(function(){

			var id = jQuery(this).data('id');
			var status = jQuery(this).data('status');
			var site_url = jQuery('.site_url').val();
			var request_url = site_url+'/ajax/category/change-status/'+id+'/'+status;

			jQuery.ajax({
				url: request_url,
				type: "get",
				success:function(data){
					location.reload();
				}
			});
		});
	});


	// data tables
	$(document).ready(function() {
		$('#category-dataTable').DataTable();
	} );

</script>
@endsection