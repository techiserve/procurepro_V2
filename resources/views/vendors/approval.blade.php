@extends('html.default')

@section('content')
<div class="body-content__header">
    <ul>
        <li><a href="#">Vendors Pending Approval</a></li>
    </ul>
</div>

<div class="body-content__wrapper requesition-body">
    <div class="card">
        <div class="card-header">
            <strong>Vendors Pending Approval</strong>
        </div>

        <div class="card-body">
            @if (session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif

            <div class="table-responsive">
                <table class="table table-striped table-bordered table-hover">
                    <thead class="table-light text-center">
                        <tr>
                            <th>Name</th>
                            <th>Type</th>
                            <th>Contact</th>
                            <th>Finance Manager</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($vendors as $vendor)
                            <tr class="text-center">
                                <td>{{ $vendor->name }}</td>
                                <td>{{ $vendor->type }}</td>
                                <td>{{ $vendor->contact_no_1 }}</td>
                                <td>
                                    @php
                                        $manager = $users->firstWhere('id', $vendor->finance_manager);
                                    @endphp
                                    {{ $manager?->name ?? 'N/A' }}
                                </td>
                                <td>
                                    <span class="badge bg-warning text-dark">Pending</span>
                                </td>
                                <td>
                                    <a href="{{ route('vendors.approval.view', $vendor->id) }}" class="btn btn-sm btn-primary">
                                        View More
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center">No vendors pending approval.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
