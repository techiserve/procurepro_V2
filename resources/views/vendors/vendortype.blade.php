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

        <form method="POST" action="{{ route('vendor-types.store') }}" enctype="multipart/form-data" onsubmit="return checkIsPasswordSame()">
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
                    <label for="name">Name</label>
                    <input class="form-control" id="name" name="name" type="text" required>
                  </div>
                </div>
                <div class="col-sm-6">
                  <div class="form-group" style="margin-top: 40px;">
                    <div class="checkbox">
                    <div class="mt-2"> <!-- Added margin top -->
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

        <div class="card">
          <div class="card-header">
            <strong>Vendor Types</strong>
          </div>

          <div class="card-body table-responsive">
            <table class="table table-bordered table-striped">
              <thead style="background-color:#000C3D; color:#fff;">
                <tr>
                  <th>Name</th>
                  <th>Action</th>
                </tr>
              </thead>
              <tbody>
                @foreach($vendorTypes as $type)
                <tr>
                  <td>{{ $type->name }}</td>
                  <td>
                    <a href="{{ route('vendor-types.edit', $type->id) }}" class="btn btn-icon btn-info mr-1"><i class="fa fa-pencil"></i>Edit</a>
                         <a href='#'  class="btn btn-icon btn-danger mr-1"style='color: white;' onclick="
                        event.preventDefault(); // Prevent the default link behavior
                        Swal.fire({
                            title: 'Delete Vendor Type?',
                            text: 'You won\'t be able to undo this!',
                            icon: 'info', // Updated property for SweetAlert2
                            showCancelButton: true,
                            confirmButtonText: 'Continue',
                            cancelButtonText: 'Cancel'
                          }).then((result) => {
                            if (result.isConfirmed) {
                              // Redirect to the URL or perform an action
                              window.location.href = '/vendor-types/delete/{{$type->id}}'; // Replace with your actual URL
                            }
                          })
                      ">
                      <span class='fa fa-trash'></span>
                      <span class='hidden-sm hidden-sm hidden-md'> Delete</span>
                    </a>&nbsp;
                  </td>
                </tr>
                @endforeach
                @if($vendorTypes->isEmpty())
                <tr>
                  <td colspan="2" class="text-center">No vendor types found.</td>
                </tr>
                @endif
              </tbody>
            </table>
          </div>
        </div>

      </div>
    </div>
  </div>
</div>

<script>
function checkIsPasswordSame() {
  // Placeholder: add any client-side validation you need
  return true;
}
</script>
@endsection
