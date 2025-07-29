@extends('stack.layouts.admin')

@section('content')
<div class="container-fluid">
  <div class="animated fadeIn">
    <div class="row">
      <div class="col-sm-12">
        <div class="card">
          <div class="card-header">
            <strong>Vendors Pending Approval</strong>
          </div>

          <div class="card-body">
            @if (session('success'))
              <div class="alert alert-success">{{ session('success') }}</div>
            @endif

            <div class="table-responsive">
              <table class="table table-bordered table-striped">
                <thead>
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
                    <tr>
                      <td>{{ $vendor->name }}</td>
                      <td>{{ $vendor->type }}</td>
                      <td>{{ $vendor->contact_no_1 }}</td>

                      @foreach ($users as $user)   
                      @if ($user->id == $vendor->finance_manager )
                     <td>{{ $user->name }}</td>
                      @endif                         
                       @endforeach
                      <td>
                        <span class="badge badge-warning">Pending</span>
                      </td>
                      <td>
                        <a href="{{ route('vendors.approval.view', $vendor->id) }}" class="btn btn-primary btn-sm">View More</a>
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
    </div>
  </div>
</div>
@endsection