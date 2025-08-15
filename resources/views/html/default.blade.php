<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>ZARQ</title>
    <link rel="icon" href="assets/img/favicon.ico" type="image/x-icon" />
    <link rel="stylesheet" href="{{ asset('assets/css/bootstrap.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/css/slick.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}" />
    <!-- <link rel="stylesheet" href="{{ asset('stack-admin/css/sweetalert2.min.css') }}"> -->
    <link rel='stylesheet' href='https://cdn.datatables.net/1.10.19/css/jquery.dataTables.min.css'>
    <link rel='stylesheet' href='https://cdn.datatables.net/responsive/2.2.3/css/responsive.dataTables.min.css'>
    <link
        href="https://fonts.googleapis.com/css2?family=Inter:ital,opsz,wght@0,14..32,100..900;1,14..32,100..900&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap"
        rel="stylesheet" />
  
    
</head>
<body>

    <!--  BEGIN SIDEBAR  -->
      @include('html.sidebar')
    <!--  END SIDEBAR  -->
      
        <!--  BEGIN NAVBAR  -->
      @include('html.navbar')
        <!--  END NAVBAR  -->
         <div class="body-content">
        
        <!--  BEGIN CONTENT AREA  -->
         @yield('content')
        <!--  END CONTENT AREA  -->
         </div>
        </div>
    <!-- END MAIN CONTAINER -->

        <script src="{{ asset('assets/js/jquery.min.js') }}"></script>
        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
         <script src='https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js'></script>
        <script src='https://cdn.datatables.net/responsive/2.2.3/js/dataTables.responsive.min.js'></script>
       <script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.18.5/xlsx.full.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/pdf.js/2.14.305/pdf.min.js"></script>
        <script src="{{ asset('assets/js/bootstrap.min.js') }}"></script>
        <script src="{{ asset('assets/js/slick.min.js') }}"></script>
        <script src="{{ asset('assets/js/custom.js') }}"></script>
          @include('sweetalert::alert')
            <script>
            $(document).ready(function () {
                $('#example').DataTable();
            });
        </script> 

        <script>
    // Spend To Date - Bar chart
    new Chart(document.getElementById("spendToDate"), {
      type: "bar",
      data: {
        labels: Array.from({length: 12}, (_, i) => `Day ${i + 1}`),
        datasets: [{
          label: "# Invoice amount by date",
          data: [800, 900, 600, 1100, 1000, 700, 1300, 1200, 600, 800, 900, 500],
          backgroundColor: "rgba(45, 93, 207, 0.7)",
          borderRadius: 4
        }]
      },
      options: {
        plugins: {
          legend: { display: false }
        },
        scales: {
          y: {
            beginAtZero: true,
            max: 1600
          }
        }
      }
    });

    // Spend By Classification - Pie chart
    new Chart(document.getElementById("classification"), {
      type: "pie",
      data: {
        labels: ["# Product For School"],
        datasets: [{
          data: [1],
          backgroundColor: ["#2d5dcf"]
        }]
      },
      options: {
        plugins: {
          legend: { display: false }
        }
      }
    });

    // Spend By Vendor - Line chart
    new Chart(document.getElementById("vendorSpend"), {
      type: "line",
      data: {
        labels: Array.from({length: 12}, (_, i) => `Day ${i + 1}`),
        datasets: [{
          label: "# Invoice amount by date",
          data: [900, 850, 950, 780, 800, 850, 880, 920, 940, 1000, 1100, 1250],
          borderColor: "#2d5dcf",
          backgroundColor: "rgba(45, 93, 207, 0.15)",
          fill: true,
          tension: 0.4
        }]
      },
      options: {
        plugins: {
          legend: { display: false }
        },
        scales: {
          y: {
            beginAtZero: true,
            max: 1400
          }
        }
      }
    });

    // Department Spend - Donut chart
    new Chart(document.getElementById("departmentSpend"), {
      type: "doughnut",
      data: {
        labels: ["# Product For School"],
        datasets: [{
          data: [1, 0],
          backgroundColor: ["#2d5dcf", "#e5ecfb"],
          cutout: "80%"
        }]
      },
      options: {
        plugins: {
          legend: { display: false }
        }
      }
    });
  </script>
</body>
</html>