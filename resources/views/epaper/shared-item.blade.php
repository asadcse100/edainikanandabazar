<!DOCTYPE html>
<html>
<head>
	<meta http-equiv="X-UA-Compatible" content="IE=edge" />
	<title>e dainikanandabazar</title>
	<meta name="Author" content="Oracle IT" />
	<meta name="Developed By" content="Oracle IT" />
	<meta name="Developer" content="Oracle IT" />
	<meta name="keywords" content="Online newspaper, bangla newspaper, bangla newspapers, bangla newspapers, bangla paper, bd newspaper, newspaper bd, newspaper bangladesh, bangladesh newspaper, bangladesh news, bangla news, bangladeshi newspapers, bangladeshi bangla newspapers, bangla news paper, bangladeshi newspaper, bd news paper, banglaeshi newspapers, list of bangla newspaper, online bangla newspaper, bd online newspaper, bd online newspapers, newspaper bangladesh, bd news, news bd, bdnews, newsbd, daily newspaper of bangladesh, daily newspapers of bangladesh, daily newspaper of bd, daily newspapers of bd, list of bd newspapers, bangladesh newspaper news, bd newspaper list, bangla daily newspaper, bd newspaper every day, bd newspaper every day, allbanglanewspaper, bdnewspapereveryday, bangla news, allbanglanewspapers, allbanglanewspaper, bdnewspaper, newspaperbd, bangla news paper, the daily bangladesh pratidin, newspaper bangladesh, newspaper bangla, newspaper in bangladesh, bangladeshi newspaper, bangla newspaper in bd, bangla, newspaper, all, news, list, bengali, bangali, bd, allbdnews, bd news, bd news paper, bangladesh paper, bangladesh newspapers, bangla news 24, bd news 24, 24 online bangla newspaper, technology, computer, financial, finance, bangladesh, bangla news, Prothom Alo, Prothom Alo newspaper,  bangla newspaper online, bangla newspaper in bangladesh, bangladeshi newspaper, bangla newspaper list, bangla, news, newspaper, all, newspapers, online, online bangla newspaper, online bangla newspapers, bd, agency, online bengali newspaper, bengali newspaper, bengali newspaper, bengali newspapers, bengali news paper, bengali patrika, patrika, bd patrika, bd newspaper, bd newspaper, dainik shokalar khabar, shokalar khabar, finance, econimic, technilogy, polital news, banking news, share bazar news, share bazar, beauty, bazaar, market, manab kantho, daily manab kantho, daily newspaper of bangladesh, poriborton, bangla newspaper online, daily bangla newspaper, bengali newspapers, daily bengali newspapers, online bengali newspaper, daily bangla newspaper, prothom-alo, bangla news, bangla news online, bengali newspaper, news paper of bangladesh, bd newspaper, news paper bangladesh, Bangla Newspaper Ittefaq, Bangladesh News Live, Bangladesh Newspapers Ittefaq, Bangla Newspaper Headlines, Manabzamin, Bangladesh News Update, সংবাদপত্র, বাংলা সংবাদপত্র,  Business, technology, financial, media, portal, foreign news, Find your desired Bangla newspaper at one page, bangal online news, bangla news portal, bangkadesh news agency, news agency, bangla news agency, ২৪ লাইভ নিউজপেপার, 24 live newspaper, 24 live, 24live, 24 newspaper, 24newspaper" />
	<meta http-equiv="Cache-Control" content="no-cache"/>
	<meta http-equiv="Pragma" content="no-cache"/>
	<meta name="distribution" content="Global">
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta http-equiv="Content-Language" content="bn"/>
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">

	<meta property="og:url" content="{{Request::url()}}" />
	<meta property="og:image" content="{{asset('uploads/epaper/'.$main_image)}}" />
	<meta name="twitter:image" content="{{asset('uploads/epaper/'.$main_image)}}">

	<link rel="stylesheet" href="{{asset('assets/bootstrap/css/bootstrap.min.css')}}">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.0/jquery.min.js"></script>
	<script src="{{asset('assets/bootstrap/js/bootstrap.min.js')}}"></script>
	<link rel="stylesheet" href="{{asset('assets/fontawesome/css/font-awesome.min.css')}}" />

	<!-- icon -->
	<link rel="icon" type="image/png" href="{{asset('assets/images/32x32.png')}}" />

	<style type="text/css">
		.modal-content {
			border-radius: 15px;
			border: 10px solid #B3B3B3;

		}
		.modal{
			background-color: #333333;

		}
		.modal_table{
			background-color: #CCCCCC;
			border-top-right-radius: 5px;
			border-top-left-radius: 5px;
		}
		.add{
			margin-top: 10px;
			margin-bottom: 10px;

		}
		.add img{
			display: block;
			margin: 0 auto;
			max-width: 100%;
			height: auto;
			vertical-align: middle;
		}
		.modal-head{
			border-bottom: 2px solid #ccc;
		}
		.close{
			opacity: 1!important;
			background: #d9534f!important;
		}
		.mclose{
			padding: 3px 10px 5px 10px!important;
			margin-top: 2px!important;
			margin-left:5px!important;
			margin-right: 5px!important;
		}
		.mclose:hover {
			color: #fff;
			background-color: #c9302c;
			border-color: #ac2925;
		}
		.elogo{
			padding-left: 10px;
			padding-top: 5px;
		}
		.btn-list{
			margin: 2px;
		}
		.footer{
			background-color: #E9E9E9;
			box-sizing:border-box;
			padding: 15px 10px;
		}
		.footer p{
			margin: 0px;
		}
		.modal-footer{
			padding-bottom: 0px;
			padding-left: 0px;
			padding-right: 0px;
			border: 1px solid #ccc;
			border-bottom-right-radius: 5px;
			border-bottom-left-radius: 5px;
		}
	</style>

</head>
<body>

	<div class="container">

		<!-- Modal -->
		<div class="modal fade" id="myModal" role="dialog">
			<div class="modal-dialog modal-lg">

				<!-- Modal content-->
				<div class="modal-content" >
					<div class="modal-head" >
						<table width="100%" class="modal_table">
							<tr>
								<td style="width: 40px">
								</td>
								<td class="text-center"> 
									<p>
										<a href="{{url('/')}}"><img src="@if(!empty(setting()->logo)) {{asset('logo')}}/{{setting()->logo}}@endif" style="height: 50px;padding: 5px 0px" ></a>
									</p>
								</td>

								<td style="width: 40px" valign="top">
									<p>
										<button class="btn btn-danger close" style="padding: 8px 10px 8px 10px;margin-top: 2px;font-size: 16px;border-radius: 50%;"  title="close"><i class="fa fa-times" style="color: white"></i></button>
									</p>
								</td>
							</tr>
						</table>

					</div>

					<center>
						<div class="modal-body">

							<div class="row" style="overflow-x: scroll;padding: 10px">
								<img src="{{asset('uploads/epaper/'.$main_image)}}" class="main_image">

								@if(!empty($related_image))
								<img src="{{asset('uploads/epaper/'.$related_image)}}" class="next_image" style="display: none;">
								@endif
							</div>


							<div class="row" style="margin-top: 20px;margin-right:auto;">

								<div style="float: left;">
									<button type="button" style="background-color: #3C5A98;border-radius: 50%;padding-top: 5px;padding-bottom: 5px;"  class="btn btn-default share_on_fb"><i class="fa fa-facebook" style="color: white" aria-hidden="true"></i></button>

									<button type="button" style="background-color: #1DA1F2;border-radius: 50%;padding-top: 5px;padding-bottom: 5px;padding-left: 10px;padding-right: 10px;"  class="btn btn-default share_on_twt"><i class="fa fa-twitter" style="color: white" aria-hidden="true"></i></button>

									<button type="button"  class="btn btn-default share_on_gplus" style="background-color: #E53935;border-radius: 50%;padding-top: 5px;padding-bottom: 5px;padding-left: 10px;padding-right: 10px;"><i class="fa fa-google" style="color: white" aria-hidden="true"></i></button>

									<button style="border-radius: 50%;padding-top: 5px;padding-bottom: 5px;padding-left: 10px;padding-right: 10px;" type="button" onclick='printDiv("<?php echo $date_show; ?>");'  name="b_print" class="btn btn-success"> <i class="fa fa-print"></i></button>

								</div>

								<div style="float: right">
									<a href="{{url('/')}}" class="btn btn-primary"> <i class="fa fa-home"></i> GO HOME</a>

									@if(!empty($related_image))
									&nbsp;&nbsp;&nbsp;&nbsp;
									<button  class="btn btn-info main_image_trigger"><i class="fa fa-backward" aria-hidden="true"></i>&nbsp;&nbsp;পূর্ববর্তী অংশ</button>
									<button class="btn btn-info next_image_trigger" >পরবর্তী অংশ&nbsp;&nbsp;<i class="fa fa-forward" aria-hidden="true"></i></button> 
									@endif
								</div>

							</div>
						</div>
					</center>
				</div>

			</div>
		</div>

	</div>

	<input type="hidden" name="site_url" class="site_url" value="{{url('/')}}">
	<input type="hidden" class="main_image_location" value="{{$main_image_location}}">
	<input type="hidden" class="related_image_name" value="{{isset($related_image_name) ? $related_image_name : ''}}">

	<script type="text/javascript">
		$(window).load(function()
		{
			$('#myModal').modal('show');
		});

		$('.main_image_trigger').hide();

		$('.next_image_trigger').click(function(){
			$('.main_image').hide();
			$('.next_image').show();
			$('.next_image_trigger').hide();
			$('.main_image_trigger').show();

		});

		$('.main_image_trigger').click(function(){
			$('.main_image').show();
			$('.next_image').hide();
			$('.next_image_trigger').show();
			$('.main_image_trigger').hide();

		});

	</script>


	<!-- article print-->
	<script type="text/javascript">
		function printDiv(bangla_date) 
		{
			var newWin=window.open('','Print-Window');

			var site_url = $(".site_url").val();

			var main_image_link = $(".main_image_location").val();
			var main_image = site_url+'/uploads/epaper/'+main_image_link;

			var related_image_link = $(".related_image_location").val();
			var related_image = site_url+'/uploads/epaper/'+related_image_link;

			newWin.document.open();

			if(related_image_link != ''){
				newWin.document.write('<html><body onload="window.print()">'+'<center><img src="@if(!empty(setting()->logo)) {{asset("logo")}}/{{setting()->logo}}@endif" style="height:40px;width:200px;" />'+'<p style="text-align:center;border-top:1px solid black;border-bottom:1px solid black;padding:5px;font-size:20px">'+bangla_date+'</p>'+'<img src='+main_image+' />'+'</center></body>'+'<body><center>'+'<img src='+related_image+' />'+'</center></body>'+'</html>');
			}else{
				newWin.document.write('<html><body onload="window.print()">'+'<center><img src="@if(!empty(setting()->logo)) {{asset("logo")}}/{{setting()->logo}}@endif" style="height:40px;width:200px;" />'+'<p style="text-align:center;border-top:1px solid black;border-bottom:1px solid black;padding:5px;font-size:20px">'+bangla_date+'</p>'+'<img src='+main_image+' />'+'</center></body></html>');
			}

			newWin.document.close();
			setTimeout(function(){newWin.close();},10);

		}
	</script>


	<!-- share apis -->
	<script async src="https://platform.twitter.com/widgets.js" charset="utf-8"></script>
	<script type="text/javascript">
		$('.share_on_fb').click(function(){
			var main_image_location = '{{$main_image_location}}';
			var site_url = $(".site_url").val();
			var current_date = $(".current_date").val();

			var related_image_name = $(".related_image_name").val();
			if(related_image_name != ''){
				var requested_url = site_url+'/uploads/epaper/'+main_image_location+'shared/'+'{{$main_image_name}}/'+related_image_name;
				window.open('https://www.facebook.com/sharer/sharer.php?u='+requested_url, '', 'window settings');
			}else{
				var requested_url = site_url+'/uploads/epaper/'+main_image_location+'shared/'+'{{$main_image_name}}';
				window.open('https://www.facebook.com/sharer/sharer.php?u='+requested_url, '', 'window settings');
			}
		});

		$('.share_on_twt').click(function(){
			var tw_main_image_location = '{{$main_image_location}}';
			var site_url = $(".site_url").val();
			var current_date = $(".current_date").val();

			var tw_related_image_name = $(".related_image_name").val();
			if(tw_related_image_name != ''){
				var tw_requested_url = site_url+'/uploads/epaper/'+tw_main_image_location+'shared/'+'{{$main_image_name}}/'+tw_related_image_name;
				window.open('https://www.twitter.com/share?url='+tw_requested_url, '', 'window settings');
			}else{
				var tw_requested_url = site_url+'/uploads/epaper/'+tw_main_image_location+'shared/'+'{{$main_image_name}}';
				window.open('https://www.twitter.com/share?url='+tw_requested_url, '', 'window settings');
			}
		});


		$('.share_on_gplus').click(function(){
			var gp_main_image_location = '{{$main_image_location}}';
			var site_url = $(".site_url").val();
			var current_date = $(".current_date").val();

			var gp_related_image_name = $(".related_image_name").val();
			if(gp_related_image_name != ''){
				var gp_requested_url = site_url+'/uploads/epaper/'+gp_main_image_location+'shared/'+'{{$main_image_name}}/'+gp_related_image_name;
				window.open('https://plus.google.com/share?url='+gp_requested_url, '', 'window settings');
			}else{
				var gp_requested_url = site_url+'/uploads/epaper/'+gp_main_image_location+'shared/'+'{{$main_image_name}}';
				window.open('https://plus.google.com/share?url='+gp_requested_url, '', 'window settings');
			}
		});

	</script>
	<!-- end share apis -->


	<script type="text/javascript">
		$('.close').click(function(){
			location.href = 'https://e.dainikanandabazar.com/';
		});
	</script>

</body>
</html>


