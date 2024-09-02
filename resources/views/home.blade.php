@extends('coreui.layouts.admin')

@section('content')

<div class="container-fluid">
  <div class="animated fadeIn">
    <div class="row">
      <div class="col-sm-6 col-lg-3">
        <div class="card text-white bg-primary">
          <div class="card-body pb-0">
            <div class="btn-group float-right">                         
            </div>
            <div class="text-value">45</div>
            <div>Requisitions</div>
          </div>
          <div class="chart-wrapper mt-3 mx-3" style="height:70px;">
            <canvas class="chart" id="card-chart1" height="70"></canvas>
          </div>
        </div>
      </div>
      <!-- /.col-->
      <div class="col-sm-6 col-lg-3">
        <div class="card text-white bg-info">
          <div class="card-body pb-0">
            <div class="btn-group float-right">                           
            </div>
            <div class="text-value">34</div>
            <div>Approvals</div>
          </div>
          <div class="chart-wrapper mt-3 mx-3" style="height:70px;">
            <canvas class="chart" id="card-chart2" height="70"></canvas>
          </div>
        </div>
      </div>
      <!-- /.col-->
      <div class="col-sm-6 col-lg-3">
        <div class="card text-white bg-cyan">
          <div class="card-body pb-0">
            <div class="btn-group float-right">
            </div>
            <div class="text-value">27</div>
            <div>Users</div>
          </div>
          <div class="chart-wrapper mt-3" style="height:70px;">
            <canvas class="chart" id="card-chart3" height="70"></canvas>
          </div>
        </div>
      </div>
      <!-- /.col-->
      <div class="col-sm-6 col-lg-3">
        <div class="card text-white bg-teal">
          <div class="card-body pb-0">
            <div class="btn-group float-right">            
            </div>
            <div class="text-value">8</div>
            <div>Companies</div>
          </div>
          <div class="chart-wrapper mt-3 mx-3" style="height:70px;">
            <canvas class="chart" id="card-chart4" height="70"></canvas>
          </div>
        </div>
      </div>
      <!-- /.col-->
    </div>
    <!-- /.row-->



    <div class="row">
      <div class="col-sm-6 col-lg-3">
        <div class="card text-white bg-primary">
          <div class="card-body pb-0">
            <div class="btn-group float-right">                         
            </div>
            <div class="text-value">20</div>
            <div>Vendors</div>
          </div>
          <div class="chart-wrapper mt-3 mx-3" style="height:70px;">
            <canvas class="chart" id="card-chart5" height="70"></canvas>
          </div>
        </div>
      </div>
      <!-- /.col-->
      <div class="col-sm-6 col-lg-3">
        <div class="card text-white bg-info">
          <div class="card-body pb-0">
            <div class="btn-group float-right">                           
            </div>
            <div class="text-value">36</div>
            <div></div>Departments
          </div>
          <div class="chart-wrapper mt-3 mx-3" style="height:70px;">
            <canvas class="chart" id="card-chart2" height="70"></canvas>
          </div>
        </div>
      </div>
      <!-- /.col-->
      <div class="col-sm-6 col-lg-3">
        <div class="card text-white bg-cyan">
          <div class="card-body pb-0">
            <div class="btn-group float-right">
            </div>
            <div class="text-value">6</div>
            <div>Finance Managers</div>
          </div>
          <div class="chart-wrapper mt-3" style="height:70px;">
            <canvas class="chart" id="card-chart3" height="70"></canvas>
          </div>
        </div>
      </div>
      <!-- /.col-->
      <div class="col-sm-6 col-lg-3">
        <div class="card text-white bg-teal">
          <div class="card-body pb-0">
            <div class="btn-group float-right">            
            </div>
            <div class="text-value">7</div>
            <div>Requests</div>
          </div>
          <div class="chart-wrapper mt-3 mx-3" style="height:70px;">
            <canvas class="chart" id="card-chart4" height="70"></canvas>
          </div>
        </div>
      </div>
      <!-- /.col-->
    </div>
    <!-- /.row-->
    
        <!-- /.row-->
      
     
    <!-- /.card-->
    <!-- /.row-->
  </div>
</div>
@endsection
