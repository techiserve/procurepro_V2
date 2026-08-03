<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title }}</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            color: #333;
            background-color: #f9f9f9;
            margin: 0;
            padding: 20px;
        }
        .container {
            max-width: 600px;
            margin: 0 auto;
            background: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
        .header {
            text-align: center;
            color: #555;
        }
        .header h2 {
            margin: 0;
            color: #333;
        }
        .content p {
            margin: 15px 0;
        }
        .reason {
            background-color: #f2f2f2;
            border-left: 4px solid #0D1E3D;
            padding: 12px;
            margin: 15px 0;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h2>{{ $title }}</h2>
        </div>
        <div class="content">
            <p>{{ $message }}</p>
            <p><strong>Requisition Number:</strong> {{ $requisitionNumber }}</p>

            @if(!empty($reason))
                <div class="reason">
                    <strong>Reason:</strong><br>
                    {{ $reason }}
                </div>
            @endif

            <p>Please log in to your Zarq profile to review the details.</p>

            <p>REGARDS,</p>
            <p><strong>Zarq</strong></p>
        </div>
    </div>
</body>
</html>
