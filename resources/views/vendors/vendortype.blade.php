@extends('stack.layouts.admin')

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
                  <div class="form-group" style="margin-top: 25px;">
                    <div class="checkbox">
                      <label>
                        <input type="checkbox" id="active" name="active" value="1"> Active
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
                    <a href="{{ route('vendor-types.edit', $type->id) }}" class="label label-sm label-success">Edit</a>
                    <form action="{{ route('vendor-types.destroy', $type->id) }}" method="POST" style="display:inline;">
                      @csrf
                      @method('DELETE')
                      <button type="submit" class="label label-sm label-danger simpleConfirm" style="border:none; background:none;">Delete</button>
                    </form>
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
