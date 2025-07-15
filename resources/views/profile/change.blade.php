@extends('stack.layouts.admin')
<style>
    .is-invalid {
    border-color: #dc3545;
}
</style>
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
                                                <input class="form-control" id="grower_rep" name="email" type="email" value="{{$user->email}}" required>
                                                <div id="emailError" class="text-danger" style="display: none; font-size: 14px;"></div>
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
    const form = document.getElementById("passwordForm");
    const emailInput = document.getElementById('grower_rep');
    const emailError = document.getElementById('emailError');
    const newPasswordInput = document.getElementById("new_password");
    const confirmPasswordInput = document.getElementById("confirm_password");

    // Email validation function
    function isValidEmail(email) {
        // More robust email validation
        const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        return emailRegex.test(email.trim());
    }

    // Real-time email validation
    emailInput.addEventListener('input', function () {
        const email = this.value.trim();
        
        if (email === '') {
            // If email is empty, remove validation styling
            this.classList.remove('is-invalid');
            emailError.textContent = '';
            emailError.style.display = 'none';
        } else if (!isValidEmail(email)) {
            this.classList.add('is-invalid');
            emailError.textContent = 'Please enter a valid email address (e.g., user@example.com)';
            emailError.style.display = 'block';
        } else {
            this.classList.remove('is-invalid');
            emailError.textContent = '';
            emailError.style.display = 'none';
        }
    });

    // Real-time password confirmation validation
    function validatePasswordMatch() {
        const newPassword = newPasswordInput.value;
        const confirmPassword = confirmPasswordInput.value;
        
        if (newPassword !== '' && confirmPassword !== '' && newPassword !== confirmPassword) {
            confirmPasswordInput.classList.add('is-invalid');
            return false;
        } else {
            confirmPasswordInput.classList.remove('is-invalid');
            return true;
        }
    }

    // Add event listeners for password validation
    newPasswordInput.addEventListener('input', validatePasswordMatch);
    confirmPasswordInput.addEventListener('input', validatePasswordMatch);

    // Form submission validation
    form.addEventListener("submit", function (event) {
        let isValid = true;

        // Validate email
        const email = emailInput.value.trim();
        if (email === '') {
            event.preventDefault();
            emailInput.classList.add('is-invalid');
            emailError.textContent = 'Email address is required';
            emailError.style.display = 'block';
            emailInput.focus();
            isValid = false;
        } else if (!isValidEmail(email)) {
            event.preventDefault();
            emailInput.classList.add('is-invalid');
            emailError.textContent = 'Please enter a valid email address (e.g., user@example.com)';
            emailError.style.display = 'block';
            emailInput.focus();
            isValid = false;
        }

        // Validate password confirmation
        const newPassword = newPasswordInput.value;
        const confirmPassword = confirmPasswordInput.value;
        
        // Only validate password match if both fields have values
        if (newPassword !== '' || confirmPassword !== '') {
            if (newPassword !== confirmPassword) {
                event.preventDefault();
                confirmPasswordInput.classList.add("is-invalid");
                isValid = false;
            }
        }

        // If validation fails, prevent submission
        if (!isValid) {
            event.preventDefault();
            return false;
        }

        return true;
    });
});
</script>