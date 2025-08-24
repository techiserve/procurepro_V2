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
        <li><a href="#">Requisition Summary</a></li>
    </ul>
</div>

<div class="body-content__wrapper requesition-body">
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <strong>Requisition Summary</strong>
            <div class="d-flex align-items-center gap-2">
                {{-- If you want to enable inline filter trigger, uncomment below --}}
                {{-- <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#filterModal">
                    <i class="fa fa-filter"></i> Filter
                </button> --}}
            </div>
        </div>

        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-striped table-bordered" id="requisitionsTable">
                    <thead class="table-light text-center">
                        <tr>
                            <th class="text-center">ID</th>
                            <th class="text-center">Vendor</th>
                            <th class="text-center">Services</th>
                            <th class="text-center">Payment Method</th>
                            <th class="text-center">Department</th>
                            <th class="text-center">Expenses</th>
                            <th class="text-center">Project Code</th>
                            <th class="text-center">(ZAR) Amount</th>
                            <th class="text-center">Status</th>
                            <th class="text-center">Date</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($requisitions as $grower)
                            <tr class="text-center">
                                <td>{{ $grower->id }}</td>
                                <td>{{ $grower->vendor }}</td>
                                <td>{{ $grower->services }}</td>
                                <td>{{ $grower->paymentmethod }}</td>
                                <td>
                                    @foreach($departments as $department)
                                        @if($grower->department == $department->id)
                                            {{ $department->name }}
                                        @endif
                                    @endforeach
                                </td>
                                <td>{{ $grower->expenses }}</td>
                                <td>{{ $grower->projectcode }}</td>
                                <td>{{ number_format($grower->amount, 2) }}</td>
                                <td>
                                    @if($grower->status == 0)
                                        <button type="button" class="btn btn-outline-primary">
                                            <span class="fa fa-spinner"></span> Pending
                                        </button>
                                    @elseif($grower->status == 1)
                                        <button type="button" class="btn btn-outline-primary">
                                            <span class="fa fa-spinner"></span> Pending
                                        </button>
                                    @elseif($grower->status == 2)
                                        <button type="button" class="btn btn-outline-success">
                                            <span class="fa fa-check-circle"></span> Approved
                                        </button>
                                    @elseif($grower->status == 3)
                                        <button type="button" class="btn btn-outline-danger">
                                            <span class="fa fa-times-circle"></span> Rejected
                                        </button>
                                    @elseif($grower->status == 4)
                                        <button type="button" class="btn btn-outline-info">
                                            <span class="fa fa-arrow-left"></span> Returned
                                        </button>
                                    @else
                                        <button type="button" class="btn btn-outline-primary">
                                            <span class="fa fa-spinner"></span> Processing
                                        </button>
                                    @endif
                                </td>
                                <td>{{ \Carbon\Carbon::parse($grower->created_at)->format('d M Y') }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            {{-- Optional: standalone filter button to match header style --}}
            <div class="mt-3 text-end">
                {{-- <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#filterModal">
                    <i class="fa fa-filter"></i> Filter
                </button> --}}
            </div>
        </div>
    </div>
</div>

{{-- Filter Modal (kept intact; just consistent Bootstrap classes) --}}
<div class="modal fade" id="filterModal" tabindex="-1" aria-labelledby="filterModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="filterModalLabel">Filter Requisition Summary</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <form method="post" action="{{ route('requisition.filtered') }}" enctype="multipart/form-data">
                {{ csrf_field() }}

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
                            <option value="0">Draft</option>
                            <option value="4">Returned</option>
                        </select>
                    </div>

                    <div class="form-group mb-3">
                        <label for="vendor" class="form-label">Vendor</label>
                        <select name="vendor" id="vendor" class="form-select js-example-basic-single" style="width:100%;">
                            <option value="">--Select Vendor--</option>
                            @foreach($vendors as $vendor)
                                <option value="{{ $vendor->SupplierName }}">{{ $vendor->SupplierName }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group mb-3">
                        <label for="department" class="form-label">Department</label>
                        <select name="department" id="department" class="form-select js-example-basic-single" style="width:100%;">
                            <option value="">--Select Department--</option>
                            @foreach($departments as $department)
                                <option value="{{ $department->id }}">{{ $department->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group mb-3">
                        <label for="amount_range" class="form-label">Amount Range</label>
                        <div class="row g-2">
                            <div class="col-6">
                                <input type="number" class="form-control" id="min_amount" name="min_amount" placeholder="Min Amount" step="0.01">
                            </div>
                            <div class="col-6">
                                <input type="number" class="form-control" id="max_amount" name="max_amount" placeholder="Max Amount" step="0.01">
                            </div>
                        </div>
                    </div>

                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-warning me-2" id="clearFilters">Clear Filters</button>
                    <button type="submit" class="btn btn-primary">Filter Summary</button>
                </div>
            </form>
        </div>
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
// DataTable init (mirrors the Vendors List page approach)
document.addEventListener("DOMContentLoaded", function () {
    const table = new DataTable('#requisitionsTable', {
        responsive: true,
        paging: true,
        searching: true,
        ordering: true,
        pageLength: 10,
        lengthMenu: [10, 25, 50, 100],
        language: {
            search: "Search requisitions:",
            lengthMenu: "Show _MENU_ requisitions per page",
            info: "Showing _START_ to _END_ of _TOTAL_ requisitions",
            infoEmpty: "Showing 0 to 0 of 0 requisitions",
            infoFiltered: "(filtered from _MAX_ total requisitions)"
        }
    });
});
</script>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Initialize Select2 for modal dropdowns
    $('.js-example-basic-single').select2({
        theme: 'bootstrap-5',
        dropdownParent: $('#filterModal')
    });

    // Clear filters
    const clearBtn = document.getElementById('clearFilters');
    if (clearBtn) {
        clearBtn.addEventListener('click', function() {
            document.getElementById('start_date').value = '';
            document.getElementById('end_date').value = '';
            $('#status').val('').trigger('change');
            $('#vendor').val('').trigger('change');
            $('#department').val('').trigger('change');
            document.getElementById('min_amount').value = '';
            document.getElementById('max_amount').value = '';
        });
    }

    // Basic form validation for ranges
    const filterForm = document.querySelector('#filterModal form');
    if (filterForm) {
        filterForm.addEventListener('submit', function(e) {
            const startDate = document.getElementById('start_date').value;
            const endDate = document.getElementById('end_date').value;

            if (startDate && endDate && new Date(startDate) > new Date(endDate)) {
                e.preventDefault();
                alert('Start date cannot be later than end date.');
                return false;
            }

            const minAmount = parseFloat(document.getElementById('min_amount').value);
            const maxAmount = parseFloat(document.getElementById('max_amount').value);

            if (!isNaN(minAmount) && !isNaN(maxAmount) && minAmount > maxAmount) {
                e.preventDefault();
                alert('Minimum amount cannot be greater than maximum amount.');
                return false;
            }
        });
    }

    // Modal events + default end date set to today if empty
    const filterModal = document.getElementById('filterModal');
    if (filterModal) {
        filterModal.addEventListener('shown.bs.modal', function() {
            $('.js-example-basic-single').select2({
                theme: 'bootstrap-5',
                dropdownParent: $('#filterModal')
            });

            const end = document.getElementById('end_date');
            if (end && !end.value) {
                end.value = new Date().toISOString().split('T')[0];
            }
        });
    }
});
</script>
@endsection
