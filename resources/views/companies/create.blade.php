@extends('stack.layouts.admin')

<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script> 
<style>
    .field-row {
        display: flex;
        gap: 1rem;
        margin-bottom: 1rem;
    }

    .field-row input,
    .field-row select {
        flex: 1;
    }
</style>
@section('content')
<div class="container-fluid">
  <div class="animated fadeIn">
    <div class="row">
      <div class="col-sm-12">
        
       <form method="POST" action="/companies/store">
       @csrf
        <div class="card">
          <div class="card-header">
            <strong>Add New Company</strong>
            <a href="/companies/index" class="btn btn-primary btn-sm pull-right"><i style="color:white;" class="fa fa-align-justify"></i> Companies List</a>
          </div>

          <div class="card-body">
            <div class="row">
              <div class="col-sm-6">
                <div class="form-group">
                  <label for="grower_name">Company Name</label>
                  <input class="form-control" id="grower_name" name="companyname" type="text" placeholder="Company Name" required>
                </div>
              </div>

              <div class="col-sm-6">
                <div class="form-group">
                  <label for="grower_rep">Company Sub Domain</label>
                  <input class="form-control" id="grower_rep" name="companydomain" type="text" placeholder="Company Sub Domain">
                </div>
              </div>
            </div>
     
            <div class="row">
              <div class="col-sm-6">
                <div class="form-group">
                  <label for="grower_address">Username</label>
                  <input class="form-control" id="grower_address" name="username" type="text" placeholder="Username" required>
                </div>
              </div>

              <div class="col-sm-6">
                <div class="form-group">
                  <label for="grower_address">Contact Person</label>
                  <input class="form-control" id="grower_address" name="contactPerson" type="text" placeholder="Contact Person">
                </div>
              </div>
            </div>

            <div class="row">
              <div class="col-sm-6">
                <div class="form-group">
                  <label for="national_id">Password</label>
                  <input class="form-control" id="national_id" name="password" type="password" placeholder="Password" required>
                </div>
              </div>

              <div class="col-sm-6">
                <div class="form-group">
                  <label for="grower_type">Confirm Password</label>
                  <input class="form-control" id="national_id" name="confirmPassword" type="password" placeholder="Confirm Password" required>
                </div>
              </div>
            </div>

            <div class="row">
              <div class="col-sm-6">
                <div class="form-group">
                  <label for="grower_number">Company Address</label>
                  <textarea class="form-control" id="exampleFormControlTextarea1" name="address" rows="3"></textarea>
                </div>
              </div>

              <div class="col-sm-4">
                <div class="form-group">       
                  <label for="province">Email Address</label>
                  <input class="form-control" id="national_id" name="email" type="text" placeholder="Email Address" required>
                </div>
              </div>
            
              <div class="col-md-1 col-form-label">
                <div class="form-group">
                  <div class="form-check">
                    <label for="province" style="visibility: hidden;">Email Address</label>  
                    <input class="form-check-input" type="checkbox" name="IsActive" value="1" id="defaultCheck1">
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
                  <select class="form-control" id="vendor_source" name="vendor_source" required>
                    <option value="">-- Select Vendor Source --</option>
                    <option value="Vendor Management">Vendor Management</option>
                    <option value="Sage">Sage</option>
                    <option value="SAP">SAP</option>
                  </select>
                </div>
              </div>
            </div>
          <hr style="border-color: black;">

            <!-- Labels once -->
            <div class="row field-labels mb-2">
              <div class="col-md-4"><label>Form Name</label></div>
              <div class="col-md-4"><label>Form Label</label></div>
              <div class="col-md-3"><label>Form Type</label></div>
              <div class="col-md-1"></div>
            </div>

            <div id="fields">
            <!-- Dynamic fields will be added here -->
        </div>
        <button type="button"  class="btn btn-info" onclick="addField()">Add Field</button>
        <br><br>

         
            <br>
          </div>

          <div class="card-footer">
            <div class="form-group pull-right">
              <input type="submit" class="btn btn-success" value="Save"/>
              <input type="reset" class="btn btn-danger" value="Cancel"/>
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

function createField(index, name = '', label = '', type = '') {
    const requiredFields = ['department', 'amount', 'vendor'];
    const isRemovable = !requiredFields.includes(name.toLowerCase());

    return `
        <div class="form-group" id="field-${index}">
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
    `;
}

function addField(name = '', label = '', type = '') {
    const container = document.getElementById('fields');
    const fieldHTML = createField(fieldIndex, name, label, type);
    container.insertAdjacentHTML('beforeend', fieldHTML);
    fieldIndex++;
}

function removeField(index) {
    const field = document.getElementById(`field-${index}`);
    if (field) {
        field.remove();
    }
}

window.onload = function () {
    addField('vendor', 'Vendor', 'string');
    addField('amount', 'Amount', 'integer');
    addField('department', 'Department', 'string');
    addField('invoiceamount', 'Invoice Amount', 'integer');
    addField('paymentmethod', 'Payment Method', 'string');
};
</script>