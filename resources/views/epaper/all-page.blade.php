@extends('layouts.app')
<style type="text/css">
	li.current_edition:hover{
		background-color: inherit !important
	}
</style>
@section('content')

<!-- content -->
<div class="row-div-left" style="padding-bottom: 0px;margin-left: 0px;width: 900px;">

	<div class="single-page-div" style="margin-top: 0px;border:2px solid #ededed">
		<ul class="list-unstyled">
			@if(!empty($get_categories) && (count($get_categories)>0))
			@foreach($get_categories as $key => $page)
			<li>
				<a href="{{url('/'.$page_edition.'/'.$date.'/'.$page->page_number)}}">
					<img src="{{asset('uploads/epaper/'.date('Y',strtotime($page->publish_date)).'/'.date('m',strtotime($page->publish_date)).'/'.date('d',strtotime($page->publish_date)).'/thumb/'.$page->image)}}" class="img-responsive thumbnail" width="148px" style="border: 2px solid #ddd;border-radius: 0px">
					<span style="color:#2C3E50;margin-top: 50px;font-weight: bold;">{{$page->name}}</span>
				</a>
			</li>
			@endforeach
			@else
			<img src="{{asset('assets/images/404.png')}}">
			@endif
		</ul>

	</div>
</div>
<!-- end content -->

@endsection