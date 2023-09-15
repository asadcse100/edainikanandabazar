
<div class="modal-header">
	<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
	<h4 class="modal-title" id="exampleModalLabel">Update Page Information</h4>
</div>


<!-- end page update info -->
<form class="form-horizontal" action="{{url('/page/update',$page_info->page_id)}}" method="post" enctype="multipart/form-data">
	<input type="hidden" name="_token" value="{{csrf_token()}}">
	<input type="hidden" name="publish_date" value="{{$page_info->publish_date}}">

	<div class="modal-body">

		<div class="form-group">
		<div class="col-sm-3 col-sm-offset-1">
			<label class="control-label"><b>Edition</b></label>
		</div>
		<div class="col-sm-7">
			
			<div>
				<select id="editonSelectionEdit" multiple="multiple" class="edition_get_edit">
					@if(!empty($edition_list) && (count($edition_list)>0))
					@foreach($edition_list as $key => $editions)
					@php $editions_get=\App\Page::PageEdition($page_info->publish_date, $page_info->page_id); @endphp
					@if(!empty($editions_get) && (count($editions_get)>0))
					@php $check_edition=0;@endphp
					@foreach($editions_get as $key => $page_edition)
					@if($page_edition->id==$editions->id)
					@php $check_edition=1;@endphp
					@endif
					@endforeach
					@endif
					<option value="{{$editions->id}}" {{isset($check_edition) && ($check_edition==1) ? 'selected' : ''}}>{{$editions->name}}</option>
					@endforeach
					@endif
				</select>
				<input type="hidden" name="edition" id="editions_value_edit" required="">
			</div>
		</div>
	</div>

	<!-- <input type="hidden" name="edition" value="1" required=""> -->

	<div class="form-group">
		<div class="col-sm-3 col-sm-offset-1">
			<label class="control-label"><b>Category</b></label>
		</div>
		<div class="col-sm-7">
			<select class="form-control" name="category" >
				<option value="">--Select Category--</option>
				@if(!empty($category_list) && (count($category_list)>0))
				@foreach($category_list as $key => $categories)
				<option value="{{$categories->id}}" {{isset($page_info) && ($page_info->category_id==$categories->id) ? 'selected' : ''}}>{{$categories->name}}</option>
				@endforeach
				@endif
			</select>
		</div>
	</div>

	<div class="form-group">
		<div class="col-sm-3 col-sm-offset-1">
			<label class="control-label"><b>Page Number</b></label>
		</div>
		<div class="col-sm-7">
			<select class="form-control" name="page_number" required="">
				@for ($i = 01; $i <= 200; $i++) 
				<option value="{{$i}}" {{isset($page_info) && ($page_info->page_number==$i) ? 'selected' : ''}} >Page {{str_pad($i, 2, "0", STR_PAD_LEFT)}}</option>
				@endfor
			</select>
		</div>
	</div>

</div>

<div class="modal-footer">
	<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
	<button type="submit" class="btn btn-primary">Update Page !</button>
</div>
</form>
<!-- end page update info -->


<!-- multi select -->
<script type="text/javascript">
	$(function() {
		$('#editonSelectionEdit').multiselect({
			includeSelectAllOption: true
		});

		// edition get
		jQuery(function(){
			jQuery('.edition_get_edit').change(function(){
				var x_edit= $('#editonSelectionEdit').val();
				var editions_edit = x_edit;
				$("#editions_value_edit").val( editions_edit );
			});
		});

	});
</script>
