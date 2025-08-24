@extends('html.default')

@section('styles')
<link rel="stylesheet" href="https://unpkg.com/bootstrap@5.3.3/dist/css/bootstrap.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.min.css">
@endsection

@section('content')
<div class="body-content__header">
    <ul>
        <li><a href="#">Al Barak Report</a></li>
    </ul>
</div>

<div class="body-content__wrapper requesition-body">
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <strong>Al Barak Report</strong>
            <div class="d-flex align-items-center gap-2">
                <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#filterModal">
                    <i class="fa fa-filter"></i> Filter
                </button>
            </div>
        </div>

        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-striped table-bordered" id="albarakReportTable">
                    <thead class="table-light text-center">
                        <tr>
                            <th class="text-center">FROM ACCOUNT</th>
                            <th class="text-center">BENEFICIARY NAME</th>
                            <th class="text-center">BENEFICIARY BRANCH CODE</th>
                            <th class="text-center">BENEFICIARY ACCOUNT</th>
                            <th class="text-center">MY REFERENCES</th>
                            <th class="text-center">BENEFICIARY REFERENCES</th>
                            <th class="text-center">NOTIFY RECIPIENT VIA SMS</th>
                            <th class="text-center">RECIPIENT PHONE</th>
                            <th class="text-center">NOTIFY RECIPIENT VIA EMAIL</th>
                            <th class="text-center">RECIPIENT EMAIL</th>
                            <th class="text-center">AMOUNT</th>
                            <th class="text-center">INSTANT PAYMENT</th>
                            <th class="text-center">DATE</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($fpurchaseorder as $grower)
                            <tr class="text-center">
                                <td>{{ $grower->bankAccountNumber }}</td>
                                <td>{{ $grower->Vendor }}</td>
                                <td>330</td>
                                <td>11111</td>
                                <td>{{ $grower->ownref }}</td>
                                <td>{{ $grower->benref }}</td>
                                <td>No</td>
                                <td></td>
                                <td>No</td>
                                <td></td>
                                <td>{{ $grower->invoiceamount }}</td>
                                <td>No</td>
                                <td>{{ $grower->created_at }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            {{-- Optional secondary trigger below table --}}
            <div class="mt-3 text-end">
                {{-- <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#filterModal">
                    <i class="fa fa-filter"></i> Filter
                </button> --}}
            </div>
        </div>
    </div>
</div>

{{-- Filter Modal (Bootstrap 5) --}}
<div class="modal fade" id="filterModal" tabindex="-1" aria-labelledby="filterModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-md">
        <form method="post" action="{{ route('purchaseorder.filtered') }}" enctype="multipart/form-data" class="modal-content">
            {{ csrf_field() }}
            <div class="modal-header">
                <h4 class="modal-title" id="filterModalLabel">Filter Purchase Order Summary</h4>
                <button class="btn-close" type="button" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="modal-body">
                <div class="form-group mb-3">
                    <label for="start_date" class="form-label">Date From</label>
                    <input class="form-control" id="start_date" name="start_date" type="date">
                </div>
                <div class="form-group mb-3">
                    <label for="end_date" class="form-label">Date To</label>
                    <input class="form-control" id="end_date" name="end_date" type="date">
                </div>
                <div class="form-group mb-3">
                    <label for="status" class="form-label">Status</label>
                    <select name="status" id="status" class="form-select js-example-basic-single" style="width:100%;">
                        <option value="">--Select Status--</option>
                        <option value="2">Approved</option>
                        <option value="3">Rejected</option>
                        <option value="1">Pending</option>
                    </select>
                </div>
                <div class="form-group mb-0">
                    <label for="vendor" class="form-label">Vendor</label>
                    <select name="vendor" id="vendor" class="form-select js-example-basic-single" style="width:100%;">
                        <option value="">--Select Vendor--</option>
                        @foreach($vendors as $vendor)
                            <option value="{{ $vendor->SupplierName }}">{{ $vendor->SupplierName }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="modal-footer">
                <button class="btn btn-secondary" type="button" data-bs-dismiss="modal">Close</button>
                <button class="btn btn-primary" type="submit">Filter Summary</button>
            </div>
        </form>
    </div>
</div>
@endsection

@section('scripts')
<!-- Bootstrap JS Bundle -->
<script src="https://unpkg.com/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<!-- jQuery (required for Select2) -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
<!-- Select2 JS -->
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

<script>
// DataTable init: mirrors the reference UX
document.addEventListener("DOMContentLoaded", function () {
    const table = new DataTable('#albarakReportTable', {
        responsive: true,
        paging: true,
        searching: true,
        ordering: true,
        pageLength: 10,
        lengthMenu: [10, 25, 50, 100],
        language: {
            search: "Search report:",
            lengthMenu: "Show _MENU_ rows per page",
            info: "Showing _START_ to _END_ of _TOTAL_ rows",
            infoEmpty: "Showing 0 to 0 of 0 rows",
            infoFiltered: "(filtered from _MAX_ total rows)"
        }
    });
});
</script>

<script>
// Make modal & selects responsive on click
document.addEventListener('DOMContentLoaded', function() {
    // Initialize Select2 inside modal
    $('.js-example-basic-single').select2({
        theme: 'bootstrap-5',
        dropdownParent: $('#filterModal')
    });

    // Re-init on modal show to ensure proper placement
    const filterModal = document.getElementById('filterModal');
    if (filterModal) {
        filterModal.addEventListener('shown.bs.modal', function () {
            $('.js-example-basic-single').select2({
                theme: 'bootstrap-5',
                dropdownParent: $('#filterModal')
            });

            // Default end date to today if empty
            const end = document.getElementById('end_date');
            if (end && !end.value) {
                end.value = new Date().toISOString().split('T')[0];
            }
        });
    }
});
</script>
@endsection
