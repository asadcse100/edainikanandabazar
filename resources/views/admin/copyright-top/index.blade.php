
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
		<div class="col-md-12">
			<div class="box box-success">
				<div class="box-header with-border"><h4 class="box-title">Manage Advertisements</h4></div>
				<div class="box-body">

					<table class="table table-bordered table-hover table-text-center" id="ad-dataTable">
						<thead>
							<tr>
								<th>SL</th>
								<th>Position</th>
								<th>Size</th>
								<th>Status</th>
								<th>Active From</th>
								<th>Last Active</th>
								<th>Action</th>
							</tr>
						</thead>

						<tbody>
							@if(!empty($advertisements) && (count($advertisements)>0))
							@foreach($advertisements as $key => $advertisement)
							<tr>
								<td >{{$key+1}}</td>
								<td >{{$advertisement->ad_position}}</td>
								<td >{{$advertisement->ad_size}}</td>
								<td >
									@if($advertisement->ad_status == 1)
									<button type="button" class="btn btn-success btn-xs" style="width: 60px">Active</button>
									@else
									<button type="button" class="btn btn-danger btn-xs" style="width: 60px">Inactive</button>
									@endif

								</td>
								<td >
									{{$advertisement->active_from}}
								</td>
								<td >
									{{$advertisement->active_upto}}
								</td>
								<td><a data-toggle="modal" data-code="{{$advertisement->ad_code}}" data-status="{{$advertisement->ad_status}}" data-id="{{$advertisement->id}}" class="btn btn-info btn-xs open-editAdModal" href="#editAdModal"><i class="fa fa-edit"></i></a></td>
							</tr>
							@endforeach
							@endif
						</tbody>
					</table>
					
				</div>
			</div>
		</div>
	</div>
</section>
<!-- /.content -->



<!-- Edit Modal -->
<div id="editAdModal" class="modal fade" role="dialog">
	<div class="modal-dialog">
		<!-- Modal content-->
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal">&times;</button>
				<h4 class="modal-title">Update Advertisement</h4>
			</div>
			<div class="modal-body">
				<form role="form" class="form-horizontal" method="post" action="{{url('/advertisement/update')}}" enctype="multipart/form-data">

					<input type="hidden" name="_token" value="{{csrf_token()}}"/>
					<input type="hidden" name="ad_id" id="ad" value=""/>

					<div class="form-group">
						<div class="col-sm-offset-1 col-sm-4">
							<label class="control-label"><b>Advertisement Status</b></label>
						</div>
						<div class="col-sm-6">
							<select class="form-control" name="ad_status" id="ad_status" required >
								<option value="1" selected>Publish</option>
								<option value="0">Unpublish</option>
							</select>
						</div>
					</div>


					<div class="form-group">
						<div class="col-sm-offset-1 col-sm-4">
							<label class="control-label"><b>Advertisement Code</b></label>
						</div>
						<div class="col-sm-6">
							<textarea class="form-control" rows="3" name="ad_code" id="ad_code" required></textarea>
						</div>
					</div>


					<div class="form-group">
						<div class="col-sm-6 col-sm-offset-5">
							<button type="submit" class="btn btn-primary btn-block">Save Advertisement !</button>
						</div>
					</div>
				</form>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
			</div>
		</div>
	</div>
</div>
<!-- End Edit Modal -->

@endsection

@section('page-scripts')

<script type="text/javascript">

	$(document).on("click", ".open-editAdModal", function () {
		var ad_id = $(this).data('id');
		var ad_code = $(this).data('code');
		var ad_status = $(this).data('status');

		$(".modal-body #ad").val( ad_id );
		$(".modal-body #ad_code").val( ad_code );
		$(".modal-body #ad_status").val( ad_status );
	});

	// data tables
	$(document).ready(function() {
		$('#ad-dataTable').DataTable();
	} );

</script>
@endsection