@extends('layouts.app')

<style type="text/css">
	li.current_edition:hover{
		background-color: inherit !important
	}
</style>

<style type="text/css">
	#mask {
		position:absolute;
		left:0;
		top:0;
		z-index:9000;
		background-color:#000;
		display:none;
	}
	#boxes .window {
		position:absolute;
		left:0;
		top:20px;
		width:auto;
		height:auto;
		display:none;
		z-index:9999;
		padding:20px;
		border-radius: 10px;
		text-align: center;
	}
	#boxes #dialog {
		width:auto;
		height:auto;
		padding:10px;
	}
</style>


<!-- pagination -->
<style type="text/css">
	.pagination {
		display: inline-block;
		margin-top: 15px;
	}
	.pagination a {
		color: white;
		float: left;
		padding: 2px 7px;
		text-decoration: none;
		background-color: #846d6d;
		border: 1px solid #ddd;
		margin: 0 4px;
	}
	.pagination a.active {
		background-color: #CC0000;
		color: white;
		border: 1px solid #CC0000;
	}
	.pagination a:hover:not(.active) {background-color: #ddd;}
</style>

<style type="text/css">
	.modal{
		background-image: url({{asset('assets/images/overlay.png')}});
}
</style>

@section('content')

@if(!empty($date))
@php $date_show=\App\Models\Epaper::GetBanglaDate($date); @endphp

<table style="width: 100%;background-color: #d2d0ce;margin: 0px 0px 10px 0px">
	<tr>
		<td>

			<center>
				<div class="pagination" style="margin: 0px;padding: 5px">


                        @if(!empty($date))
                        <a href="{{url('/all/pages/nogor-edition/'.$date)}}"><img src="{{asset('assets/images/front/all1.png')}}"></a>
                        @endif



					<a style="margin-left: 0px;" href="#">&laquo;</a>
					@for($i=1; $i <= count($pagination_pages); $i++)
					<a href="{{url('/nogor-edition/'.$date.'/'.$i)}}">{{$i}}</a>
					@endfor
					<a href="{{url('/nogor-edition/'.$date.'/1')}}">&raquo;</a>


                    @if(!empty($home_page) && !empty($date))
                    <a href="javascript::void(0)" onclick='printPage("{{asset('uploads/epaper/'.date('Y',strtotime($home_page->publish_date)).'/'.date('m',strtotime($home_page->publish_date)).'/'.date('d',strtotime($home_page->publish_date)).'/pages/'.$home_page->image)}}");'><img src="{{asset('assets/images/front/print.png')}}"></a>
                    @endif
				</div>
			</center>
		</td>
	</tr>
</table>
@endif


<div class="left-content">

	<div class="main-img-div" style="padding-left: 10px;padding-right: 10px;padding-bottom: 10px">
		@if(!empty($home_page) && !empty($date))
		<img src="{{asset('uploads/epaper/'.date('Y',strtotime($home_page->publish_date)).'/'.date('m',strtotime($home_page->publish_date)).'/'.date('d',strtotime($home_page->publish_date)).'/pages/'.$home_page->image)}}" usemap="#enewspaper" class="map" />

		<map name="enewspaper" >
			@php
			$image_location='uploads/epaper/'.date('Y',strtotime($date)).'/'.date('m',strtotime($date)).'/'.date('d',strtotime($date)).'/images/';
			@endphp

			@if(!empty($epaper_articles) && (count($epaper_articles)>0))
			@foreach($epaper_articles as $key => $article)

			@php
			$related_item = \App\Models\Epaper::GetRelatedItem($date, $article->related_image_id);
			$get_image_width = \App\Models\Epaper::GetImageSize($image_location.$article->image);
			@endphp

			<area  shape="rect" coords="{{$article->coords}}" data-image="{{$article->image}}"  class="main-img"  onclick="modalOpen('<?php echo $article->image; ?>','<?php echo $image_location; ?>','<?php echo $related_item; ?>','<?php echo $get_image_width; ?>')"/>
			@endforeach
			@endif
		</map>
		@else
		<img src="{{asset('assets/images/underConstruction.png')}}">
		@endif
	</div>

	<table width="100%" class="page-trigger" style="padding: 10px 10px 0px 10px;margin-left: 0px">
		<tr>
			<td>
				@if(!empty($date))
				<a style="float: left" href="{{url('/all/pages/nogor-edition/'.$date)}}" style="padding: 8px"><img src="{{asset('assets/images/front/all.png')}}" /></a>
				@endif
			</td>
			<td>
				@if( !empty($get_categories) && (count($get_categories)>1) && (!empty($date)))
				<a href="{{url('/nogor-edition/'.$date.'/2')}}" class="pull-right"><img src="{{asset('assets/images/front/next.png')}}" /></a>
				@endif
			</td>
		</tr>
	</table>
	<br>

</div>



<!-- The Modal -->
<div id="newsPopup" class="modal">
	<div class="modal-content customized_content loading_img" id="modal-content">
		<div class="modal-head" >
			<table width="100%" class="modal_table">
				<tr>
					<td style="width: 40px">
					</td>
					<td class="text-center">
						<p>
							<a href="{{Route('home')}}"><img src="@if(!empty(setting()->logo)) {{asset('logo')}}/{{setting()->logo}}@endif" style="height: 50px;padding: 5px 0px" ></a>
						</p>
					</td>

					<td style="width: 40px" valign="top">
						<p>
							<button class="btn btn-danger close" style="padding: 8px 10px 8px 10px;margin-top: 2px;font-size: 16px;border-radius: 50%;"  title="close"><i class="fa fa-times"></i></button>
						</p>
					</td>
				</tr>
			</table>


		</div>

		<div class="modal-body text-center" style="padding: 20px;">
			<div class="modal-main-img" id="newsImg" style="overflow-x: auto;">

				<center>
					<img src="" class="image_view" style="border: 2px solid #CCC;" />
					<img src="" class="related_image" style="border: 2px solid #CCC;display: none" />
				</center>

			</div>

			<div style="margin-top: 20px;margin-right:auto;padding-bottom: 20px">

				<div style="float: left;">
					<span style="font-size: 20px;border-bottom: 2px solid black;">শেয়ার করুন</span>
					<button type="button" style="background-color: #3C5A98;border-radius: 50%;padding: 5px 9px 5px 9px"  class="btn btn-default share_on_fb"><i class="fa fa-facebook" style="color: white" aria-hidden="true"></i></button>

					<button type="button" style="background-color: #1DA1F2;border-radius: 50%;padding: 5px 7px 5px 7px;"  class="btn btn-default share_on_twt"><i class="fa fa-twitter" style="color: white" aria-hidden="true"></i></button>

					<button type="button"  class="btn btn-default share_on_gplus" style="background-color: #E53935;border-radius: 50%;padding: 5px 7px 5px 7px;"><i class="fa fa-google" style="color: white" aria-hidden="true"></i></button>

					<button style="border-radius: 50%;padding: 5px 7px 5px 7px;" type="button" onclick='printDiv("<?php echo $date_show; ?>");'  name="b_print" class="btn btn-success"> <i class="fa fa-print"></i></button>

				</div>

				<div style="float: right">
					<button  class="btn btn-info trigger-prev prvs" style="display: none;padding: 2px 6px"><i class="fa fa-backward" aria-hidden="true"></i>&nbsp;&nbsp;পূর্ববর্তী অংশ</button>
					<button class="btn btn-info trigger-next nxt" style="display: none;padding: 2px 6px">পরবর্তী অংশ&nbsp;&nbsp;<i class="fa fa-forward" aria-hidden="true"></i></button>
				</div>
			</div>
			<br/>
		</div>

	</div>
</div>
<!--modal end-->


<input type="hidden" class="get_pagination" value="{{isset($pagination_pages) ? count($pagination_pages) : ''}}">
<input type="hidden" class="current_date" value="{{isset($date) ? $date : ''}}">



<!-- js for the page -->
<script type="text/javascript">
	/*==Get the modal==*/
	var modal = document.getElementById('newsPopup');
	var body = document.getElementById('body');
	/*==Get the button that opens the modal==*/
	var btn = document.getElementById("myBtn");
	/*==Get the <span> element that closes the modal==*/
	var button = document.getElementsByClassName("close")[0];
  /*################################
  ## click on modal (x) close ##
  #################################*/
  button.onclick = function() {
  	/*==remove related image class==*/
  	var remove_image_item = document.getElementsByClassName("image_view")[0].innerHTML = "";
  	$(".modal-body .image_view").attr( "src", remove_image_item );
  	var remove_related_item = document.getElementsByClassName("related_image")[0].innerHTML = "";
  	$(".modal-body .related_image").attr( "src", remove_related_item );

  	modal.style.display = "none";
  	document.getElementById("body").style.overflow = 'scroll';
  }

  /*##################################
  ## click on outside modal close ##
  ###################################*/
  window.onclick = function(event) {
  	if (event.target == modal) {
  		/*==remove related image class==*/
  		var remove_image_item = document.getElementsByClassName("image_view")[0].innerHTML = "";
  		$(".modal-body .image_view").attr( "src", remove_image_item );
  		var remove_related_item = document.getElementsByClassName("related_image")[0].innerHTML = "";
  		$(".modal-body .related_image").attr( "src", remove_related_item );
  		$('.image_view').show();
  		modal.style.display = "none";
  		$('.nxt').hide();
  		$('.prvs').hide();
  		document.getElementById("body").style.overflow = 'scroll';
  	}
  }


  /*##################################
  ## modal open ##
  ###################################*/
  function modalOpen(image,image_location,related_item,image_width){
  	$('#newsPopup').fadeIn(100);
  	modal.style.display = "block";
  	/*==modal width set==*/
  	var modal_width = image_width;
	  if(modal_width<300 && modal_width<400){
		modal_width=350;
	}else if(modal_width<400 && modal_width<500){
		modal_width=450;
	}else if(modal_width<500 && modal_width<600){
		modal_width=550;
	}else if(modal_width<600 && modal_width<700){
		modal_width=650;
	}else if(modal_width<700 && modal_width<800){
		modal_width=750;
	}else if(modal_width<800 && modal_width<900){
		modal_width=850;
	}else if(modal_width<900 && modal_width<1000){
		modal_width=950;
	}else if(modal_width<1000 && modal_width<1100){
		modal_width=1050;
	}else{
		modal_width=1200;
	}

  	document.getElementById("modal-content").style.width = modal_width+'px';
  	$('.related_image').hide();
  	var image = image_location + image;
  	$(".modal-body .image_view").attr( "src", image );

  	/*==next prev button==*/
  	if(related_item != ''){
  		var related_image = image_location + related_item;
  		$(".modal-body .related_image").attr( "src", related_image );
  		$('.nxt').show();
  		$('.prvs').hide();
  	}

  }



  /*##################################
  ## click on next button ##
  ###################################*/
  $(".nxt").click(function(){
  	$('.image_view').hide();
  	$('.prvs').show();
  	$('.nxt').hide();
  	$('.related_image').show();

  	var modal_width = $('.related_image').width();
	  if(modal_width<300 && modal_width<400){
		modal_width=350;
	}else if(modal_width<400 && modal_width<500){
		modal_width=450;
	}else if(modal_width<500 && modal_width<600){
		modal_width=550;
	}else if(modal_width<600 && modal_width<700){
		modal_width=650;
	}else if(modal_width<700 && modal_width<800){
		modal_width=750;
	}else if(modal_width<800 && modal_width<900){
		modal_width=850;
	}else if(modal_width<900 && modal_width<1000){
		modal_width=950;
	}else if(modal_width<1000 && modal_width<1100){
		modal_width=1050;
	}else{
		modal_width=1200;
	}
  	document.getElementById("modal-content").style.width = modal_width+'px';
  });



  /*##################################
  ## click on previous ##
  ###################################*/
  $(".prvs").click(function(){
  	$('.image_view').show();
  	$('.prvs').hide();
  	$('.nxt').show();
  	$('.related_image').hide();

  	var modal_width = $('.image_view').width();
	  if(modal_width<300 && modal_width<400){
		modal_width=350;
	}else if(modal_width<400 && modal_width<500){
		modal_width=450;
	}else if(modal_width<500 && modal_width<600){
		modal_width=550;
	}else if(modal_width<600 && modal_width<700){
		modal_width=650;
	}else if(modal_width<700 && modal_width<800){
		modal_width=750;
	}else if(modal_width<800 && modal_width<900){
		modal_width=850;
	}else if(modal_width<900 && modal_width<1000){
		modal_width=950;
	}else if(modal_width<1000 && modal_width<1100){
		modal_width=1050;
	}else{
		modal_width=1200;
	}
  	document.getElementById("modal-content").style.width = modal_width+'px';
  });


  /*##################################
  ## click on close button ##
  ###################################*/
  $(".close").click(function(){
  	$('.nxt').hide();
  	$('.prvs').hide();
  	$('.image_view').show();
  });

 </script>
 <!--end js for modal-->



 <!--pagination-->
 <script src="{{asset('assets/js/jquery.paginate.js')}}" type="text/javascript"></script>
 <script type="text/javascript">
 	$(function() {
 		var total_pages = $('.get_pagination').val();
 		var display_pages =total_pages;
 		if(total_pages > 24){
 			display_pages = 23;
 		}
 		$("#demo").paginate({
 			count     : total_pages,
 			start     : 1,
 			display     : display_pages,
 			border          : false,
 			text_color        : '#888',
 			background_color      : '#EEE',
 			text_hover_color      : 'black',
 			background_hover_color  : '#CFCFCF'
 		});
 	});

 	function getPage(page){
 		var current_date = $('.current_date').val();
 		var site_url = $('.site_url').val();
 		$('.current_page').val(page);
 		var request_url = site_url+'/nogor-edition/'+current_date+'/'+page;
 		window.location=request_url;
 	}
 </script>
 <!--pagination end-->



 <!-- article print-->
 <script type="text/javascript">
 	function printDiv(bangla_date)
 	{
 		var newWin=window.open('','Print-Window');
 		var site_url = $(".site_url").val();
 		var main_image_link = $(".image_view").attr( "src" );
 		var main_image = site_url+'/'+main_image_link;
 		var related_image_link = $(".related_image").attr( "src" );
 		var related_image = site_url+'/'+related_image_link;
 		newWin.document.open();
 		if(related_image_link != ''){
 			newWin.document.write('<html><body onload="window.print()">'+'<center><img src="{{asset("assets/images/logo1.png")}}" style="height:50px;" />'+'<p style="text-align:center;border-top:1px solid black;border-bottom:1px solid black;padding:5px;font-size:20px">'+bangla_date+'</p>'+'<img src='+main_image+' />'+'</center></body>'+'<body><center>'+'<img src='+related_image+' />'+'</center></body>'+'</html>');
 		}else{
 			newWin.document.write('<html><body onload="window.print()">'+'<center><img src="{{asset("assets/images/logo1.png")}}" style="height:50px;" />'+'<p style="text-align:center;border-top:1px solid black;border-bottom:1px solid black;padding:5px;font-size:20px">'+bangla_date+'</p>'+'<img src='+main_image+' />'+'</center></body></html>');
 		}
 		newWin.document.close();
 		setTimeout(function(){newWin.close();},10);
 	}
 </script>


 <!-- share apis -->
 <script async src="https://platform.twitter.com/widgets.js" charset="utf-8"></script>
 <script type="text/javascript">
 	$('.share_on_fb').click(function(){
 		var fb_link = '/'+$(".image_view").attr( "src" );
 		var splitedfb = fb_link.split("images/");
 		var lengthfb = splitedfb.length;
 		var fb_link = splitedfb[lengthfb-2];
 		var mainImage = splitedfb[lengthfb-1];

 		var related_image = $(".related_image").attr( "src" );
 		var site_url = $(".site_url").val();
 		var current_date = $(".current_date").val();

 		if(related_image != ''){
 			var splited = related_image.split("/");
 			var length = splited.length;
 			var related_image = splited[length-1];
 			var requested_url = site_url+fb_link+'images/shared/'+mainImage+'/'+related_image;
 			window.open('https://www.facebook.com/sharer/sharer.php?u='+requested_url, '', 'window settings');
 		}else{
 			var requested_url = site_url+fb_link+'images/shared/'+mainImage;
 			window.open('https://www.facebook.com/sharer/sharer.php?u='+requested_url, '', 'window settings');
 		}
 	});

 	$('.share_on_twt').click(function(){
 		var tw_link = '/'+$(".image_view").attr( "src" );
 		var tw_splited = tw_link.split("images/");
 		var tw_length = tw_splited.length;
 		var tw_link = tw_splited[tw_length-2];
 		var tw_mainImage = tw_splited[tw_length-1];

 		var tw_related_image = $(".related_image").attr( "src" );
 		var site_url = $(".site_url").val();
 		var current_date = $(".current_date").val();

 		if(tw_related_image != ''){
 			var tw_related_splited = tw_related_image.split("/");
 			var tw_related_length = tw_related_splited.length;
 			var tw_related_image = tw_related_splited[tw_related_length-1];
 			var tw_requested_url = site_url+tw_link+'images/shared/'+tw_mainImage+'/'+tw_related_image;
 			window.open('https://www.twitter.com/share?url='+tw_requested_url, '', 'window settings');
 		}else{
 			var tw_requested_url = site_url+tw_link+'images/shared/'+tw_mainImage;
 			window.open('https://www.twitter.com/share?url='+tw_requested_url, '', 'window settings');
 		}

 	});


 	$('.b_download').click(function(){
 		var gp_link = '/'+$(".main_image").attr( "src" );
 		var gp_splited = gp_link.split("images/");
 		var gp_length = gp_splited.length;
 		var gp_link = gp_splited[gp_length-2];
 		var gp_mainImage = gp_splited[gp_length-1];

 		var site_url = $(".site_url").val();
		 console.log(gp_link,site_url);
		$.ajax({
			method: "GET",
			url: "{{ Route('download') }}",
			data: {
				image_gp_link: gp_link,
				image: gp_mainImage
			}
		});

 	});


 	function printPage(printPage)
 	{

 		var newWinPage=window.open('','Print-Window');

 		newWinPage.document.open();

 		newWinPage.document.write('<html><body onload="window.print()">'+'<center>'+'<img src='+printPage+' />'+'</center></body></html>');

 		newWinPage.document.close();
 		setTimeout(function(){newWinPage.close();},10);
 	}

 </script>
 <!-- end share apis -->

 @endsection
