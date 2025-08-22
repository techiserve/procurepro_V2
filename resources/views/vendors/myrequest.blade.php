@extends('html.default')
<link href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.all.min.js"></script>
<link rel="stylesheet" href="https://unpkg.com/bootstrap@5.3.3/dist/css/bootstrap.min.css">
<link rel="stylesheet" href="https://unpkg.com/bs-brain@2.0.4/tutorials/timelines/timeline-7/assets/css/timeline-7.css">
@section('content')
<div class="body-content__header">
    <ul>
        <li><a href="#">My Requests List</a></li>
    </ul>
</div>

<div class="body-content__wrapper requesition-body">
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <strong>Vendors List</strong>
            {{-- <a href="/procurement/createVendor" class="btn btn-success btn-md">
                <i class="fa fa-plus"></i> Add Vendor
            </a> --}}
        </div>

        <div class="card-body">
            @if(session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif

            <div class="table-responsive">
                <table class="table table-striped table-bordered" id="vendorsTable">
                    <thead class="table-light text-center">
                        <tr>
                            <th>Name</th>
                            <th>Type</th>
                            <th>Contact</th>
                            <th>Finance Manager</th>
                            <th>Bank</th>
                            <th>Account #</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($vendors as $vendor)
                            @php
                                $statusLabels = [
                                    1 => ['text' => 'Incomplete', 'class' => 'btn btn-outline-secondary'],
                                    2 => ['text' => 'Pending', 'class' => 'btn btn-outline-warning'],
                                    3 => ['text' => 'Approved', 'class' => 'btn btn-outline-success'],
                                    4 => ['text' => 'Returned', 'class' => 'btn btn-outline-info'],
                                    5 => ['text' => 'Rejected', 'class' => 'btn btn-outline-danger'],
                                ];
                                $currentStatus = $statusLabels[$vendor->status] ?? ['text' => 'Unknown', 'class' => 'btn btn-outline-dark'];
                            @endphp
                            <tr class="text-center">
                                <td>{{ $vendor->name }}</td>
                                <td>{{ $vendor->type }}</td>
                                <td>{{ $vendor->contact_no_1 }}</td>
                                <td>
                                    @foreach($users as $user)
                                        @if($user->id == $vendor->finance_manager)
                                            {{ $user->name }}
                                            @break
                                        @endif
                                    @endforeach
                                </td>
                                <td>{{ $vendor->bank_name }}</td>
                                <td>{{ $vendor->account_number }}</td>
                                <td>
                                    <span class=" {{ $currentStatus['class'] }}">
                                        {{ $currentStatus['text'] }}
                                    </span>
                                </td>
                                <td class="d-flex justify-content-center flex-wrap gap-2">
                                    @if($vendor->status != 5)
                                        <a href="/vendors/edit/{{$vendor->id}}" class="btn btn-info btn-sm">
                                            <i class="fa fa-pencil"></i> Edit
                                        </a>
                                        <button type="button" class="btn btn-danger btn-sm" onclick="
                                            Swal.fire({
                                                title: 'Delete Vendor?',
                                                text: 'You won\'t be able to undo this!',
                                                icon: 'warning',
                                                showCancelButton: true,
                                                confirmButtonText: 'Delete',
                                                cancelButtonText: 'Cancel'
                                            }).then((result) => {
                                                if(result.isConfirmed){
                                                    window.location.href='/vendors/delete/{{$vendor->id}}';
                                                }
                                            })">
                                            <i class="fa fa-trash"></i> Delete
                                        </button>
                                    @endif
                                    <button type="button" class="btn btn-success btn-sm" data-bs-toggle="modal" data-bs-target="#historyModal{{ $vendor->id }}">
                                        <i class="fa fa-history"></i> Logs
                                    </button>

                                    <!-- Modal -->
                                    <div class="modal fade" id="historyModal{{ $vendor->id }}" tabindex="-1" aria-labelledby="historyModalLabel{{ $vendor->id }}" aria-hidden="true">
                                        <div class="modal-dialog modal-lg modal-dialog-scrollable">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="historyModalLabel{{ $vendor->id }}">Vendor Request Logs</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <section class="bsb-timeline-7 py-3">
                                                        <div class="container">
                                                            <div class="row justify-content-center">
                                                                <div class="col-12">
                                                                    @if($vendor->history->isEmpty())
                                                                        <p>No history found for this vendor.</p>
                                                                    @else
                                                                        <ul class="timeline">
                                                                            @foreach($vendor->history as $history)
                                                                                @php $date = \Carbon\Carbon::parse($history->created_at); @endphp
                                                                                <li class="timeline-item">
                                                                                    <div class="timeline-body">
                                                                                        <div class="timeline-meta">
                                                                                            <div class="d-inline-flex flex-column px-2 py-1 text-success-emphasis bg-success-subtle border border-success-subtle rounded-2 text-md-end">
                                                                                                <span class="fw-bold">{{ $date->format('d F Y') }}</span>
                                                                                                <span>{{ $date->format('g:ia') }}</span>
                                                                                            </div>
                                                                                        </div>
                                                                                        <div class="timeline-content timeline-indicator">
                                                                                            <div class="card border-0 shadow">
                                                                                                <div class="card-body p-xl-4 position-relative">
                                                                                                    <h6 class="card-subtitle text-secondary mb-3 position-absolute top-0 end-0">{{ $loop->iteration }}</h6>
                                                                                                    <h2 class="card-title mb-2">{{ $history->doneby }}</h2>
                                                                                                    <p class="card-text m-0">{{ $history->reason }}</p>
                                                                                                </div>
                                                                                            </div>
                                                                                        </div>
                                                                                    </div>
                                                                                </li>
                                                                            @endforeach
                                                                        </ul>
                                                                    @endif
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </section>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="text-center">No vendors found.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener("DOMContentLoaded", function() {
    const table = new DataTable('#vendorsTable', {
        responsive: true,
        paging: true,
        searching: true,
        ordering: true,
        pageLength: 10,
        lengthMenu: [10, 25, 50, 100],
        language: {
            search: "Search vendors:",
            lengthMenu: "Show _MENU_ vendors per page",
            info: "Showing _START_ to _END_ of _TOTAL_ vendors",
            infoEmpty: "Showing 0 to 0 of 0 vendors",
            infoFiltered: "(filtered from _MAX_ total vendors)"
        }
    });
});
</script>
@endsection
