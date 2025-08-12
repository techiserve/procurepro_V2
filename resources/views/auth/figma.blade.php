<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>TagPay Login</title>
<link href="https://stackpath.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" rel="stylesheet">

    <style>
        /* Include Gilroy-Bold font from a local source or web font */
        @font-face {
            font-family: 'Gilroy-Bold';
            src: url('{{ asset('fonts/gilroy-bold/Gilroy-Bold.ttf') }}') format('truetype');
            font-weight: bold;
            font-style: normal;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            background-color: #0D1E3D;
            font-family: 'Gilroy-Bold', Arial, sans-serif; /* Use Gilroy-Bold */
        }

        .container {
            display: flex;
            width: 1000px;
            height: 600px;
            background-color: #0D1E3D;
            position: relative;
            right: -50px; /* Move the container to the right */
        }

        .left {
            width: 60%;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .left img {
            width: 150%; 
            margin-left: -490px;/* Increase the logo size by 50% (from 60% to 90%) */
        }

        .right {
            width: 43%;
            background-color: #D9DFE647;
            border-radius: 28px;
            border: 2px solid #FFFFFF;
            padding: 50px;
            color: white;
            margin-bottom: 40px;
            margin-left: -10px;
            margin-right: -10px;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }

        h3 {
            font-size: 35px;
            margin-bottom: 30px; /* Adjusted margin to move text up */
            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.5); /* Add shadow */
        }

        .login-title {
            font-size: 25px;
            margin-bottom: 30px; /* Space between "Login" and "Email" */
        }

        .right h3 {
            text-align: center; /* Center only the h2 element */
           
        }

        form {
            margin-bottom: 35px;
            display: flex;
            flex-direction: column;
        }

        label {
            font-size: 14px;
            margin-bottom: 15px;
        }

        input {
            padding: 12px;
            margin-bottom: 20px;
            border-radius: 10px;
            border: none;
            font-size: 14px;
            width: 100%;
        }

        input[type="email"],
        input[type="password"] {
            background-color: #ece3e3;
            color: #000000;
        }

        input[type="submit"] {
            background-color: #0D1E3D;
            color: white;
            cursor: pointer;
            font-size: 16px;
        }

        input[type="submit"]:hover {
            background-color: #072C5B;
        }

        .forgot-password {
            text-align: right;
            margin-bottom: 20px;
        }

        .forgot-password a {
            color: white;
            text-decoration: none;
            font-size: 14px;
        }

        .register {
            margin-top: 20px;
            text-align: center;
            font-size: 14px;
        }

        .register a {
            color: white;
            text-decoration: none;
        }
        
        input.is-invalid {
            border: 2px solid #ff7276;
        }

        /* Ensure modal appears above everything */
        .modal {
            z-index: 9999 !important;
        }
        
        .modal-backdrop {
            z-index: 9998 !important;
        }
    </style>

     
</head>
<body>

<div class="container">
    <div class="left">
        <img src="{{ asset('template/assets/media/photos/logo1.png') }}" alt="TagPay Logo">
    </div>
    <div class="right">
        <h3 style="font-family: 'Gilroy-Bold', Arial, sans-serif;" >Login to TagPay..</h3>
        <div class="login-title"></div> 
        <form  id="login-form"  action="{{ route('login') }}" method="POST">
        @csrf
            <label for="email">Email</label>
         <input type="email" id="email" name="email"  class="{{ $errors->has('email') ? 'is-invalid' : '' }}" placeholder="username@tagpay.digital" value="{{ old('email') }}">
        @error('email')
            <span style="color: #ff7276; font-size: 13px;">{{ $message }}</span>
        @enderror

            <label for="password">Password</label>
         <input type="password" id="password"  class="{{ $errors->has('password') ? 'is-invalid' : '' }}" name="password" placeholder="Password">
            @error('password')
                <span style="color: #ff7276; font-size: 13px;">{{ $message }}</span>
            @enderror

            <div class="forgot-password">
            <a href="/forgot-password">Forgot Password?</a>
            </div>

            <input id="show-company-modal"  type="submit" value="Sign in" style="font-family: 'Gilroy-Bold', Arial, sans-serif;">

     
        </form>
    </div>
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