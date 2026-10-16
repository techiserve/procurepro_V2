@extends('html.default')

@section('content')
<div class="body-content__header">
    <ul><li><a href="#">{{ $bankLabel }} Purchase Requisitions</a></li></ul>
</div>

<div class="body-content__wrapper requesition-body" data-bank-report-root data-bank-slug="{{ $bankSlug }}" data-bank-title="{{ $bankLabel }} Purchase Requisitions" data-bank-filename="{{ $bankSlug }}-purchase-requisitions">
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center flex-wrap gap-2">
            <strong>{{ $bankLabel }} Purchase Requisitions</strong>
            <div class="d-flex gap-2">
                <button type="button" data-bank-export-action="copy" class="btn btn-outline-secondary btn-sm" title="Copy report">
                    <i class="fa fa-copy" aria-hidden="true"></i> Copy
                </button>
                <button type="button" data-bank-export-action="csv" class="btn btn-outline-secondary btn-sm" title="Download CSV">
                    <i class="fa fa-file-csv"></i> CSV
                </button>
                <button type="button" data-bank-export-action="excel" class="btn btn-outline-secondary btn-sm" title="Download Excel">
                    <i class="fa fa-file-excel"></i> Excel
                </button>
                <button type="button" data-bank-export-action="pdf" class="btn btn-outline-secondary btn-sm" title="Download PDF">
                    <i class="fa fa-file-pdf"></i> PDF
                </button>
            </div>
        </div>

        <div class="card-body">
            <form method="GET" action="{{ url()->current() }}" class="row g-2 align-items-end mb-3">
                <div class="col-md-3">
                    <label for="date_from" class="form-label">From</label>
                    <input id="date_from" name="date_from" type="date" class="form-control" value="{{ $filters['date_from'] ?? '' }}">
                </div>
                <div class="col-md-3">
                    <label for="date_to" class="form-label">To</label>
                    <input id="date_to" name="date_to" type="date" class="form-control" value="{{ $filters['date_to'] ?? '' }}">
                </div>
                <div class="col-md-3">
                    <label for="department" class="form-label">Department</label>
                    <select id="department" name="department" class="form-control">
                        <option value="">All departments</option>
                        @foreach($departments as $departmentId => $departmentName)
                            <option value="{{ $departmentId }}" @selected(($filters['department'] ?? '') == $departmentId)>{{ $departmentName }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-3 d-flex gap-2">
                    <button type="submit" class="btn btn-primary">Filter</button>
                    <a href="{{ url()->current() }}" class="btn btn-outline-secondary">Reset filters</a>
                </div>
            </form>

            @include('reports.partials.bank-report-controls', ['reportType' => 'pr'])

            <div class="table-responsive">
                <table id="prBankReportTable" class="table table-striped table-bordered bank-report-table" data-bank-report-table style="width:100%">
                    <thead class="table-light">
                        <tr>
                            <th class="bank-checkbox-col" data-bank-export="false"><input type="checkbox" class="form-check-input" data-select-all aria-label="Select all matching requisitions" title="Select all matching rows"></th>
                            <th data-bank-export="false">Requisition</th>
                            <th data-bank-export="false">Date</th>
                            <th data-bank-export="false">Department</th>
                            @if($bankSlug === 'albaraka')
                                <th data-bank-export="true">FROM ACCOUNT</th>
                                <th data-bank-export="true">BENEFICIARY NAME</th>
                                <th data-bank-export="true">BENEFICIARY BRANCH CODE</th>
                                <th data-bank-export="true">BENEFICIARY ACCOUNT</th>
                                <th data-bank-export="true">MY REFERENCES</th>
                                <th data-bank-export="true">BENEFICIARY REFERENCES</th>
                                <th data-bank-export="true">NOTIFY RECIPIENT VIA SMS</th>
                                <th data-bank-export="true">RECIPIENT PHONE</th>
                                <th data-bank-export="true">NOTIFY RECIPIENT VIA EMAIL</th>
                                <th data-bank-export="true">RECIPIENT EMAIL</th>
                                <th data-bank-export="true">AMOUNT</th>
                                <th data-bank-export="true">INSTANT PAYMENT</th>
                                <th data-bank-export="true">DATE</th>
                            @else
                                <th data-bank-export="true" data-export-label="RICIPIENT NAME">Recipient Name</th>
                                <th data-bank-export="true" data-export-label="RICIPIENT ACCOUNT">Recipient Account</th>
                                <th data-bank-export="true" data-export-label="RICIPIENT ACCOUNT TYPE">Recipient Account Type</th>
                                <th data-bank-export="true">BRANCH</th>
                                <th data-bank-export="true">AMOUNT</th>
                                <th data-bank-export="true">OWN REFERENCES</th>
                                <th data-bank-export="true" data-export-label="RICIPIENT REFERENCES">Recipient References</th>
                            @endif
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($frequisitions as $requisition)
                            <tr @if($bankSlug === 'fnb') data-fnb-from-account="{{ $requisition->bankAccountNumber }}" @endif>
                                <td><input type="checkbox" class="form-check-input bank-row-checkbox" value="{{ $requisition->id }}" aria-label="Select {{ $requisition->requisitionNumber }}"></td>
                                <td>{{ $requisition->requisitionNumber }}</td>
                                <td>{{ optional($requisition->created_at)->format('Y-m-d') }}</td>
                                <td>{{ $departments[$requisition->department] ?? '' }}</td>
                                @if($bankSlug === 'albaraka')
                                    <td>{{ $requisition->bankAccountNumber }}</td>
                                    <td>{{ $requisition->selectedVendor?->vendor_final ?? $requisition->bankReportVendorName() }}</td>
                                    <td>{{ $requisition->selectedVendor?->branchCode }}</td>
                                    <td>{{ $requisition->selectedVendor?->account_number }}</td>
                                    <td>{{ $requisition->ownref }}</td>
                                    <td>{{ $requisition->benref }}</td>
                                    <td>No</td><td></td><td>No</td><td></td>
                                    <td>{{ $requisition->amount }}</td>
                                    <td>No</td>
                                    <td>{{ $requisition->created_at }}</td>
                                @else
                                    <td>{{ $requisition->selectedVendor?->vendor_final ?? $requisition->bankReportVendorName() }}</td>
                                    <td>{{ $requisition->selectedVendor?->account_number }}</td>
                                    <td>{{ $requisition->selectedVendor?->account_type }}</td>
                                    <td>{{ $requisition->selectedVendor?->branchCode }}</td>
                                    <td>{{ $requisition->amount }}</td>
                                    <td>{{ $requisition->ownref }}</td>
                                    <td>{{ $requisition->benref }}</td>
                                @endif
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

@include('reports.partials.bank-report-assets')
@endsection
