<!DOCTYPE html>
<html lang="en">

<head>

	<!-- meta tag -->
	<meta http-equiv="X-UA-Compatible" content="IE=edge" />
	<title>আনন্দবাজার ই-পেপার | E.dainikanandabazar </title>
	<meta name="Author" content="Origin IT" />
	<meta name="Developed By" content="Origin IT" />
	<meta name="Developer" content="Origin IT" />
	<meta name="keywords" content="E dainikanandabazar, dainik anandabazar,dainikanandabazar epaper,ই আনন্দবাজার, আনন্দবাজার ই পেপার, আজকের আনন্দবাজার, bangla newspaper, bangla newspapers, bangla newspapers, bangla paper, bd newspaper, newspaper bd, newspaper bangladesh, bangladesh newspaper, bangladesh news, bangla news, bangladeshi newspapers, bangladeshi bangla newspapers, bangla news paper, bangladeshi newspaper, bd news paper, banglaeshi newspapers, list of bangla newspaper, online bangla newspaper, bd online newspaper, bd online newspapers, newspaper bangladesh, bd news, news bd, bdnews, newsbd, daily newspaper of bangladesh, daily newspapers of bangladesh, daily newspaper of bd, daily newspapers of bd, list of bd newspapers, bangladesh newspaper news, bd newspaper list, bangla daily newspaper, bd newspaper every day, bd newspaper every day, allbanglanewspaper, bdnewspapereveryday, bangla news, allbanglanewspapers, allbanglanewspaper, bdnewspaper, newspaperbd, bangla news paper, the daily bangladesh pratidin, newspaper bangladesh, newspaper bangla, newspaper in bangladesh, bangladeshi newspaper, bangla newspaper in bd, bangla, newspaper, all, news, list, bengali, bangali, bd, allbdnews, bd news, bd news paper, bangladesh paper, bangladesh newspapers, bangla news 24, bd news 24, 24 online bangla newspaper, technology, computer, financial, finance, bangladesh, bangla news, Prothom Alo, Prothom Alo newspaper,  bangla newspaper online, bangla newspaper in bangladesh, bangladeshi newspaper, bangla newspaper list, bangla, news, newspaper, all, newspapers, online, online bangla newspaper, online bangla newspapers, bd, agency, online bengali newspaper, bengali newspaper, bengali newspaper, bengali newspapers, bengali news paper, bengali patrika, patrika, bd patrika, bd newspaper, bd newspaper, dainik shokalar khabar, shokalar khabar, finance, econimic, technilogy, polital news, banking news, share bazar news, share bazar, beauty, bazaar, market, manab kantho, daily manab kantho, daily newspaper of bangladesh, poriborton, bangla newspaper online, daily bangla newspaper, bengali newspapers, daily bengali newspapers, online bengali newspaper, daily bangla newspaper, prothom-alo, bangla news, bangla news online, bengali newspaper, news paper of bangladesh, bd newspaper, news paper bangladesh, Bangladesh News Live, Bangla Newspaper Headlines, Bangladesh News Update, সংবাদপত্র, বাংলা সংবাদপত্র,  Business, technology, financial, media, portal, foreign news bangal online news, bangla news portal, bangladesh news agency, news agency, bangla news agency" />
	<meta http-equiv="Cache-Control" content="no-cache" />
	<meta http-equiv="Pragma" content="no-cache" />
	<meta name="distribution" content="Global">
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta http-equiv="Content-Language" content="bn" />
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">

	<meta property="og:title" content="ePaper" />
	@if(!empty($home_page))
	<meta property="og:image" content="{{asset('uploads/epaper/'.date('Y',strtotime($home_page->publish_date)).'/'.date('m',strtotime($home_page->publish_date)).'/'.date('d',strtotime($home_page->publish_date)).'/pages/'.$home_page->image)}}" />
	<link rel="image_src" href="{{asset('uploads/epaper/'.date('Y',strtotime($home_page->publish_date)).'/'.date('m',strtotime($home_page->publish_date)).'/'.date('d',strtotime($home_page->publish_date)).'/pages/'.$home_page->image)}}" />
	@endif
	<meta property="og:image:type" content="image/jpeg" />
	<meta name="description" content="Daily  publishing news in both online and print media by covering article - Entertainment, Business, Politics, Education,Sports, Crime, Opinion, Lifestyle, Photo, Video, Travel, National, World." />


	<!-- icon -->
	<link rel="icon" type="image/png" href="{{asset('assets/images/32x32.png')}}" />

	<!-- font awesome css -->
	<link rel="stylesheet" type="text/css" href="{{asset('assets/font-awesome/css/font-awesome.min.css')}}" />
	<!-- main css -->
	<link rel="stylesheet" href="{{asset('assets/css/main.css?v=1.2')}}" />
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
	<?php
	$file = fopen("log.txt", "r");
	$arr = fread($file, filesize("log.txt"));
	fclose($file);
	$arr = explode("⎌", $arr);
	?>
	<div class="main-container" style="margin-top: 10px;margin-bottom: 10px;border: 3px solid #e2dbdb;width: 1150px">
		<div class="header-div">
			<div class="header-div">
				@if(!empty($arr))
				<!-- header top -->
				<div class="top-header" style="height: 33px;padding: 5px 10px;background-color: #EEEEEE;box-shadow: none;border-bottom: none;">
					<table width="100%" cellspacing="0" cellpadding="0" border="0">
						<tr>
							<td>
								<div class="date text-left" style="margin-top: 2px">
									<!-- <p style="color: black;font-size: 17px"><?php echo $arr[0]; ?>| অনলাইন ভার্সন দেখতে ক্লিক করুন <a style="color: #3C5A98" href="<?php echo $arr[1]; ?>" target="_blank">অনলাইন ভার্সন</a></p> -->
									<!-- <p style="color: black;font-size: 17px"><?php echo $arr[0]; ?>| <a style="color: #3C5A98" href="<?php echo $arr[1]; ?>" target="_blank">অনলাইন ভার্সন</a></p> -->

									<p style="color: black;font-size: 17px">
										<?php echo $arr[0]; ?>| <a style="color: #3C5A98" href="<?php echo $arr[1]; ?>" target="_blank">অনলাইন ভার্সন</a>
										@foreach(DB::table('topbar_infos')->get() as $data)
										<a style="color: #3C5A98" href="{{$data->url}}" target="_blank">
											{{$data->title}} |
										</a>
										@endforeach
									</p>
								</div>
							</td>

							<td>
								<div class="social-icon" style="text-align: right;margin-top: 3px">
									<ul class="list-unstyled" style="height: 32px;margin-left: 0;padding-left: 0">
										<li class="fb btn"><a href="<?php echo $arr[5]; ?>" target="_blank"><abbr title="Facebook"><i class="fa fa-facebook" aria-hidden="true"></i></abbr></a>
										</li>
										<li class="twit btn"><a href="<?php echo $arr[6]; ?>" target="_blank"><abbr title="Twitter"><svg xmlns="http://www.w3.org/2000/svg" height="1em" viewBox="0 0 512 512">
														<path d="M389.2 48h70.6L305.6 224.2 487 464H345L233.7 318.6 106.5 464H35.8L200.7 275.5 26.8 48H172.4L272.9 180.9 389.2 48zM364.4 421.8h39.1L151.1 88h-42L364.4 421.8z" />
													</svg></abbr></a>
										</li>
										<li class="gplus btn"><a href="<?php echo $arr[7]; ?>" target="_blank"><i class="fa fa-youtube" aria-hidden="true"></i></a>
										</li>
									</ul>
								</div>
							</td>
						</tr>
					</table>
				</div>
				<!-- header top end -->

				@endif


				<div class="container">
					<div style="display: flex; items-center">
						<div style="flex: 1; padding: 3px;">
							<div class="add text-center">
								<a href="{{Route('home')}}"><img src="@if(!empty(setting()->logo)) {{asset('logo')}}/{{setting()->logo}}@endif" style="width: 250px"></a>

							</div>
						</div>
						<div style="flex: 1; padding: 3px;">
							<div class="add text-center">
								@if(!empty($date))
								<p>
									@php $date_show=\App\Models\Epaper::GetBanglaDate($date); @endphp
								<p style="font-size: 18px; margin-bottom: 0px; line-height: 21px; color: #BB1919; padding-top: 3px">{{isset($date_show) ? $date_show : ''}}</p>
								<input type="hidden" id="bangla_date" name="bangla_date" value="{{isset($date_show) ? $date_show : ''}}">
								</p>

								<p style="margin-top: 10px">
									@if(!empty($date))
									<a href="{{url('/all/pages/nogor-edition/'.$date)}}"><img src="{{asset('assets/images/front/all1.png')}}"></a>
									@endif
									@if(!empty($home_page) && !empty($date))
									<a href="javascript::void(0)" onclick='printPage("{{asset('uploads/epaper/'.date('Y',strtotime($home_page->publish_date)).'/'.date('m',strtotime($home_page->publish_date)).'/'.date('d',strtotime($home_page->publish_date)).'/pages/'.$home_page->image)}}");'><img src="{{asset('assets/images/front/print.png')}}"></a>
									@endif
								</p>
								@endif
							</div>
						</div>
						<div style="flex: 1; padding: 3px;">
							<div class="add text-center">
								<!-- epaper_header_top_ad -->
								@php $epaper_header_top_ad = \App\Models\Epaper::GetAdvertisement('epaper_header_top'); @endphp
								@if(!empty($epaper_header_top_ad) && !empty($epaper_header_top_ad->ad_code) && ($epaper_header_top_ad->ad_status=='1'))
								<?php echo $epaper_header_top_ad->ad_code; ?>
								@endif
								<!-- end epaper_header_top_ad -->
							</div>
						</div>
					</div>
				</div>
			</div>

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

			<!-- epaper_header_bottom_ad -->
			@php $epaper_header_bottom_ad = \App\Models\Epaper::GetAdvertisement('epaper_header_bottom'); @endphp
			@if(!empty($epaper_header_bottom_ad) && !empty($epaper_header_bottom_ad->ad_code) && ($epaper_header_bottom_ad->ad_status=='1'))
			<div class="add text-center" style="background-color: #EEEEEE;margin: 20px;padding: 15px 10px 15px 10px">
				<?php echo $epaper_header_bottom_ad->ad_code; ?>
			</div>
			@endif
			<!-- end epaper_header_bottom_ad -->

			@if(!empty($arr))
			<div class="footer" style="margin-top: 20px">
				<div class="footer-contend" style="padding: 30px">

					<div style="width: 100%;" class="footer_texts">
						<table style="width: 100%">
							<tr>
								<td style="width: 250px">
									<p class="footerLogo"><img src="@if(!empty(setting()->logo)) {{asset('logo')}}/{{setting()->logo}}@endif" style="width: 250px"></p>
								</td>
								<td>
									<div style="text-align: left !important;padding-left: 10px">
										<p style="color: black;font-size: 16px"><?php echo $arr[2]; ?> </p>
										<p></p>
										<p style="color: black;font-size: 16px"><?php echo $arr[3]; ?> </p>
									</div>
								</td>
							</tr>
						</table>
					</div>

					<p style="font-size: 14px;color:black;border-top:1px solid #636363;margin-top: 10px;text-align: left;padding-right: 0px;padding-left: 0px">
						{{ date('Y') }} <?php echo $arr[4]; ?> <!--কারিগরি সহযোগীতায় : <a style="color:black" href="https://Originitbd.com/" target="_blank">ওরাকল আইটি.</a> -->
					</p>
				</div>
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
		{{-- <input type="hidden" class="site_url_name" value="@if(!empty(Request::route()->getName()))){{\Request::route()->getName()}}@endif"> --}}
		{{-- <input type="hidden" class="current_url" value="{{Route::getCurrentRoute()->getPath()}}"> --}}

</body>

</html>