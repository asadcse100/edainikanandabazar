@extends('admin.layouts.app')

@section('page-css')
<style type="text/css">
    .table-text-center th {
        text-align: center;
    }

    .table-text-center td {
        text-align: center;
    }

    /*tr:nth-child(even) {
		background-color: #dddddd;
	}*/
</style>
@endsection

@section('content')


<!-- messages -->
<section class="content-header" style="margin-top: 0px">
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
</section>
<!-- end messages -->



<!-- Main content -->
<section class="content">
    <div class="row">

        <div class="col-md-12">
            <div class="box box-success">
                <div class="box-header with-border">
                    <h4 class="box-title">Top Bar</h4> <button type="button" data-toggle="modal" data-target="#addNewUser" class="btn btn-primary btn-xs pull-right"><i class="fa fa-plus"></i> Add New</button>
                </div>
                <div class="box-body">

                    <table class="table table-bordered table-hover table-text-center" id="user-dataTable">
                        <thead>
                            <tr>
                                <th>SL</th>
                                <th>Title</th>
                                <th>Url</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>

                        <tbody>
                            @if(!empty($topbar_infos) && (count($topbar_infos)>0))
                            @foreach($topbar_infos as $key => $list)
                            <tr>
                                <td style="vertical-align: middle;">{{$key+1}}</td>
                                <td style="vertical-align: middle;">{{$list->title}}</td>
                                <td style="vertical-align: middle;">{{$list->url}}</td>
                                <td style="vertical-align: middle;">
                                    @if($list->is_active=='1')
                                    <button type="button" class="btn btn-success btn-xs">Active</button>
                                    @else
                                    <button type="button" class="btn btn-danger btn-xs">Inactive</button>                                    
                                    @endif
                                </td>

                                <td style="vertical-align: middle;">
                                <a type="button" href="{{$list->url}}" class="btn btn-success btn-xs" target="_blank"><i class="fa fa-eye"></i></a>
                                    <button type="button" data-toggle="modal" data-target="#updateTopbarInfo" class="btn btn-info btn-xs openEditModal" data-id="{{$list->id}}" data-title="{{$list->title}}" data-status="{{$list->is_active}}"><i class="fa fa-edit"></i></button>
                                </td>
                            </tr>
                            @endforeach
                            @endif
                        </tbody>
                    </table>

                </div>
            </div>
        </div>
    </div>
</section>
<!-- End Main content -->


<!-- add new topbar info modal -->
<div class="modal fade" id="addNewUser" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="exampleModalLabel">Add New Topbar Info</h4>
            </div>

            <form class="form-horizontal" action="{{ Route('topbar_info.store') }}" method="post" enctype="multipart/form-data">
                <input type="hidden" name="_token" value="{{csrf_token()}}">

                <div class="modal-body">
                    <div class="form-group">
                        <label class="col-sm-3 control-label">Title</label>
                        <div class="col-sm-9">
                            <input type="text" name="title" class="form-control" placeholder="Title" required="required">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-3 control-label">URL</label>
                        <div class="col-sm-9">
                            <input type="text" name="url" class="form-control" required="required" autocomplete="off">
                        </div>
                    </div>

                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Save</button>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- end add new topbar modal -->


<!-- edit topbar modal -->
<div class="modal fade" id="updateTopbarInfo" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="exampleModalLabel">Update Topbar Info</h4>
            </div>

            <form class="form-horizontal" action="{{ Route('topbarinfo_update') }}" method="post" enctype="multipart/form-data">
                <input type="hidden" name="_token" value="{{csrf_token()}}">
                <input type="hidden" name="topbar_id" id="id" value="">

                <div class="modal-body">
                    <div class="form-group">
                        <label class="col-sm-3 control-label">Title</label>
                        <div class="col-sm-9">
                            <input type="text" name="title" id="title" class="form-control" placeholder="Title" required="required">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-3 control-label">URL</label>
                        <div class="col-sm-9">
                            <input type="text" name="url" id="url" class="form-control" placeholder="url" required="required">
                        </div>
                    </div>
                    <div class="form-group">
						<label class="col-sm-3 control-label">Status</label>
						<div class="col-sm-9">
						<select class="form-control" name="is_active" id="is_active" required="required">
								<option value="1">Active</option>
								<option value="0">Inactive</option>
							</select>
						</div>
					</div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Update</button>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- end edit user modal -->

@endsection

@section('page-scripts')
<script type="text/javascript">
    /*#############################
    ## Edit User
    #############################*/
    $(document).on("click", ".openEditModal", function() {
        var id = $(this).data('id');
        var title = $(this).data('title');
        var url = $(this).data('url');
        var is_active = $(this).data('is_active');
        $(".modal-content #id").val(id);
        $(".modal-content #title").val(title);
        $(".modal-content #url").val(url);
        $(".modal-content #is_active").val(is_active);
    });

    // data tables
    $(document).ready(function() {
        $('#user-dataTable').DataTable();
    });
</script>
@endsection