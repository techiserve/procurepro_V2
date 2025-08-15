@extends('html.default')

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" crossorigin="anonymous">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
<link href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.all.min.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>

@section('content')
<div class="container-fluid">
  <div class="animated fadeIn">
    <div class="row">
      <div class="col-sm-12">

        <!-- Add New Bank Form -->
        <form method="POST" action="/banks/store">
          @csrf
          <div class="card">
            <div class="card-header">
              <strong>Add New Bank</strong>
            </div>

            <div class="card-body">
              <div class="row">
                <div class="col-sm-6">
                  <div class="form-group">
                    <label for="grower_name">Name</label>
                    <input class="form-control" id="grower_name" name="bankname" type="text" placeholder="Name" required>
                  </div>
                </div>

                <div class="col-md-1 col-form-label">
                  <div class="form-group" style="margin-top: 25px;">
                    <div class="form-check form-switch">
                      <input class="form-check-input" type="checkbox" role="switch" name="IsActive" value="1" id="flexSwitchCheckDefault" />
                      <label class="form-check-label" for="defaultCheck1">Active</label>
                    </div>
                  </div>
                </div>
              </div>

              <hr style="border-color: black;">
            </div>

            <div class="card-footer">
              <div class="form-group pull-right">
                <input type="submit" class="btn btn-success" value="Save" style="padding: 10px 20px; font-size: 16px; min-width: 100px;"/>
                <input type="reset" class="btn btn-danger" value="Cancel" style="padding: 10px 20px; font-size: 16px; min-width: 100px;"/>
              </div>
            </div>
          </div>
        </form>

      </div>
    </div>

    <!-- Banks List -->
    <div class="row">
      <div class="col-sm-12">
        <div class="card">
          <div class="card-header">
            <strong>Banks</strong>
            <small>List</small>
          </div>

          <div class="card-body">
            <table class="table table-responsive-sm table-bordered table-striped table-sm">
              <thead>
                <tr>
                  <th>#</th>
                  <th class="text-center">Name</th>
                  <th class="text-center">Status</th>
                  <th class="text-center">Action</th>
                </tr>
              </thead>
              <tbody>
                @foreach($banks as $user)
                  <tr>
                    <td></td>
                    <td class="text-center">{{ $user->name }}</td>
                    <td class="text-center">
                      @if($user->isActive)
                        <span class="badge badge-success">Active</span>
                      @else
                        <span class="badge badge-secondary">Inactive</span>
                      @endif
                    </td>
                    <td class="text-center">
                      <a href='/banks/{{$user->id}}/edit' class='btn btn-info btn-sm' style='color: white;'>
                        <span class='fa fa-pencil'></span>
                        <span class='hidden-sm hidden-sm hidden-md'>Edit</span>
                      </a>
                      <a href='#' class='btn btn-danger btn-sm' onclick="
                        event.preventDefault();
                        Swal.fire({
                          title: 'Delete Bank?',
                          text: 'You won\'t be able to undo this!',
                          icon: 'info',
                          showCancelButton: true,
                          confirmButtonText: 'Continue',
                          cancelButtonText: 'Cancel'
                        }).then((result) => {
                          if (result.isConfirmed) {
                            window.location.href = '/banks/{{$user->id}}/delete';
                          }
                        });
                      ">
                        <span class='fa fa-trash'></span>
                        <span class='hidden-sm hidden-sm hidden-md'>Delete</span>
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
@endsection
