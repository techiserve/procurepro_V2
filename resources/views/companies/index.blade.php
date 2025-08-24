@extends('html.default')

@section('content')
<div class="body-content__header">
  <ul>
    <li><a href="#">Companies</a></li>
  </ul>
</div>

<div class="body-content__wrapper">
  <div class="row">
    <div class="col-12">
      <div class="card">
        <div class="card-header">
          <strong>Companies</strong>
        </div>

        <div class="card-body">
          <div class="table-responsive">
            <table class="table table-striped table-bordered zero-configuration">
              <thead>
                <tr>
                  <th>Company Name</th>
                  <th>Domain</th>
                  <th>Contact Person</th>
                  <th class="text-center">Email</th>
                  <th class="text-center">Status</th>
                  <th class="text-center">Action</th>
                </tr>
              </thead>
              <tbody>
                @foreach($companies as $company)
                <tr>
                  <td>{{$company->name}}</td>
                  <td>{{$company->domain}}</td>
                  <td>{{$company->contactPerson}}</td>
                  <td class="text-center">{{$company->email}}</td>
                  <td class="text-center">
                    @if($company->IsActive == null)
                      <span class='btn btn-outline-secondary'>Inactive</span>
                    @else
                      <span class='btn btn-outline-success'>Active</span>
                    @endif
                  </td>
                  <td class="text-center">
                    <a href='/company/{{$company->id}}/edit' class='btn btn-success btn-sm'>
                      <span class='fa fa-desktop'></span>
                      <span class='hidden-sm hidden-sm hidden-md'>Edit</span>
                    </a>&nbsp;

                    <!-- Delete button uses data-url and delegated JS handler below -->
                    <a href='/company/{{$company->id}}/delete' class='btn btn-danger btn-sm js-delete-company' data-delete-url='/company/{{$company->id}}/delete' style='color: white;'>
                      <span class='fa fa-pencil'></span>
                      <span class='hidden-sm hidden-sm hidden-md'> Delete</span>
                    </a>&nbsp;

                    <a href='/company/{{$company->id}}/manageReports' class='btn btn-info btn-sm'>
                      <span class='fa fa-bank'></span>
                      <span class='hidden-sm hidden-sm hidden-md'>Configure Reports</span>
                    </a>&nbsp;
                  </td>
                </tr>
                @endforeach
              </tbody>
            </table>
          </div>
        </div>

      </div>
    </div>
  </div>
</div>
@endsection


<script>
(function() {
  function ensureSwal(cb){
    if (window.Swal) { cb(); return; }
    var s=document.createElement('script');
    s.src='https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.all.min.js';
    s.onload=cb; document.head.appendChild(s);
  }
  document.addEventListener('click', function(e){
    var btn = e.target.closest('.js-delete-company');
    if(!btn) return;
    e.preventDefault();
    var url = btn.getAttribute('data-delete-url') || btn.getAttribute('href');
    ensureSwal(function(){
      Swal.fire({
        title: 'Delete Company?',
        text: "You won't be able to undo this!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Continue',
        cancelButtonText: 'Cancel'
      }).then(function(result){
        if(result.isConfirmed){
          window.location.href = url;
        }
      });
    });
  });
})();
</script>

