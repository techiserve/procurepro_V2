@extends('stack.layouts.admin')

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
          
             <a style="color:white;" href="/companies/create" class="btn btn-primary btn-md pull-right"><i style="color:white;" class="icon-cloud-upload"></i> Add New Company</a>
          </div>

          <div class="card-body">
           <h2 class="mb-4">Create Custom Reports</h2>
<input type="hidden" id="fpurchaseorderColumnsJson" value='@json($fpurchaseorderColumns)'>
  <form method="POST" action="{{ route('reports.store') }}" id="customReportForm">
    @csrf

     <div class="row">
    <div class="col-md-6 mb-3">
        <div class="form-group">
      <label for="report_name" class="form-label">Report Name</label>
      <input type="text" name="report_name" id="report_name" class="form-control" required>
    </div>
    </div>

      <input type="hidden" name="companyId" id="" value="{{$company->id}}" class="form-control" required>

    <div class="col-md-6 mb-3">
        <div class="form-group">
      <label for="report_description" class="form-label">Report Description</label>
      <textarea name="report_description" id="report_description" class="form-control" rows="3"></textarea>
    </div>
    </div>
</div>

    <h5 class="mt-4">Columns</h5>
    <div class="table-responsive mb-3">
      <table class="table table-bordered" id="columnConfigTable">
        <thead>
          <tr>
            <th>Label</th>
            <th>Source Column</th>
            <th>Leave Blank?</th>
            <th>Action</th>
          </tr>
        </thead>
        <tbody id="columnConfigBody">
          <tr>
            <td><input type="text" name="columns[0][label]" class="form-control" required></td>
            <td>   <select name="columns[0][column]" class="form-control column-select">
            @foreach($fpurchaseorderColumns as $column)
                <option value="{{ $column }}">{{ $column }}</option>
            @endforeach
            </select></td>
            <td class="text-center"><input type="checkbox" name="columns[0][blank]" value="1"></td>
            <td><button type="button" class="btn btn-danger btn-sm remove-row">Remove</button></td>
          </tr>
        </tbody>
      </table>
      <button type="button" class="btn btn-secondary" id="addColumnBtn">Add Column</button>
    </div>

    <button type="submit" class="btn btn-success">Save Report</button>
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
  let rowCount = 1;

  const columnList = JSON.parse(document.getElementById('fpurchaseorderColumnsJson').value);

  function generateColumnOptionsHTML() {
    return '<option value="">Select a column</option>' + 
           columnList.map(col => `<option value="${col}">${col}</option>`).join('');
  }

  function initializeSelect2() {
    // Destroy existing Select2 instances first
    $('.column-select').select2('destroy').off('select2:open select2:close');
    
    // Initialize Select2
    $('.column-select').select2({
      width: '100%',
      placeholder: 'Select a column',
      allowClear: true,
      theme: 'bootstrap-5' // Use bootstrap-5 theme for better compatibility
    });
  }

  // Initialize the first dropdown after DOM is ready
  setTimeout(function() {
    initializeSelect2();
  }, 100);

  $('#addColumnBtn').on('click', function () {
    const newRow = `
      <tr>
        <td><input type="text" name="columns[${rowCount}][label]" class="form-control" required></td>
        <td>
          <select name="columns[${rowCount}][column]" class="form-control column-select">
            ${generateColumnOptionsHTML()}
          </select>
        </td>
        <td class="text-center"><input type="checkbox" name="columns[${rowCount}][blank]" value="1"></td>
        <td><button type="button" class="btn btn-danger btn-sm remove-row">Remove</button></td>
      </tr>
    `;
    $('#columnConfigBody').append(newRow);
    
    // Re-initialize Select2 for all dropdowns
    setTimeout(function() {
      initializeSelect2();
    }, 50);
    
    rowCount++;
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
});
</script>