
<style type="text/css">
	.related_image_display ul {
		list-style-type: none;
	}

	.related_image_display li {
		display: inline-block;
	}

	input[type="radio"][id^="riu"] {
		display: none;
	}

	label {
		border: 1px solid #fff;
		padding: 5px;
		display: block;
		position: relative;
		margin: 5px;
		cursor: pointer;
	}

	label:before {
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

	label img {
		height: 280px;
		width: 240px;
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
</style>


<form action="{{url('/manage-relations-save/'.$image_date.'/new/'.$image_id)}}" method="post" enctype="multipart/form-data">
	<input type="hidden" name="_token" value="{{csrf_token()}}">

	<div class="modal-body text-center">
		<div class="row">
			<div class="col-md-4">
				<h4 style="background-color: #CCD1D1;padding: 5px">Image</h4>
				<img src="{{$up_dir.$uploads_path.date('Y/m/',strtotime($image_date)).date('d',strtotime($image_date)).'/images/'.$main_image->image}}" class="image-responsive col-md-12 col-sm-12" style="border: 3px solid #AEB6BF">
			</div>
			<div class="col-md-8 col-sm-12 related_image_display" >
				<h4 style="background-color: #CCD1D1;padding: 5px">Update Related Image</h4>
				@if(!empty($related_images) && (count($related_images)>0))
				<center>
					<ul >
						@foreach($related_images as $key => $related_image_list)
						<li>
							<input type="radio" name="related_image_id" id="riu{{$key+1}}" value="{{$related_image_list->id}}" {{isset($main_image) && ($main_image->related_image_id == $related_image_list->id) ? 'checked' : ''}} />
							<label for="riu{{$key+1}}"><img src="{{$up_dir.$uploads_path.date('Y/m/',strtotime($image_date)).date('d',strtotime($image_date)).'/images/'.$related_image_list->image}}" class="image-responsive" style="border: 1px solid black"></label>
						</li>
						@endforeach
						
					</ul>
				</center>
				@else
				<div class="alert alert-danger text-center">No data found !</div>
				@endif
			</div>

		</div>
	</div>

	<div class="modal-footer">
		<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
		<button data-toggletip="tooltip" data-placement="top" title="Save !" type="submit" class="btn btn-primary btn-sm">Update Related Image !</button>
	</div>

</form>



<script type="text/javascript">
	$('.images_list li').click(function() {
		$('.images_list .selected').removeClass('selected');
		$(this).toggleClass('selected');
		var clicked = $(this).attr('title');
		$("#"+clicked).removeClass("hidden").siblings().addClass("hidden");
	});
</script>
