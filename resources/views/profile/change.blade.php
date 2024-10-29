@extends('stack.layouts.admin')

@section('content')
<div class="content-header row">
                <div class="content-header-left col-md-6 col-12 mb-2">
                 
                    <div class="row breadcrumbs-top">
                        <div class="breadcrumb-wrapper col-12">
                  
                        </div>
                    </div>
                </div>


                <div class="content-header-right col-md-6 col-12 mb-md-0 mb-2">
                    <div class="btn-group float-md-right" role="group" aria-label="Button group with nested dropdown">
                        <div class="btn-group" role="group">
                       
                        </div>
                    </div>
                </div>
            </div>
            <div class="content-body">
                <!-- horizontal grid start -->
                <section class="horizontal-grid" id="horizontal-grid">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="card">
                            
                                <div class="card-content collapse show">
                                    <div class="card-body">
                                    <form method="POST" action="{{ route('profile.update') }}" id="passwordForm" novalidate>
                                    @csrf
                                            @method('put')

                                    <div class="card">
                                    <div class="card-header">
                                                <strong>Edit Profile.</strong>
                                            
                                            </div>

                                        <div class="card-body">
                                        <div class="row">
                                            <div class="col-sm-6">
                                            <div class="form-group">
                                                <label for="grower_name">Name</label>
                                                <input class="form-control" id="grower_name" name="name" type="text" value="{{$user->name}}" required  >
                                            </div>
                                            </div>

                                            <div class="col-sm-6">
                                            <div class="form-group">
                                                <label for="grower_rep">Email</label>
                                                <input class="form-control" id="grower_rep" name="email" type="email" value="{{$user->email}}" required >
                                            </div>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-sm-6">
                                            <div class="form-group">
                                                <label for="grower_address">Current Password</label>
                                                <input class="form-control" id="current_password"  name="current_password" type="password" placeholder="********">
                                            </div>
                                            </div>

                                            <div class="col-sm-6">
                                            <div class="form-group">
                                                <label for="province">New Password</label>
                                                <input class="form-control" id="new_password" name="password" type="password"  placeholder="********">
                                            </div>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-sm-6">
                                            <div class="form-group">
                                                <label for="grower_address">Confirm Password</label>
                                                <input class="form-control" id="confirm_password" name="password_confirmation" type="password"  placeholder="********">
                                                <div class="invalid-feedback">Passwords do not match.</div>
                                            </div>
                                            </div> 
                                        </div>

                                        <hr style="border-color: black;">
                                        <br>
                                        </div>

                                        <div class="card-footer">
                                        <div class="form-group pull-right">
                                            <input type="submit" class="btn btn-success" value="Save">
                                            <input type="reset" class="btn btn-danger" value="Cancel">
                                        </div>
                                        </div>
                                    </div>
                                    </form>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
                <!-- horizontal grid end -->

</div>
</div>
@endsection
<script>
document.addEventListener("DOMContentLoaded", function() {
    document.getElementById("passwordForm").addEventListener("submit", function (event) {       
        const newPassword = document.getElementById("new_password").value;
        const confirmPassword = document.getElementById("confirm_password").value;

        if (newPassword !== confirmPassword) {
            event.preventDefault(); // Prevent form submission
            document.getElementById("confirm_password").classList.add("is-invalid");
        } else {
            document.getElementById("confirm_password").classList.remove("is-invalid");
        }
    });
});
</script>
