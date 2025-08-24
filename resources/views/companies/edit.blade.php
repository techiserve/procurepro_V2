@extends('html.default')

@section('content')
<div class="body-content__header">
  <ul>
    <li><a href="#">Users</a></li>
    <li><a href="#">Edit</a></li>
    <li class="ms-auto"><a href="/companies/index" class="btn btn-primary btn-md"><i class="fa fa-align-justify" style="color:white;"></i> Companies List</a></li>
  </ul>
</div>

<div class="body-content__wrapper">
  <div class="row">
    <div class="col-12">

      <form method="POST" action="/company/{{ $company->id }}/update" id="passwordForm" novalidate>
        @csrf
        @method('put')
        <div class="card">
          <div class="card-header">
            <strong>Edit Company</strong>
          </div>

          <div class="card-body">
            <!-- Row 1 -->
            <div class="row">
              <div class="col-md-6"><br>
                <div class="form-col">
                  <label for="grower_name">Company Name</label>
                  <input class="form-control" id="grower_name" name="companyname" value="{{ $company->name }}" type="text" placeholder="Company Name">
                </div>
              </div>

              <div class="col-md-6"><br>
                <div class="form-col">
                  <label for="grower_rep">Company Sub Domain</label>
                  <input class="form-control" id="grower_rep" name="companydomain" value="{{ $company->domain }}" type="text" placeholder="Company Sub Domain">
                </div>
              </div>
            </div>

            <!-- Row 2 -->
            <div class="row">
              <div class="col-md-6">
                <div class="form-col">
                  <label for="grower_address">Username</label>
                  <input class="form-control" id="grower_address" name="username" value="{{ $company->username }}" type="text" placeholder="Username">
                </div>
              </div>

              <div class="col-md-6">
                <div class="form-col">
                  <label for="grower_address">Contact Person</label>
                  <input class="form-control" id="grower_address" name="contactPerson" value="{{ $company->contactPerson }}" type="text" placeholder="Contact Person">
                </div>
              </div>
            </div>

            <!-- Row 3 -->
            <div class="row">
              <div class="col-md-6">
                <div class="form-col">
                  <label for="national_id">Password</label>
                  <input class="form-control" id="new_password" name="new_password" type="password" placeholder="Password">
                </div>
              </div>

              <div class="col-md-6">
                <div class="form-col">
                  <label for="grower_type">Confirm Password</label>
                  <input class="form-control" id="confirm_password" name="confirm_password" type="password" placeholder="Confirm Password">
                  <div class="invalid-feedback">Passwords do not match.</div>
                </div>
              </div>
            </div>

            <!-- Row 4 -->
            <div class="row">
              <div class="col-md-6">
                <div class="form-col">
                  <label for="grower_number">Company Address</label>
                  <textarea class="form-control" id="exampleFormControlTextarea1" name="address" rows="3">{{ $company->address }}</textarea>
                </div>
              </div>

              <div class="col-md-4">
                <div class="form-col">
                  <label for="province">Email Address</label>
                  <input class="form-control" id="national_id" name="email" value="{{ $company->email }}" type="text" placeholder="Email Address">
                </div>
              </div>

              @php  $active = $company->IsActive; @endphp
              <div class="col-md-2 d-flex align-items-center">
                <div class="form-check form-switch" style="margin-top: 27px;">
                  <input class="form-check-input" type="checkbox" name="IsActive" value="1" id="defaultCheck1" @if($active) checked @endif>
                  <label class="form-check-label" for="defaultCheck1">Active</label>
                </div>
              </div>
            </div>

            <!-- Vendor Source Dropdown -->
            <div class="row">
              <div class="col-md-6">
                <div class="form-col">
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

            <!-- Dynamic Fields Section (reduced size preserved) -->
            <div class="dynamic-fields-section">
              <h5>Dynamic Fields</h5>
              @if(isset($dynamicFields) && count($dynamicFields) > 0)
                <div class="row">
                  <div class="col-sm-12">
                    <h5>Additional Fields</h5>
                  </div>
                </div>
              @endif

              <div class="row field-labels mb-1">
                <div class="col-md-3"><label>Form Name</label></div>
                <div class="col-md-3"><label>Form Label</label></div>
                <div class="col-md-2"><label>Form Type</label></div>
                <div class="col-md-3"><label>Options (for dropdown)</label></div>
                <div class="col-md-1"></div>
              </div>

              <div id="fields"></div>
              <button type="button" class="btn btn-secondary btn-sm" onclick="addField()">Add Field</button>
            </div>

          </div>

          <div class="card-footer">
            <div class="d-flex justify-content-end" style="gap: 10px;">
              <input type="submit" class="btn btn-success" value="Save" style="padding: 10px 20px; font-size: 16px; min-width: 100px;"/>
              <input type="reset" class="btn btn-danger" value="Cancel" style="padding: 10px 20px; font-size: 16px; min-width: 100px;"/>
            </div>
          </div>
        </div>
      </form>

    </div>
  </div>
</div>
@endsection

<style>
/* Reduced-size styles preserved (from your original) */
.dynamic-fields-section .form-group{margin-bottom:.75rem}
.dynamic-fields-section .form-control{padding:.25rem .5rem;font-size:.875rem;height:auto}
.dynamic-fields-section .btn{padding:.25rem .5rem;font-size:.875rem}
.dynamic-fields-section .text-muted{font-size:.75rem}
.dynamic-fields-section .row{margin-bottom:.5rem}
.field-labels{font-weight:600;font-size:.875rem}
</style>

<script>
    let fieldIndex = 0;
    let existingFields = @json($dynamicFields);

    document.addEventListener('DOMContentLoaded', function () {
        if (existingFields.length > 0) {
           existingFields.forEach(field => {
                let parsedOptions = '';
                try {
                    const json = JSON.parse(field.options);
                    parsedOptions = Array.isArray(json) ? json.join(',') : field.options;
                } catch (e) {
                    parsedOptions = field.options;
                }
                addField(field.name, field.label, field.type, field.id, parsedOptions);
            });
        } else {
            addField('vendor', 'Vendor', 'string');
            addField('amount', 'Amount', 'integer');
            addField('department', 'Department', 'string');
            addField('invoiceamount', 'Invoice Amount', 'integer');
            addField('paymentmethod', 'Payment Method', 'string');
        }
        setTimeout(() => {
            for (let i = 0; i < fieldIndex; i++) {
                const typeSelect = document.querySelector(`select[name="fields[${i}][type]"]`);
                if (typeSelect && typeSelect.value === 'dropdown') {
                    toggleDropdownOptions(i);
                }
            }
        }, 100);
    });

    function addField(name = '', label = '', type = '', fieldId = '', options = '') {
        const container = document.getElementById('fields');
        const fieldHTML = createField(fieldIndex, name, label, type, fieldId, options);
        container.insertAdjacentHTML('beforeend', fieldHTML);
        fieldIndex++;
    }

    function createField(index, name = '', label = '', type = '', fieldId = '', options = '') {
      const requiredFields = ['department', 'amount', 'vendor'];
      const isRemovable = !requiredFields.includes(name.toLowerCase());
      return `
        <div class="form-group" id="field-${index}">
            <div class="row">
                <input type="hidden" name="fields[${index}][id]" value="${fieldId}">
                <div class="col-md-3">
                    <input type="text" class="form-control form-control-sm" name="fields[${index}][name]" value="${name}" placeholder="Field Name" required ${isRemovable ? '' : 'readonly'}>
                </div>
                <div class="col-md-3">
                    <input type="text" class="form-control form-control-sm" name="fields[${index}][label]" value="${label}" placeholder="Label" required ${isRemovable ? '' : 'readonly'}>
                </div>
                <div class="col-md-2">
                    <select class="form-control form-control-sm" name="fields[${index}][type]" onchange="toggleDropdownOptions(${index})" required ${isRemovable ? '' : 'readonly'}>
                        <option value="">-- Select type --</option>
                        <option value="string" ${type === 'string' ? 'selected' : ''}>String</option>
                        <option value="integer" ${type === 'integer' ? 'selected' : ''}>Integer</option>
                        <option value="checkbox" ${type === 'checkbox' ? 'selected' : ''}>Checkbox</option>
                        <option value="dropdown" ${type === 'dropdown' ? 'selected' : ''}>Dropdown</option>
                    </select>
                </div>
                <div class="col-md-3">
                    <input type="text" class="form-control form-control-sm" id="options-${index}" name="fields[${index}][options]" value="${options}" placeholder="Option1,Option2,Option3" style="display: ${type === 'dropdown' ? 'block' : 'none'};">
                    <small class="text-muted" id="options-help-${index}" style="display: ${type === 'dropdown' ? 'block' : 'none'};">Separate options with commas</small>
                </div>
                <div class="col-md-1 text-right">
                    ${isRemovable ? `<button type="button" class="btn btn-danger btn-sm" onclick="removeField(${index})">&times;</button>` : ''}
                </div>
            </div>
        </div>`;
    }

    function removeField(index) {
        const element = document.getElementById(`field-${index}`);
        if (element) element.remove();
    }

    function toggleDropdownOptions(index) {
        const typeSelect = document.querySelector(`select[name="fields[${index}][type]"]`);
        const optionsInput = document.getElementById(`options-${index}`);
        const optionsHelp = document.getElementById(`options-help-${index}`);
        if (typeSelect.value === 'dropdown') {
            optionsInput.style.display = 'block';
            optionsHelp.style.display = 'block';
            optionsInput.required = true;
        } else {
            optionsInput.style.display = 'none';
            optionsHelp.style.display = 'none';
            optionsInput.required = false;
            optionsInput.value = '';
        }
    }
</script>
