
@extends('admin.layouts.app')

@section('content')

<!-- messages -->
<section class="content-header" >
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
        <div class="box-body">
          <h4>Hello <b>{{Auth::user()->name}}</b> ! <br> You are successfully logged in to ePaper Solution.</h4>
        </div>
      </div>
    </div>
    <div class="col-lg-3 col-xs-6">
      <!-- small box -->
      <div class="small-box bg-aqua" style="border-radius: 10px;">
        <div class="inner">
          <h3>{{isset($total_pages) ? $total_pages : ''}}</h3>

          <p>Today's Page</p>
        </div>
        <div class="icon">
          <i class="fa fa-file-text-o"></i>
        </div>
        <a href="#" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
      </div>
    </div>
    <!-- ./col -->
    <div class="col-lg-3 col-xs-6">
      <!-- small box -->
      <div class="small-box bg-yellow" style="border-radius: 10px;">
        <div class="inner">
          <h3>{{isset($total_pages) ? $total_pages : ''}}</h3>

          <p>Total Published Page</p>
        </div>
        <div class="icon">
          <i class="fa fa-file-text-o"></i>
        </div>
        <a href="#" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
      </div>
    </div>
    <div class="col-lg-3 col-xs-6">
      <!-- small box -->
      <div class="small-box bg-red" style="border-radius: 10px;">
        <div class="inner">
          <h3>{{isset($total_pages) ? $total_pages : ''}}</h3>

          <p>Total Image</p>
        </div>
        <div class="icon">
          <i class="fa fa-file-text-o"></i>
        </div>
        <a href="#" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
      </div>
    </div>
    <div class="col-lg-3 col-xs-6">
      <!-- small box -->
      <div class="small-box bg-green" style="border-radius: 10px;">
        <div class="inner">
          <h3>{{isset($active_ads) ? $active_ads : ''}}</h3>

          <p>Active Ads</p>
        </div>
        <div class="icon">
          <i class="fa fa-bullhorn"></i>
        </div>
        <a href="#" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
      </div>
    </div>
    <!-- ./col -->
    <div class="col-lg-3 col-xs-6">
      <!-- small box -->
      <div class="small-box bg-yellow" style="border-radius: 10px;">
        <div class="inner">
          <h3>{{isset($total_users) ? $total_users : ''}}</h3>

          <p>Total User's</p>
        </div>
        <div class="icon">
          <i class="fa fa-users"></i>
        </div>
        <a href="#" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
      </div>
    </div>
    <!-- ./col -->
    <div class="col-lg-3 col-xs-6">
      <!-- small box -->
      <div class="small-box bg-red" style="border-radius: 10px;">
        <div class="inner">
          <h3>{{isset($total_category) ? $total_category : ''}}</h3>

          <p>Total Categories</p>
        </div>
        <div class="icon">
          <i class="fa fa-tag"></i>
        </div>
        <a href="#" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
      </div>
    </div>
    <!-- ./col -->
  
  </div>

  <div class="row">

    <div class="col-md-12">
      <div class="box box-success">
        <div class="box-header with-border">
          <h1 class="box-title" style="color:rgb(6, 0, 0)">Temporery Folder's</h1>
          <p style="color:brown">NB: Please delete "Temporary Folder" after a certain period. </p>
          
        </div>
        <div class="box-body">

          <table class="table table-hover">
            <thead>
              <tr>
                <th>SL</th>
                <th>Folder Title</th>
                <th>Folder Size</th>
                <th>Action</th>
              </tr>
            </thead>

            <tbody>
              @if(!empty($folder_info) && (count($folder_info)>0))
              @foreach($folder_info as $key => $folder)
              <tr>
                <td>{{$key+1}}</td>
                <td>{{$folder['title']}}</td>
                <td>{{number_format($folder['size'],2)}} MB</td>
                <td><a href="{{url('/home/remove-temp-folder/'.$folder['title'])}}" class="btn btn-danger btn-xs"><i class="fa fa-trash"></i></a></td>
              </tr>
              @endforeach
              @else
              <tr>
                <th colspan="4">
                  <div class="alert alert-info text-center" style="margin-bottom: 0">Temporery Folder is Empty !</div>
                </th>
              </tr>
              @endif
            </tbody>
          </table>

        </div>
      </div>
    </div>
  <!-- ./col -->

  <!-- ./col -->

  </div>

</section>
<!-- /.content -->



@endsection
