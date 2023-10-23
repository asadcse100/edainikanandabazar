
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

		<!-- edition list -->
		<div class="col-md-7">
			<div class="box box-success">
				<div class="box-header with-border"><h4 class="box-title">Edition List</h4></div>
				<div class="box-body">
					
					<table class="table table-bordered table-hover table-text-center" id="edition-dataTable">
						<thead>
							<tr>
								<th>SL</th>
								<th>Edition Name</th>
								<th>Edition Title</th>
								<th>Crt. Date</th>
								<th>Crt. By</th>
								<th>Status</th>
								<th>Action</th>
							</tr>
						</thead>
						<tbody>
							@if(!empty($edition_list) && (count($edition_list)>0))
							@foreach($edition_list as $key => $list)
							<tr>
								<td>{{$key+1}}</td>
								<td>{{$list->name}}</td>
								<td>{{$list->title}}</td>
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
									<button type="button" class="btn btn-info btn-xs openEditModal" data-toggle="modal" data-target="#editEdition" data-id="{{$list->id}}" data-name="{{$list->name}}" data-title="{{$list->title}}"><i class="fa fa-edit"></i></button>

									<button type="button " data-confirm-url="{{url('/edition/delete',$list->id)}}"  class="btn btn-danger btn-xs confirm_box"><i class="fa fa-trash"></i></button>
								</td>
							</tr>
							@endforeach
							@else
							@endif
						</tbody>
					</table>

				</div>
			</div>
		</div>
		<!-- end edition list -->

		<div class="col-md-5">
			<div class="box box-success">
				<div class="box-header with-border"><h4 class="box-title">Add New Edition</h4></div>
				<div class="box-body">
					
					<form class="form-horizontal" action="{{url('/edition/create')}}" method="post" enctype="multipart/form-data">
						<input type="hidden" name="_token" value="{{csrf_token()}}">

						<div class="form-group">
							<label class="col-sm-3 control-label">Edition Name</label>
							<div class="col-sm-9">
								<input type="text" name="edition_name" class="form-control" placeholder="Edition Name" required="required">
							</div>
						</div>

						<div class="form-group">
							<label class="col-sm-3 control-label">Edition Title</label>
							<div class="col-sm-9">
								<input type="text" name="edition_title" class="form-control" placeholder="Edition Title" required="required">
							</div>
						</div>

						<div class="box-footer">
							<button type="submit" class="btn btn-primary pull-right">Save Edition !</button>
						</div>

						
					</form>

				</div>
			</div>
		</div>

	</div>
</section>
<!-- /.content -->

<!-- edit modal -->
<div class="modal fade" id="editEdition" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title" id="exampleModalLabel">Update Category</h4>
			</div>


			<form class="form-horizontal" action="{{url('/edition/update')}}" method="post" enctype="multipart/form-data">
				<input type="hidden" name="_token" value="{{csrf_token()}}">

				<div class="modal-body">
					<div class="form-group">
						<label class="col-sm-3 control-label">Edition Name</label>
						<div class="col-sm-9">
						<input type="text" name="edition_name" id="name" class="form-control" placeholder="Edition Name" required="required">
						</div>
					</div>

					<div class="form-group">
						<label class="col-sm-3 control-label">Edition Title</label>
						<div class="col-sm-9">
							<input type="text" name="edition_title" id="title" class="form-control" placeholder="Edition Title" required="required">
						</div>
					</div>
					<input type="hidden" name="edition_id" id="id" required="">
				</div>

				<div class="modal-footer">
					<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
					<button type="submit" class="btn btn-primary">Update Edition !</button>
				</div>

			</form>

			

		</div>
	</div>
</div>
<!-- end edit modal -->

@endsection

@section('page-scripts')
<script type="text/javascript">

	/*#############################
    ## Edit Edition
    #############################*/
    $(document).on("click", ".openEditModal", function () {
    	var id = $(this).data('id');
    	var name = $(this).data('name');
    	var title = $(this).data('title');
    	$(".modal-body #id").val( id );
    	$(".modal-body #name").val( name );
    	$(".modal-body #title").val( title );
    });

    /*###########################
	# Confirm Box
	#############################
	*/ 
	jQuery(function(){

		jQuery('.confirm_box').click(function(){

			var confirm_url=jQuery(this).data('confirm-url');
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
			var request_url = site_url+'/ajax/edition/change-status/'+id+'/'+status;

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
		$('#edition-dataTable').DataTable();
	} );

</script>
@endsection