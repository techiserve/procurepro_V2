@extends('html.default')

@section('content')  
<div class="requisition-requested d-flex justify-content-between gap-3 flex-wrap" 
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
    <div class="requisition-requested-item flex-fill" 
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
    </div>

</div>                             
@endsection
