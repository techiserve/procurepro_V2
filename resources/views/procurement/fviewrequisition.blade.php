@extends('html.default')
<!-- iCheck CSS -->
<link href="https://cdn.jsdelivr.net/npm/icheck/skins/square/blue.css" rel="stylesheet">

<!-- jQuery (required) -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<!-- iCheck JS -->
<script src="https://cdn.jsdelivr.net/npm/icheck/icheck.min.js"></script>
@section('content')

@php
  $prev = url()->previous();
  $fallback = route('procurement.indexrequisition');
  $backUrl = ($prev && str_starts_with($prev, url('/'))) ? $prev : $fallback;
@endphp

<!-- TOP: Back button (previous page) -->
<div class="container-fluid">
  <div class="py-2">
    <a href="{{ $backUrl }}" class="btn btn-outline-secondary btn-sm">
      <i class="fa fa-arrow-left"></i> Back
    </a>
  </div>
</div>

<div class="container-fluid">
  <div class="animated fadeIn">
    <div class="row">
      <div class="col-sm-12">
    <form method="POST" action="/procurement/{{$frequisition->id}}/approve">
       @csrf
       @method('put')
          <div class="card">
          <div class="card-header">
            <div class="d-flex justify-content-between align-items-center">
              <strong>View Requisition.</strong>
              <a href="/procurement/indexrequisition" class="btn btn-primary btn-sm">
                <i style="color:white;" class="fa fa-align-justify"></i> Requistions List
              </a>
            </div>
           </div>

           <div class="card-body">
    <div class="row">
    @php
        $normalizedRequisition = [];
        foreach ($frequisition->getAttributes() as $key => $value) {
            $normalizedRequisition[strtolower(trim($key))] = $value;
        }
        $hiddenFields = ['invoiceamount', 'invoice amount'];
    @endphp

    @foreach ($formFields as $field)
        @php
            $normalizedField = strtolower(trim($field->name));
        @endphp

        @continue(in_array($normalizedField, $hiddenFields))

        @php
            $value = '';
            if ($normalizedField === 'department') {
                $value = $departments->firstWhere('id', $frequisition->department)->name ?? 'Unknown Department';
            } else {
                $value = $normalizedRequisition[$normalizedField] ?? '';
            }
        @endphp

        <div class="col-md-6 mb-3">
            <label class="form-label">{{ $field->label }}</label>
            <input type="text" class="form-control" value="{{ $value }}" readonly>
        </div>
        @endforeach
        </div>
         <div class="row">
          @if($frequisition->reason != null)
              <div class="col-sm-6">
          <div class="form-group">
            <label for="grower_type">Reason</label>
            <textarea class="form-control" id="exampleFormControlTextarea1" name="reason" rows="3" readonly>{{$frequisition->reason}}</textarea>
          </div>
        </div>
        @endif
        </div>
      </div>
       <br>
       </div>
    </div>
</div>
</div>

    <div class="row">
      <div class="col-sm-12">
        <div class="card">
          <div class="card-header">
            <strong>Vendors</strong>
            <small>List</small>
          </div>

          <div class="card-body">
            <table class="table table-responsive-sm table-bordered table-striped table-sm">
          <thead>
            <tr>
             <th class="text-center">Select</th>
              <th class="text-center">Vendor Name</th>
              <th class="text-center">Amount</th>
              <th class="text-center">Document</th>
            </tr>
          </thead>
          <tbody>
            @foreach ($frequisitionvendors as $faira)
              <tr>
                <td class="text-center">
                  <input type="checkbox"
                         name="selected_vendor"
                         value="{{ $faira->id }}"
                         class="exclusive-checkbox"
                         {{ $faira->status == 1 ? 'checked' : '' }}>
                </td>
                <td class="text-center">{{ $faira->vendor_final }}</td>
                <td class="text-center">R {{ number_format($faira->amount, 2) }}</td>
                <td class="text-center">
                 @if (!empty($faira->file_path))
                <a href="{{ asset('/storage/uploads/' . $faira->file_path) }}" target="_blank" class="btn btn-info btn-sm" style="color: white;">
                  View Document
                </a>
               @else
                    <p>No document available.</p>
                  @endif
                </td>
              </tr>
            @endforeach
          </tbody>
        </table>
          </div>

          <!-- Restore ACTION BUTTONS at bottom -->
          @if($frequisition->userId != auth()->user()->id AND $history == NULL AND  $frequisition->status != 6)
            @if($frequisition->approvedby == auth()->user()->userrole AND $frequisition->approvallevel <= $frequisition->totalapprovallevels)
              <div class="card-footer">
                <div class="form-group pull-right">
                  <button type="submit" id="submitBtn" class="btn btn-success" disabled>
                    <span class='fa fa-check-circle'></span> Approve
                  </button>
                  <a href="" data-target="#returnback" data-toggle="modal" class="btn btn-info" style="color: white;">
                    <span class='fa fa-arrow-left'></span>
                    <span class='hidden-sm hidden-sm hidden-md'>Return</span>
                  </a>
                  <a href="" data-target="#emailCopy" data-toggle="modal" class="btn btn-danger" style="color: white;">
                    <span class='fa fa-times-circle'></span>
                    <span class='hidden-sm hidden-sm hidden-md'>Reject</span>
                  </a>
                </div>
              </div>
            @endif
          @endif

        </div>
      </div>
    </div>
 
    </form>
</div>

<!-- MODALS unchanged ... -->

@endsection

<script>
document.addEventListener('DOMContentLoaded', function () {
    const checkboxes = document.querySelectorAll('.exclusive-checkbox');
    const form = document.querySelector('form');
    const submitBtn = document.getElementById('submitBtn');

    function enforceSingleSelection(selected) {
        checkboxes.forEach(cb => {
            if (cb !== selected) cb.checked = false;
        });
    }

    function updateSubmitButtonState() {
        const isChecked = Array.from(checkboxes).some(cb => cb.checked);
        submitBtn.disabled = !isChecked;
    }

    updateSubmitButtonState();

    checkboxes.forEach(cb => {
        cb.addEventListener('change', function () {
            enforceSingleSelection(this);
            updateSubmitButtonState();
        });
    });

    form.addEventListener('submit', function (e) {
        const isChecked = Array.from(checkboxes).some(cb => cb.checked);
        if (!isChecked) {
            e.preventDefault();
            alert('You must select exactly one vendor.');
        }
    });
});
</script>
