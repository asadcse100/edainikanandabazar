<!DOCTYPE html>
<html lang="en">

<head>
	<?php
	$file = fopen("log.txt", "r");
	$arr = fread($file, filesize("log.txt"));
	fclose($file);
	$arr = explode("⎌", $arr);
	?>
	<!-- meta tag -->
	<meta http-equiv="X-UA-Compatible" content="IE=edge" />
	<title><?php echo $arr[0]; ?> | {{setting()->site_name ? setting()->site_name :''}} </title>
	<meta name="keywords" content="{{setting()->meta_keywords ? setting()->meta_keywords :''}}" />
	<meta http-equiv="Cache-Control" content="no-cache" />
	<meta http-equiv="Pragma" content="no-cache" />
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta http-equiv="Content-Language" content="bn" />
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">

	<meta property="og:title" content="{{setting()->meta_title ? setting()->meta_title :''}}" />
	@if(!empty($home_page))
	<meta property="og:image" content="{{asset('uploads/epaper/'.date('Y',strtotime($home_page->publish_date)).'/'.date('m',strtotime($home_page->publish_date)).'/'.date('d',strtotime($home_page->publish_date)).'/pages/'.$home_page->image)}}" />
	<link rel="image_src" href="{{asset('uploads/epaper/'.date('Y',strtotime($home_page->publish_date)).'/'.date('m',strtotime($home_page->publish_date)).'/'.date('d',strtotime($home_page->publish_date)).'/pages/'.$home_page->image)}}" />
	@endif
	<meta property="og:image:type" content="image/jpeg" />
	<meta name="description" content="{{setting()->meta_description ? setting()->meta_description :''}}" />

	<!-- icon -->
	<!-- <link rel="icon" type="image/png" href="{{asset('assets/images/32x32.png')}}" /> -->
	<link rel="icon" type="image/png" href="@if(!empty(setting()->favicon)) {{asset('favicon')}}/{{setting()->favicon}}@endif">

	<!-- font awesome css -->
	<link rel="stylesheet" type="text/css" href="{{asset('assets/font-awesome/css/font-awesome.min.css')}}" />
	<!-- main css -->
	<link rel="stylesheet" href="{{asset('assets/css/main.css?v=1.3')}}" />
	<!-- fonts -->
	<link rel="stylesheet" href="{{asset('assets/fonts/styles.css')}}" />
	<!-- jquery js -->
	<script src="{{asset('assets/js/jquery-3.1.1.min.js')}}"></script>
	<!-- maplight js -->
	<script src="{{asset('assets/js/jquery.maphilight.min.js')}}"></script>
	<script type="text/javascript">
		$(function() {
			$('.map').maphilight();
		});
	</script>
	<!-- main js -->
	<script type="text/javascript" src="{{asset('assets/js/main.js')}}"></script>
	<!-- datepicker -->
	<link rel="stylesheet" href="{{asset('assets/plugins/jquery-ui/jquery-ui.css')}}">
	<script src="{{asset('assets/plugins/jquery-ui/jquery-ui.js')}}"></script>
	<style type="text/css">
		.ui-datepicker-inline {
			width: auto !important;
			border-radius: 0px;
		}
	</style>

	<style type="text/css">
		@media (min-width: 0px) and (max-width: 400px) {
			.footerLogo {
				display: none !important;
			}
		}
	</style>

</head>

<body id="body">
<div class="main-container">
	<div style="flex: 1; padding: 3px;">
		<div class="add text-center" style="text-align: center;">
			<a href="{{Route('home')}}"><img src="@if(!empty(setting()->logo)) {{asset('logo')}}/{{setting()->logo}}@endif" style="width: 250px"></a>
		</div>
	</div>
	</div>


		<div class="header-div">
			@if(!empty($arr))
			<!-- header top -->

			<div class="top-header" style="border-bottom: none;">
				<div class="main-container" style="height: 33px;padding: 5px 10px;background-color: #EEEEEE;box-shadow: none;border-bottom: none;">
					<table width="100%" cellspacing="0" cellpadding="0" border="0">
						<tr>
							<td>
								<div class="date text-left" style="margin-top: 2px">
									<p style="color: black;font-size: 17px">
										@foreach(DB::table('topbar_infos')->get() as $data)
										<a style="color: #3C5A98; text-decoration: none;" href="{{$data->url}}" target="_blank">
											{{$data->title}} |
										</a>
										@endforeach
									</p>
								</div>
							</td>

							<td>
								<div class="social-icon" style="text-align: right;margin-top: 3px">

									<ul class="list-unstyled" style="height: 32px;margin-left: 0;padding-left: 0">
										@if(!empty($date))
										@php $date_show=\App\Models\Epaper::GetBanglaDate($date); @endphp
										<li style="font-size: 18px; margin-bottom: 0px; line-height: 21px; color: #BB1919; padding-top: 3px">
											{{isset($date_show) ? $date_show : ''}}
											<input type="hidden" id="bangla_date" name="bangla_date" value="{{isset($date_show) ? $date_show : ''}}">
										</li>
										@endif

									</ul>

								</div>
							</td>
						</tr>
					</table>
				</div>
			</div>
			<div class="main-container">
				<div style="display: flex; flex-direction: column; align-items: center; justify-content: center; padding-top:10px; padding-bottom:10px;">
					<!-- epaper_header_top_ad -->
					@php $epaper_header_top_ad = \App\Models\Epaper::GetAdvertisement('epaper_header_top'); @endphp
					@if(!empty($epaper_header_top_ad) && !empty($epaper_header_top_ad->ad_code) && ($epaper_header_top_ad->ad_status=='1'))
					<?php echo $epaper_header_top_ad->ad_code; ?>
					@endif
					<!-- end epaper_header_top_ad -->
				</div>
			</div>
			<!-- header top end -->
			@endif
			
		</div>


	<div class="main-container" >
		<div class="row-div" style="overflow: hidden;">

			@if(empty($page_name) && !empty($get_categories) && (count($get_categories)>0))
			<!-- left paper div -->
			<div class="row-div-left" style="padding-left: 10px;width: 170px;margin-left: 0px;">
				<p style="text-align: center;background-color: #eeeeee;padding: 4px;border: 1px solid #D2D0CE;border-bottom: none;"><img src="{{asset('assets/images/front/all1.png')}}"></p>
				<div style="border: 1px solid #D2D0CE;width: 168px;height: 1015px;overflow-y: scroll;">
					<ul style="list-style: unset;padding: 0px;margin: 0px;">
						@foreach($get_categories as $key => $page)
						<li style="padding: 10px">
							<a style="text-decoration: none;" href="{{url('/'.$page_edition.'/'.$date.'/'.$page->page_number)}}"><img src="{{asset('uploads/epaper/'.date('Y',strtotime($page->publish_date)).'/'.date('m',strtotime($page->publish_date)).'/'.date('d',strtotime($page->publish_date)).'/thumb/'.$page->image)}}" style="width: 100%">
								<p style="margin-bottom: 0px;padding: 3px;background-color: #ebe5de;text-align: center;color: black;border-bottom: 2px solid #939993">{{$page->name}}</p>
							</a>
						</li>
						@endforeach
					</ul>
				</div>
			</div>
			@endif

			<!-- main paper div -->
			<div class="row-div-left" style="padding-left: 10px;width: auto;margin-left: 10px">
				<div>
					@yield('content')
				</div>
			</div>

			<!-- search result not found messages -->
			@if(Session::has('message_not_found'))
			<span id="message_not_found"></span>
			@endif
			<!-- end search result not found messages -->


			<!-- right sidebar -->
			<div class="row-div-right" style="padding-right: 10px;margin-right: 0px;width: 200px">
				<div class="right-content" style="margin-top: 0px;background-color: white;border: none;padding: 0px !important;overflow: hidden;">

					<!-- sidebar ad 1 -->
					@php $sidebar_ad_1 = \App\Models\Epaper::GetAdvertisement('sidebar_ad_1'); @endphp
					@if(!empty($sidebar_ad_1) && !empty($sidebar_ad_1->ad_code) && ($sidebar_ad_1->ad_status=='1'))
					<div class="add text-center" style="margin-top: 0px;margin-bottom:10px;padding: 5px;border: 1px solid #c5c5c5">
						<?php echo $sidebar_ad_1->ad_code; ?>
					</div>
					@endif

					<!-- datepicker -->
					<p style="background-color: #EEEEEE;color: black;padding: 6px;text-align: center;width: auto;font-size: 18px;margin-bottom: 0px;border: 1px solid #c5c5c5;border-bottom: none;">পুরোনো সংখ্যা</p>
					<div id="Datepicker1"></div>

					<!-- sidebar ad 2 -->
					@php $sidebar_ad_2 = \App\Models\Epaper::GetAdvertisement('sidebar_ad_2'); @endphp
					@if(!empty($sidebar_ad_2) && !empty($sidebar_ad_2->ad_code) && ($sidebar_ad_2->ad_status=='1'))
					<div class="add text-center" style="margin-top: 10px;padding: 5px;border: 1px solid #c5c5c5">
						<?php echo $sidebar_ad_2->ad_code; ?>
					</div>
					@endif

					<!-- categories -->
					@if(!empty($get_categories) && (count($get_categories)>0))
					<div class="add text-center" style="margin-top: 10px">
						<p style="background-color: #EEEEEE;color: black;padding: 6px;text-align: center;width: auto;font-size: 18px;margin-bottom: 0px;border: 1px solid #c5c5c5;border-bottom: none;">আজকের পত্রিকা</p>
						<div style="border: 1px solid #c5c5c5;">
							<ul style="list-style: none;padding: 0px;margin: 0px;text-align: left;">
								@foreach($get_categories as $key => $category)
								@if(!empty($category->category_id))
								<li style="border-bottom: 1px solid #c5c5c5;padding: 8px 10px 8px 10px"><a style="font-size: 18px;color: black;text-decoration: none;" href="{{url('/nogor-edition/'.$category->publish_date.'/'.$category->page_number)}}"> &#8594; {{$category->name}}</a></li>
								@endif
								@endforeach
							</ul>
						</div>
					</div>
					@endif

					<!-- sidebar ad 3 -->
					@php $sidebar_ad_3 = \App\Models\Epaper::GetAdvertisement('sidebar_ad_3'); @endphp
					@if(!empty($sidebar_ad_3) && !empty($sidebar_ad_3->ad_code) && ($sidebar_ad_3->ad_status=='1'))
					<div class="add text-center" style="margin-top: 10px;padding: 5px;border: 1px solid #c5c5c5">
						<?php echo $sidebar_ad_3->ad_code; ?>
					</div>
					@endif

					<!-- sidebar ad 4 -->
					@php $sidebar_ad_4 = \App\Models\Epaper::GetAdvertisement('sidebar_ad_4'); @endphp
					@if(!empty($sidebar_ad_4) && !empty($sidebar_ad_4->ad_code) && ($sidebar_ad_4->ad_status=='1'))
					<div class="add text-center" style="margin-top: 10px;padding: 5px;border: 1px solid #c5c5c5">
						<?php echo $sidebar_ad_4->ad_code; ?>
					</div>
					@endif

				</div>
			</div>

		</div>
	</div>


	<div class="main-container">
		<div style="display: flex; flex-direction: column; align-items: center; justify-content: center;">
			<!-- epaper_header_top_ad -->
			@php $epaper_header_bottom_ad = \App\Models\Epaper::GetAdvertisement('epaper_header_bottom'); @endphp
			@if(!empty($epaper_header_bottom_ad) && !empty($epaper_header_bottom_ad->ad_code) && ($epaper_header_bottom_ad->ad_status=='1'))
			<?php echo $epaper_header_bottom_ad->ad_code; ?>
			@endif
			<!-- end epaper_header_top_ad -->
		</div>

	</div>


	<div class="footer-contend">
		@if(!empty($arr))

		<div class="main-container" style="background-color: #EEEEEE; margin-top: 20px; padding: 30px;">
			<div class="footer_texts">
				<table style="width: 100%">
					<tr>
						<td style="width: 250px">
							<p class="footerLogo"><img src="@if(!empty(setting()->logo)) {{asset('logo')}}/{{setting()->logo}}@endif" style="width: 250px"></p>
						</td>
						<td style="width: 750px">
							<div style="text-align: left !important;padding-left: 10px">
								<p style="color: black;font-size: 16px"><?php echo $arr[2]; ?> </p>
								<p></p>
								<p style="color: black;font-size: 16px"><?php echo $arr[3]; ?> </p>
							</div>
						</td>
						
						<td style="width: 200px; text-align: center;">
							<div>
								<a href="{{ $arr[5] }}" target="_blank">
									<abbr title="Facebook">
										<img src="{{asset('logo/facebook.png')}}" height="30" alt="">
									</abbr>
								</a>
							</div>

							<div>
								<a href="{{$arr[6]}}" target="_blank">
									<abbr title="Twitter">
										<img src="{{asset('logo/twitter.png')}}" height="30" alt="">
									</abbr>
								</a>
							</div>

							<div>
								<a href="{{$arr[7]}}" target="_blank">
									<abbr title="Youtube">
										<img src="{{asset('logo/youtube.png')}}" height="30" alt="">
									</abbr>
								</a>
							</div>
						</td>
					</tr>
				</table>
			</div>
			<p style="background-color: #EEEEEE; margin-top: 10px; padding: 10px; font-size: 14px; color: black; border-top: 1px solid #636363; text-align: center; padding-right: 0px; padding-left: 0px">
			Developed by: <a style="color: black; text-decoration: none;" href="https://contriverit.com" target="_blank"><strong>Contriver IT</strong></a>
		</p>
		</div>
		@endif
	</div>
	
	@php $publishDates = DB::table('publish_dates')->where('status', 1)->pluck('publish_date'); @endphp


	<!-- datepicker -->
	<script type="text/javascript">
		jQuery(function() {
			var enableDays = <?php echo json_encode($publishDates); ?>;

			function enableAllTheseDays(date) {
				var sdate = $.datepicker.formatDate('yy-mm-dd', date)
				if ($.inArray(sdate, enableDays) != -1) {
					return [true];
				}
				return [false];
			}
			$('#Datepicker1').datepicker({
				dateFormat: 'yy-mm-dd',
				beforeShowDay: enableAllTheseDays
			});
		})


		$(function() {
			$("#Datepicker1").datepicker();
			$("#Datepicker1").on("change", function() {
				var archive_date = $(this).val();
				var site_url = $(".site_url").val();
				if (archive_date == '') {
					alert('Please Select A Valid Date !');
					window.reload();
				}
				if (archive_date != null) {
					var request_url = site_url + '/nogor-edition/' + archive_date + '/1';
					window.location = request_url;
				}
			});
		});
	</script>
	<!-- search result not found -->
	<script type="text/javascript">
		$(function() {
			$('<div class="alert-box message_body">আপনি যে বিষয়টি অনুসন্ধান করছেন তা খুজে পাওয়া যায়নি !! আপনাকে ধন্যবাদ খবর অনুসন্ধান করার জন্য ।</div>')
				.insertBefore('#message_not_found')
				.delay(3000)
				.fadeOut(4000, function() {
					$(this).remove();
				});
		});
	</script>

	<input type="hidden" class="site_url" value="{{Route('home')}}">
	<input type="hidden" class="site_url_name" value="@if(!empty(Request::route()->getName()))){{\Request::route()->getName()}}@endif">
	{{-- <input type="hidden" class="current_url" value="{{Route::getCurrentRoute()->getPath()}}"> --}}
</body>

</html>