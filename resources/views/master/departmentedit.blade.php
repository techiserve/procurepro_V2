@extends('stack.layouts.admin')

<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script> 
<link href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.all.min.js"></script>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" crossorigin="anonymous">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>

@section('content')
<div class="container-fluid">
  <div class="animated fadeIn">
    <div class="row">
      <div class="col-sm-12">
        
       <form method="POST" action="/department/{{$department->id}}/update">
       @csrf
       @method('put')
        <div class="card">
          <div class="card-header">
            <strong>Update Department</strong>
          </div>

          <div class="card-body">
            <div class="row">
              <div class="col-sm-6">
                <div class="form-group">
                  <label for="grower_name">Department Name</label>
                  <input class="form-control" id="grower_name" name="departmentname" type="text" value="{{$department->name}}" placeholder="Enter Department Name...">
                </div>
              </div> 

              @php  $active = $department->IsActive; @endphp  
              <div class="col-md-1 col-form-label">
                <div class="form-group">
                  <div class="form-check form-switch">
                    <input class="form-check-input" type="checkbox" role="switch" name="IsActive" value="1" id="flexSwitchCheckDefault" @if($active) checked @endif>
                    <label class="form-check-label" for="defaultCheck1">Active</label>
                  </div>
                </div>
              </div>
            </div>

            <hr style="border-color: black;">
            <br>
            <div class="row">
              <div class="col-md-6"><label>Approval Level</label></div>
              <div class="col-md-6"><label>User Role</label></div>
            </div>

            <!-- Dynamic Fields for Approval and Role -->
            <div class="clearfix" id="dynamic_field">
              @foreach($da as $index => $rolez)
                <div class="row" id="row{{ $index }}">
                  <div class="col-md-6">
                    <div class="form-group">
                      <select class="form-control" name="approval[]">
                        <option value="1" @if($rolez->approvalId == 1) selected @endif>First Line</option>
                        <option value="2" @if($rolez->approvalId == 2) selected @endif>Second Line</option>
                        <option value="3" @if($rolez->approvalId == 3) selected @endif>Third Line</option>
                        <option value="4" @if($rolez->approvalId == 4) selected @endif>Fourth Line</option>
                        <option value="5" @if($rolez->approvalId == 5) selected @endif>Fifth Line</option>
                        <option value="6" @if($rolez->approvalId == 6) selected @endif>Sixth Line</option>
                      </select>
                    </div>
                  </div>

                  <div class="col-md-5">
                    <div class="form-group">
                      <select class="form-control" name="role[]">
                        @foreach($roles as $role)
                          <option value="{{ $role->id }}" @if($role->id == $rolez->roleId) selected @endif>{{ $role->name }}</option>
                        @endforeach
                      </select>
                    </div>
                  </div>

                  <div class="col-md-1">
                    <button type="button" class="btn btn-danger btn_remove" data-row="row{{ $index }}">x</button>
                  </div>
                </div>
              @endforeach  
            </div>
            <!-- End of Dynamic Fields -->

            <button type="button" name="add" id="add" class="btn btn-primary mt-3">Add More</button>
          </div>

          <div class="card-footer">
            <div class="form-group pull-right">
              <input type="submit" class="btn btn-success" value="Update" style="padding: 10px 20px; font-size: 16px; min-width: 100px;">
              <input type="reset" class="btn btn-danger" value="Cancel" style="padding: 10px 20px; font-size: 16px; min-width: 100px;">
            </div>
          </div>
        </div>
      </form>
     </div>
    </div>
  </div>
</div>
@endsection

<script type="text/javascript">
    $(document).ready(function(){      
      var i = {{ count($da) }};  // Initialize based on existing count of dynamic fields

      // Add dynamic field
      $('#add').click(function(){  
           i++;  
           $('#dynamic_field').append(`
             <div class="row" id="row${i}">
               <div class="col-md-6">
                 <div class="form-group">
                   <select class="form-control" name="approval[]">
                     <option value="" selected>Select Approval Level</option>
                     <option value="1">First Line</option>
                     <option value="2">Second Line</option>
                     <option value="3">Third Line</option>
                     <option value="4">Fourth Line</option>
                     <option value="5">Fifth Line</option>
                     <option value="6">Sixth Line</option>
                   </select>
                 </div>
               </div>

               <div class="col-md-5">
                 <div class="form-group">
                   <select class="form-control" name="role[]">
                     <option value="" selected>Select Role</option>
                     @foreach($roles as $role)
                       <option value="{{ $role->id }}">{{ $role->name }}</option>
                     @endforeach
                   </select>
                 </div>
               </div>

               <div class="col-md-1">
                 <button type="button" class="btn btn-danger btn_remove" data-row="row${i}">x</button>
               </div>
             </div>
           `);
      });  

      // Remove dynamic field
      $(document).on('click', '.btn_remove', function(){  
           var button_id = $(this).data("row");   
           $('#' + button_id).remove();  
      });  

    });  
</script>
