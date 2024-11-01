<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Requisition Approval Request</title>
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
        .header, .footer {
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
        .details-table {
            width: 100%;
            margin-top: 15px;
            border-collapse: collapse;
        }
        .details-table td {
            padding: 10px;
            border: 1px solid #ddd;
        }
        .details-table td.label {
            background-color: #f2f2f2;
            font-weight: bold;
        }
        .cta-button {
            display: block;
            width: 100%;
            text-align: center;
            padding: 12px;
            margin-top: 20px;
            background-color: #28a745;
            color: #fff;
            text-decoration: none;
            border-radius: 5px;
        }
        .cta-button:hover {
            background-color: #218838;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h2>Requisition Approval Request</h2>
        </div>
        <div class="content">
            <p>A request for your approval for a requisition has been submitted by <strong>Subrathi</strong> from the Admin department. The details of the requisition are as follows:</p>
            
            <table class="details-table">
                <tr>
                    <td class="label">Vendor Name:</td>
                    <td>{{$emailData['vendor']}}</td>
                </tr>
                <tr>
                    <td class="label">Services:</td>
                    <td>{{$emailData['services']}}</td>
                </tr>
                <tr>
                    <td class="label">Property Name:</td>
                    <td>{{$emailData['PropertyName']}}</td>
                </tr>
                <tr>
                    <td class="label">Expenses:</td>
                    <td>{{$emailData['expenses']}}</td>
                </tr>
                <tr>
                    <td class="label">Amount:</td>
                    <td>{{$emailData['amount']}}</td>
                </tr>
            </table>

            <p>Please log in to your Tagpay profile to review the details and approve or reject the request. For ease of access, click the link below:</p>


            <p>REGARDS,</p>
            <p><strong>TagPay System</strong></p>
        </div>
    </div>
</body>
</html>
