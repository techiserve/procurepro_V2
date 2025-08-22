@extends('html.default')

@section('content')
<div class="body-content__header">
    <ul>
        <li><a href="#">Create Users</a></li>
    </ul>
</div>

<div class="body-content__wrapper">
    <div class="row">
        <div class="col-12">
            <form method="POST" action="/users/store">
                @csrf
                <div class="card">
                    <div class="card-header">
                        <strong>Create Users</strong>
                    </div>

                    <div class="card-body">
                        <!-- Row 1 -->
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-col">
                                    <label for="name">Name</label>
                                    <input class="form-control" id="name" name="name" type="text" placeholder="Enter Full Name..." required>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-col">
                                    <label for="phonenumber">Phone Number</label>
                                    <input class="form-control" id="phonenumber" name="phonenumber" type="text" placeholder="Enter Phone Number">
                                </div>
                            </div>
                        </div>

                        <!-- Row 2 -->
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-col">
                                    <label for="role">Role</label>
                                    <select class="js-example-basic-single form-control" id="role" name="role" required>
                                        <option value="">Select Role</option>
                                        @foreach($roles as $role)
                                            <option value="{{ $role->id }}">{{ $role->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-col">
                                    <label for="department">Department</label>
                                    <select class="js-example-basic-single form-control" id="department" name="department" required>
                                        <option value="">Select Department</option>
                                        @foreach($departments as $department)
                                            <option value="{{ $department->id }}">{{ $department->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>

                        <!-- Row 3 -->
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-col">
                                    <label for="position">Position</label>
                                    <input class="form-control" id="position" name="position" type="text" placeholder="Enter Position">
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-col">
                                    <label for="email">Email Address</label>
                                    <input class="form-control" id="email" name="email" type="email" placeholder="Enter Email Address" required>
                                </div>
                            </div>
                        </div>

                        <!-- Row 4 -->
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-col">
                                    <label for="password">Password</label>
                                    <input class="form-control" id="password" name="password" type="password" placeholder="********" required>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-col">
                                    <label for="confirmpassword">Confirm Password</label>
                                    <input class="form-control" id="confirmpassword" name="confirmpassword" type="password" placeholder="********" required>
                                </div>
                            </div>
                        </div>

                        <!-- Row 5 -->
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-col">
                                    <label for="address">Address</label>
                                    <textarea class="form-control" id="address" name="address" rows="3" placeholder="Enter Address..."></textarea>
                                </div>
                            </div>

                            <div class="col-md-2 d-flex align-items-center">
                                <div class="form-check form-switch">
                                    <input class="form-check-input" type="checkbox" role="switch" name="IsActive" value="1" id="flexSwitchCheckDefault">
                                    <label class="form-check-label" for="flexSwitchCheckDefault">Active</label>
                                </div>
                            </div>
                        </div>

                        <hr style="border-color: black;">
                    </div>

                    <div class="card-footer">
                        <div class="d-flex justify-content-end">
                            <input type="submit" class="btn btn-success" value="Save" style="padding:10px 20px; font-size:16px; min-width:100px;">
                            <input type="reset" class="btn btn-danger" value="Cancel" style="padding:10px 20px; font-size:16px; min-width:100px;">
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
