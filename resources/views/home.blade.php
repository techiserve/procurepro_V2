@extends('html.default')

@section('content')  
<div class="requisition-requested d-flex justify-content-between flex-wrap" 
     style="background: #f4f5f8; width: 100%; padding: 0px;">

    <!-- Item 1 -->
    <div class="requisition-requested-item flex-fill" 
         style="background: #f5f6fa;">
        <div class="requisition-requested-item__wrapper" style="background: #f5f6fa;">
            <div class="requisition-requested-item__content">
                <h3>Requisition Requested</h3>
                <h4>{{$requisitions}}</h4>
                <ul>
                    <li>10% less than last week</li>
                </ul>
            </div>
            <div class="requisition-requested-item__image">
                <img src="assets/img/requisition-requested-img.png" alt="">
            </div>
        </div>
    </div>

    <!-- Item 2 -->
    <div class="requisition-requested-item flex-fill" 
         style="background: #f5f6fa;">
        <div class="requisition-requested-item__wrapper" style="background: #f5f6fa;">
            <div class="requisition-requested-item__content">
                <h3>Pending Requisitions</h3>
                <h4>{{$departments}}</h4>
                <ul>
                    <li>5% more than last week</li>
                </ul>
            </div>
            <div class="requisition-requested-item__image">
                <img src="assets/img/requisition-requested-img.png" alt="">
            </div>
        </div>
    </div>

    <!-- Item 3 -->
    <div class="requisition-requested-item flex-fill" 
         style="background: #f5f6fa;">
        <div class="requisition-requested-item__wrapper" style="background: #f5f6fa;">
            <div class="requisition-requested-item__content">
                <h3>Purchase Orders</h3>
                <h4>{{$purchaseorders}}</h4>
                <ul>
                    <li>No change from last week</li>
                </ul>
            </div>
            <div class="requisition-requested-item__image">
                <img src="assets/img/requisition-requested-img.png" alt="">
            </div>
        </div>
    </div>

    <!-- Item 4 -->
    {{-- <div class="requisition-requested-item flex-fill" 
         style="background: #f5f6fa;">
        <div class="requisition-requested-item__wrapper" style="background: #f5f6fa;">
            <div class="requisition-requested-item__content">
                <h3>Pending Purchase Orders</h3>
                <h4>{{$userCount}}</h4>
                <ul>
                    <li>20% more than last week</li>
                </ul>
            </div>
            <div class="requisition-requested-item__image">
                <img src="assets/img/requisition-requested-img.png" alt="">
            </div>
        </div>
    </div> --}}

</div>                             
@endsection


{{-- 
@extends('html.default')

@section('content')
 <div class="body-content__header">
                <ul>
                    <li><a href="#">Spend Overview Report</a></li>
                </ul>
            </div>
            <div class="body-content__wrapper reporting-body">
                <div class="report-top-bar">
                    <div class="row report-top-bar_flex">
                        <div class="col-md-6 col-xl-3 report-top-col">
                            <div class="row report-top-inner">
                                <div class="col-md-6 report-inner-col date-col">
                                    <input type="tel" placeholder="Date from">
                                </div>
                                <div class="col-md-6 report-inner-col date-col">
                                    <input type="tel" placeholder="Date to">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12 col-xl-7 report-top-col">
                            <div class="row report-top-inner">
                                <div class="col-md-6 report-inner-col">
                                    <div class="select-box-item">
                                        <label for="">Classification of expenses</label>
                                        <select name="">
                                            <option value="">--Select--</option>
                                            <option value="">Option 01</option>
                                            <option value="">Option 01</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6 report-inner-col">
                                    <div class="select-box-item">
                                        <label for="">Department</label>
                                        <select name="">
                                            <option value="">--Select--</option>
                                            <option value="">Option 01</option>
                                            <option value="">Option 01</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 col-xl-2 report-top-col">
                            <div class="save-cancel-btn">
                                <button class="btn btn-primary">Save</button>
                                <button class="btn btn-danger">Cancel</button>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="report-chart">
                    <div class="row report-chart-flex">
                        <div class="col-lg-6">
                            <div class="report-chart-box">
                                <h4>Spend To Date</h4>
                                <div class="report-chart-cards">
                                    <h6># Invoice amount by date
                                        <select class="select-month">
                                            <option>JUNE</option>
                                            <option>JUNE</option>
                                            <option>JUNE</option>
                                        </select>
                                    </h6>
                                    <canvas id="spendToDate"></canvas>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="report-chart-box">
                                <h4>Spend By Classification</h4>
                                <div class="report-chart-cards">
                                    <h6># Product For School </h6>
                                    <canvas id="classification"></canvas>
                                    <img src="assets/img/chart-bg.png" alt="" class="chart-bg">
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="report-chart-box">
                                <h4>Spend By Vendor</h4>
                                <div class="report-chart-cards">
                                    <h6># Invoice amount by date
                                        <select class="select-month">
                                            <option>JUNE</option>
                                            <option>JUNE</option>
                                            <option>JUNE</option>
                                        </select>
                                    </h6>
                                    <canvas id="vendorSpend"></canvas>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="report-chart-box">
                                <h4>Department Spend</h4>
                                <div class="report-chart-cards">
                                    <h6># Product For School </h6>
                                    <canvas id="departmentSpend"></canvas>
                                    <img src="assets/img/chart-bg.png" alt="" class="chart-bg">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
@endsection --}}
