<html>
<head>
    <title>Bank</title>
</head>
<body>
    <h1>Requisition Infomation</h1>
    <table>
        <thead>
            <tr>
                <th>Vendor</th>
                <th>Service</th>  
                <th>Amount</th>   
            </tr>
        </thead>
        <tbody>
           
            <tr>
                <td>{{ $data->vendor }}</td>
                <td>{{ $data->services }}</td>
                <td>{{ $data->amount }}</td>
            </tr>
          
        </tbody>
    </table>
</body>
</html>
