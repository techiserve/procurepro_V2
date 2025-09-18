@extends('html.default')

<link href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<link rel="stylesheet" href="https://unpkg.com/bootstrap@5.3.3/dist/css/bootstrap.min.css">
<link rel="stylesheet" href="https://unpkg.com/bs-brain@2.0.4/tutorials/timelines/timeline-7/assets/css/timeline-7.css">

@section('content')
<div class="container-fluid">
  <div class="animated fadeIn">
    <div class="row">
      <div class="col-sm-12">
        <div class="card">
          <div class="card-header">
            <strong>Companies</strong>
           <div class="d-flex justify-content-end mb-3" style="gap: 10px;">
             <a style="color:white;" href="/companies/create" class="btn btn-primary btn-md pull-right"><i style="color:white;" class="icon-cloud-upload"></i> Add New Company</a>
          </div>
           </div>

          <div class="card-body">
           <h2 class="mb-4">Create Custom Reports</h2>
           
<!-- Store both column arrays as JSON -->
<input type="hidden" id="fpurchaseorderColumnsJson" value='@json($fpurchaseorderColumns)'>
<input type="hidden" id="frequisitionsColumnsJson" value='@json($frequistionsColumns)'>

  <form method="POST" action="{{ route('reports.store') }}" id="customReportForm">
    @csrf

     <div class="row">
    <div class="col-md-4 mb-3">
        <div class="form-group">
      <label for="report_name" class="form-label">Report Name</label>
      <input type="text" name="report_name" id="report_name" class="form-control" required>
    </div>
    </div>

      <input type="hidden" name="companyId" id="" value="{{$company->id}}" class="form-control" required>

    <!-- New Report Type Dropdown -->
    <div class="col-md-4 mb-3">
        <div class="form-group">
            <label for="report_type" class="form-label">Report Type</label>
            <select name="report_type" id="report_type" class="form-control" required>
                <option value="">Select Report Type</option>
                <option value="purchase_order">Purchase Order</option>
                <option value="requisition">Requisition</option>
            </select>
        </div>
    </div>

    <div class="col-md-4 mb-3">
        <div class="form-group">
      <label for="filterfield" class="form-label">Select Filter Field</label>
       <select name="filterfield" id="filterfield" class="form-control filter-select" required disabled>
                    <option value="">Select report type first</option>
                </select>
    </div>
    </div>
</div>

    <h5 class="mt-4">Columns</h5>
    <div class="alert alert-info" id="selectTypeAlert">
        <i class="fas fa-info-circle"></i> Please select a Report Type first to configure columns.
    </div>
    
    <div class="table-responsive mb-3" id="columnTableWrapper" style="display: none;">
      <table class="table table-bordered" id="columnConfigTable">
        <thead>
          <tr>
            <th>Label</th>
            <th>Source Column</th>
            <th>Leave Blank?</th>
            <th>Default Value</th>
            <th>Action</th>
          </tr>
        </thead>
        <tbody id="columnConfigBody">
           <!-- Initial row will be added dynamically -->
        </tbody>
      </table>
      <button type="button" class="btn btn-info" id="addColumnBtn">Add Column</button>
    </div>

    <button type="submit" class="btn btn-success" id="submitBtn" disabled>Save Report</button>
  </form>
          </div>

        </div>
      </div>
    </div>


  </div>
</div>

@endsection

{{-- Place JS below the Blade section --}}
<!-- jQuery (v3.6+) -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<!-- Bootstrap 5 JS (matches your CSS version) -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

<!-- SweetAlert -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.all.min.js"></script>

<!-- Select2 -->
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

<script>
$(document).ready(function () {
  let rowCount = 0;
  let currentColumns = [];
  
  const fpurchaseorderColumns = JSON.parse(document.getElementById('fpurchaseorderColumnsJson').value);
  const frequisitionsColumns = JSON.parse(document.getElementById('frequisitionsColumnsJson').value);

  function generateColumnOptionsHTML(columns) {
    return '<option value="">Select a column</option>' + 
           columns.map(col => `<option value="${col}">${col}</option>`).join('');
  }

  function initializeSelect2() {
    // Destroy existing Select2 instances first
    $('.column-select').each(function() {
        if ($(this).data('select2')) {
            $(this).select2('destroy');
        }
    });
    
    $('.filter-select').each(function() {
        if ($(this).data('select2')) {
            $(this).select2('destroy');
        }
    });
    
    // Initialize Select2
    $('.column-select').select2({
      width: '100%',
      placeholder: 'Select a column',
      allowClear: true,
      theme: 'bootstrap-5'
    });
    
    $('.filter-select').select2({
      width: '100%',
      placeholder: 'Select a column',
      allowClear: true,
      theme: 'bootstrap-5'
    });
  }

  // Handle Report Type change
  $('#report_type').on('change', function() {
    const reportType = $(this).val();
    
    if (reportType === '') {
      // Reset everything if no type selected
      $('#selectTypeAlert').show();
      $('#columnTableWrapper').hide();
      $('#filterfield').prop('disabled', true).html('<option value="">Select report type first</option>');
      $('#submitBtn').prop('disabled', true);
      currentColumns = [];
      return;
    }
    
    // Enable submit button and filter field
    $('#submitBtn').prop('disabled', false);
    $('#filterfield').prop('disabled', false);
    
    // Set columns based on selection
    if (reportType === 'purchase_order') {
      currentColumns = fpurchaseorderColumns;
    } else if (reportType === 'requisition') {
      currentColumns = frequisitionsColumns;
    }
    
    // Update filter field dropdown
    $('#filterfield').html(generateColumnOptionsHTML(currentColumns));
    
    // Show column table and hide alert
    $('#selectTypeAlert').hide();
    $('#columnTableWrapper').show();
    
    // Clear existing rows
    $('#columnConfigBody').empty();
    rowCount = 0;
    
    // Add initial row
    addNewRow();
    
    // Re-initialize Select2
    setTimeout(function() {
      initializeSelect2();
    }, 100);
  });

  function addNewRow() {
    const newRow = `
    <tr>
        <td><input type="text" name="columns[${rowCount}][label]" class="form-control" required></td>
        <td>
        <select name="columns[${rowCount}][column]" class="form-control column-select">
            ${generateColumnOptionsHTML(currentColumns)}
        </select>
        </td>
        <td class="text-center"><input type="checkbox" name="columns[${rowCount}][blank]" value="1"></td>
        <td><input type="text" name="columns[${rowCount}][default]" class="form-control" placeholder="Optional default"></td>
        <td><button type="button" class="btn btn-danger btn-sm remove-row">Remove</button></td>
    </tr>
    `;
    $('#columnConfigBody').append(newRow);
    rowCount++;
  }

  $('#addColumnBtn').on('click', function () {
    if (currentColumns.length === 0) {
      Swal.fire({
        icon: 'warning',
        title: 'Warning',
        text: 'Please select a report type first.'
      });
      return;
    }
    
    addNewRow();
    
    // Re-initialize Select2 for all dropdowns
    setTimeout(function() {
      initializeSelect2();
    }, 50);
  });

  $('#columnConfigBody').on('click', '.remove-row', function () {
    if ($('#columnConfigBody tr').length > 1) {
      // Destroy Select2 instance before removing the row
      $(this).closest('tr').find('.column-select').select2('destroy');
      $(this).closest('tr').remove();
    } else {
      Swal.fire({
        icon: 'warning',
        title: 'Warning',
        text: 'At least one column must remain.'
      });
    }
  });
  
  // Form validation before submit
  $('#customReportForm').on('submit', function(e) {
    if ($('#report_type').val() === '') {
      e.preventDefault();
      Swal.fire({
        icon: 'error',
        title: 'Error',
        text: 'Please select a report type.'
      });
      return false;
    }
    
    if ($('#columnConfigBody tr').length === 0) {
      e.preventDefault();
      Swal.fire({
        icon: 'error',
        title: 'Error',
        text: 'Please add at least one column.'
      });
      return false;
    }
  });
});
</script>