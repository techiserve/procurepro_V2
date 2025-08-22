@extends('html.default')

<link href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.all.min.js"></script>

@section('content')
<div class="body-content__header">
  <ul>
    <li><a href="#">Add Vendor Type</a></li>
    {{-- <li class="ms-auto">
      <a href="{{ route('vendor-types.index') }}" class="btn btn-primary btn-sm">
        <i class="fa fa-list"></i> Vendor Type List
      </a>
    </li> --}}
  </ul>
</div>

<div class="body-content__wrapper">
  <div class="row">
    <div class="col-sm-12">

      {{-- Add Vendor Type Form --}}
      <form method="POST" action="{{ route('vendor-types.store') }}" enctype="multipart/form-data" onsubmit="return checkIsPasswordSame()">
        @csrf
        <div class="card">
          <div class="card-header">
            <strong>Add Vendor Type</strong>
          </div>

          <div class="card-body">
            <div class="row">
              <div class="col-md-6"><br>
                <div class="form-col">
                  <label for="name">Name</label>
                  <input class="form-control" id="name" name="name" type="text" required>
                </div>
              </div>

              <div class="col-md-2 d-flex align-items-center">
                <div class="form-check">
                  <input class="form-check-input" type="checkbox" id="active" name="active" value="1">
                  <label class="form-check-label" for="active">Active</label>
                </div>
              </div>
            </div>
          </div>

          <div class="card-footer">
            <div class="d-flex justify-content-end">
              <a href="{{ route('vendor-types.index') }}" class="btn btn-danger" style="padding:10px 20px; font-size:16px; min-width:100px;">Cancel</a>
              <button type="submit" class="btn btn-success" style="padding:10px 20px; font-size:16px; min-width:100px;">Save</button>
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

        <div class="card-body">
          <table class="table table-responsive-sm table-bordered table-striped table-sm">
            <thead>
              <tr>
                <th class="text-center">Name</th>
                <th class="text-center" style="min-width:220px;">Action</th>
              </tr>
            </thead>
            <tbody>
              @foreach($vendorTypes as $type)
              <tr>
                <td class="text-center">{{ $type->name }}</td>
                <td class="text-center text-nowrap">
                  <a href="{{ route('vendor-types.edit', $type->id) }}" class="btn btn-info btn-sm">
                    <i class="fa fa-pencil"></i> Edit
                  </a>
                  <a href="#" class="btn btn-danger btn-sm"
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

<script>
function checkIsPasswordSame() {
  // Keeping placeholder logic from original
  return true;
}
</script>
@endsection
