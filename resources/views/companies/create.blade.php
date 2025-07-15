@extends('stack.layouts.admin')
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
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

    .is-invalid {
  border-color: #dc3545;
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
                  <input class="form-control" id="password" name="password" type="password" placeholder="Password" required>
                </div>
              </div>

              <div class="col-sm-6">
             <div class="form-group">
              <label for="confirm_password">Confirm Password</label>
              <input class="form-control" id="confirm_password" name="confirmPassword" type="password" placeholder="Confirm Password" required>
              <div id="confirmPasswordError" class="text-danger" style="display: none; font-size: 14px;"></div>
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
                   <div class="form-group" style="margin-top: 27px;">         
                    <div class="form-check form-switch">
                      <input class="form-check-input" type="checkbox" role="switch" name="IsActive" value="1" id="flexSwitchCheckDefault" />
                      <label class="form-check-label" for="defaultCheck1">Active</label>
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
              <input type="reset" class="btn btn-danger" value="Cancel" id="resetBtn"/>
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

document.addEventListener('DOMContentLoaded', function () {
    // Load default fields on page load
    addField('vendor', 'Vendor', 'string');
    addField('amount', 'Amount', 'integer');
    addField('department', 'Department', 'string');
    addField('invoiceamount', 'Invoice Amount', 'integer');
    addField('paymentmethod', 'Payment Method', 'string');

    // Password validation
    const form = document.querySelector('form');
    const password = document.getElementById('password');
    const confirm = document.getElementById('confirm_password');
    const errorDiv = document.getElementById('confirmPasswordError');

    form.addEventListener('submit', function (e) {
        if (password.value !== confirm.value) {
            e.preventDefault();
            confirm.classList.add('is-invalid');
            errorDiv.innerText = 'Passwords do not match.';
            errorDiv.style.display = 'block';
        } else {
            confirm.classList.remove('is-invalid');
            errorDiv.innerText = '';
            errorDiv.style.display = 'none';
        }
    });

    confirm.addEventListener('input', function () {
        if (this.value !== password.value) {
            this.classList.add('is-invalid');
            errorDiv.innerText = 'Passwords do not match.';
            errorDiv.style.display = 'block';
        } else {
            this.classList.remove('is-invalid');
            errorDiv.innerText = '';
            errorDiv.style.display = 'none';
        }
    });

    document.getElementById('resetBtn').addEventListener('click', function () {
    // Clear all dynamic fields
    const fieldsContainer = document.getElementById('fields');
    fieldsContainer.innerHTML = '';

    // Reset field index
    fieldIndex = 0;

    // Re-add default fields
    addField('vendor', 'Vendor', 'string');
    addField('amount', 'Amount', 'integer');
    addField('department', 'Department', 'string');
    addField('invoiceamount', 'Invoice Amount', 'integer');
    addField('paymentmethod', 'Payment Method', 'string');
});

});
</script>