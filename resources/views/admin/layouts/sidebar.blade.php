<aside class="main-sidebar">
	<!-- sidebar: style can be found in sidebar.less -->
	<section class="sidebar">
		<!-- Sidebar user panel -->
		<div class="user-panel">
			<div class="pull-left image">
				@if(!empty(\Auth::user()->user_image))
				<img src="{{asset('admin/assets/images/avatars/'.\Auth::user()->user_image)}}" class="img-circle" alt="User Image">
				@else
				<img src="{{asset('admin/assets/images/avatars/default_avatar.png')}}" class="img-circle" alt="User Image">
				@endif
			</div>
			<div class="pull-left info">
				<p>{{\Auth::user()->name}}</p>
				<a href="#"><i class="fa fa-circle text-success"></i> Online</a>
			</div>
		</div>

		<!-- sidebar menu: : style can be found in sidebar.less -->
		<ul class="sidebar-menu">

			<li class="header" style="color: #00C0EF">ePaper Operator Controls</li>
			<li class="{{ Request::is('home') ? 'active' : '' }}">
				<a href="{{url('/home')}}">
					<i class="fa fa-dashboard"></i> <span>Dashboard</span>
				</a>
			</li>

			<li class="{{ Request::is('manage-category') ? 'active' : '' }}">
				<a href="{{url('/manage-category')}}">
					<i class="fa fa-list"></i> <span>Manage Categories</span>
				</a>
			</li>

			<li class="{{ Request::is('manage-edition') ? 'active' : '' }}">
				<a href="{{url('/manage-edition')}}">
					<i class="fa fa-adjust"></i> <span>Manage Editions</span>
				</a>
			</li>

			<li class="{{ Request::is('manage-pages') || (Route::currentRouteName()=='Image Mapping') ? 'active' : '' }}">
				<a href="{{url('/manage-pages')}}">
					<i class="fa fa-picture-o"></i> <span>Manage Pages </span>
				</a>
			</li>

			<li class="{{ Request::is('publish-pages') ? 'active' : '' }}">
				<a href="{{url('/publish-pages')}}">
					<i class="fa fa-eye"></i> <span>Publish Pages </span>
				</a>
			</li>

			@if(Auth::user()->role == 'admin')
			<li class="header" style="color: #00C0EF">ePaper Admin Controls</li>

			<li class="{{ Request::is('manage-advertisements') ? 'active' : '' }}">
				<a href="{{url('/manage-advertisements')}}">
					<i class="fa fa-bullhorn"></i> <span>Manage Advertisements </span>
				</a>
			</li>

			<li class="{{ Request::is('manage-users') ? 'active' : '' }}">
				<a href="{{url('/manage-users')}}">
					<i class="fa fa-users"></i> <span>Manage Users </span>
				</a>
			</li>
			@endif
			@if(Auth::user()->role == 'admin')
			<li onclick="sidebar_open();">
				<a>
					<i class="fa fa-copy"></i> <span>Copy Right Text</span>
				</a>
			</li>

			<li class="{{ Request::is('settings') ? 'active' : '' }}">
				<a href="{{Route('settings')}}">
					<i class="fa fa-cog"></i> <span>Settings</span>
				</a>
			</li>

			<li class="{{ Request::is('topbar_info') ? 'active' : '' }}">
				<a href="{{Route('topbar_info')}}">
					<i class="fa fa-cog"></i> <span>Topbar Info</span>
				</a>
			</li>
			@endif
		</ul>
	</section>
	<!-- /.sidebar -->
</aside>
<style>
	* {
		box-sizing: border-box;
		margin: 0px;
		padding: 0px;
	}

	#screen1 {
		width: 100%;
		height: 100%;
		position: fixed;
		top: 0px;
		left: 0px;
		background: rgba(0, 0, 0, 0.1);
		z-index: 99;
		display: none;
	}

	#block1 .cancel {
		width: 20px;
		height: 20px;
		background: transparent;
		font-size: 1.3em;
		position: sticky;
		left: calc(100% - 10px);
		z-index: 2;
		top: 15px;
	}

	#block1 .ttl {
		width: 100%;
		padding-top: 30px;
		text-align: center;
		border-bottom: 2px solid rgba(0, 0, 0, 0.2);
		font-size: 1.2em;
		padding-bottom: 7px;
		margin-bottom: 5px;
		position: sticky;
		top: -20px;
		background: white;
	}

	#block1 {
		padding: 20px;
		padding-top: 0px;
		display: none;
	}

	#block1 .in_block {
		width: 100%;
		margin-bottom: 10px;
	}

	#block1 .in_block input {
		height: 30px;
		border: none;
		width: 100%;
		border-bottom: 2px solid dodgerblue;
		padding: 0px 5px;
	}

	#block1 .in_block textarea {
		border: none;
		width: 100%;
		border-bottom: 2px solid dodgerblue;
		padding: 0px 5px;
		margin-top: 5px;
		padding-bottom: 7px;
	}

	#block1 .in_block lebel {
		width: 100%;
		color: rgba(0, 0, 0, 0.7);
	}

	#block1 [value~=save] {
		width: 100%;
		height: 45px;
		background: dodgerblue;
		color: white;
		border: none;
		font-size: 1.2em;
		font-weight: 500;
		text-transform: uppercase;
		margin-top: 10px;
		border-radius: 6px;
	}

	@media only screen and (max-width: 768px) {
		#block1 {
			width: 100%;
			height: 100%;
			background: white;
			position: fixed;
			z-index: 999;
			overflow: scroll;
		}
	}

	@media only screen and (min-width: 768px) {
		#block1 {
			width: calc(100% - 230px);
			height: calc(100% - 50px);
			background: white;
			position: fixed;
			z-index: 999;
			right: 0px;
			overflow: scroll;
		}
	}
</style>
<div id="screen1" onclick="sidebar_open()"></div>
<div id="block1" class="block1">
	<i class="fa fa-times cancel" data-status="1" id="dt" onclick="sidebar_open()"></i>
	<p class="ttl">Manage Title & Copyright</p>


	<?php
	$file = fopen("log.txt", "r");
	$arr = fread($file, filesize("log.txt"));
	fclose($file);
	$arr = explode("⎌", $arr);
	?>

	@if(!empty($arr))
	<div class="in_block">
		<lebel>Title Text</lebel>
		<textarea class="in1" row="3"><?php echo $arr[0]; ?> </textarea>
	</div>
	<div class="in_block">
		<lebel>Online Version Link</lebel>
		<input class="in1" type="text" value="<?php echo $arr[1]; ?> ">
	</div>
	<div class="in_block">
		<lebel>Editor</lebel>
		<textarea class="in1"><?php echo $arr[2]; ?> </textarea>
	</div>
	<div class="in_block">
		<lebel>Publisher</lebel>
		<textarea class="in1"><?php echo $arr[3]; ?> </textarea>
	</div>
	<div class="in_block">
		<lebel>CopyRight</lebel>
		<textarea class="in1"><?php echo $arr[4]; ?> </textarea>
	</div>
	<div class="in_block">
		<lebel>Facebook Link</lebel>
		<input class="in1" type="text" value="<?php echo $arr[5]; ?> ">
	</div>
	<div class="in_block">
		<lebel>Twitter Link</lebel>
		<input class="in1" type="text" value="<?php echo $arr[6]; ?> ">
	</div>
	<div class="in_block">
		<lebel>Youtube Link</lebel>
		<input class="in1" type="text" value="<?php echo $arr[7]; ?> ">
	</div>
	@endif
	<div style="position:relative;width:300px;height:100px;"><img src="@if(!empty(setting()->logo)) {{asset('logo')}}/{{setting()->logo}}@endif" style="width:100%;height:100%;position:absolute;z-index:1;top:0px;left:0px;" id="logo_img">
		<input type="file" accept="image/*" src="@if(!empty(setting()->logo)) {{asset('logo')}}/{{setting()->logo}}@endif" style="width:100%;height:100%;position:absolute;z-index:2;top:0px;left:0px;opacity:0px;opacity:0;" oninput="send_image(this)">
	</div>
	<input type="button" value="save" onclick="send_ajax()">
</div>

<script>
	function send_ajax() {
		var post = "";
		var inputs = document.getElementsByClassName("in1");
		for (var a = 0; a < inputs.length; a++) {
			if (a == 0) {
				post = "data" + a + "=" + encodeURI(inputs[a].value);
			} else {
				post = post + "&&data" + a + "=" + encodeURI(inputs[a].value);
			}
			/* condition */
		}
		url = "ajax.php";
		serve_ajax(url, post);
		/* loop */
	}

	function sidebar_open() {
		var status = document.getElementById("dt");
		var screen1 = document.getElementById("screen1").style;
		var block1 = document.getElementById("block1").style;
		if (status.getAttribute("data-status") == 0) {
			status.setAttribute("data-status", "1");
			screen1.display = "none";
			block1.display = "none";
		} else {
			status.setAttribute("data-status", "0");
			screen1.display = "block";
			block1.display = "block";
		}
	}

	function send_image(data) {
		var img1 = data;
		var formData = new FormData();
		if (true) {
			var file1 = img1.files[0];
			if (file1) {
				formData.append("img1", file1);
				var url = "save_image.php";
				var post = formData;
				serve_ajax(url, post, "", '1');
			} else {
				alert("your file is not an image");
			}
		}
	}

	function serve_ajax(link, post, msg_bx, encrypt) {
		var xhttp;
		if (window.XMLHttpRequest) {
			xhttp = new XMLHttpRequest();
		} else {
			// code for IE6, IE5
			xhttp = new ActiveXObject("Microsoft.XMLHTTP");
		}
		xhttp.onreadystatechange = function() {
			if (this.readyState == 4 && this.status == 200) {
				var arr = this.responseText.split("⎌");

				if (arr[1] == 1) {
					document.getElementById("logo_img").src = arr[0];
					alert("Logo Updated Please Clear Your Cache And Refresh You Page");
				} else {
					alert(arr[0]);
				}
				// condition
			}
			// server return end
		};
		xhttp.open("POST", link, true);
		if (encrypt == "1") {} else {
			xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
		}
		xhttp.send(post);
	}
</script>