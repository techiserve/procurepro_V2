@extends('stack.layouts.admin')

@section('content')
<div class="content-body">
                <!-- fitness target -->
                <div class="row" style="margin-top: 120px;">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-content">
                                <div class="row" style="width:100%;">
                                    <div class="col-xl-3 col-lg-6 col-md-12 border-right-blue-grey border-right-lighten-5">
                                        <div class="my-1 text-center">
                                            <div class="card-header mb-2 pt-0">
                                                <h5 class="primary">Requisitions Requested</h5>
                                                <h3 class="font-large-2 text-bold-200">{{$requisitions}}</h3>
                                            </div>
                                            <div class="card-content">
                                                <input type="text" value="65" class="knob hide-value responsive angle-offset" data-angleOffset="40" data-thickness=".15" data-linecap="round" data-width="130" data-height="130" data-inputColor="#BABFC7" data-readOnly="true" data-fgColor="#00B5B8" data-knob-icon="icon-star">
                                                <ul class="list-inline clearfix pt-1 mb-0">
                                                    <li class="border-right-grey border-right-lighten-2 pr-2">
                                                     
                                                    </li>
                                                    <li class="pl-2">
                                                   
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-xl-3 col-lg-6 col-md-12 border-right-blue-grey border-right-lighten-5">
                                        <div class="my-1 text-center">
                                            <div class="card-header mb-2 pt-0">
                                                <h5 class="danger">Pending Requisitions</h5>
                                                <h3 class="font-large-2 text-bold-200">{{$departments}}<span class="font-medium-1 grey darken-1 text-bold-400"></span></h3>
                                            </div>
                                            <div class="card-content">
                                                <input type="text" value="70" class="knob hide-value responsive angle-offset" data-angleOffset="0" data-thickness=".15" data-linecap="round" data-width="130" data-height="130" data-inputColor="#BABFC7" data-readOnly="true" data-fgColor="#FF7588" data-knob-icon="icon-pointer">
                                                <ul class="list-inline clearfix pt-1 mb-0">
                                                    <li>
                                                   
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-xl-3 col-lg-6 col-md-12 border-right-blue-grey border-right-lighten-5">
                                        <div class="my-1 text-center">
                                            <div class="card-header mb-2 pt-0">
                                                <h5 class="warning">Purchase Orders</h5>
                                                <h3 class="font-large-2 text-bold-200">{{$purchaseorders}}<span class="font-medium-1 grey darken-1 text-bold-400"></span></h3>
                                            </div>
                                            <div class="card-content">
                                                <input type="text" value="81" class="knob hide-value responsive angle-offset" data-angleOffset="20" data-thickness=".15" data-linecap="round" data-width="130" data-height="130" data-inputColor="#BABFC7" data-readOnly="true" data-fgColor="#FFA87D" data-knob-icon="icon-briefcase">
                                                <ul class="list-inline clearfix pt-1 mb-0">
                                                    <li>
                                                       
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-xl-3 col-lg-6 col-md-12">
                                        <div class="my-1 text-center">
                                            <div class="card-header mb-2 pt-0">
                                                <h5 class="success">Pending Purchase Orders</h5>
                                                <h3 class="font-large-2 text-bold-200">{{$userCount}} <span class="font-medium-1 grey darken-1 text-bold-400"></span></h3>
                                            </div>
                                            <div class="card-content">
                                                <input type="text" value="75" class="knob hide-value responsive angle-offset" data-angleOffset="20" data-thickness=".15" data-linecap="round" data-width="130" data-height="130" data-inputColor="#BABFC7" data-readOnly="true" data-fgColor="#16D39A" data-knob-icon="icon-user">
                                                <ul class="list-inline clearfix pt-1 mb-0">
                                                    <li>
                                          
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


