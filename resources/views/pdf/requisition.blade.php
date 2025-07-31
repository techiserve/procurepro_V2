<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment Requisition Form</title>
    <style>
        /* Same styling as before */
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        body {
            background-color: #f3f4f6;
            padding: 40px;
        }
        .container {
            width: 180mm;
            background-color: white;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0px 10px 20px rgba(0, 0, 0, 0.1);
        }
        h1 {
            text-align: center;
            margin-bottom: 9px;
            color: #333;
            font-size: 25px;
            text-transform: uppercase;
            letter-spacing: 2px;
        }
        .header-info-table {
            width: 100%;
            margin-bottom: 5px;
        }
        .header-info-table td {
            vertical-align: top;
        }
        .address {
            text-align: left;
            font-size: 14px;
            color: #555;
            font-weight: bold;
            margin-bottom: -40px;
        }
        .logo {
            width: 150px;
            height: auto;
            text-align: right;
            margin-bottom: 40px;
        }
        .requisition-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 8px;
            background-color: #fff;
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
        }
        .requisition-table td {
            padding: 6px;
            border-bottom: 1px solid #f1f1f1;
        }
        .left-column {
            background-color: #0A2042;
            color: white;
            font-weight: normal;
            text-transform: uppercase;
            letter-spacing: 1px;
            font-size: 14px;
            width: 35%;
        }
        .right-column {
            background-color: #f9f9f9;
            color: #333;
            text-align: left;
            font-size: 16px;
            font-weight: 500;
        }
        .footer {
            text-align: right;
            margin-top: 20px;
            font-size: 14px;
            color: #555;
        }
        .footer a {
            color: #007bff;
            text-decoration: none;
        }
        .footer a:hover {
            text-decoration: underline;
        }
        @media print {
            body {
                width: 160mm;
                height: 297mm;
                margin: 0;
                padding: 0;
            }
            .container {
                width: 100%;
                box-shadow: none;
                padding: 0;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Payment Requisition Form</h1>

        <table class="header-info-table">
            <tr>
                <td class="address">
                   <br><br>70 3rd Road<br>Linbro Park, Sandton<br>2090<br>Gauteng<br>South Africa
                </td>
                <td style="text-align: right;">
                    <img src="data:image/png;base64,{{ base64_encode(file_get_contents(public_path('coreui/img/zarq1.png'))) }}" alt="Company Logo" class="logo">
                </td>
            </tr>
        </table>

        <table class="requisition-table">
            <!-- Always visible fields -->
            <tr>
                <td class="left-column">ID:</td>
                <td class="right-column">{{ $company->id }}</td>
            </tr>

            <tr>
                <td class="left-column">Status:</td>
                <td class="right-column">
                    @switch($company->status)
                        @case(0)
                        @case(1)
                            Pending
                            @break
                        @case(2)
                            Approved
                            @break
                        @case(3)
                            Rejected
                            @break
                        @case(4)
                            Returned
                            @break
                        @default
                            Processing
                    @endswitch
                </td>
            </tr>

            <tr>
                <td class="left-column">Submitted by:</td>
                <td class="right-column">{{ $user->email }}</td>
            </tr>

            <tr>
                <td class="left-column">Date of requisition:</td>
                <td class="right-column">{{ $company->created_at }}</td>
            </tr>

            <tr>
                <td class="left-column">Department:</td>
                <td class="right-column">{{ $department->name ?? '' }}</td>
            </tr>

            <!-- Dynamic Fields -->
            @foreach($formFields as $field)
                @if($field->name !== 'invoiceamount' || $field->name !== 'department'|| $field->name !== 'Department'  ) {{-- Skip this field --}}
                    <tr>
                        <td class="left-column">{{ ucwords(str_replace('_', ' ', $field->name)) }}:</td>
                        <td class="right-column">{{ $company->{$field->name} ?? '' }}</td>
                    </tr>
                @endif
            @endforeach

            <!-- Approval History -->
            @foreach ($history as $hist)
            <tr>
                <td class="left-column">{{ $hist->doneby }}:</td>
                <td class="right-column">{{ $hist->action }} on {{ $hist->created_at->format('d M Y') }}</td>
            </tr>   
            @endforeach
        </table>

        <div class="footer">
            Powered by <a href="https://techiserve.com">TechIServe</a>
        </div>
    </div>
</body>
</html>
