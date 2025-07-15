@extends('stack.layouts.admin')

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
<link href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css" rel="stylesheet">

<!-- SweetAlert2 JS -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.all.min.js"></script>
@section('content')
<div class="container-fluid">
  <div class="animated fadeIn">
    <div class="row">
      <div class="col-sm-12">
        
       <form method="POST" action="/banks/store">
       @csrf
        <div class="card">
          <div class="card-header">
            <strong>Add New Bank</strong>
            <a href="#" class="btn btn-primary btn-sm pull-right"><i style="color:white;" class="fa fa-align-justify"></i></a>
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
                <div class="form-check form-switch" >
                <input class="form-check-input" type="checkbox" role="switch" name="IsActive"  value="1"  id="flexSwitchCheckDefault" />
                <label class="form-check-label" for="defaultCheck1">
               Active
               </label>
                </div>
                </div>
              </div>
            </div>
      

			<hr style="border-color: black;">
			<br>
          </div>
          <div class="card-footer">
            <div class="form-group pull-right">
    				<input type="submit" class="btn btn-success" value="Save "  style="padding: 10px 20px; font-size: 16px; min-width: 100px;"/>
    				<input type="reset" class="btn btn-danger" value="Cancel "  style="padding: 10px 20px; font-size: 16px; min-width: 100px;"/>
    			</div>
          </div>
       </div>
      </form>
     </div>
    </div>


    
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
                  <td class="text-center">{{$user->name}}</td>
                  <td class="text-center">
                  @if($user->isActive == null)
                    <span class='badge badge-success'>Active</span>
                    @else
                    <span class='badge badge-success'>Active</span>
                    @endif
                    </td>           
                  <td class="text-center">
                  <a href='/banks/{{$user->id}}/edit' class='btn btn-info btn-sm' style='color: white;'>
                      <span class='fa fa-pencil'></span>
                      <span class='hidden-sm hidden-sm hidden-md'>Edit</span>
                    </a>
                  <a href='#' class='btn btn-danger btn-sm'   onclick="
                        event.preventDefault(); // Prevent the default link behavior
                        Swal.fire({
                            title: 'Delete Bank?',
                            text: 'You won\'t be able to undo this!',
                            icon: 'info', // Updated property for SweetAlert2
                            showCancelButton: true,
                            confirmButtonText: 'Continue',
                            cancelButtonText: 'Cancel'
                          }).then((result) => {
                            if (result.isConfirmed) {
                              // Redirect to the URL or perform an action
                              window.location.href = '/banks/{{$user->id}}/delete'; // Replace with your actual URL
                            }
                          })
                      "
                    >
                      <span class='fa fa-trash'></span>
                      <span class='hidden-sm hidden-sm hidden-md'>Delete</span>
                    </a>&nbsp;
                  
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
