@extends('html.default')


<link href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.all.min.js"></script>


@section('content')
<div class="container-fluid">
  <div class="animated fadeIn">
    <div class="row">
      <div class="col-sm-12">

        {{-- Add Vendor Type Form --}}
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
              <div class="col-sm-6 d-flex align-items-center">
                <div class="form-check mt-2">
                  <input class="form-check-input" type="checkbox" id="active" name="active" value="1">
                  <label class="form-check-label" for="active">
                    Active
                  </label>
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

        {{-- Vendor Types Table --}}
        <div class="card">
          <div class="card-header">
            <strong>Vendor Types</strong>
          </div>

          <div class="card-body table-responsive">
         <table class="table table-bordered table-striped">
  <thead style="background-color:#000C3D; color:#fff;">
    <tr>
      <th>Name</th>
      <th style="min-width: 220px;">Action</th> <!-- Increased width -->
    </tr>
  </thead>
  <tbody>
    @foreach($vendorTypes as $type)
    <tr>
      <td>{{ $type->name }}</td>
      <td class="text-nowrap"> <!-- Prevent button wrapping -->
        <a href="{{ route('vendor-types.edit', $type->id) }}" class="btn btn-icon btn-info btn-sm mr-1">
          <i class="fa fa-pencil"></i> Edit
        </a>
        <a href="#" class="btn btn-icon btn-danger btn-sm mr-1"
           onclick="event.preventDefault(); Swal.fire({
             title: 'Delete Vendor Type?',
             text: 'You won\'t be able to undo this!',
             icon: 'info',
             showCancelButton: true,
             confirmButtonText: 'Continue',
             cancelButtonText: 'Cancel'
           }).then((result) => { if(result.isConfirmed){ window.location.href='/vendor-types/delete/{{$type->id}}'; } })">
          <i class="fa fa-trash"></i> Delete
        </a>
      </td>
    </tr>
    @endforeach
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
  // Keeping placeholder logic from original
  return true;
}
</script>
@endsection
  