@extends('coreui.layouts.admin')

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>

@section('content')
<div class="container-fluid">
  <div class="animated fadeIn">
    <div class="row">
      <div class="col-sm-12">
        
       <form method="post" action="/role/update/{{$role->id}}" name="add_name" id="">
       @csrf
       @method('put')
        <div class="card">
          <div class="card-header">
            <strong>Executive Registration</strong>
            <a href="/growers/" class="btn btn-primary btn-sm pull-right"><i style="color:white;" class="fa fa-align-justify"></i> Users List</a>
          </div>

          <div class="card-body">
            <div class="row">
              <div class="col-sm-6">
                <div class="form-group">
                  <label for="grower_nam">Role Name</label>
                  <input class="form-control" id="grower_nam" name="roleName" value="{{$role->name}}"  type="text" placeholder="Enter Role Name">
                </div>
              </div>

              <div class="col-sm-6">
                <div class="form-group">
                  <label for="province">Description</label>
                  <textarea class="form-control" id="exampleFormControlTextarea1" value="{{$role->description}}" name="description" rows="3">{{$role->description}}</textarea>
                </div>
              </div>
            </div>
            <!-- /.row-->

            <hr style="border-color: black;">
			<br>
            <nav>
            <div class="nav nav-tabs" id="nav-tab" role="tablist">
                <a class="nav-item nav-link active" id="nav-home-tab" data-toggle="tab" href="#nav-1" role="tab" aria-controls="nav-1" aria-selected="true">Users</a>
                <a class="nav-item nav-link" id="nav-profile-tab" data-toggle="tab" href="#nav-2" role="tab" aria-controls="nav-2" aria-selected="false">Vendor Management</a>
                <a class="nav-item nav-link" id="nav-contact-tab" data-toggle="tab" href="#nav-3" role="tab" aria-controls="nav-3" aria-selected="false">Approval Level</a>
                <a class="nav-item nav-link" id="nav-home-tab" data-toggle="tab" href="#nav-4" role="tab" aria-controls="nav-4" aria-selected="false ">Configuration</a>
                <a class="nav-item nav-link" id="nav-profile-tab" data-toggle="tab" href="#nav-5" role="tab" aria-controls="nav-5" aria-selected="false">Reports</a>
                <a class="nav-item nav-link" id="nav-contact-tab" data-toggle="tab" href="#nav-6" role="tab" aria-controls="nav-6" aria-selected="false">Procurement</a>
            </div>
            </nav>
            <div class="tab-content" id="nav-tabContent">
            <!-- User Management -->
            <div class="tab-pane fade show active" id="nav-1" role="tabpanel" aria-labelledby="nav-home-tab">
              <ul class="list-group">
              <li class="list-group-item d-flex justify-content-between align-items-center" style="background-color:#edf2f4;">
                Add New User

                @php  $newuser = 'Add New User'; @endphp
                <div class="form-check form-switch">
                <input class="form-check-input" type="checkbox" role="switch" name="addnewuser" value="Add New User"  id="flexSwitchCheckDefault" 
                 @if(in_array($newuser , $permissions)) checked @endif />       
                </div> 
                </li>
                <li class="list-group-item d-flex justify-content-between align-items-center">
                Manage Users

                @php  $newuser = 'Manage Users'; @endphp
                <div class="form-check form-switch">
                <input class="form-check-input" type="checkbox" role="switch" name="manageusers"  value="Manage Users"  id="flexSwitchCheckDefault" 
                @if(in_array($newuser , $permissions)) checked @endif />   
                </div>
                </li>
        
                </ul>
            </div>
            <!-- End of User Management -->
            
             <!-- Start of Vendor Management -->
            <div class="tab-pane fade" id="nav-2" role="tabpanel" aria-labelledby="nav-profile-tab">
                <ul class="list-group">
                <li class="list-group-item d-flex justify-content-between align-items-center" style="background-color:#edf2f4;">
                Request New Vendor

                @php  $newuser = 'Request New Vendor'; @endphp
                    <div class="form-check form-switch">
                <input class="form-check-input" type="checkbox" role="switch" name="requestnewvendor"  value="Request New Vendor" id="flexSwitchCheckDefault" 
                @if(in_array($newuser , $permissions)) checked @endif />   
                
                </div> 
                </li>
                <li class="list-group-item d-flex justify-content-between align-items-center">
                    Pending Requests

                    @php  $newuser = 'Pending Requests'; @endphp
                    <div class="form-check form-switch">
                <input class="form-check-input" type="checkbox" role="switch" name="pendingrequests" value="Pending Requests"  id="flexSwitchCheckDefault" 
                @if(in_array($newuser , $permissions)) checked @endif />   

                </div>
                </li>
                </li>
                <li class="list-group-item d-flex justify-content-between align-items-center" style="background-color:#edf2f4;">
                    Manage Vendors

                    @php  $newuser = 'Manage Vendors'; @endphp
                    <div class="form-check form-switch">
                <input class="form-check-input" type="checkbox" role="switch"  name="managevendors" value="Manage Vendors" id="flexSwitchCheckDefault" 
                @if(in_array($newuser , $permissions)) checked @endif />   

                </div>
                </li>
                </li>
                <li class="list-group-item d-flex justify-content-between align-items-center">
                   My Requests

                   @php  $newuser = 'My Requests'; @endphp
                    <div class="form-check form-switch">
                <input class="form-check-input" type="checkbox" role="switch"  name="myrequests" value="My Requests"  id="flexSwitchCheckDefault" 
                @if(in_array($newuser , $permissions)) checked @endif />   

                </div>
                </li>
                </li>
                <li class="list-group-item d-flex justify-content-between align-items-center" style="background-color:#edf2f4;">
                    Vendor Request Approval

                    @php  $newuser = 'Vendor Request Approval'; @endphp
                    <div class="form-check form-switch">
                <input class="form-check-input" type="checkbox" role="switch" name="vendorrequestapproval" value="Vendor Request Approval"  id="flexSwitchCheckDefault" 
                @if(in_array($newuser , $permissions)) checked @endif />   

                </div>
                </li>
       
               </ul>
            </div>
             <!-- End of vendor Management -->

             <!-- start of approval Management -->
            <div class="tab-pane fade" id="nav-3" role="tabpanel" aria-labelledby="nav-contact-tab">
            <ul class="list-group">
                <li class="list-group-item d-flex justify-content-between align-items-center" style="background-color:#edf2f4;">
                First Line Approval

                @php  $newuser = 'First Line Approval'; @endphp
                    <div class="form-check form-switch">
                <input class="form-check-input" type="checkbox" role="switch" name="firstlineapproval" value="First Line Approval"  id="flexSwitchCheckDefault" 
                @if(in_array($newuser , $permissions)) checked @endif />   
                
                </div> 
                </li>
                <li class="list-group-item d-flex justify-content-between align-items-center">
                    Second Line Approval

                    @php  $newuser = 'Second Line Approval'; @endphp
                    <div class="form-check form-switch">
                <input class="form-check-input" type="checkbox" role="switch"  name="secondlineapproval" value="Second Line Approval"  id="flexSwitchCheckDefault" 
                @if(in_array($newuser , $permissions)) checked @endif />   

                </div>
                </li>
                </li>
                <li class="list-group-item d-flex justify-content-between align-items-center" style="background-color:#edf2f4;">
                Third Line Approval

                @php  $newuser = 'Third Line Approval'; @endphp
                    <div class="form-check form-switch">
                <input class="form-check-input" type="checkbox" role="switch" name="thirdlineapproval" value="Third Line Approval"  id="flexSwitchCheckDefault" 
                @if(in_array($newuser , $permissions)) checked @endif />   

                </div>
                </li>
                </li>
                <li class="list-group-item d-flex justify-content-between align-items-center">
                Fourth Line Approval

                @php  $newuser = 'Fourth Line Approval'; @endphp
                    <div class="form-check form-switch">
                <input class="form-check-input" type="checkbox" role="switch" name="fourthlineapproval" value="Fourth Line Approval"  id="flexSwitchCheckDefault" 
                @if(in_array($newuser , $permissions)) checked @endif />   

                </div>
                </li>
                </li>
                <li class="list-group-item d-flex justify-content-between align-items-center" style="background-color:#edf2f4;">
                Fiveth Line Approval

                @php  $newuser = 'Fiveth Line Approval'; @endphp
                    <div class="form-check form-switch">
                <input class="form-check-input" type="checkbox" role="switch" name="fivethlineapproval" value="Fiveth Line Approval"  id="flexSwitchCheckDefault" 
                @if(in_array($newuser , $permissions)) checked @endif />   

                </div>
                </li>
       
               </ul>
            </div>
             <!-- End of approval Management -->

             <!-- start of config Management -->
            <div class="tab-pane fade" id="nav-4" role="tabpanel" aria-labelledby="nav--tab">
            <ul class="list-group">
                <li class="list-group-item d-flex justify-content-between align-items-center" style="background-color:#edf2f4;">
                Master Pages

                @php  $newuser = 'Master Pages'; @endphp
                    <div class="form-check form-switch">
                <input class="form-check-input" type="checkbox" role="switch" name="masterpages" value="Master Pages"  id="flexSwitchCheckDefault" 
                @if(in_array($newuser , $permissions)) checked @endif />   
                
                </div> 
                </li>
       
               </ul>
            </div>
             <!-- End of config Management -->

             <!-- start of procurement Management -->
            <div class="tab-pane fade" id="nav-5" role="tabpanel" aria-labelledby="nav-profile-tab">
            <ul class="list-group">
                <li class="list-group-item d-flex justify-content-between align-items-center" style="background-color:#edf2f4;">
                Reports

                @php  $newuser = 'Reports'; @endphp
                    <div class="form-check form-switch">
                <input class="form-check-input" type="checkbox" role="switch" name="reports" value="Reports"  id="flexSwitchCheckDefault" 
                @if(in_array($newuser , $permissions)) checked @endif />   
                
                </div> 
                </li>               
               </ul>
            </div>
             <!-- End of procurement Management -->

             <!-- start of Reports Management -->
            <div class="tab-pane fade" id="nav-6" role="tabpanel" aria-labelledby="nav-contact-tab">
                <ul class="list-group">
                <ul class="list-group">
                <li class="list-group-item d-flex justify-content-between align-items-center" style="background-color:#edf2f4;">
                Create Purchase Requistion

                @php  $newuser = 'Create Purchase Requistion'; @endphp
                    <div class="form-check form-switch">
                <input class="form-check-input" type="checkbox" role="switch" name="createpurchaserequistion" value="Create Purchase Requistion"  id="flexSwitchCheckDefault" 
                @if(in_array($newuser , $permissions)) checked @endif />   
                
                </div> 
                </li>
                <li class="list-group-item d-flex justify-content-between align-items-center">
                View Requisitions

                @php  $newuser = 'View Requisitions'; @endphp
                    <div class="form-check form-switch">
                <input class="form-check-input" type="checkbox" role="switch" name="viewrequisitions" value="View Requisitions"  id="flexSwitchCheckDefault" 
                @if(in_array($newuser , $permissions)) checked @endif />   

                </div>
                </li>
                </li>
                <li class="list-group-item d-flex justify-content-between align-items-center" style="background-color:#edf2f4;">
                View Purchase Orders

                @php  $newuser = 'View Purchase Orders'; @endphp
                    <div class="form-check form-switch">
                <input class="form-check-input" type="checkbox" role="switch"  name="viewpurchaseorders" value="View Purchase Orders"  id="flexSwitchCheckDefault" 
                @if(in_array($newuser , $permissions)) checked @endif />   
                </div>
                </li>
                </li>
                <li class="list-group-item d-flex justify-content-between align-items-center">
                Manage Purchase Orders

                @php  $newuser = 'Manage Purchase Orders'; @endphp
                <div class="form-check form-switch">
                <input class="form-check-input" type="checkbox" role="switch"  name="managepurchaseorders" value="Manage Purchase Orders"  id="flexSwitchCheckDefault" 
                @if(in_array($newuser , $permissions)) checked @endif />   
                </div>
                </li>
                </li>                 
               </ul>
            </div>
             <!-- End of Reports Management -->
            </div>
          </div>
          <div class="card-footer">
            <div class="form-group pull-right">
    				<input type="submit" class="btn btn-success" value="Edit Role"/>
    				<input type="reset" class="btn btn-danger" value="Cancel Editing"/>
    			</div>
          </div>
       </div>
      </form>
     </div>
    </div>

   </div>
</div>
@endsection

