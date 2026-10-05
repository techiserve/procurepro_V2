@extends('html.default')

@section('content')
<div class="body-content__header">
    <ul><li><a href="#">{{ $bankLabel }} Purchase Orders</a></li></ul>
</div>

<div class="body-content__wrapper requesition-body" data-bank-report-root data-bank-title="{{ $bankLabel }} Purchase Orders" data-bank-filename="{{ $bankSlug }}-purchase-orders">
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center flex-wrap gap-2">
            <strong>{{ $bankLabel }} Purchase Orders</strong>
            <div class="d-flex gap-2 flex-wrap">
                <button type="button" data-bank-export-action="copy" class="btn btn-outline-secondary btn-sm" title="Copy report"><i class="fa fa-copy" aria-hidden="true"></i> Copy</button>
                <button type="button" data-bank-export-action="csv" class="btn btn-outline-secondary btn-sm" title="Download CSV"><i class="fa fa-file-csv" aria-hidden="true"></i> CSV</button>
                <button type="button" data-bank-export-action="excel" class="btn btn-outline-secondary btn-sm" title="Download Excel"><i class="fa fa-file-excel" aria-hidden="true"></i> Excel</button>
                <button type="button" data-bank-export-action="pdf" class="btn btn-outline-secondary btn-sm" title="Download PDF"><i class="fa fa-file-pdf" aria-hidden="true"></i> PDF</button>
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

            @include('reports.partials.bank-report-controls', ['reportType' => 'po'])

            <div class="table-responsive">
                <table class="table table-striped table-bordered bank-report-table" data-bank-report-table style="width:100%">
                    <thead class="table-light">
                        <tr>
                            <th class="bank-checkbox-col" data-bank-export="false"><input type="checkbox" class="form-check-input" data-select-all aria-label="Select all matching purchase orders" title="Select all matching rows"></th>
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
                        @foreach($fpurchaseorder as $order)
                            <tr>
                                <td><input type="checkbox" class="form-check-input bank-row-checkbox" value="{{ $order->id }}" aria-label="Select {{ $order->requisitionNumber }}"></td>
                                <td>{{ $order->requisitionNumber }}</td>
                                <td>{{ optional($order->created_at)->format('Y-m-d') }}</td>
                                <td>{{ $departments[$order->department] ?? '' }}</td>
                                @if($bankSlug === 'albaraka')
                                    <td>{{ $order->bankAccountNumber }}</td>
                                    <td>{{ $order->frequisition?->selectedVendor?->vendor_final ?? $order->vendor }}</td>
                                    <td>{{ $order->vendorbankBranch }}</td>
                                    <td>{{ $order->vendorbankAccountNumber }}</td>
                                    <td>{{ $order->ownref }}</td>
                                    <td>{{ $order->benref }}</td>
                                    <td>No</td><td></td><td>No</td><td></td>
                                    <td>{{ $order->invoiceamount }}</td>
                                    <td>No</td>
                                    <td>{{ $order->created_at }}</td>
                                @else
                                    <td>{{ $order->frequisition?->selectedVendor?->vendor_final ?? $order->vendor }}</td>
                                    <td>{{ $order->vendorbankAccountNumber }}</td>
                                    <td>{{ $order->vendorbankAccountType }}</td>
                                    <td>{{ $order->vendorbankBranch }}</td>
                                    <td>{{ $order->invoiceamount }}</td>
                                    <td>{{ $order->ownref }}</td>
                                    <td>{{ $order->benref }}</td>
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
