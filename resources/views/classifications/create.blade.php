@extends('html.default')
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.all.min.js"></script>
@section('content')
<div class="container-fluid">
  <div class="animated fadeIn">
    <div class="row">
      <div class="col-sm-12">

        <!-- Create Classification Form -->
        <form method="POST" action="{{ route('classifications.store') }}">
          @csrf
          <div class="card">
            <div class="card-header">
              <strong>Create Classification of Expense</strong>
            </div>

            <div class="card-body">
              @if (session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
              @endif

              <div class="row">
                <div class="col-sm-6">
                  <div class="form-group">
                    <label for="name">Classification Name</label>
                    <input class="form-control" id="name" name="name" type="text" required>
                  </div>
                </div>
                <div class="col-sm-6">
                  <div class="form-group" style="margin-top: 40px;">
                    <div class="checkbox">
                      <label><input type="checkbox" name="active" checked> Active</label>
                    </div>
                  </div>
                </div>
              </div>
            </div>

            <div class="card-footer">
              <button type="submit" class="btn btn-primary pull-right">Save</button>
            </div>
          </div>
        </form>

        <br>

        <!-- List of Classifications -->
        <div class="card">
          <div class="card-header">
            <strong>All Classifications of Expense</strong>
          </div>
          <div class="card-body table-responsive">
            <table class="table table-bordered table-striped">
              <thead style="background-color:#000C3D; color:#fff;">
                <tr>
                  <th>Name</th>
                  <th>Status</th>
                  <th>Actions</th>
                </tr>
              </thead>
              <tbody>
                @forelse($classifications as $classification)
                  <tr>
                    <td>{{ $classification->name }}</td>
                    <td>
                      <span class="badge {{ $classification->active ? 'badge-success' : 'badge-danger' }}">
                        {{ $classification->active ? 'Active' : 'Inactive' }}
                      </span>
                    </td>
                    <td>
                      <a href="{{ route('classifications.edit', $classification->id) }}" class="label label-sm label-success">
                        <span class='fa fa-pencil'></span>
                        <span class='hidden-sm hidden-sm hidden-md'> Edit</span>
                      </a>

                      <form action="{{ route('classifications.destroy', $classification->id) }}" method="POST" style="display:inline;" onsubmit="return confirm('Are you sure you want to delete this classification?');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="label label-sm label-danger" style="border:none; background:none;">
                          <span class='fa fa-trash'></span>
                          <span class='hidden-sm hidden-sm hidden-md'> Delete</span>
                        </button>
                      </form>
                    </td>
                  </tr>
                @empty
                  <tr>
                    <td colspan="3" class="text-center">No classifications found.</td>
                  </tr>
                @endforelse
              </tbody>
            </table>
          </div>
        </div>

      </div>
    </div>
  </div>
</div>
@endsection


<script type="text/javascript">
  $(document).ready(function(){
    // Optional: SweetAlert confirmation for deletion
    $('form').on('submit', function(e){
      if($(this).find('button[type=submit]').hasClass('label-danger')){
        return confirm('Are you sure you want to delete this classification?');
      }
    });
  });
</script>
