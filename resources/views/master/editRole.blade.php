@extends('html.default')

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" crossorigin="anonymous">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>

@section('content')
<div class="container-fluid">
    <div class="animated fadeIn">
        <div class="row">
            <div class="col-sm-12">
                <form method="post" action="/role/update/{{ $role->id }}">
                    @csrf
                    @method('put')

                    <div class="card">
                        <div class="card-header">
                            <strong>Executive Registration</strong>
                            <a href="/master/manageRole" class="btn btn-primary btn-sm float-end">
                                <i class="fa fa-align-justify text-white"></i> Users Roles
                            </a>
                        </div>

                        <div class="card-body">
                            <div class="row mb-3">
                                <div class="col-sm-6">
                                    <label for="grower_nam" class="form-label">Role Name</label>
                                    <input type="text" id="grower_nam" name="roleName" value="{{ $role->name }}" class="form-control" placeholder="Enter Role Name">
                                </div>

                                <div class="col-sm-6">
                                    <label for="description" class="form-label">Description</label>
                                    <textarea id="description" name="description" class="form-control" rows="3">{{ $role->description }}</textarea>
                                </div>
                            </div>

                            <hr class="border-dark">

                            <nav>
                                <div class="nav nav-tabs" id="nav-tab" role="tablist">
                                    <a class="nav-link active" data-bs-toggle="tab" href="#nav-1" role="tab">Users</a>
                                    <a class="nav-link" data-bs-toggle="tab" href="#nav-2" role="tab">Vendor Management</a>
                                  
                                    <a class="nav-link" data-bs-toggle="tab" href="#nav-4" role="tab">Configuration</a>
                                    <a class="nav-link" data-bs-toggle="tab" href="#nav-5" role="tab">Reports</a>
                                    <a class="nav-link" data-bs-toggle="tab" href="#nav-6" role="tab">Procurement</a>
                                </div>
                            </nav>

                            <div class="tab-content mt-3" id="nav-tabContent">
                                {{-- Users --}}
                                <div class="tab-pane fade show active" id="nav-1" role="tabpanel">
                                    <ul class="list-group">
                                        @php $perm = 'Add New User'; @endphp
                                        <li class="list-group-item d-flex justify-content-between align-items-center bg-light">
                                            Add New User
                                            <input class="form-check-input" type="checkbox" name="addnewuser" value="Add New User" @if(in_array($perm, $permissions)) checked @endif>
                                        </li>

                                        @php $perm = 'Manage Users'; @endphp
                                        <li class="list-group-item d-flex justify-content-between align-items-center">
                                            Manage Users
                                            <input class="form-check-input" type="checkbox" name="manageusers" value="Manage Users" @if(in_array($perm, $permissions)) checked @endif>
                                        </li>
                                    </ul>
                                </div>

                                {{-- Vendor Management --}}
                                <div class="tab-pane fade" id="nav-2" role="tabpanel">
                                    <ul class="list-group">
                                        @php $perm = 'Request a Vendor'; @endphp
                                        <li class="list-group-item d-flex justify-content-between align-items-center bg-light">
                                            Request New Vendor
                                            <input class="form-check-input" type="checkbox" name="requestnewvendor" value="Request a Vendor" @if(in_array($perm, $permissions)) checked @endif>
                                        </li>

                                        @php $perm = 'Pending Requests'; @endphp
                                        <li class="list-group-item d-flex justify-content-between align-items-center">
                                            Pending Requests
                                            <input class="form-check-input" type="checkbox" name="pendingrequests" value="Pending Requests" @if(in_array($perm, $permissions)) checked @endif>
                                        </li>

                                        @php $perm = 'All Vendors'; @endphp
                                        <li class="list-group-item d-flex justify-content-between align-items-center bg-light">
                                            Manage Vendors
                                            <input class="form-check-input" type="checkbox" name="managevendors" value="All Vendors" @if(in_array($perm, $permissions)) checked @endif>
                                        </li>

                                        @php $perm = 'My Requests'; @endphp
                                        <li class="list-group-item d-flex justify-content-between align-items-center">
                                            My Requests
                                            <input class="form-check-input" type="checkbox" name="myrequests" value="My Requests" @if(in_array($perm, $permissions)) checked @endif>
                                        </li>

                                        @php $perm = 'Vendor Type'; @endphp
                                        <li class="list-group-item d-flex justify-content-between align-items-center bg-light">
                                            Vendor Type
                                            <input class="form-check-input" type="checkbox" name="vendorrequestapproval" value="Vendor Type" @if(in_array($perm, $permissions)) checked @endif>
                                        </li>
                                    </ul>
                                </div>

                      

                                {{-- Configuration --}}
                                <div class="tab-pane fade" id="nav-4" role="tabpanel">
                                    <ul class="list-group">
                                        @php $perm = 'Master Pages'; @endphp
                                        <li class="list-group-item d-flex justify-content-between align-items-center bg-light">
                                            Master Pages
                                            <input class="form-check-input" type="checkbox" name="masterpages" value="Master Pages" @if(in_array($perm, $permissions)) checked @endif>
                                        </li>
                                    </ul>
                                </div>

                                {{-- Reports --}}
                                <div class="tab-pane fade" id="nav-5" role="tabpanel">
                                    <ul class="list-group">
                                        @php $perm = 'Reports'; @endphp
                                        <li class="list-group-item d-flex justify-content-between align-items-center bg-light">
                                            Reports
                                            <input class="form-check-input" type="checkbox" name="reports" value="Reports" @if(in_array($perm, $permissions)) checked @endif>
                                        </li>
                                    </ul>
                                </div>

                                {{-- Procurement --}}
                                <div class="tab-pane fade" id="nav-6" role="tabpanel">
                                    <ul class="list-group">
                                        @foreach ([
                                            'Create Purchase Requisition',
                                            'View Requisitions',
                                            'View Purchase Orders',
                                            'Manage Purchase Orders'
                                        ] as $i => $label)
                                            @php $perm = $label; @endphp
                                            <li class="list-group-item d-flex justify-content-between align-items-center {{ $i % 2 == 0 ? 'bg-light' : '' }}">
                                                {{ $label }}
                                                <input class="form-check-input" type="checkbox" name="{{ str_replace(' ', '', strtolower($label)) }}" value="{{ $label }}" @if(in_array($perm, $permissions)) checked @endif>
                                            </li>
                                        @endforeach
                                    </ul>
                                </div>
                            </div>
                        </div>

                        <div class="card-footer text-end">
                            <input type="submit" class="btn btn-success" value="Edit">
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
