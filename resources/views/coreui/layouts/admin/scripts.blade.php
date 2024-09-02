<script src="{{ asset('coreui/js/app.js') }}"></script>
<script src="{{ asset('coreui/node_modules/jquery/dist/jquery.min.js') }}"></script>
<script src="{{ asset('coreui/node_modules/popper.js/dist/umd/popper.min.js') }}"></script>
<script src="{{ asset('coreui/node_modules/pace-progress/pace.min.js') }}"></script>
<script src="{{ asset('coreui/node_modules/perfect-scrollbar/dist/perfect-scrollbar.min.js') }}"></script>
<script src="{{ asset('coreui/node_modules/@coreui/coreui/dist/js/coreui.min.js') }}"></script>
<!-- Plugins and scripts required by this view-->
<script src="{{ asset('coreui/node_modules/chart.js/dist/Chart.min.js') }}"></script>
<script src="{{ asset('coreui/node_modules/@coreui/coreui-plugin-chartjs-custom-tooltips/dist/js/custom-tooltips.min.js') }}"></script>
<script src="{{ asset('coreui/js/main.js') }}"></script>
<script src="{{ asset('coreui/js/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('coreui/js/dataTables.fixedHeader.min.js') }}"></script>
<!-- <script src="{{ asset('coreui/js/bootstrap-select.min.js') }}"></script> -->
<!-- <script src="{{ asset('coreui/js/sweetalert2.all.min.js') }}"></script> -->
<!-- <script src="{{ asset('coreui/js/sweetalert2.min.js') }}"></script> -->
<!-- <script src="{{ asset('coreui/js/sweetalert.min.js') }}"></script> -->
<script src="{{ asset('coreui/js/select2.min.js') }}"></script>

<!-- for bootstrap datatables -->
<script src="{{ asset('coreui/js/data-table/bootstrap-table.js') }}"></script>
<script src="{{ asset('coreui/js/data-table/tableExport.js') }}"></script>
<script src="{{ asset('coreui/js/data-table/bootstrap-table-editable.js') }}"></script>
<script src="{{ asset('coreui/js/data-table/bootstrap-editable.js') }}"></script>
<script src="{{ asset('coreui/js/data-table/bootstrap-table-resizable.js') }}"></script>
<script src="{{ asset('coreui/js/data-table/colResizable-1.5.source.js') }}"></script>
<script src="{{ asset('coreui/js/data-table/bootstrap-table-export.js') }}"></script>


<script type="text/javascript">
    $(document).ready( function () {
        $('#growers').DataTable({
            processing: true,
            serverSide: true,
            ajax: '',
            columns: [
                { data: 'id', name: 'id' },
                { data: 'grower_name', name: 'grower_name' },
                { data: 'grower_number', name: 'grower_number'},
                { data: 'province', name: 'province'},
                { data: 'national_id', name: 'national_id'},
                { data: 'grower_type', name: 'grower_type'},
                { data: 'grower_size', name: 'grower_size'},
                {
                        "data": 'status',
                        render:function(data)
                        {
                            // return data;
                            if(data == 1){

                                return "<span class='badge badge-secondary'>Inactive</span>";

                            }else{

                                return "<span class='badge badge-success'>Active</span>";
                            }
                            
                        }
                },

                {
                        "data": 'id',
                        render:function(data)
                        {
                            // return data;
                            return "<a href='/growers/"+data+"' class='btn btn-success btn-sm'><span class='fa fa-desktop'></span><span class='hidden-sm hidden-sm hidden-md'> View</span></a>&nbsp;<a href='/growers/"+data+"/edit' class='btn btn-info btn-sm' style='color: white;'><span class='fa fa-pencil'></span><span class='hidden-sm hidden-sm hidden-md'> Edit</span></a>";
                        },
                        "targets": -1
                }
            ]
        });
    } );
</script>

<!-- sWEET alert -->

@include('sweetalert::alert')


<script type="text/javascript">
        $(document).ready(function() {
            // Activate the modal as soon as the page is rendered
            $('#addProvince').modal('show');
        });
    </script>
<!-- <script type="text/javascript">
    $(document).ready(function() {
        // Setup - add a text input to each footer cell
        $('.table thead tr').clone(true).appendTo( '.table thead' );
        $('.table thead tr:eq(1) th').each( function (i) {
            var title = $(this).text();
            $(this).html( '<input type="text" class="form-control form-control-sm" placeholder="'+title+'" />' );
    
            $( 'input', this ).on( 'keyup change', function () {
                if ( table.column(i).search() !== this.value ) {
                    table
                        .column(i)
                        .search( this.value )
                        .draw();
                }
            } );
        } );
    
        var table = $('.table').DataTable( {
            orderCellsTop: true,
            fixedHeader: true
        } );
    } );
</script> -->


<!-- for disabling rows selected -->
<script type="text/javascript">
    // first row checkboxes
    $('tr td:first-child input[type="checkbox"]').click( function() {
    //enable/disable all except checkboxes, based on the row is checked or not
    $(this).closest('tr').find(":input:not(:first)").attr('disabled', !this.checked);
    });
</script>

<script type="text/javascript">
  $(document).ready(function () {
    $("#s_grower_id").change(function () {
        var val = JSON.parse($(this).val());
        // console.log(val.grower_type);
        if (val.grower_size == "small_scale") {
            $("#s_report_type").html("<option value='F1'>Field Report One</option><option value='F2'>Field Report Two</option><option value='F3'>Field Report Three</option><option value='GR'>General Report</option><option value='STP_1'>STP Phase One</option><option value='STP_2'>STP Phase Two</option><option value='STP_3'>STP Phase Three</option><option value='NF'>Northern Farming Report</option>");
        } else if (val.grower_size == "Small Scale") {
            $("#s_report_type").html("<option value='F1'>Field Report One</option><option value='F2'>Field Report Two</option><option value='F3'>Field Report Three</option><option value='GR'>General Report</option><option value='STP_1'>STP Phase One</option><option value='STP_2'>STP Phase Two</option><option value='STP_3'>STP Phase Three</option><option value='NF'>Northern Farming Report</option>");
        } else if (val.grower_size == "commercial") {
            $("#s_report_type").html("<option value='SEPT'>September Report</option><option value='NOV'>November Report</option><option value='JAN'>January Report</option><option value='MAR'>March Report</option><option value='C_GR'>General Report</option><option value='STP_1'>STP Phase One</option><option value='STP_2'>STP Phase Two</option><option value='STP_3'>STP Phase Three</option><option value='NF'>Northern Farming Report</option>");
        } else if (val.grower_size == "Commercial") {
            $("#s_report_type").html("<option value='SEPT'>September Report</option><option value='NOV'>November Report</option><option value='JAN'>January Report</option><option value='MAR'>March Report</option><option value='C_GR'>General Report</option><option value='STP_1'>STP Phase One</option><option value='STP_2'>STP Phase Two</option><option value='STP_3'>STP Phase Three</option><option value='NF'>Northern Farming Report</option>");
        }
    });
});
</script>

<script type="text/javascript">
  $(document).ready(function () {
    $("#category").change(function () {
        var val = $(this).val();
        var production_items = document.getElementById("production_items");
        var capital_items = document.getElementById("capital_items");
        var non_selected = document.getElementById("non_selected");
        console.log(val);
        if (val == "production") {
            production_items.style.display = "block";
            capital_items.style.display = "none";
            non_selected.style.display = "none";
        } else if (val == "capital") {
            capital_items.style.display = "block";
            production_items.style.display = "none";
            non_selected.style.display = "none";
        } else {
            non_selected.style.display = "block";
            capital_items.style.display = "none";
            production_items.style.display = "none";
        } 
    });
});
</script>

<script type="text/javascript">
    $(document).ready(function () {
        var districts = [];
        $("#province").change(function (){
            var val = $(this).val();
            $.get('/districts/'+val).then(response => {
                $('#district').find('option').remove().end();
                // console.log(response);
                response.forEach(function(element) {
                    $('#district').append($('<option>').text(element.district).attr('value', element.id));
                });
            });
        });

    });
</script>

<!-- <script type="text/javascript">
    $(document).ready(function () {
        var notification = [];
        $.get('/notification/all').then(response => {

            response.forEach(function(element){
                console.log(element.data);
            });

        });
    });
</script> -->

<script type="text/javascript">
    var expanded = false;

    function showCheckboxes() {
    var checkboxes = document.getElementById("checkboxes");
    if (!expanded) {
        checkboxes.style.display = "block";
        expanded = true;
    } else {
        checkboxes.style.display = "none";
        expanded = false;
    }
    }
</script>


<script type="text/javascript">

    function markNotificationAsRead(){
        $.get('/markAsRead');
    }
 
</script>


<script type="text/javascript">
    // In your Javascript (external .js resource or <script> tag)
    $(document).ready(function() {
        $('.js-example-basic-single').select2({
            theme: "bootstrap"
        });
    });
</script>

<script type="text/javascript">
    $(document).ready(function() {
        $('#organization-input').select2({
            dropdownParent: $('#seasonsModal')
        });
    });
</script>

<script type="text/javascript">
    $(document).ready(function() {
        $('#project_manager').select2({
            dropdownParent: $('#addAssignment')
        });
        $('#assign_assessors').select2({
            dropdownParent: $('#addAssignment')
        })
    });
</script>


<script type="text/javascript">
    $(document).ready(function() {
        $(".js-example-theme-multiple").select2({
            theme: "bootstrap"
        });
    });
</script>

<script>
    $(document).ready(function() {
        $('#grower_id').select2({
            dropdownParent: $('#documentModal')
        });
    });
</script>

<script>
    $(document).ready(function() {
        $('#roles').select2({
            dropdownParent: $('#accessModal')
        });
    });
</script>

<script>
    $(document).ready(function() {
        $('#grower_name').select2({
            dropdownParent: $('#multiple_assign')
        });
    });
</script>

<script>
    $(document).ready(function() {
        $('#areas').select2({
            dropdownParent: $('#filterModal')
        });
    });
</script>

<script>
    $(document).ready(function() {
        $('#assessors').select2({
            dropdownParent: $('#filterModal'),
            placeholder: "Select a state",
            allowClear: true
        });
    });
</script>

<script>
    $(document).ready(function() {
        $('#main_body').select2({
            dropdownParent: $('#accessModal')
        });
    });
</script>


<script>
    $(document).ready(function() {
        $('#grower_number').select2({
            dropdownParent: $('#extractModal')
        });
    });
</script>

<script>
    $(document).ready(function() {
        $('#month_id').select2({
            dropdownParent: $('#exportHistory')
        });
    });
</script>

<script>
    $(document).ready(function() {
        $('#capital_id').select2({
            dropdownParent: $('#exportHistory')
        });
    });
</script>

<script>
    $(document).ready(function() {
        $('#production_id').select2({
            dropdownParent: $('#exportHistory')
        });
    });
</script>

<script>
    $(document).ready(function() {
        $('#province_farm').select2({
            dropdownParent: $('#farmModal')
        });
    });
</script>

<!-- <script>
    var spinner = $('#loader');
    $(function() {
    $('#email-form').submit(function(e) {
        e.preventDefault();
        spinner.show();
        setInterval(function() {
            spinner.hide();
        }, 5000); //5 seconds
    });
    });
</script> -->
<script type="text/javascript">
    if(document.getElementById("season")){
        
        document.getElementById("season").addEventListener("load", season);

        $(document).ready(function season() {
        Swal.fire({
            type: 'info',
            title: 'Sorry...',
            text: 'No season is activated. Please contact the administrator to activate a season for you to access the system.',
            }).then((result) => {
                document.getElementById('logout-form').submit();
            });
        });

    }

    
</script>

<!-- sync growers from b1 -->
<script type="text/javascript">
    $('#load').click( function() {

        let timerInterval
        Swal.fire({
        title: 'Synchronizing Growers!',
        html: '<strong style="color:green;"> Please wait while synchronizing....<strong>',
        allowOutsideClick: false,
        onBeforeOpen: () => {
            Swal.showLoading()
            return fetch('/sync-growers')
        },
        onClose: () => {
            clearInterval(timerInterval)
        }
        }).then((result) => {
        if (
            // Read more about handling dismissals
            result.dismiss === Swal.DismissReason.timer
        ) {
            console.log('I was closed by the timer')
        }
        });
    });
</script>

<!-- sync products from b1 -->
<script type="text/javascript">
    $('#load').click( function() {

        let timerInterval
        Swal.fire({
        title: 'Synchronizing Products!',
        html: '<strong style="color:green;"> Please wait while synchronizing....<strong>',
        allowOutsideClick: false,
        onBeforeOpen: () => {
            Swal.showLoading()
            return fetch('/sync-products')
            .then(response => {
                
                console.log(response);
                if(response.status == 200){
                    Swal.fire({
                        title: 'Synchronization Complete!',
                        text: "All products successfully synchronized",
                        type: 'success',
                        confirmButtonText: 'OK'
                    }).then((result) => {
                            if (result.value) {
                                location.reload();
                            }
                    })
                                        
                }else if(response == 2){
                    Swal.fire(
                        'Synchronization Failed!',
                        'Count is null. Please try again later!',
                        'error'
                    )
                }else if(response == 3){
                    Swal.fire(
                        'Synchronization Failed!',
                        'Please sign in to B1 again, session has expired.',
                        'error'
                    )
                }else if(response == 4){
                    Swal.fire(
                        'Synchronization Failed!',
                        'Failed to sync all products. Please try again later.',
                        'error'
                    ) 
                }else{

                    Swal.fire(
                        'Synchronization Failed!',
                        'Failed to synchronize products with an unknown error.',
                        'error'
                    ) 
                }

            })
            .catch(error => {
                Swal.showValidationMessage(
                'Request failed!'
                )
            })
        },
        onClose: () => {
            clearInterval(timerInterval)
        }
        }).then((result) => {
        if (
            // Read more about handling dismissals
            result.dismiss === Swal.DismissReason.timer
        ) {
            console.log('I was closed by the timer')
        }
        });
    });
</script>

<script type="text/javascript">
$(document).ready(function() {
    $('.table').DataTable( {
        fixedHeader: true,
        responsive: true
    } );
} );
</script>

<script type="text/javascript">
    function printDiv(divName){
        var printContents = document.getElementById(divName).innerHTML;
        var originalContents = document.body.innerHTML;
        document.body.innerHTML = printContents;
        window.print();
        document.body.innerHTML = originalContents;
    }
</script>

<script type="text/javascript">
    function printCapex(divName){
        var printContents = document.getElementById(divName).innerHTML;
        var originalContents = document.body.innerHTML;
        document.body.innerHTML = printContents;
        window.print();
        document.body.innerHTML = originalContents;
    }
</script>