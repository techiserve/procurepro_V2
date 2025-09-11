@extends('html.default')

@section('content')
<div class="body-content__header">
  <ul>
    <li><a href="#">ProcurePro Requisitions</a></li>
 
  </ul>
</div>

@php
  /** @var \App\Models\Requisition $requisition */
  // Prefer an explicitly-passed $documents collection; otherwise fall back to a relation


  $status = (string)($requisition->status_code ?? '');
  $badgeClass = match($status) {
      'Approved' => 'badge-success',
      'Pending', 'In Review' => 'badge-info',
      'Rejected', 'Declined' => 'badge-danger',
      default => 'badge-secondary'
  };

  // Small helper for boolean badges
  $yesNo = fn($v) => ($v == 1 || $v === true || $v === '1')
      ? '<span class="badge badge-success">Yes</span>'
      : '<span class="badge badge-secondary">No</span>';
@endphp

<div class="container-fluid">
  <!-- Top actions -->
  <div class="d-flex justify-content-between align-items-center mb-3">
    <div>
      {{-- <a href="{{ url()->previous() }}" class="btn btn-light">
        <i class="fa fa-arrow-left mr-1"></i> Back
      </a> --}}
    </div>
    <div class="text-right">
      <span class="mr-2">Status:</span>
      <span class="badge {{ $badgeClass }} p-2">{{ $status ?: '—' }}</span>
    </div>
  </div>

  <!-- Card: Requisition Details -->
  <div class="card shadow-sm mb-4">
    <div class="card-header d-flex justify-content-between align-items-center">
      <h5 class="mb-0">Requisition Details</h5>
      <small class="text-muted">Unique ID: <strong>{{ $requisition->unique_id }}</strong></small>
    </div>
    <div class="card-body">
      <form class="needs-validation" novalidate>
        <div class="row">
          <div class="col-md-6 mb-3">
            <label>Description</label>
            <input type="text" class="form-control" name="description" value="{{ $requisition->description }}" readonly>
          </div>
          <div class="col-md-3 mb-3">
            <label>Amount</label>
            <input type="text" class="form-control" name="amount" value="{{ is_numeric($requisition->amount) ? number_format($requisition->amount, 2) : $requisition->amount }}" readonly>
          </div>
          <div class="col-md-3 mb-3">
            <label>Method Payment</label>
            <input type="text" class="form-control" name="method_payment" value="{{ $requisition->method_payment }}" readonly>
          </div>

          <div class="col-md-3 mb-3">
            <label>Vendor Registered</label>
            <input type="text" class="form-control" name="vendor_registered" value="{{ $requisition->vendor_registered }}" readonly>
          </div>
          <div class="col-md-3 mb-3">
            <label>Vendor ID</label>
            <input type="text" class="form-control" name="vendor_id" value="{{ $requisition->vendor_id }}" readonly>
          </div>
          <div class="col-md-3 mb-3">
            <label>Supplier Code</label>
            <input type="text" class="form-control" name="supplier_code" value="{{ $requisition->supplier_code }}" readonly>
          </div>
          <div class="col-md-3 mb-3">
            <label>Project Code</label>
            <input type="text" class="form-control" name="project_code" value="{{ $requisition->project_code }}" readonly>
          </div>

          <div class="col-md-4 mb-3">
            <label>Class of Expenses</label>
            <input type="text" class="form-control" name="class_of_expenses" value="{{ $requisition->class_of_expenses }}" readonly>
          </div>
          <div class="col-md-4 mb-3">
            <label>Reference</label>
            <input type="text" class="form-control" name="reference" value="{{ $requisition->reference }}" readonly>
          </div>
          <div class="col-md-4 mb-3">
            <label>General LGR Alloc</label>
            <input type="text" class="form-control" name="general_lgr_alloc" value="{{ $requisition->general_lgr_alloc }}" readonly>
          </div>

          <div class="col-md-4 mb-3">
            <label>Bank ID</label>
            <input type="text" class="form-control" name="bank_id" value="{{ $requisition->bank_id }}" readonly>
          </div>
          <div class="col-md-4 mb-3">
            <label>Added By (ID)</label>
            <input type="text" class="form-control" name="added_by_id" value="{{ $requisition->added_by_id }}" readonly>
          </div>
          <div class="col-md-4 mb-3">
            <label>Created Date</label>
            <input type="text" class="form-control" name="created_date" value="{{ $requisition->created_date }}" readonly>
          </div>

          <div class="col-md-12 mb-3">
            <label>Notes</label>
            <textarea class="form-control" name="notes" rows="2" readonly>{{ $requisition->notes }}</textarea>
          </div>
        </div>

        <hr>
        <h6 class="mb-3">Approval Routing</h6>
        <div class="row">
          <div class="col-md-4 mb-3">
            <label>First Line App (ID)</label>
            <input type="text" class="form-control" name="first_line_app" value="{{ $requisition->first_line_app }}" readonly>
          </div>
          <div class="col-md-4 mb-3">
            <label>Finance Manager (ID)</label>
            <!-- NOTE: field name kept exactly as provided: "finanace_manager" -->
            <input type="text" class="form-control" name="finanace_manager" value="{{ $requisition->finanace_manager }}" readonly>
          </div>
          <div class="col-md-4 mb-3">
            <label>MD (ID)</label>
            <input type="text" class="form-control" name="MD" value="{{ $requisition->MD }}" readonly>
          </div>

          <div class="col-md-4 mb-3">
            <label class="d-block">First Line Approved</label>
            <div>{!! $yesNo($requisition->first_line_approved) !!}</div>
          </div>
          <div class="col-md-4 mb-3">
            <label class="d-block">Finance Approved</label>
            <!-- NOTE: field name kept exactly as provided: "finanace_manager_approved" -->
            <div>{!! $yesNo($requisition->finanace_manager_approved) !!}</div>
          </div>
          <div class="col-md-4 mb-3">
            <label class="d-block">MD Approved</label>
            <div>{!! $yesNo($requisition->md_approved) !!}</div>
          </div>
        </div>

        <div class="d-flex justify-content-end">
          <a href='{{ url("/procureprorequisition/{$requisition->unique_id}/edit") }}' class="btn btn-primary">
            <i class="fa fa-edit mr-1"></i> Edit Requisition
          </a>
        </div>
      </form>
    </div>
  </div>

  <!-- Card: Documents -->
  <div class="card shadow-sm">
    <div class="card-header d-flex justify-content-between align-items-center">
      <h5 class="mb-0">Attached Documents</h5>
    </div>
    <div class="card-body">
     <div class="table-responsive">
  <table class="table table-sm" >
    <thead class="thead-light">
      <tr>
        <th class="text-center" >#</th>
        <th>Filename</th>
        <th>Type</th>
        <th class="text-center" >Action</th>
      </tr>
    </thead>
    <tbody>
      @forelse($documents as $doc)
        <tr>
          <td class="text-center">{{ $loop->iteration }}</td>
          <td>{{ $doc->name }}</td>
          <td>{{ $doc->type }}</td>
          <td class="text-center">
            <a href="{{ asset($doc->file_path) }}" 
               target="_blank" 
               class="btn btn-sm btn-info">
               <i class=""></i> View
            </a>
          </td>
        </tr>
      @empty
        <tr>
          <td colspan="4" class="text-center text-muted">
            No documents attached to this requisition.
          </td>
        </tr>
      @endforelse
    </tbody>
  </table>
</div>
    </div>
  </div>
</div>

{{-- Optional: Activate small DataTable for docs only (no server-side) --}}
<link  href="https://cdn.datatables.net/1.13.8/css/jquery.dataTables.min.css" rel="stylesheet"/>
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="https://cdn.datatables.net/1.13.8/js/jquery.dataTables.min.js"></script>
<script>
  $(function(){
    $('#reqDocsTable').DataTable({
      pageLength: 10,
      lengthChange: false,
      order: [[0, 'asc']],
      dom: 't<"dt-bottom"ip>'
    });
  });
</script>
@endsection
