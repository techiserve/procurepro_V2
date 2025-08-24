@extends('html.default')

@section('styles')
<link rel="stylesheet" href="https://unpkg.com/bootstrap@5.3.3/dist/css/bootstrap.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
@endsection

@section('content')
<div class="body-content__header">
    <ul>
        <li><a href="#">Custom Reports</a></li>
    </ul>
</div>

<div class="body-content__wrapper requesition-body">
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <strong>Custom Reports</strong>
            <div class="d-flex align-items-center gap-2">
                {{-- <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#filterModal">
                    <i class="fa fa-filter"></i> Filter
                </button> --}}
            </div>
        </div>

        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-striped table-bordered" id="customReportsTable">
                    <thead class="table-light">
                        <tr class="text-center">
                            <th>Name</th>
                            <th>Description</th>
                            <th style="width:220px;">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($reports as $report)
                            <tr class="align-middle">
                                <td>{{ $report->name }}</td>
                                <td>{{ $report->description }}</td>
                                <td class="text-center">
                                    <a href="{{ route('reports.show', $report->id) }}" class="btn btn-info btn-sm">
                                        View Report
                                    </a>
                                    <form action="{{ route('reports.destroy', $report->id) }}"
                                          method="POST"
                                          class="d-inline-block"
                                          onsubmit="return confirm('Are you sure you want to delete this report?');">
                                        @csrf
                                        {{-- Intentionally left as-is per original code --}}
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                        @if($reports->isEmpty())
                            <tr>
                                <td colspan="3" class="text-center">No reports found.</td>
                            </tr>
                        @endif
                    </tbody>
                </table>
            </div>

            {{-- Optional: actions/footer area --}}
            {{-- <div class="mt-3 text-end">
                <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#filterModal">
                    <i class="fa fa-filter"></i> Filter
                </button>
            </div> --}}
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script src="https://unpkg.com/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

<script>
// DataTable init to mirror the reference UX
document.addEventListener("DOMContentLoaded", function () {
    const table = new DataTable('#customReportsTable', {
        responsive: true,
        paging: true,
        searching: true,
        ordering: true,
        pageLength: 10,
        lengthMenu: [10, 25, 50, 100],
        language: {
            search: "Search reports:",
            lengthMenu: "Show _MENU_ reports per page",
            info: "Showing _START_ to _END_ of _TOTAL_ reports",
            infoEmpty: "Showing 0 to 0 of 0 reports",
            infoFiltered: "(filtered from _MAX_ total reports)"
        }
    });
});
</script>
@endsection
