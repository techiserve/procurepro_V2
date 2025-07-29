@extends('stack.layouts.admin')

<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script> 

@section('content')
<div class="container-fluid">
  <div class="animated fadeIn">
    <div class="row">
      <div class="col-sm-12">
        
       <form method="POST" action="/company/{{ $company->id }}/update" id="passwordForm" novalidate>
       @csrf
       @method('put')
        <div class="card">
          <div class="card-header">
            <strong>Edit Company</strong>
            <a href="/companies/index" class="btn btn-primary btn-md pull-right"><i style="color:white;" class="fa fa-align-justify"></i> Companies List</a>
          </div>

          <div class="card-body">
            <div class="row">
              <div class="col-sm-6">
                <div class="form-group">
                  <label for="grower_name">Company Name</label>
                  <input class="form-control" id="grower_name" name="companyname" value="{{ $company->name }}" type="text" placeholder="Company Name">
                </div>
              </div>

              <div class="col-sm-6">
                <div class="form-group">
                  <label for="grower_rep">Company Sub Domain</label>
                  <input class="form-control" id="grower_rep" name="companydomain" value="{{ $company->domain }}" type="text" placeholder="Company Sub Domain">
                </div>
              </div>
            </div>
     
            <div class="row">
              <div class="col-sm-6">
                <div class="form-group">
                  <label for="grower_address">Username</label>
                  <input class="form-control" id="grower_address" name="username" value="{{ $company->username }}" type="text" placeholder="Username">
                </div>
              </div>

              <div class="col-sm-6">
                <div class="form-group">
                  <label for="grower_address">Contact Person</label>
                  <input class="form-control" id="grower_address" name="contactPerson" value="{{ $company->contactPerson }}" type="text" placeholder="Contact Person">
                </div>
              </div>
            </div>
            
            <div class="row">
              <div class="col-sm-6">
                <div class="form-group">
                  <label for="national_id">Password</label>
                  <input class="form-control" id="new_password" name="new_password" type="password" placeholder="Password">
                </div>
              </div>

              <div class="col-sm-6">
                <div class="form-group">
                  <label for="grower_type">Confirm Password</label>
                  <input class="form-control" id="confirm_password" name="confirm_password" type="password" placeholder="Confirm Password">
                  <div class="invalid-feedback">Passwords do not match.</div>
                </div>
              </div>
            </div>

            <div class="row">
              <div class="col-sm-6">
                <div class="form-group">
                  <label for="grower_number">Company Address</label>
                  <textarea class="form-control" id="exampleFormControlTextarea1" name="address" rows="3">{{ $company->address }}</textarea>
                </div>
              </div>

              <div class="col-sm-4">
                <div class="form-group">       
                  <label for="province">Email Address</label>
                  <input class="form-control" id="national_id" name="email" value="{{ $company->email }}" type="text" placeholder="Email Address">
                </div>
              </div>
            
              @php  $active = $company->IsActive; @endphp  
              <div class="col-md-1 col-form-label">
                <div class="form-group">
                  <div class="form-check">
                    <label for="province" style="visibility: hidden;">Email Address</label>  
                    <input class="form-check-input" type="checkbox" name="IsActive" value="1" id="defaultCheck1" @if($active) checked @endif>
                    <label class="form-check-label" for="defaultCheck1">
                      Active
                    </label>
                  </div>
                </div>
              </div>
            </div>

            <!-- New Vendor Source Dropdown -->
            <div class="row">
              <div class="col-sm-6">
                <div class="form-group">
                  <label for="vendor_source">Vendor Source</label>
                  <select class="form-control" id="vendor_source" name="vendor_source">
                    <option value="">-- Select Vendor Source --</option>
                    <option value="Vendor Management" @if($company->vendor_source == 'Vendor Management') selected @endif>Vendor Management</option>
                    <option value="Sage" @if($company->vendor_source == 'Sage') selected @endif>Sage</option>
                    <option value="SAP" @if($company->vendor_source == 'SAP') selected @endif>SAP</option>
                  </select>
                </div>
              </div>
            </div>

            <hr style="border-color: black;">
            <br>
                    {{--  --}}
          <h5>Dynamic Fields</h5>
        @if(isset($dynamicFields) && count($dynamicFields) > 0)
            <div class="row">
              <div class="col-sm-12">
                <h5>Additional Fields</h5>
              </div>
            </div>
        @endif

       
          <div id="fields"></div>
          <button type="button" class="btn btn-secondary" onclick="addField()">Add Field</button>
    
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
   </div>
</div>
@endsection

<script>
    let fieldIndex = 0;
    let existingFields = @json($dynamicFields);

    document.addEventListener('DOMContentLoaded', function () {
        if (existingFields.length > 0) {
            existingFields.forEach(field => {
                addField(field.name, field.label, field.type, field.id);
            });
        } else {
            addField('vendor', 'Vendor', 'string');
            addField('amount', 'Amount', 'integer');
            addField('department', 'Department', 'string');
            addField('invoiceamount', 'Invoice Amount', 'integer');
            addField('paymentmethod', 'Payment Method', 'string');
        }
    });

    function addField(name = '', label = '', type = '', fieldId = '') {
        const container = document.getElementById('fields');
        const fieldHTML = createField(fieldIndex, name, label, type, fieldId);
        container.insertAdjacentHTML('beforeend', fieldHTML);
        fieldIndex++;
    }

   function createField(index, name = '', label = '', type = '', fieldId = '') {
    const requiredFields = ['department', 'amount', 'vendor'];
    const isRemovable = !requiredFields.includes(name.toLowerCase());

    return `
        <div class="form-group" id="field-${index}">
            <div class="row">
                <input type="hidden" name="fields[${index}][id]" value="${fieldId}">
                <div class="col-md-12">
                    <div class="row">
                        <div class="col-md-4">
                            <input type="text" class="form-control" name="fields[${index}][name]" value="${name}" placeholder="Field Name" required ${isRemovable ? '' : 'readonly'}>
                        </div>
                        <div class="col-md-4">
                            <input type="text" class="form-control" name="fields[${index}][label]" value="${label}" placeholder="Label" required ${isRemovable ? '' : 'readonly'}>
                        </div>
                        <div class="col-md-3">
                            <select class="form-control" name="fields[${index}][type]" required ${isRemovable ? '' : 'readonly'}>
                                <option value="">-- Select type --</option>
                                <option value="string" ${type === 'string' ? 'selected' : ''}>String</option>
                                <option value="integer" ${type === 'integer' ? 'selected' : ''}>Integer</option>
                                <option value="checkbox" ${type === 'checkbox' ? 'selected' : ''}>Checkbox</option>
                            </select>
                        </div>
                        <div class="col-md-1 text-right">
                            ${isRemovable ? `<button type="button" class="btn btn-danger btn-md" onclick="removeField(${index})">&times;</button>` : ''}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    `;
}


    function removeField(index) {
        const element = document.getElementById(`field-${index}`);
        if (element) element.remove();
    }
</script>
