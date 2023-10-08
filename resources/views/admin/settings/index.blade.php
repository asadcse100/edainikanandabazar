
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

						<div class="box-footer">
							<button type="submit" class="btn btn-primary pull-right">Save</button>
						</div>
					</form>

				</div>
			</div>
		</div>

		<!-- category list -->
		<!-- <div class="col-md-7">
			<div class="box box-success">
				<div class="box-header with-border"><h4 class="box-title">Category List</h4></div>
				<div class="box-body">
					
					<table class="table table-bordered table-hover table-text-center" id="category-dataTable">
						<thead>
							<tr>
								<th>SL</th>
								<th>Category Title</th>
								<th>Crt. Date</th>
								<th>Crt. By</th>
								<th>Status</th>
								<th>Action</th>
							</tr>
						</thead>
						<tbody>
							@if(!empty($category_list) && (count($category_list)>0))
							@foreach($category_list as $key => $list)
							<tr>
								<td>{{$key+1}}</td>
								<td>{{$list->name}}</td>
								<td>{{ date("d-M-y", strtotime($list->created_at))}}</td>
								<td><b>{{$list->creator_name}}</b></td>
								<td>
									@if(isset($list->status) && ($list->status==1))
									<button type="button" data-id="{{$list->id}}" data-status="0" class="btn btn-default btn-xs changeStatus"><i class="fa fa-check"></i></button>
									@else
									<button type="button" data-id="{{$list->id}}" data-status="1" class="btn btn-danger btn-xs changeStatus"><i class="fa fa-times"></i></button>
									@endif
								</td>
								<td>
									<button type="button" class="btn btn-info btn-xs openEditModal" data-toggle="modal" data-target="#editCategory" data-id="{{$list->id}}" data-category="{{$list->name}}"><i class="fa fa-edit"></i></button>

									<button type="button" data-confirm-url="{{url('/category/delete',$list->id)}}"  class="btn btn-danger btn-xs confirm_box"><i class="fa fa-trash"></i></button>
								</td>
							</tr>
							@endforeach
							@endif
						</tbody>
					</table>

				</div>
			</div>
		</div> -->
		<!-- end category list -->


	</div>
</section>
<!-- /.content -->

<!-- edit modal -->
<!-- <div class="modal fade" id="editCategory" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title" id="exampleModalLabel">Update Category</h4>
			</div>
			<form class="form-horizontal" action="{{url('/category/update')}}" method="post" enctype="multipart/form-data">
				<input type="hidden" name="_token" value="{{csrf_token()}}">
				<div class="modal-body">
					<div class="form-group">
						<label class="col-sm-3 control-label">Category Title</label>
						<div class="col-sm-9">
							<input type="text" name="category_name" id="category_name" class="form-control" required="required">
							<input type="hidden" name="category_id" id="id">
						</div>
					</div>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
					<button type="submit" class="btn btn-primary">Update Category !</button>
				</div>
			</form>
		</div>
	</div>
</div> -->
<!-- end edit modal -->

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