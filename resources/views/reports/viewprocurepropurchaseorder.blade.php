@extends('html.default')

@section('content')
<div class="body-content__header">
  <ul>
    <li><a href="#">ProcurePro Purchase Order</a></li>
    <li><span>/</span></li>
    <li><strong>View Purchase Order</strong></li>
  </ul>
</div>

@php
  /**
   * Expected variables:
   * - $purchaseOrder (object/model) OR $po (fallback)
   * - optional $documents collection (otherwise falls back to relation ->documents)
   */
  $po = $purchaseOrder ?? ($po ?? null);
  if (!$po) { $po = (object)[]; }


  $status = (string)($po->status_code ?? '');
  $badgeClass = match($status) {
      'Approved' => 'badge-success',
      'Pending', 'In Review', 'Unprocessed' => 'badge-info',
      'Rejected', 'Declined' => 'badge-danger',
      default => 'badge-secondary'
  };

  $fmtMoney = function($v) {
    if (is_null($v) || $v === '') return '';
    return is_numeric($v) ? number_format((float)$v, 2) : $v;
  };
  $yesNo = fn($v) => ($v == 1 || $v === true || $v === '1')
      ? '<span class="badge badge-success">Yes</span>'
      : '<span class="badge badge-secondary">No</span>';
@endphp

<div class="container-fluid">
  <!-- Top actions -->
  <div class="d-flex justify-content-between align-items-center mb-3">
    <div>
      <a href="{{ url()->previous() }}" class="btn btn-light">
        <i class="fa fa-arrow-left mr-1"></i> Back
      </a>
    </div>
    <div class="text-right">
      <small class="text-muted mr-2">Purchase ID:</small>
      <strong class="mr-3">{{ $po->purchase_id ?? '—' }}</strong>
      <span class="mr-2">Status:</span>
      <span class="badge {{ $badgeClass }} p-2">{{ $status ?: '—' }}</span>
    </div>
  </div>

  <!-- Card: Purchase Order Details -->
  <div class="card shadow-sm mb-4">
    <div class="card-header d-flex justify-content-between align-items-center">
      <h5 class="mb-0">Purchase Order Details</h5>
      <small class="text-muted">Unique ID: <strong>{{ $po->unique_id ?? '—' }}</strong></small>
    </div>
    <div class="card-body">
      <form class="needs-validation" novalidate>
        <div class="row">
          <div class="col-md-3 mb-3">
            <label>Purchase ID</label>
            <input type="text" class="form-control" name="purchase_id" value="{{ $po->purchase_id ?? '' }}" readonly>
          </div>
          <div class="col-md-3 mb-3">
            <label>Purchase Req ID</label>
            <input type="text" class="form-control" name="purchase_req_id" value="{{ $po->purchase_req_id ?? '' }}" readonly>
          </div>
          <div class="col-md-3 mb-3">
            <label>Unique ID</label>
            <input type="text" class="form-control" name="unique_id" value="{{ $po->unique_id ?? '' }}" readonly>
          </div>
          <div class="col-md-3 mb-3">
            <label>Status</label>
            <input type="text" class="form-control" name="status_code" value="{{ $status }}" readonly>
          </div>

          <div class="col-md-6 mb-3">
            <label>Description</label>
            <input type="text" class="form-control" name="description" value="{{ $po->description ?? '' }}" readonly>
          </div>
          <div class="col-md-3 mb-3">
            <label>Amount</label>
            <input type="text" class="form-control" name="amount" value="{{ $fmtMoney($po->amount ?? null) }}" readonly>
          </div>
          <div class="col-md-3 mb-3">
            <label>Method Payment</label>
            <input type="text" class="form-control" name="method_payment" value="{{ $po->method_payment ?? '' }}" readonly>
          </div>

          <div class="col-md-3 mb-3">
            <label>Vendor Registered</label>
            <input type="text" class="form-control" name="vendor_registered" value="{{ $po->vendor_registered ?? '' }}" readonly>
          </div>
          <div class="col-md-3 mb-3">
            <label>Vendor ID</label>
            <input type="text" class="form-control" name="vendor_id" value="{{ $po->vendor_id ?? '' }}" readonly>
          </div>
          <div class="col-md-3 mb-3">
            <label>Class of Expenses</label>
            <input type="text" class="form-control" name="class_of_expenses" value="{{ $po->class_of_expenses ?? '' }}" readonly>
          </div>

          <div class="col-md-4 mb-3">
            <label>First Line App (ID)</label>
            <input type="text" class="form-control" name="first_line_app" value="{{ $po->first_line_app ?? '' }}" readonly>
          </div>
          <div class="col-md-4 mb-3">
            <label>Finance Manager (ID)</label>
            <!-- NOTE: field name intentionally preserved: finanace_manager -->
            <input type="text" class="form-control" name="finanace_manager" value="{{ $po->finanace_manager ?? '' }}" readonly>
          </div>
          <div class="col-md-4 mb-3">
            <label>MD (ID)</label>
            <input type="text" class="form-control" name="MD" value="{{ $po->MD ?? '' }}" readonly>
          </div>

          <div class="col-md-4 mb-3">
            <label class="d-block">First Line Approved</label>
            <div>{!! $yesNo($po->first_line_approved ?? 0) !!}</div>
          </div>
          <div class="col-md-4 mb-3">
            <label class="d-block">Finance Approved</label>
            <!-- NOTE: field name intentionally preserved: finanace_manager_approved -->
            <div>{!! $yesNo($po->finanace_manager_approved ?? 0) !!}</div>
          </div>
          <div class="col-md-4 mb-3">
            <label class="d-block">MD Approved</label>
            <div>{!! $yesNo($po->md_approved ?? 0) !!}</div>
          </div>

          <div class="col-md-3 mb-3">
            <label>Invoice Amount</label>
            <input type="text" class="form-control" name="invoice_amount" value="{{ $fmtMoney($po->invoice_amount ?? null) }}" readonly>
          </div>
          <div class="col-md-3 mb-3">
            <label>Invoice Number</label>
            <!-- NOTE: field name intentionally preserved: invoice_nummber -->
            <input type="text" class="form-control" name="invoice_nummber" value="{{ $po->invoice_nummber ?? '' }}" readonly>
          </div>
          <div class="col-md-3 mb-3">
            <label>Full Filled</label>
            <input type="text" class="form-control" name="full_filled" value="{{ ($po->full_filled ?? 0) ? 'Yes' : 'No' }}" readonly>
          </div>
          <div class="col-md-3 mb-3">
            <label>Payment Release</label>
            <input type="text" class="form-control" name="payment_release" value="{{ $po->payment_release ?? '' }}" readonly>
          </div>

          <div class="col-md-4 mb-3">
            <label>Beneficiary Reference</label>
            <input type="text" class="form-control" name="beneficiary_reference" value="{{ $po->beneficiary_reference ?? '' }}" readonly>
          </div>
          <div class="col-md-4 mb-3">
            <label>My Reference</label>
            <input type="text" class="form-control" name="my_reference" value="{{ $po->my_reference ?? '' }}" readonly>
          </div>
          <div class="col-md-4 mb-3">
            <label>Added By Role</label>
            <input type="text" class="form-control" name="added_by_role" value="{{ $po->added_by_role ?? '' }}" readonly>
          </div>

          <div class="col-md-4 mb-3">
            <label>Added By (ID)</label>
            <input type="text" class="form-control" name="added_by_id" value="{{ $po->added_by_id ?? '' }}" readonly>
          </div>
          <div class="col-md-4 mb-3">
            <label>Modified Date</label>
            <input type="text" class="form-control" name="modified_date" value="{{ $po->modified_date ?? '' }}" readonly>
          </div>
          <div class="col-md-4 mb-3">
            <label>Created Date</label>
            <input type="text" class="form-control" name="created_date" value="{{ $po->created_date ?? '' }}" readonly>
          </div>

          <div class="col-md-12 mb-3">
            <label>Notes</label>
            <textarea class="form-control" name="notes" rows="2" readonly>{{ $po->notes ?? '' }}</textarea>
          </div>
        </div>

        <div class="d-flex justify-content-end">
          <a href='{{ url("/procurepropurchaseorder/" . ($po->purchase_id ?? '')) }}/edit' class="btn btn-primary {{ empty($po->purchase_id) ? 'disabled' : '' }}">
            <i class="fa fa-edit mr-1"></i> Edit Purchase Order
          </a>
        </div>
      </form>
    </div>
  </div>

  <!-- Card: Attached Documents -->
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

{{-- Lightweight DataTable for documents list --}}
<link  href="https://cdn.datatables.net/1.13.8/css/jquery.dataTables.min.css" rel="stylesheet"/>
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="https://cdn.datatables.net/1.13.8/js/jquery.dataTables.min.js"></script>
<script>
  $(function(){
    $('#poDocsTable').DataTable({
      pageLength: 10,
      lengthChange: false,
      order: [[0, 'asc']],
      dom: 't<"dt-bottom"ip>'
    });
  });
</script>
@endsection
