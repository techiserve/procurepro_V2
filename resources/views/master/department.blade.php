@extends('stack.layouts.admin')

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script> 
<link href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.all.min.js"></script>

@section('content')
<div class="container-fluid">
  <div class="animated fadeIn">
    <div class="row">
      <div class="col-sm-12">
        
        <form method="POST" action="/department/store">
          @csrf
          <div class="card">
            <div class="card-header">
              <strong>Add New Department</strong>
            </div>

            <div class="card-body">
              <div class="row">
                <div class="col-sm-6">
                  <div class="form-group">
                    <label for="grower_name">Department Name</label>
                    <input class="form-control" id="grower_name" name="departmentname" type="text" placeholder="Enter Department Name..." required>
                  </div>
                </div>

                <div class="col-md-1 col-form-label">
                  <div class="form-group" style="margin-top: 27px;">         
                    <div class="form-check form-switch">
                      <input class="form-check-input" type="checkbox" role="switch" name="IsActive" value="1" id="flexSwitchCheckDefault" />
                      <label class="form-check-label" for="defaultCheck1">Active</label>
                    </div>
                  </div>
                </div>
              </div>

              <hr style="border-color: black;">
              <br>
            
            <div class="form-group">
              <div class="form-check form-switch" style="margin-left: 2%;">
                <input class="form-check-input" type="checkbox" role="switch" name="po" id="enable_secondary" />
                <label for="enable_secondary">Enable Purchase Order Flow</label>
              </div>
            </div>

              <div class="clearfix" id="dynamic_field_primary">
                <div class="row">
                 <label for="PR">Purchase Requisition Flow</label>
                  <div class="col-md-6">    
                    <div class="form-group">
                      <select class="form-control" name="approval[]">
                        <option value="">Select Approval Level</option>                       
                        <option value="1">First Line</option>                          
                        <option value="2">Second Line</option>
                        <option value="3">Third Line</option>                         
                        <option value="4">Fourth Line</option>       
                        <option value="5">Fiveth Line</option>
                        <option value="6">Sixth Line</option>                                          
                      </select>
                    </div>
                  </div>
                  <div class="col-md-5">
                    <div class="form-group">
                      <select class="form-control" name="role[]">
                        <option value="">Select Role</option>
                        @foreach($roles as $role)
                          <option value="{{ $role->id }}">{{ $role->name }}</option>
                        @endforeach
                      </select>
                    </div>
                  </div>
                  <div class="col-md-1">
                    <button type="button" name="add_primary" id="add_primary" class="btn btn-primary">+ </button>
                  </div>
                </div>
              </div>

              <!-- Second Group (conditionally shown) -->
              <div class="clearfix" id="dynamic_field_secondary" style="display: none;">
                <hr>
                <div class="row">
                      <label for="PR">Purchase Order Flow</label>
                  <div class="col-md-6">
                    <div class="form-group">
                      <select class="form-control" name="secondary_approval[]">
                        <option value="">Select Approval Level</option>                       
                        <option value="1">First Line</option>                          
                        <option value="2">Second Line</option>
                        <option value="3">Third Line</option>                         
                        <option value="4">Fourth Line</option>       
                        <option value="5">Fiveth Line</option>
                        <option value="6">Sixth Line</option>                                          
                      </select>
                    </div>
                  </div>
                  
                  <div class="col-md-3">
                    <div class="form-group">
                      <select class="form-control secondary-role-select" name="secondary_role[]" onchange="updateDefaultValue(this)">
                        <option value="">Select Role</option>
                        @foreach($roles as $role)
                          <option value="{{ $role->id }}">{{ $role->name }}</option>
                        @endforeach
                      </select>
                    </div>
                  </div>
                         <div class="col-md-2 d-flex align-items-center">
                    <div class="form-check">
                      <input class="form-check-input secondary-default-checkbox" type="checkbox" name="is_default_secondary" value="">
                      <label class="form-check-label">Assign Bank Account</label>
                    </div>
                  </div>
                  <div class="col-md-1">
                    <button type="button" name="add_secondary" id="add_secondary" class="btn btn-info">+ </button>
                  </div>
                </div>
              </div>

            </div>
            <div class="card-footer">
              <div class="form-group pull-right">
                <input type="submit" class="btn btn-success" value="Save" style="padding: 10px 20px; font-size: 16px; min-width: 100px;" />
                <input type="reset" class="btn btn-danger" value="Cancel" style="padding: 10px 20px; font-size: 16px; min-width: 100px;" />
              </div>
            </div>
          </div>
        </form>
      </div>
    </div>

    <!-- Department list code remains unchanged -->
      

    <div class="row">
      <div class="col-sm-12">
        <div class="card">
          <div class="card-header">
            <strong>Department List</strong>

          </div>

          <div class="card-body">
            <table class="table table-responsive-sm table-bordered table-striped table-sm">
              <thead>
                <tr>


                  <th class="text-center">Department Name</th>
                  <th class="text-center">Added by</th>
                  <th class="text-center">Status</th>
                  <th class="text-center">Action</th>

                </tr>
              </thead>
              <tbody>
                @foreach($departments as $user)
                <tr>
                  <td class="text-center">{{$user->name}}</td>
                  <td class="text-center">
                  @foreach($users as $us)
                   @if($user->userId ==  $us->id)
                   {{ $us->name }}

                   @endif

                    @endforeach

                      </td>
                  <td class="text-center">
                  @if($user->IsActive == null)
                    <span class='badge badge-secondary'>Inactive</span>
                    @else
                    <span class='badge badge-success'>Active</span>
                    @endif
                    </td>           
                  <td class="text-center">
                  <a href='/department/{{$user->id}}/edit' class='btn btn-info btn-sm' style='color: white;'>
                      <span class='fa fa-pencil'></span>
                      <span class='hidden-sm hidden-sm hidden-md'> Edit</span>
                    </a>
                    &nbsp;
                  <a href='#' class='btn btn-danger btn-sm'   onclick="
                        event.preventDefault(); // Prevent the default link behavior
                        Swal.fire({
                            title: 'Delete Department?',
                            text: 'You won\'t be able to undo this!',
                            icon: 'info', // Updated property for SweetAlert2
                            showCancelButton: true,
                            confirmButtonText: 'Continue',
                            cancelButtonText: 'Cancel'
                          }).then((result) => {
                            if (result.isConfirmed) {
                              // Redirect to the URL or perform an action
                              window.location.href = '/department/{{$user->id}}/delete'; // Replace with your actual URL
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

<script type="text/javascript">
$(document).ready(function(){      
  let i = 1;
  let j = 1;

  $('#add_primary').click(function(){  
    i++;  
    $('#dynamic_field_primary').append(
      '<div id="primary_row'+i+'" class="row dynamic-added">' +
        '<div class="col-md-6">' +
          '<div class="form-group">' +
            '<select class="form-control" name="approval[]">' +
              '<option value="">Select Approval Level</option>' +
              '<option value="1">First Line</option>' +
              '<option value="2">Second Line</option>' +
              '<option value="3">Third Line</option>' +
              '<option value="4">Fourth Line</option>' +
              '<option value="5">Fiveth Line</option>' +
              '<option value="6">Sixth Line</option>' +
            '</select>' +
          '</div>' +
        '</div>' +
        '<div class="col-md-5">' +
          '<div class="form-group">' +
            '<select class="form-control" name="role[]">' +
              '<option value="">Select Role</option>' +
              @json($roles).map(role => `<option value="${role.id}">${role.name}</option>`).join('') +
            '</select>' +
          '</div>' +
        '</div>' +
        '<div class="col-md-1">' +
          '<button type="button" name="remove_primary" id="'+i+'" class="btn btn-danger btn_remove_primary">x</button>' +
        '</div>' +
      '</div>'
    );
  });

  $(document).on('click', '.btn_remove_primary', function(){  
    const id = $(this).attr("id");   
    $('#primary_row'+id).remove();  
  });

$('#add_secondary').click(function(){  
  j++;  
  $('#dynamic_field_secondary').append(
    `<div id="secondary_row${j}" class="row dynamic-added">
      <div class="col-md-6">
        <div class="form-group">
          <select class="form-control" name="secondary_approval[]">
            <option value="">Select Approval Level</option>
            <option value="1">First Line</option>
            <option value="2">Second Line</option>
            <option value="3">Third Line</option>
            <option value="4">Fourth Line</option>
            <option value="5">Fiveth Line</option>
            <option value="6">Sixth Line</option>
          </select>
        </div>
      </div>
      <div class="col-md-3">
        <div class="form-group">
          <select class="form-control secondary-role-select" name="secondary_role[]" onchange="updateDefaultValue(this)">
            <option value="">Select Role</option>
            ${@json($roles).map(role => `<option value="${role.id}" data-name="${role.name}">${role.name}</option>`).join('')}
          </select>
        </div>
      </div>
      <div class="col-md-2 d-flex align-items-center">
        <div class="form-check">
          <input class="form-check-input secondary-default-checkbox" type="checkbox" name="is_default_secondary" value="">
          <label class="form-check-label">Assign Bank Account</label>
        </div>
      </div>
      <div class="col-md-1">
        <button type="button" name="remove_secondary" id="${j}" class="btn btn-danger btn_remove_secondary">x</button>
      </div>
    </div>`
  );
});

  $(document).on('click', '.btn_remove_secondary', function(){  
    const id = $(this).attr("id");   
    $('#secondary_row'+id).remove();  
  });

  
  $(document).on('change', '.secondary-default-checkbox', function(){
    $('.secondary-default-checkbox').not(this).prop('checked', false);
  });

   window.updateDefaultValue = function(selectElement) {
    const checkbox = $(selectElement).closest('.row').find('.secondary-default-checkbox');
    const selectedOption = selectElement.options[selectElement.selectedIndex];
   const selectedId = selectedOption.value;
    checkbox.val(selectedId);
  }

  $('#enable_secondary').change(function(){
    if ($(this).is(':checked')) {
      $('#dynamic_field_secondary').show();
    } else {
      $('#dynamic_field_secondary').hide();
      $('#dynamic_field_secondary').find('.dynamic-added').remove(); // remove added rows
    }
  });

});
</script>
