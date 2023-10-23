@extends('layouts.app')
<style type="text/css">
	li.current_edition:hover{
		background-color: inherit !important
	}
</style>

<!-- pagination -->
<style type="text/css">

	/* Modal Content (image) */
	.modal-content {
	margin: auto;
	display: block;
	width: 100%;
	max-width: 1200px !important;
	}

	.modal {
		display: none; /* Hidden by default */
		position: fixed; /* Stay in place */
		z-index: 1; /* Sit on top */
		padding-top: 100px; /* Location of the box */
		left: 0;
		top: 0;
		width: 100%; /* Full width */
		height: 100%; /* Full height */
		overflow: auto; /* Enable scroll if needed */
		background-color: rgb(0,0,0); /* Fallback color */
		background-color: rgba(0,0,0,0.9); /* Black w/ opacity */
		}

/* Caption of Modal Image */
#caption {
  margin: auto;
  display: block;
  width: 80%;
  max-width: 1200px !important;
  text-align: center;
  color: #ccc;
  padding: 10px 0;
  height: 150px;
}

/* Add Animation */
.modal-content, #caption {  
  -webkit-animation-name: zoom;
  -webkit-animation-duration: 0.6s;
  animation-name: zoom;
  animation-duration: 0.6s;
}

@-webkit-keyframes zoom {
  from {-webkit-transform:scale(0)} 
  to {-webkit-transform:scale(1)}
}

@keyframes zoom {
  from {transform:scale(0)} 
  to {transform:scale(1)}
}



.close:hover,
.close:focus {
  color: #bbb;
  text-decoration: none;
  cursor: pointer;
}


	/* 100% Image Width on Smaller Screens */
	@media only screen and (max-width: 1200px){
	.modal-content {
		width: 100% !important;
	}
	}

</style>

<style type="text/css">
	.modal{
		background-image: url({{asset('assets/images/overlay.png')}});
		
}

</style>

@section('content')


<!-- content -->
<div class="row-div-left" style="margin-left: 0px;width: auto;">

	@if(!empty($date))
	@php $date_show=\App\Models\Epaper::GetBanglaDate($date); @endphp
	<table style="width: 100%;background-color: #D2D0CE;margin: 0px 0px 10px 0px">
		<tr>
			<td>
				<center>
					<div class="pagination" style="margin: 0px;padding: 5px">
						<a style="margin-left: 0px;" href="{{url('/'.$page_edition.'/'.$date.'/'.$page_last)}}">&laquo;</a>
						@for($i=1; $i <= count($pagination_pages); $i++)
						<a class="{{$i == $current_page ? 'active' : ''}}" href="{{url('/'.$page_edition.'/'.$date.'/'.$i)}}">{{$i}}</a>
						@endfor
						<a href="{{url('/'.$page_edition.'/'.$date.'/'.$page_next)}}">&raquo;</a>
					</div>
				</center>
			</td>
		</tr>
	</table>
	@else
	@php $date_show=Null; $data = Null; @endphp
	@endif

	<div class="left-content">

		<!-- main page -->
		<div class="main-img-div" style="padding-left: 10px;padding-right: 10px;padding-bottom: 10px">
			@if(!empty($home_page))
			<img src="{{asset('uploads/epaper/'.date('Y',strtotime($home_page->publish_date)).'/'.date('m',strtotime($home_page->publish_date)).'/'.date('d',strtotime($home_page->publish_date)).'/pages/'.$home_page->image)}}" usemap="#enewspaper" class="map" />

			<map name="enewspaper">
				@php
				$image_location='uploads/epaper/'.date('Y',strtotime($date)).'/'.date('m',strtotime($date)).'/'.date('d',strtotime($date)).'/images'; 

				$image_width_location='uploads/epaper/'.date('Y',strtotime($date)).'/'.date('m',strtotime($date)).'/'.date('d',strtotime($date)).'/images/';
				@endphp

				@if(!empty($epaper_articles) && (count($epaper_articles)>0))
				@foreach($epaper_articles as $key => $article)

				@php 
				$related_item = \App\Models\Epaper::GetRelatedItem($date, $article->related_image_id);

				$get_image_width = \App\Models\Epaper::GetImageSize($image_width_location.$article->image);

				@endphp

				<area shape="rect" coords="{{$article->coords}}" data-image="{{$article->image}}"  class="main-img"  onclick="modalOpen('<?php echo $article->image; ?>','<?php echo $image_location; ?>','<?php echo $related_item; ?>','<?php echo $article->relation; ?>', '<?php echo $get_image_width; ?>')"/>
				@endforeach
				@endif
			</map>

			@endif
		</div>
		<!-- end main page -->


		<!-- page trigger -->
		<table width="100%" class="page-trigger" style="padding: 10px 10px 0px 10px;margin-left: 0px">
			<tr>
				<td>
					@if(($page_last+1)>1)
					<a style="float: left" href="{{url('/'.$page_edition.'/'.$date.'/'.$page_last)}}"><img src="{{asset('assets/images/front/previous.png')}}" /></a>
					@else
					@if(!empty($date))
					<a style="float: left" href="{{url('/all/pages/'.$page_edition.'/'.$date)}}" style="padding: 8px"><img src="{{asset('assets/images/front/all.png')}}" /></a>
					@endif
					@endif
				</td>
				<td>
					@if(count($get_categories)>($page_next-1))
					<a href="{{url('/'.$page_edition.'/'.$date.'/'.$page_next)}}" class="pull-right"><img src="{{asset('assets/images/front/next.png')}}" /></a>
					@endif
				</td>
			</tr>
		</table>
		<br>
		<!-- end page trigger -->

	</div>
</div>
<!-- end content -->


<!-- The Modal -->
<div id="newsPopup" class="modal">
	<div class="modal-content customized_content loading_img" id="modal-content" style="width: 1000px;">
		<div class="modal-head" >
			<table width="100%" class="modal_table">
				<tr>
					<td style="width: 40px">
					</td>
					<td class="text-center"> 
						<p>
							<a href="{{Route('home')}}"><img src="@if(!empty(setting()->logo)) {{asset('logo')}}/{{setting()->logo}}@endif" style="height: 50px;padding: 5px 0px" ></a>
							<button style="border-radius: 50%;padding: 5px 7px 5px 7px;" type="button" onclick='printDiv("<?php echo $date_show; ?>");'  name="b_print" class="btn btn-success"> <i class="fa fa-print"></i></button>
							<button style="border-radius: 50%;padding: 5px 7px 5px 7px;" type="button" name="b_download" class="btn btn-success b_download"> <i class="fa fa-download"></i></button>
							<button style="border-radius: 50%;padding: 5px 7px 5px 7px;" type="button" name="copyImagePath" class="btn btn-success copyImagePath"> <i class="fa fa-link"></i></button>
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
			<div id='DivIdToPrint' class="modal-main-img img-responsive" id="newsImg">
				<center>
					<img src=""  id="singleNewsImg" class="image_view">
					<img src="" class="related_image">
				</center>
			</div>

			<div style="margin-top: 20px;padding-bottom: 20px">
				<div style="float: left">
					<span style="font-size: 20px;border-bottom: 2px solid black;">শেয়ার করুন</span>
					<button type="button" style="background-color: #3C5A98;border-radius: 50%;padding: 5px 9px 5px 9px"  class="btn btn-default share_on_fb"><i class="fa fa-facebook" style="color: white" aria-hidden="true"></i></button>

					<button type="button" style="background-color: #1DA1F2;border-radius: 50%;padding: 5px 7px 5px 7px;"  class="btn btn-default share_on_twt"><i class="fa fa-twitter" style="color: white" aria-hidden="true"></i></button>

					<!-- <button type="button"  class="btn btn-default share_on_gplus" style="background-color: #E53935;border-radius: 50%;padding: 5px 7px 5px 7px;"><i class="fa fa-google" style="color: white" aria-hidden="true"></i></button> -->

					<button style="border-radius: 50%;padding: 5px 7px 5px 7px;" type="button"  name="wahtsapp" class="btn btn-success"> <i class="fa fa-whatsapp"></i></button>
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
<input type="hidden" class="current_date" value="{{!empty($date) ? $date : ''}}">
<input type="hidden" class="page_edition" value="{{$page_edition}}">
<input type="hidden" class="current_page" value="{{$current_page}}">
<img src="" class="main_image" style="display: none" >


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
  function modalOpen(image,image_location,related_item,image_relation,image_width){
  	modal.style.display = "block";

  	var site_url = $('.site_url').val();

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

  	var main_image = image_location +'/' + image;
  	$(".main_image").attr( 'src' ,main_image );


  	var image = site_url+'/'+image_location +'/' + image;
  	$(".modal-body .image_view").attr( "src", image );

  	/*==next prev button==*/
  	if(related_item != ''){
  		var related_image = site_url+'/'+image_location +'/' + related_item;
  		$(".modal-body .related_image").attr( "src", related_image );

  		if(image_relation == 'next'){

  /*##################################
  ## click on next button ##
  ###################################*/
  $('.nxt').show();
  $(".nxt").click(function(){
  	$('.prvs').show();
  	$('.nxt').hide();
  	$('.image_view').hide();
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
  	$('.nxt').show();
  	$('.prvs').hide();
  	$('.image_view').show();
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
 }
 if(image_relation == 'previous'){
 	$('.prvs').show();

 	$(".prvs").click(function(){
 		$('.prvs').hide();
 		$('.nxt').show();
 		$('.image_view').hide();
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

 	$(".nxt").click(function(){
 		$('.nxt').hide();
 		$('.prvs').show();
 		$('.image_view').show();
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
 }

}

}


  /*##################################
  ## click on close button ##
  ###################################*/
  $(".close").click(function(){
  	$('.nxt').hide();
  	$('.prvs').hide();
  	$('.image_view').show();

  });

  
 </script>
 <!--end modal-->



 <!--pagination-->
 <script src="{{asset('assets/js/jquery.paginate.js')}}" type="text/javascript"></script>
 <script type="text/javascript">
 	$(function() {

 		var total_pages = $('.get_pagination').val();
 		var current_page = $('.current_page').val();
 		var display_pages =total_pages;

 		if(total_pages > 24){
 			display_pages = 23;
 		}

 		$("#demo").paginate({
 			count     : total_pages,
 			start     : current_page,
 			display     : display_pages,
 			border          : false,
 			text_color        : '#888',
 			background_color      : '#EEE', 
 			text_hover_color      : 'black',
 			background_hover_color  : '#CFCFCF'
 		});
 	});

 	function getPage(page){

 		var page_edition = $('.page_edition').val();
 		var current_date = $('.current_date').val();
 		var site_url = $('.site_url').val();

 		var request_url = site_url+'/'+page_edition+'/'+current_date+'/'+page;
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
 			newWin.document.write('<html><body onload="window.print()">'+'<center><img src="@if(!empty(setting()->logo)) {{asset("logo")}}/{{setting()->logo}}@endif" style="height:50px;" />'+'<p style="text-align:center;border-top:1px solid black;border-bottom:1px solid black;padding:5px;font-size:20px">'+bangla_date+'</p>'+'<img src='+main_image_link+' />'+'</center></body>'+'<body><center>'+'<img src='+related_image_link+' />'+'</center></body>'+'</html>');
 		}else{
 			newWin.document.write('<html><body onload="window.print()">'+'<center><img src="@if(!empty(setting()->logo)) {{asset("logo")}}/{{setting()->logo}}@endif" style="height:50px;" />'+'<p style="text-align:center;border-top:1px solid black;border-bottom:1px solid black;padding:5px;font-size:20px">'+bangla_date+'</p>'+'<img src='+main_image_link+' />'+'</center></body></html>');
 		}

 		newWin.document.close();
 		setTimeout(function(){newWin.close();},10);
 	}
 </script>


 <!-- share apis -->
 <script async src="https://platform.twitter.com/widgets.js" charset="utf-8"></script>
 <script type="text/javascript">
 	$('.share_on_fb').click(function(){
 		var fb_link = '/'+$(".main_image").attr( "src" );
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
 		var tw_link = '/'+$(".main_image").attr( "src" );
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
 			window.open('https://twitter.com/intent/tweet?url='+tw_requested_url,  '', 'window settings');
 		}else{
 			var tw_requested_url = site_url+tw_link+'images/shared/'+tw_mainImage;
 				window.open('https://twitter.com/intent/tweet?url='+tw_requested_url,  '', 'window settings');
 		}
 	});

	 $('.copyImagePath').click(function () {
    var gp_link = '/' + $(".main_image").attr("src");
    var gp_splited = gp_link.split("images/");
    var gp_length = gp_splited.length;
    var gp_link = gp_splited[gp_length - 2];
    var gp_mainImage = gp_splited[gp_length - 1];

    var site_url = $(".site_url").val();
    $.ajax({
        method: "GET",
        url: "{{ route('copyImagePath') }}",
        data: {
            image_gp_link: gp_link,
            image: gp_mainImage
        },
        dataType: "json", // Set the dataType to "json"
        success: function (response) {
            
            var copyImagePath = response.copyImagePath;
			console.log(response);
            // Copy the image URL to the clipboard
            var imageUrl = site_url + copyImagePath;
			
            navigator.clipboard.writeText(imageUrl).then(function () {
                // URL copied successfully
                alert('Image URL copied to clipboard: ' + imageUrl);
            }).catch(function (error) {
                console.error('Failed to copy URL: ' + error);
            });
        },
        error: function (xhr, status, error) {
            console.error(error);
        }
    });
});

 	$('.b_download').click(function(){
 		var gp_link = '/'+$(".main_image").attr( "src" );
 		var gp_splited = gp_link.split("images/");
 		var gp_length = gp_splited.length;
 		var gp_link = gp_splited[gp_length-2];
 		var gp_mainImage = gp_splited[gp_length-1];

 		var site_url = $(".site_url").val();
		$.ajax({
			method: "GET",
			url: "{{ Route('download') }}",
			data: {
				image_gp_link: gp_link,
				image: gp_mainImage
			},
			xhrFields: {
                responseType: 'blob'
            },
			success: function(response){
				console.log(response);
                var blob = new Blob([response]);
                var link = document.createElement('a');
                link.href = window.URL.createObjectURL(blob);
				link.download = site_url + gp_link + "images/" + gp_mainImage;
                link.click();
            },
            error: function(blob){
                console.log(blob);
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
