
@extends('admin.layouts.app')

@section('page-css')
<style type="text/css">

	.table-text-center th{
		text-align: center;
	}
	.table-text-center td{
		text-align: center;
	}
	/*tr:nth-child(even) {
		background-color: #dddddd;
	}*/
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
				<div class="box-header with-border"><h4 class="box-title">User Management</h4> <button type="button" data-toggle="modal" data-target="#addNewUser" class="btn btn-primary btn-xs pull-right"><i class="fa fa-plus"></i> Add New</button></div>
				<div class="box-body">

					<table class="table table-bordered table-hover table-text-center" id="user-dataTable">
						<thead>
							<tr>
								<th>SL</th>
								<th>Photo</th>
								<th>Name</th>
								<th>Role</th>
								<th>Email</th>
								<th>Status</th>
								<th>Action</th>
							</tr>
						</thead>

						<tbody>
							@if(!empty($users_info) && (count($users_info)>0))
							@foreach($users_info as $key => $list)
							<tr>
								<td style="vertical-align: middle;">{{$key+1}}</td>
								<td style="vertical-align: middle;">
									@if(!empty($list->user_image))
									<img src="{{asset('admin/assets/images/avatars/'.$list->user_image)}}" style="height: 40px;width: 40px;border-radius: 100%">
									@else
									<img src="{{asset('admin/assets/images/avatars/default_avatar.png')}}" style="height: 40px;width: 40px;border-radius: 100%">
									@endif
								</td>
								<td style="vertical-align: middle;">{{$list->name}}</td>
								<td style="vertical-align: middle;">{{$list->role}}</td>
								<td style="vertical-align: middle;">{{$list->email}}</td>
								<td style="vertical-align: middle;">
									@if($list->user_status=='1')
									<button type="button" class="btn btn-success btn-xs">Active</button>
									@else
									<button type="button" class="btn btn-danger btn-xs">Blocked</button>
									@endif
								</td>
								<td style="vertical-align: middle;">
									<button type="button" data-toggle="modal" data-target="#updateUser" class="btn btn-info btn-xs openEditModal" data-id="{{$list->id}}" data-name="{{$list->name}}" data-role="{{$list->role}}" data-email="{{$list->email}}" data-status="{{$list->user_status}}"><i class="fa fa-edit"></i></button>
								</td>
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
<!-- End Main content -->


<!-- add new user modal -->
<div class="modal fade" id="addNewUser" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title" id="exampleModalLabel">Add New User</h4>
			</div>

			<form class="form-horizontal" action="{{url('/user/create')}}" method="post" enctype="multipart/form-data">
				<input type="hidden" name="_token" value="{{csrf_token()}}">

				<div class="modal-body">
					<div class="form-group">
						<label class="col-sm-3 control-label">Name</label>
						<div class="col-sm-9">
							<input type="text" name="name" class="form-control" placeholder="Full Name" required="required">
						</div>
					</div>

					<div class="form-group">
						<label class="col-sm-3 control-label">Role</label>
						<div class="col-sm-9">
							<select class="form-control" name="role" required="required">
								<option value="operator">Operator</option>
								<option value="admin">Admin</option>
							</select>
						</div>
					</div>

					<div class="form-group">
						<label class="col-sm-3 control-label">Email</label>
						<div class="col-sm-9">
							<input type="email" name="email" class="form-control" placeholder="Email" required="required">
						</div>
					</div>

					<div class="form-group">
						<label class="col-sm-3 control-label">Password</label>
						<div class="col-sm-9">
							<input type="password" name="password" class="form-control" required="required" autocomplete="off">
						</div>
					</div>

					<div class="form-group">
						<label class="col-sm-3 control-label">Photo</label>
						<div class="col-sm-9">
							<input type="file" name="user_image" class="form-control">
						</div>
					</div>

				</div>

				<div class="modal-footer">
					<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
					<button type="submit" class="btn btn-primary">Save New User !</button>
				</div>
			</form>
		</div>
	</div>
</div>
<!-- end add new user modal -->


<!-- edit user modal -->
<div class="modal fade" id="updateUser" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title" id="exampleModalLabel">Update User Information</h4>
			</div>

			<form class="form-horizontal" action="{{url('/user/update')}}" method="post" enctype="multipart/form-data">
				<input type="hidden" name="_token" value="{{csrf_token()}}">
				<input type="hidden" name="user_id" id="id" value="">

				<div class="modal-body">
					<div class="form-group">
						<label class="col-sm-3 control-label">Name</label>
						<div class="col-sm-9">
							<input type="text" name="name" id="name" class="form-control" placeholder="Full Name" required="required">
						</div>
					</div>

					<div class="form-group">
						<label class="col-sm-3 control-label">Role</label>
						<div class="col-sm-9">
							<select class="form-control" name="role" id="role" required="required">
								<option value="operator">Operator</option>
								<option value="admin">Admin</option>
							</select>
						</div>
					</div>

					<div class="form-group">
						<label class="col-sm-3 control-label">Email</label>
						<div class="col-sm-9">
							<input type="email" name="email" id="email" class="form-control" placeholder="Email" required="required">
						</div>
					</div>

					<div class="form-group">
						<label class="col-sm-3 control-label">Password</label>
						<div class="col-sm-9">
							<input type="text" name="password" class="form-control" autocomplete="off">
						</div>
					</div>

					<div class="form-group">
						<label class="col-sm-3 control-label">Status</label>
						<div class="col-sm-9">
						<select class="form-control" name="user_status" id="status" required="required">
								<option value="1">Active</option>
								<option value="0">Blocked</option>
							</select>
						</div>
					</div>

				</div>

				<div class="modal-footer">
					<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
					<button type="submit" class="btn btn-primary">Update User !</button>
				</div>
			</form>
		</div>
	</div>
</div>
<!-- end edit user modal -->

@endsection

@section('page-scripts')
<script type="text/javascript">
	/*#############################
    ## Edit User
    #############################*/
    $(document).on("click", ".openEditModal", function () {
    	var id = $(this).data('id');
    	var name = $(this).data('name');
    	var role = $(this).data('role');
    	var email = $(this).data('email');
    	var status = $(this).data('status');
    	$(".modal-content #id").val( id );
    	$(".modal-content #name").val( name );
    	$(".modal-content #role").val( role );
    	$(".modal-content #email").val( email );
    	$(".modal-content #status").val( status );
    });

    // data tables
	$(document).ready(function() {
		$('#user-dataTable').DataTable();
	} );
</script>
@endsection