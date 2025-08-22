@extends('html.default')
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script> 
<link href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.all.min.js"></script>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" crossorigin="anonymous">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>

@section('content')
<div class="body-content__header">
    <ul>
        <li><a href="#">Update Department</a></li>
    </ul>
</div>

<div class="body-content__wrapper">
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
              <div class="col-md-6">
                <div class="form-col">
                  <label for="grower_name">Department Name</label>
                  <input class="form-control" id="grower_name" name="departmentname" type="text" value="{{$department->name}}" placeholder="Enter Department Name...">
                </div>
              </div> 

              @php  $active = $department->IsActive; @endphp  
        
              <div class="col-md-1 col-form-label d-flex align-items-center">
                <div class="form-check form-switch">
                  <input class="form-check-input" type="checkbox" role="switch" name="IsActive" value="1" id="flexSwitchCheckDefault" @if($active) checked @endif>
                  <label class="form-check-label" for="flexSwitchCheckDefault">Active</label>
                </div>
              </div>
            </div>

            <hr style="border-color: black;">
            <br>

            <!-- Primary Approval Flow -->
            <h5>Approval Purchase Requisition Flow</h5>
            <div id="dynamic_field_a">
              @foreach($da as $index => $rolez)</br>
                <div class="row" id="rowa{{ $index }}">
                  <div class="col-md-6">
                    <div class="form-col">
                      <label for="approval_a_{{ $index }}">Approval Level</label>
                      <select class="form-control" id="approval_a_{{ $index }}" name="approval_a[]">
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
                    <div class="form-col">
                      <label for="role_a_{{ $index }}">Role</label>
                      <select class="form-control" id="role_a_{{ $index }}" name="role_a[]">
                        @foreach($roles as $role)
                          <option value="{{ $role->id }}" @if($role->id == $rolez->roleId) selected @endif>{{ $role->name }}</option>
                        @endforeach
                      </select>
                    </div>
                  </div>
                  <div class="col-md-1 d-flex align-items-end">
                    <button type="button" class="btn btn-danger btn_remove_a" data-row="rowa{{ $index }}">x</button>
                  </div>
                </div>
              @endforeach
            </div>
            <div class="d-flex justify-content-end mt-2">
              <button type="button" id="add_a" class="btn btn-sm btn-primary">Add More</button>
            </div>

            <br><br>

            <!-- Secondary Approval Flow -->
            <h5>Approval Purchase Order Flow</h5>
            <div id="dynamic_field_b">
              @foreach($da_b as $index => $rolez)</br>
                <div class="row" id="rowb{{ $index }}">
                  <div class="col-md-6">
                    <div class="form-col">
                      <label for="approval_b_{{ $index }}">Approval Level</label>
                      <select class="form-control" id="approval_b_{{ $index }}" name="approval_b[]">
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
                    <div class="form-col">
                      <label for="role_b_{{ $index }}">Role</label>
                      <select class="form-control" id="role_b_{{ $index }}" name="role_b[]">
                        @foreach($roles as $role)
                          <option value="{{ $role->id }}" @if($role->id == $rolez->roleId) selected @endif>{{ $role->name }}</option>
                        @endforeach
                      </select>
                    </div>
                  </div>
                  <div class="col-md-1 d-flex align-items-end">
                    <button type="button" class="btn btn-danger btn_remove_b" data-row="rowb{{ $index }}">x</button>
                  </div>
                </div>
              @endforeach
            </div>
            <div class="d-flex justify-content-end mt-2">
              <button type="button" id="add_b" class="btn btn-sm btn-primary">Add More</button>
            </div>

          </div>

          <div class="card-footer">
            <div class="d-flex justify-content-end gap-2">
              <input type="submit" class="btn btn-success" value="Update" style="padding:10px 20px; font-size:16px; min-width:100px;">
              <input type="reset" class="btn btn-danger" value="Cancel" style="padding:10px 20px; font-size:16px; min-width:100px;">
            </div>
          </div>
        </div>
      </form>
    </div>
  </div>
</div>
@endsection



<script type="text/javascript">
$(document).ready(function(){
  let i = {{ count($da) }};
  let j = {{ count($da_b) }};

  // Add more rows for Requisition Flow
  $('#add_a').click(function(){
    i++;
    $('#dynamic_field_a').append(`
    </br>
      <div class="row" id="rowa${i}">
        <div class="col-md-6">
          <select class="form-control" name="approval_a[]">
            <option value="1">First Line</option>
            <option value="2">Second Line</option>
            <option value="3">Third Line</option>
            <option value="4">Fourth Line</option>
            <option value="5">Fifth Line</option>
            <option value="6">Sixth Line</option>
          </select>
        </div>
        <div class="col-md-5">
          <select class="form-control" name="role_a[]">
            @foreach($roles as $role)
              <option value="{{ $role->id }}">{{ $role->name }}</option>
            @endforeach
          </select>
        </div>
        <div class="col-md-1">
          <button type="button" class="btn btn-danger btn_remove_a" data-row="rowa${i}">x</button>
        </div>
      </div>
    `);
  });

  // Add more rows for Purchase Order Flow
  $('#add_b').click(function(){
    j++;
    $('#dynamic_field_b').append(`
    </br>
      <div class="row" id="rowb${j}">
        <div class="col-md-6">
          <select class="form-control" name="approval_b[]">
            <option value="1">First Line</option>
            <option value="2">Second Line</option>
            <option value="3">Third Line</option>
            <option value="4">Fourth Line</option>
            <option value="5">Fifth Line</option>
            <option value="6">Sixth Line</option>
          </select>
        </div>
        <div class="col-md-5">
          <select class="form-control" name="role_b[]">
            @foreach($roles as $role)
              <option value="{{ $role->id }}">{{ $role->name }}</option>
            @endforeach
          </select>
        </div>
        <div class="col-md-1">
          <button type="button" class="btn btn-danger btn_remove_b" data-row="rowb${j}">x</button>
        </div>
      </div>
    `);
  });

  // Remove rows
  $(document).on('click', '.btn_remove_a', function(){
    const id = $(this).data("row");
    $('#' + id).remove();
  });

  $(document).on('click', '.btn_remove_b', function(){
    const id = $(this).data("row");
    $('#' + id).remove();
  });
});
</script>

