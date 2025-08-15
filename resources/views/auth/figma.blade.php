<!DOCTYPE html>
<html lang="en">

<head>
   <meta charset="UTF-8">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <meta name="csrf-token" content="{{ csrf_token() }}">
   <title>Zarq</title>
   
   <link rel="icon" href="{{ asset('assets/img/favicon.ico') }}" type="image/x-icon">
   <link rel="stylesheet" href="{{ asset('assets/css/bootstrap.min.css') }}">
   <link rel="stylesheet" href="{{ asset('assets/css/slick.css') }}">
   <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">
   <link href="https://fonts.googleapis.com/css2?family=Inter:ital,opsz,wght@0,14..32,100..900;1,14..32,100..900&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">
   <link href="https://stackpath.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
<div class="full-width-background">
    <div class="login-container">
        <div class="login-logo"><a href="#"><img src="assets/img/zarq-Logo-white.png" alt=""></a></div>
        <div class="logine-wrapper">
              <form  id="login-form" action="{{ route('login') }}" method="POST">
                   @csrf
            <div class="logine-input-row"><input type="email" id="email" name="email"  class="{{ $errors->has('email') ? 'is-invalid' : '' }}" placeholder="username@tagpay.digital" value="{{ old('email') }}"></div>
                 @error('email')
            <span style="color: #ff7276; font-size: 13px;">{{ $message }}</span>
        @enderror
            <div class="logine-input-row">
                <input type="password"  id="password"  class="{{ $errors->has('password') ? 'is-invalid' : '' }}" name="password" placeholder="Password"/>
                <button type="button" id="btnToggle" class="toggle">
                    <i id="eyeIcon" class="fa fa-eye"></i>
                </button>
            </div>
               @error('password')
                <span style="color: #ff7276; font-size: 13px;">{{ $message }}</span>
            @enderror
            <div class="logine-flex">
                <div class="logine-checkbox">
                    <input type="checkbox" id="remember-me" name="remember-me">
                    <label for="remember-me">Remember Me</label>
                </div>                
                <a href="#" class="forgot-password">Forgot Password?</a>
            </div>
            <div class="btn-logine-input"><input type="submit" id="show-company-modal" value="Login"></div>
        </div>
        </form>
    </div>
    <img src="assets/img/login-bg.jpg" class="full-width-background__image" alt="">
</div>

<!-- Company Selection Modal -->
<div class="modal fade" id="companySelectModal" tabindex="-1" role="dialog" aria-hidden="true" style="display: none;">
  <div class="modal-dialog" role="document">
    <form id="modal-login-form" method="POST" action="{{ route('login') }}">
      @csrf
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Select Company</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <input type="hidden" name="email" id="modal-email">
          <input type="hidden" name="password" id="modal-password">

          <div class="form-group">
            <label for="companySelect">Company</label>
            <select name="company_id" class="form-control" id="companySelect" required>
              @foreach ($companies as $company)
                <option value="{{ $company->id }}">{{ $company->name }}</option>
              @endforeach
            </select>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" id="proceedLogin" class="btn btn-primary">Continue</button>
        </div>
      </div>
    </form>
  </div>
</div>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script> 
</body>

</html>

   {{-- <script src="{{ asset('assets/js/jquery.min.js') }}"></script> --}}
   {{-- <script src="{{ asset('assets/js/slick.min.js') }}"></script>
   <script src="{{ asset('assets/js/custom.js') }}"></script> --}}

 
<script>
  
    document.getElementById('proceedLogin').addEventListener('click', function () {
        const company = document.getElementById('companySelect').value;
        if (!company) {
            alert('Please select a company.');
            return;
        }

        let hidden = document.createElement('input');
        hidden.type = 'hidden';
        hidden.name = 'company_id';
        hidden.value = company;
        document.querySelector('form').appendChild(hidden);

        document.querySelector('form').submit();
    });
</script>
<script>
document.addEventListener('DOMContentLoaded', function () {
    document.getElementById('login-form').addEventListener('submit', function (e) {
        e.preventDefault();

        const email = document.querySelector('input[name="email"]').value;
        const password = document.querySelector('input[name="password"]').value;
         // console.log(email,password); 
        fetch('/check-executive', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: JSON.stringify({ email: email })
        })
        .then(response => response.json())
        .then(data => {

            if (data.is_executive) {
                // Show modal
                // console.log(data);
                document.getElementById('modal-email').value = email;
                document.getElementById('modal-password').value = password;
                const companySelect = document.getElementById('companySelect');
                companySelect.innerHTML = '';

                // Populate with fetched companies
                data.companies.forEach(company => {
                    const option = document.createElement('option');
                    option.value = company.id;
                    option.textContent = company.name;
                    companySelect.appendChild(option);
                });
                $('#companySelectModal').modal('show');
            } else {
                // Submit original login form
                e.target.submit();
            }
        })
        .catch(error => {
            console.error('Error checking executive status:', error);
            e.target.submit(); // fallback to normal login
        });
    });
});
</script>