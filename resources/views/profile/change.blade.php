@extends('html.default')

@section('content')
<style>
  .is-invalid { border-color: #dc3545; }
</style>

<div class="body-content__header">
  <ul>
    <li><a href="#">Edit Profile</a></li>
  </ul>
</div>

<div class="body-content__wrapper">
  <div class="row">
    <div class="col-12">
      <form method="POST" action="{{ route('profile.update') }}" id="passwordForm" novalidate>
        @csrf
        @method('put')

        <div class="card">
          <div class="card-header">
            <strong>Edit Profile</strong>
          </div>

          <div class="card-body">
            <!-- Row 1 -->
            <div class="row">
              <div class="col-md-6"><br>
                <div class="form-col">
                  <label for="grower_name">Name</label>
                  <input class="form-control" id="grower_name" name="name" type="text" value="{{ $user->name }}" placeholder="Enter Full Name..." required>
                </div>
              </div>

              <div class="col-md-6"><br>
                <div class="form-col">
                  <label for="grower_rep">Email</label>
                  <input class="form-control" id="grower_rep" name="email" type="email" value="{{ $user->email }}" placeholder="Enter Email Address" required>
                  <div id="emailError" class="text-danger" style="display:none;font-size:14px;"></div>
                </div>
              </div>
            </div>

            <!-- Row 2 -->
            <div class="row">
              <div class="col-md-6"><br>
                <div class="form-col">
                  <label for="current_password">Current Password</label>
                  <input class="form-control" id="current_password" name="current_password" type="password" placeholder="********">
                </div>
              </div>

              <div class="col-md-6"><br>
                <div class="form-col">
                  <label for="new_password">New Password</label>
                  <input class="form-control" id="new_password" name="password" type="password" placeholder="********">
                </div>
              </div>
            </div>

            <!-- Row 3 -->
            <div class="row">
              <div class="col-md-6"><br>
                <div class="form-col">
                  <label for="confirm_password">Confirm Password</label>
                  <input class="form-control" id="confirm_password" name="password_confirmation" type="password" placeholder="********">
                  <div class="invalid-feedback">Passwords do not match.</div>
                </div>
              </div>
            </div>

            <hr style="border-color:black;">
          </div>

          <div class="card-footer">
            <div class="d-flex justify-content-end">
              <input type="submit" class="btn btn-success" value="Save" style="padding:10px 20px; font-size:16px; min-width:100px;">
              <input type="reset" class="btn btn-danger ms-2" value="Cancel" style="padding:10px 20px; font-size:16px; min-width:100px;">
            </div>
          </div>
        </div>
      </form>
    </div>
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
    const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    return emailRegex.test(email.trim());
  }

  // Real-time email validation
  emailInput.addEventListener('input', function () {
    const email = this.value.trim();
    if (email === '') {
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

  newPasswordInput.addEventListener('input', validatePasswordMatch);
  confirmPasswordInput.addEventListener('input', validatePasswordMatch);

  // Form submission validation
  form.addEventListener("submit", function (event) {
    let isValid = true;

    // Validate email
    const email = emailInput.value.trim();
    if (email === '') {
      emailInput.classList.add('is-invalid');
      emailError.textContent = 'Email address is required';
      emailError.style.display = 'block';
      emailInput.focus();
      isValid = false;
    } else if (!isValidEmail(email)) {
      emailInput.classList.add('is-invalid');
      emailError.textContent = 'Please enter a valid email address (e.g., user@example.com)';
      emailError.style.display = 'block';
      emailInput.focus();
      isValid = false;
    }

    // Validate password confirmation (only if either provided)
    const newPassword = newPasswordInput.value;
    const confirmPassword = confirmPasswordInput.value;
    if (newPassword !== '' || confirmPassword !== '') {
      if (newPassword !== confirmPassword) {
        confirmPasswordInput.classList.add("is-invalid");
        isValid = false;
      }
    }

    if (!isValid) {
      event.preventDefault();
      return false;
    }
    return true;
  });
});
</script>
