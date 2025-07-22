@extends('stack.layouts.admin')
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script> 
<link href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css" rel="stylesheet">

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.all.min.js"></script>
<link rel="stylesheet" href="https://unpkg.com/bootstrap@5.3.3/dist/css/bootstrap.min.css">
<link rel="stylesheet" href="https://unpkg.com/bs-brain@2.0.4/tutorials/timelines/timeline-7/assets/css/timeline-7.css">
@section('content')
<div class="container-fluid">
  <div class="animated fadeIn">
    <div class="row">
      <div class="col-sm-12">

        <form method="POST" action="/vendortype/update/{{$vendor->id}}" enctype="multipart/form-data">
        @method('PUT')

          @csrf
          <div class="card">
            <div class="card-header">
              <strong>Add Vendor Type</strong>
              <a href="{{ route('vendor-types.index') }}" class="btn btn-primary btn-sm pull-right">
                <i class="fa fa-list"></i> Vendor Type List
              </a>
            </div>

            <div class="card-body">
              <div class="row">
                <div class="col-sm-6">
                  <div class="form-group">
                    <label for="name">Name.</label>
                    <input class="form-control" id="name" name="name"  value="{{$vendor->name}}" type="text" required>
                  </div>
                </div>
                <div class="col-sm-6">
                  <div class="form-group" style="margin-top: 40px;">
                    <div class="checkbox">
                    <div class="mt-2">  
                      <label>
                        <input type="checkbox" id="active" name="active" value="1">  Active
                      </label>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>

            <div class="card-footer">
              <div class="form-group pull-right">
                <a href="{{ route('vendor-types.index') }}" class="btn btn-default">Cancel</a>
                <button type="submit" class="btn btn-primary">Save</button>
              </div>
            </div>
          </div>
        </form>

        <br>


      </div>
    </div>
  </div>
</div>


@endsection
