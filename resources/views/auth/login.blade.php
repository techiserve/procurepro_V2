<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TagPay Login</title>
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
            font-size: 25px;
            margin-bottom: 70px; /* Adjusted margin to move text up */
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
            display: flex;
            flex-direction: column;
        }

        label {
            font-size: 14px;
            margin-bottom: 5px;
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
            background-color: #ffffff;
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
    </style>
</head>
<body>

<div class="container">
    <div class="left">
        <img src="{{ asset('template/assets/media/photos/logo1.png') }}" alt="TagPay Logo">
    </div>
    <div class="right">
        <h3 style="font-family: 'Gilroy-Bold', Arial, sans-serif;" >Welcome to TagPay</h3>
        <div class="login-title">Login</div> 
        <form action="{{ route('login') }}" method="POST">
        @csrf
            <label for="email">Email</label>
            <input type="email" id="email" name="email" placeholder="username@gmail.com">

            <label for="password">Password</label>
            <input type="password" id="password" name="password" placeholder="Password">

            <div class="forgot-password">
            
            </div>

            <input type="submit" value="Sign in" style="font-family: 'Gilroy-Bold', Arial, sans-serif;">

     
        </form>
    </div>
</div>

</body>
</html>
