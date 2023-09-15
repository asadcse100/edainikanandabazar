@extends('admin.layouts.app')

@section('page-css')
<link rel="stylesheet" type="text/css" href="{{asset('admin/assets/image-mapping/css/jquery.Jcrop.min.css')}}">
<style type="text/css">
	.table-text-center th{
		text-align: center;
		vertical-align: middle;
	}
	.table-text-center td{
		text-align: center;
	}

	.select_related_image ul {
		list-style-type: none;
	}

	.select_related_image li {
		display: inline-block;
	}

	.select_related_image input[type="radio"][id^="cb"] {
		display: none;
	}

	.select_related_image label {
		border: 1px solid #fff;
		padding: 10px;
		display: block;
		position: relative;
		margin: 10px;
		cursor: pointer;
	}

	.select_related_image label:before {
		background-color: white;
		color: white;
		content: " ";
		display: block;
		border-radius: 50%;
		border: 1px solid grey;
		position: absolute;
		top: -5px;
		left: -5px;
		width: 25px;
		height: 25px;
		text-align: center;
		line-height: 28px;
		transition-duration: 0.4s;
		transform: scale(0);
	}

	.select_related_image label img {
		height: 100px;
		width: 100px;
		transition-duration: 0.2s;
		transform-origin: 50% 50%;
	}

	:checked + label {
		border-color: #ddd;
	}

	:checked + label:before {
		content: "✓";
		background-color: grey;
		transform: scale(1);
	}

	:checked + label img {
		transform: scale(0.9);
		box-shadow: 0 0 5px #333;
		z-index: -1;
	}


	/*scrollbar*/
	#doublescroll
	{
		overflow: auto; overflow-y: hidden; 
	}
	#doublescroll p
	{
		margin: 0; 
		padding: 1em; 
		white-space: nowrap; 
	}

	.img:hover{
		opacity: 0.3;
	}
</style>
@endsection

@section('content')

<!-- Content Header (Page header) -->
<!-- <section class="content-header">
	<h1>
		Image Mapping Page
		<small>ePaper image mapping.</small>
	</h1>
	<ol class="breadcrumb">
		<li><a href="{{url('/home')}}"><i class="fa fa-dashboard"></i> Home</a></li>
		<li><a href="{{url('/manage-pages?&date='.date('d-m-Y',strtotime($page_info->publish_date)))}}">Pages</a></li>
		<li class="active">Mapping</li>
	</ol>
</section>
-->

<!-- messages -->
<!-- <section class="content-header" style="margin-top: 20px">
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
</section> -->
<!-- end messages -->


<!-- Main content -->
<section class="content" style="margin-top: 50px;">
	<div class="row">
		<div class="col-md-12">
			<div class="box box-success" style="border-top: none;">
				
				<div class="box-body" style="padding-top: 0px">
					@if(!empty($page_info))
					<form action="{{url('/image-mapping/crop-image',$page_info->page_id)}}" method="post" enctype="multipart/form-data">
						<input type="hidden" name="_token" value="{{csrf_token()}}">

						<div class="row" style="position: fixed;z-index: 1000;border-top: 5px solid white;padding: 0px 5px;border-radius: 0px;top: 50px;width: 70%;">
							<div class="col-md-12" style="background-color: #3C8DBC;">
								<table class="table" style="margin-bottom: 0px">
									<tbody>
										<tr>
											<td style="border-top: none;">
												<input type="text" class="form-control" id="code-result" name="coords" value="" readonly="" required="" placeholder="Coords" />
											</td>
											<td style="border-top: none;">
												<select class="form-control get_relation relation" name="relation">
													<option value="no">No Relation</option>
													<option value="next">Have Next</option>
													<option value="previous">Have Previous</option>
												</select>
											</td>
											<td style="border-top: none;">
												<select class="form-control get_relation page_no" name="related_page_no">
													<option value="">--Related Page Number--</option>
													@for ($i = 01; $i <= 200; $i++) 
													<option value="{{$i}}">Page {{$i}}</option>
													@endfor
												</select>
											</td>
											<td class="" style="border-top: none;">
												<button type="button" class="btn btn-success select_related_item ajax_select_image_relation" data-toggle="modal" data-target="#SelectLinkedImage" style="display: none;" data-image-date="{{$page_info->publish_date}}">Select Related Image</button> &nbsp;
												<button type="submit" class="btn btn-success">Save Page !</button>
											</td>
										</tr>
									</tbody>
								</table>
							</div>
						</div>

						@if(!empty($page_info))
						<div id="doublescroll" style="margin-top: 60px">
							@php
							$file_location=0;

							$map_image_directory='uploads/temp/'.date('Y',strtotime($page_info->publish_date)).'/'.date('m',strtotime($page_info->publish_date)).'/'.date('d',strtotime($page_info->publish_date)).'/original-pages/'.$page_info->image;
							if(file_exists($map_image_directory)){
							list($main_img_width, $main_img_height, $type, $attr) = getimagesize($map_image_directory);
							
						}else{
						$file_location=1;

						$map_image_directory='uploads/epaper/'.date('Y',strtotime($page_info->publish_date)).'/'.date('m',strtotime($page_info->publish_date)).'/'.date('d',strtotime($page_info->publish_date)).'/pages/'.$page_info->image;
					}
					
					@endphp

					<center>
						<div style="position: relative;">
							<img src="{{asset($map_image_directory)}}" class="img image-responsive image-mapper-img" style="padding:0;margin: 0;" id="jcrop_target">


							@if(!empty($image_list) && (count($image_list)>0) && ($file_location==0))
							@foreach($image_list as $key => $images)

							@php
							$coords_array = explode(',', $images->coords);
							$overlay_height=$coords_array[0];

							$x1=($coords_array[0]*$main_img_width)/700;
							$y1=($coords_array[1]*$main_img_height)/910;
							$x2=($coords_array[2]*$main_img_width)/700;
							$y2=($coords_array[3]*$main_img_height)/910;

							$overlay_width=$x2-$x1;
							$overlay_height=$y2-$y1;

							@endphp

							<div style="width: {{$overlay_width}}px;height: {{$overlay_height}}px;position: absolute;left: {{$x1}}px;top: {{$y1}}px;background-color: black;opacity: .3">
							</div>

							@endforeach
							@endif

						</div>
					</center>

				</div>
				<input type="hidden" name="page_publish_date" value="{{$page_info->publish_date}}">
				<input type="hidden" name="page_image" value="{{$page_info->image}}">
				@endif

				<!-- Select Relation Modal -->
				<div class="modal fade" id="SelectLinkedImage" role="dialog">
					<div class="modal-dialog modal-lg">
						<!-- Modal content-->
						<div class="modal-content">
							<div class="modal-header">
								<button type="button" class="close" data-dismiss="modal">&times;</button>
								<h4 class="modal-title">Link Related Images</h4>
							</div>
							<div class="ajax_image_relation_modal_view"></div>
						</div>
					</div>
				</div>
				<!-- End Select Relation Modal -->

			</form>

			@else
			<div class="alert alert-success text-center">No Page Found !</div>
			@endif
			<hr>

			<table class="table table-bordered table-hover table-text-center">
				<thead>
					<tr>
						<th>SL</th>
						<th>Cropped Image</th>
						<th>Image ID</th>
						<th>Relation</th>
						<th>Select Linked Image</th>
						<th>Action</th>
					</tr>
				</thead>
				<tbody>
					@if(!empty($image_list) && (count($image_list)>0))
					@foreach($image_list as $key => $images)
					<tr>
						<td style="vertical-align: middle;">{{$key+1}}</td>
						<td style="vertical-align: middle;">
							<img src="{{$up_dir.$uploads_path.date('Y',strtotime($page_info->publish_date)).'/'.date('m',strtotime($page_info->publish_date)).'/'.date('d',strtotime($page_info->publish_date)).'/images/'.$images->image}}" class=" image-responsive" style="height: 150px;width: 150px">
							
						</td>
						<td style="vertical-align: middle;">{{$images->id}}</td>
						<td style="vertical-align: middle;">{{ucfirst($images->relation)}}</td>
						<td style="vertical-align: middle;">
							<button type="button" class="btn btn-info btn-sm ajax_image_relation_update" data-toggle="modal" data-target="#LinkedImageUpdate" data-image-date="{{$page_info->publish_date}}" data-related-page="{{$images->related_page_no}}" data-image-id="{{$images->id}}" data-related-image="{{$images->id}}" data-relation-type="{{$images->relation}}" {{isset($images) && ($images->relation=='no') ? 'disabled' : ''}}>Select Linked Image</button>

							@if($images->image_status==1)
							<button data-toggletip="tooltip" data-placement="top" title="Already Linked" type="button" class="btn btn-sm btn-success"><i class="fa fa-check"></i></button>
							@endif
						</td>
						<td style="vertical-align: middle;">
							<button data-toggletip="tooltip" data-placement="top" title="Delete" data-confirm-url="{{url('/image-mapping/delete/'.$images->id.'/'.$images->image.'/'.$page_info->publish_date)}}" type="button" class="btn btn-danger btn-sm confirm_box"><i class="fa fa-trash"></i></button>
						</td>
					</tr>
					@endforeach
					@else
					<tr>
						<td colspan="6"><div class="alert alert-info text-center" style="margin: 0">No Data Available !</div></td>
					</tr>
					@endif
				</tbody>
			</table>

		</div>
	</div>
</div>
</div>

</section>
<!-- /.content -->







<!-- Relation Udate Modal -->
<div class="modal fade" id="LinkedImageUpdate" role="dialog">
	<div class="modal-dialog modal-lg">

		<!-- Modal content-->
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal">&times;</button>
				<h4 class="modal-title">Link Related Images</h4>
			</div>

			<div class="ajax_image_relation_update_modal"></div>
		</div>
	</div>
</div>
<!-- End Relation Udate Modal -->

<input type="hidden" class="edition_id" value="{{$page_info->edition_id}}">

@endsection

@section('page-scripts')
<script type="text/javascript">

	// button trigger
	$("document").ready(function() {
		$(".sidebar-toggle").trigger('click');
	});


	/*################################
	## ajax_select_image_relation
	################################*/
	jQuery(function(){
		jQuery('.ajax_select_image_relation').click(function(){

			var image_date = jQuery(this).data('image-date');
			var related_page = $('.page_no').val();
			var site_url = jQuery('.site_url').val();
			var edition_id = jQuery('.edition_id').val();
			var request_url = site_url+'/ajax-image-relation/edition/'+edition_id+'/'+image_date+'/'+related_page;

			jQuery.ajax({
				url: request_url,
				type: 'get',
				success:function(data){

					jQuery('.ajax_image_relation_modal_view').html(data);
				}
			});

		});
	});


	/*###########################
	# get_relation
	#############################
	*/ 
	jQuery(function(){
		jQuery('.get_relation').change(function(){
			var relation = $('.relation').val();
			var page_no = $('.page_no').val();

			$('.select_related_item').hide();
			if((relation == 'previous') && (page_no != '')){
				$('.select_related_item').show();
			}

		});
	});


	/*################################
	## ajax_image_relation_update
	################################*/

	jQuery(function(){
		jQuery('.ajax_image_relation_update').click(function(){

			var image_date = jQuery(this).data('image-date');
			var related_page = jQuery(this).data('related-page');
			var image_id = jQuery(this).data('image-id');
			var related_image = jQuery(this).data('related-image');
			var relation_type = jQuery(this).data('relation-type');
			var site_url = jQuery('.site_url').val();
			var edition_id = jQuery('.edition_id').val();

			var request_url = site_url+'/ajax-image-relation-update/edition/'+edition_id+'/'+image_id+'/'+related_image+'/'+image_date+'/'+related_page+'/'+relation_type;

			jQuery.ajax({
				url: request_url,
				type: 'get',
				success:function(data){

					jQuery('.ajax_image_relation_update_modal').html(data);
				}
			});

		});
	});


	/*###########################
	# Confirm Box
	#############################
	*/ 
	jQuery(function(){
		jQuery('.confirm_box').click(function(){
			var confirm_url=jQuery(this).data('confirm-url');
			if (confirm("Delete This Image Permanently !\nDo You Want To Proceed ?") == true) {
				window.location.href=confirm_url;
			}
		});
	});

	// tooltip
	$(function () {
		$('[data-toggletip="tooltip"]').tooltip();
	});


	// scrollbar
	function DoubleScroll(element) {
		var scrollbar= document.createElement('div');
		scrollbar.appendChild(document.createElement('div'));
		scrollbar.style.overflow= 'auto';
		scrollbar.style.overflowY= 'hidden';
		scrollbar.firstChild.style.width= element.scrollWidth+'px';
		scrollbar.firstChild.style.paddingTop= '1px';
		scrollbar.firstChild.appendChild(document.createTextNode('\xA0'));
		scrollbar.onscroll= function() {
			element.scrollLeft= scrollbar.scrollLeft;
		};
		element.onscroll= function() {
			scrollbar.scrollLeft= element.scrollLeft;
		};
		element.parentNode.insertBefore(scrollbar, element);
	}

	DoubleScroll(document.getElementById('doublescroll'));
</script>
<script src="{{asset('admin/assets/image-mapping/js/jquery.Jcrop.min.js')}}"></script>
<script src="{{asset('admin/assets/image-mapping/js/app.js')}}"></script>
<script src="{{asset('admin/assets/js/jquery.maphilight.min.js')}}"></script>
@endsection