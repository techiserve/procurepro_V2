@extends('html.default')

@section('content')
<div class="body-content__header">
    <ul>
        <li><a href="#">Create Role</a></li>
    </ul>
    <a href="#" class="btn-requisition-list"><i class="icon-20"></i> Roles List</a>
</div>

<div class="body-content__wrapper">
    <form method="post" action="/userrole/store" name="add_name" id="roleForm">
        @csrf

        <div class="row">
            <div class="col-md-6">
                <div class="form-col">
                    <label for="grower_nam">Role Name *</label>
                    <input class="form-control" id="grower_nam" name="roleName" type="text" placeholder="Enter Role Name" required>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-col">
                    <label for="description">Description</label>
                    <textarea class="form-control" id="description" name="description" rows="3" placeholder="Enter description"></textarea>
                </div>
            </div>
        </div>

        <hr>

        {{-- Tabs --}}
        <div class="tab-container">
            <ul class="nav nav-tabs" id="role-tabs" role="tablist">
                <li class="nav-item"><a class="nav-link active" data-bs-toggle="tab" href="#users" role="tab">Users</a></li>
                <li class="nav-item"><a class="nav-link" data-bs-toggle="tab" href="#vendor" role="tab">Vendor Management</a></li>
                <li class="nav-item"><a class="nav-link" data-bs-toggle="tab" href="#config" role="tab">Configuration</a></li>
                <li class="nav-item"><a class="nav-link" data-bs-toggle="tab" href="#reports" role="tab">Reports</a></li>
                <li class="nav-item"><a class="nav-link" data-bs-toggle="tab" href="#procurement" role="tab">Procurement</a></li>
            </ul>

            <div class="tab-content mt-3" id="role-tab-content">
                {{-- Users --}}
                <div class="tab-pane fade show active" id="users" role="tabpanel">
                    <ul class="list-group">
                        <li class="list-group-item d-flex justify-content-between align-items-center bg-light">
                            Add New User
                            <input class="form-check-input" type="checkbox" name="addnewuser" value="Add New User">
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            Manage Users
                            <input class="form-check-input" type="checkbox" name="manageusers" value="Manage Users">
                        </li>
                    </ul>
                </div>

                {{-- Vendor Management --}}
                <div class="tab-pane fade" id="vendor" role="tabpanel">
                    <ul class="list-group">
                        <li class="list-group-item d-flex justify-content-between align-items-center bg-light">
                            Request a Vendor
                            <input class="form-check-input" type="checkbox" name="requestnewvendor" value="Request a Vendor">
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            Pending Requests
                            <input class="form-check-input" type="checkbox" name="pendingrequests" value="Pending Requests">
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center bg-light">
                            All Vendors
                            <input class="form-check-input" type="checkbox" name="managevendors" value="All Vendors">
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            My Requests
                            <input class="form-check-input" type="checkbox" name="myrequests" value="My Requests">
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center bg-light">
                            Vendor Type
                            <input class="form-check-input" type="checkbox" name="vendorrequestapproval" value="Vendor Type">
                        </li>
                    </ul>
                </div>

                {{-- Configuration --}}
                <div class="tab-pane fade" id="config" role="tabpanel">
                    <ul class="list-group">
                        <li class="list-group-item d-flex justify-content-between align-items-center bg-light">
                            Master Pages
                            <input class="form-check-input" type="checkbox" name="masterpages" value="Master Pages">
                        </li>
                    </ul>
                </div>

                {{-- Reports --}}
                <div class="tab-pane fade" id="reports" role="tabpanel">
                    <ul class="list-group">
                        <li class="list-group-item d-flex justify-content-between align-items-center bg-light">
                            Reports
                            <input class="form-check-input" type="checkbox" name="reports" value="Reports">
                        </li>
                    </ul>
                </div>

                {{-- Procurement --}}
                <div class="tab-pane fade" id="procurement" role="tabpanel">
                    <ul class="list-group">
                        <li class="list-group-item d-flex justify-content-between align-items-center bg-light">
                            Create Purchase Requisition
                            <input class="form-check-input" type="checkbox" name="createpurchaserequistion" value="Create Purchase Requisition">
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            View Requisitions
                            <input class="form-check-input" type="checkbox" name="viewrequisitions" value="View Requisitions">
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center bg-light">
                            View Purchase Orders
                            <input class="form-check-input" type="checkbox" name="viewpurchaseorders" value="View Purchase Orders">
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            Manage Purchase Orders
                            <input class="form-check-input" type="checkbox" name="managepurchaseorders" value="Manage Purchase Orders">
                        </li>
                    </ul>
                </div>
            </div>
        </div>

        {{-- Select / Clear All --}}
        <div class="mt-3">
            <button type="button" class="btn btn-outline-primary btn-sm me-2" onclick="selectAllCheckboxes()">Select All</button>
            <button type="button" class="btn btn-outline-secondary btn-sm" onclick="clearAllCheckboxes()">Clear All</button>
        </div>

        {{-- Buttons --}}
        <div class="button-group mt-4">
            <button type="submit" class="btn btn-primary">Save</button>
            <button type="reset" class="btn btn-secondary">Cancel</button>
        </div>
    </form>
</div>

{{-- Roles List --}}
<div class="body-content__wrapper mt-5">
    <h4>Roles List</h4>
    <table class="table table-bordered table-striped">
        <thead>
            <tr>
                <th>#</th>
                <th>Name</th>
                <th>Description</th>
                <th class="text-center">Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach($users as $user)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $user->name }}</td>
                <td>{{ $user->description }}</td>
                <td class="text-center">
                    <a href="/manageRole/{{ $user->id }}/editrole" class="btn btn-info btn-sm text-white">
                        <i class="fa fa-pencil"></i> Edit
                    </a>
                    <a href="#" class="btn btn-danger btn-sm" onclick="
                        event.preventDefault();
                        Swal.fire({
                            title: 'Delete Role?',
                            text: 'You won\'t be able to undo this!',
                            icon: 'warning',
                            showCancelButton: true,
                            confirmButtonText: 'Continue',
                            cancelButtonText: 'Cancel'
                        }).then((result) => {
                            if (result.isConfirmed) {
                                window.location.href = '/manageRole/{{ $user->id }}/delete';
                            }
                        });
                    ">
                        <i class="fa fa-trash"></i> Delete
                    </a>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>

{{-- SweetAlert2 --}}
<link href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const form = document.querySelector('#roleForm');

    function hasCheckedCheckbox() {
        return Array.from(form.querySelectorAll('input[type="checkbox"]')).some(c => c.checked);
    }

    function selectAllCheckboxes() {
        form.querySelectorAll('input[type="checkbox"]').forEach(c => c.checked = true);
    }

    function clearAllCheckboxes() {
        form.querySelectorAll('input[type="checkbox"]').forEach(c => c.checked = false);
    }

    window.selectAllCheckboxes = selectAllCheckboxes;
    window.clearAllCheckboxes = clearAllCheckboxes;

    form.addEventListener('submit', function(e) {
        const roleName = document.getElementById('grower_nam').value.trim();
        if (!roleName) {
            e.preventDefault();
            Swal.fire({ title: 'Validation Error', text: 'Please enter a role name.', icon: 'error' });
            return;
        }
        if (!hasCheckedCheckbox()) {
            e.preventDefault();
            Swal.fire({ title: 'Validation Error', text: 'Please select at least one permission.', icon: 'error' });
            return;
        }
    });
});
</script>
@endsection
