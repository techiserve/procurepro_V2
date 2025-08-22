@extends('html.default')
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.all.min.js"></script>
@section('content')
<div class="body-content__header">
    <ul>
        <li><a href="#">Create Classification of Expense</a></li>
    </ul>
</div>

<div class="body-content__wrapper">
    <div class="row">
        <div class="col-sm-12">
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
                          <div class="col-md-6"><br>
                              <div class="form-col">
                                  <label for="name">Classification Name</label>
                                  <input class="form-control" id="name" name="name" type="text" placeholder="Enter Classification Name..." required>
                              </div>
                          </div>

                          <div class="col-md-3 d-flex align-items-center">
                              <div class="form-check form-switch">
                                  <input class="form-check-input" type="checkbox" role="switch" name="active" value="1" id="flexSwitchActive" checked />
                                  <label class="form-check-label" for="flexSwitchActive">Active</label>
                              </div>
                          </div>
                      </div>
                    </div>

                 <div class="card-footer">
                    <div class="d-flex justify-content-end gap-2">
                        <input type="submit" class="btn btn-success" value="Save" style="padding:10px 20px; font-size:16px; min-width:100px;" />
                        <input type="reset" class="btn btn-danger" value="Cancel" style="padding:10px 20px; font-size:16px; min-width:100px;" />
                    </div>
                </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Classification List Table -->
    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-header">
                    <strong>All Classifications of Expense</strong>
                </div>
                <div class="card-body">
                    <table class="table table-responsive-sm table-bordered table-striped table-sm">
                        <thead>
                            <tr>
                                <th class="text-center">Name</th>
                                <th class="text-center">Status</th>
                                <th class="text-center">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($classifications as $classification)
                                <tr>
                                    <td class="text-center">{{ $classification->name }}</td>
                                    <td class="text-center">
                                        @if($classification->active)
                                            <span class='btn btn-outline-success'>Active</span>
                                        @else
                                            <span class='btn btn-outline-secondary'>Inactive</span>
                                        @endif
                                    </td>
                                    <td class="text-center">
                                        <a href="{{ route('classifications.edit', $classification->id) }}" class='btn btn-info btn-sm'>
                                            <span class='fa fa-pencil'></span> Edit
                                        </a>

                                        <form action="{{ route('classifications.destroy', $classification->id) }}" method="POST" style="display:inline;" 
                                            onsubmit="return confirm('Are you sure you want to delete this classification?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class='btn btn-danger btn-sm'>
                                                <span class='fa fa-trash'></span> Delete
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
