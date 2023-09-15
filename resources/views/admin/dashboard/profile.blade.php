@extends('admin.layouts.app')

@section('content')

<!-- messages -->
<section class="content-header">
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


<section class="content">
	<div class="row">
		<div class="col-md-4">
			<!-- Profile Image -->
			<div class="box box-primary">
				<div class="box-body box-profile">
					@if(!empty(\Auth::user()->user_image))
					<img class="profile-user-img img-responsive img-circle" src="{{asset('admin/assets/images/avatars/'.\Auth::user()->user_image)}}" alt="User Avatar">
					@else
					<img class="profile-user-img img-responsive img-circle" src="{{asset('admin/assets/images/avatars/default_avatar.png')}}" alt="User Avatar">
					@endif
					<h3 class="profile-username text-center">{{isset($user_info->name) ? $user_info->name : ''}}</h3>

					<p class="text-muted text-center">ePaper {{isset($user_info->role) ? $user_info->role : ''}}</p>

					<ul class="list-group list-group-unbordered">
						<li class="list-group-item">
							<b>Name</b> <a class="pull-right">{{ucfirst($user_info->name)}}</a>
						</li>
						<li class="list-group-item">
							<b>Position</b> <a class="pull-right">{{ucfirst($user_info->role)}}</a>
						</li>
						<li class="list-group-item">
							<b>Mobile</b> <a class="pull-right">{{!empty($user_info->mobile) ? $user_info->mobile : 'NA'}}</a>
						</li>
						<li class="list-group-item">
							<b>Address</b> <a class="pull-right">{{!empty($user_info->address) ? $user_info->address : 'NA'}}</a>
						</li>
						<li class="list-group-item">
							<b>Active From</b> <a class="pull-right">{{date('d M Y',strtotime($user_info->created_at))}}</a>
						</li>
					</ul>
				</div>
				<!-- /.box-body -->
			</div>
			<!-- /.box -->
		</div>

		<div class="col-md-8">
			<!-- About Me Box -->
			<div class="box box-primary">
				<div class="box-header with-border">
					<h3 class="box-title">Update Information</h3>
				</div>
				<!-- /.box-header -->
				<div class="box-body">
					<form action="{{url('/profile/update')}}" method="post" enctype="multipart/form-data">
						<input type="hidden" name="_token" value="{{csrf_token()}}">

						<strong><i class="fa fa-user"></i> Full Name</strong>

						<p class="text-muted">
							<input type="text" name="name" value="{{$user_info->name}}" class="form-control">
						</p>

						<hr>

						<strong><i class="fa fa-phone"></i> Mobile No.</strong>

						<p class="text-muted"><input type="text" name="mobile" value="{{$user_info->mobile}}" class="form-control"></p>

						<hr>

						<strong><i class="fa fa-map-marker"></i> Address</strong>

						<p>
							<textarea name="address" class="form-control">{{$user_info->address}}</textarea>
						</p>

						<hr>

						<strong><i class="fa fa-lock"></i> Password</strong>

						<p>
							<input name="password" type="text" class="form-control">
						</p>

						<hr>
						<button type="submit" class="btn btn-primary pull-right">Update Information ! <i class="fa fa-arrow-circle-o-right"></i></button>

					</form>
				</div>
				<!-- /.box-body -->
			</div>
			<!-- /.box -->
		</div>

	</div>
</section>



@endsection