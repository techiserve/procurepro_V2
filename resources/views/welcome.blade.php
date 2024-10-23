@extends('stack.layouts.admin')

@section('content')
<div class="content-body">
                <!-- fitness target -->
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-content">
                                <div class="row" style="width:100%;">
                                    <div class="col-xl-3 col-lg-6 col-md-12 border-right-blue-grey border-right-lighten-5">
                                        <div class="my-1 text-center">
                                            <div class="card-header mb-2 pt-0">
                                                <h5 class="primary">Total Requisition Requested</h5>
                                                <h3 class="font-large-2 text-bold-200">326</h3>
                                            </div>
                                            <div class="card-content">
                                                <input type="text" value="65" class="knob hide-value responsive angle-offset" data-angleOffset="40" data-thickness=".15" data-linecap="round" data-width="130" data-height="130" data-inputColor="#BABFC7" data-readOnly="true" data-fgColor="#00B5B8" data-knob-icon="icon-trophy">
                                                <ul class="list-inline clearfix pt-1 mb-0">
                                                    <li class="border-right-grey border-right-lighten-2 pr-2">
                                                        <h2 class="grey darken-1 text-bold-400">65%</h2>
                                                        <span class="primary"><span class="feather icon-arrow-up"></span>
                                                            Completed</span>
                                                    </li>
                                                    <li class="pl-2">
                                                        <h2 class="grey darken-1 text-bold-400">35%</h2>
                                                        <span class="danger"><span class="feather icon-arrow-down"></span>
                                                            Remaining</span>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-xl-3 col-lg-6 col-md-12 border-right-blue-grey border-right-lighten-5">
                                        <div class="my-1 text-center">
                                            <div class="card-header mb-2 pt-0">
                                                <h5 class="danger">Departments</h5>
                                                <h3 class="font-large-2 text-bold-200">7<span class="font-medium-1 grey darken-1 text-bold-400"></span></h3>
                                            </div>
                                            <div class="card-content">
                                                <input type="text" value="70" class="knob hide-value responsive angle-offset" data-angleOffset="0" data-thickness=".15" data-linecap="round" data-width="130" data-height="130" data-inputColor="#BABFC7" data-readOnly="true" data-fgColor="#FF7588" data-knob-icon="icon-pointer">
                                                <ul class="list-inline clearfix pt-1 mb-0">
                                                    <li>
                                                        <h2 class="grey darken-1 text-bold-400">10</h2>
                                                        <span class="danger">Miles Today's Target</span>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-xl-3 col-lg-6 col-md-12 border-right-blue-grey border-right-lighten-5">
                                        <div class="my-1 text-center">
                                            <div class="card-header mb-2 pt-0">
                                                <h5 class="warning">Purchase Orders</h5>
                                                <h3 class="font-large-2 text-bold-200">40<span class="font-medium-1 grey darken-1 text-bold-400"></span></h3>
                                            </div>
                                            <div class="card-content">
                                                <input type="text" value="81" class="knob hide-value responsive angle-offset" data-angleOffset="20" data-thickness=".15" data-linecap="round" data-width="130" data-height="130" data-inputColor="#BABFC7" data-readOnly="true" data-fgColor="#FFA87D" data-knob-icon="icon-energy">
                                                <ul class="list-inline clearfix pt-1 mb-0">
                                                    <li>
                                                        <h2 class="grey darken-1 text-bold-400">5000</h2>
                                                        <span class="warning">kcla Today's Target</span>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-xl-3 col-lg-6 col-md-12">
                                        <div class="my-1 text-center">
                                            <div class="card-header mb-2 pt-0">
                                                <h5 class="success">Users</h5>
                                                <h3 class="font-large-2 text-bold-200">12 <span class="font-medium-1 grey darken-1 text-bold-400"></span></h3>
                                            </div>
                                            <div class="card-content">
                                                <input type="text" value="75" class="knob hide-value responsive angle-offset" data-angleOffset="20" data-thickness=".15" data-linecap="round" data-width="130" data-height="130" data-inputColor="#BABFC7" data-readOnly="true" data-fgColor="#16D39A" data-knob-icon="icon-heart">
                                                <ul class="list-inline clearfix pt-1 mb-0">
                                                    <li>
                                                        <h2 class="grey darken-1 text-bold-400">125</h2>
                                                        <span class="success">BPM Highest</span>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
</div>
@endsection


