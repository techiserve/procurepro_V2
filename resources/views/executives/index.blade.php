@extends('html.default')

@section('content')
<div class="body-content__header">
  <ul>
    <li><a href="#">Executives</a></li>
  </ul>
</div>

<div class="body-content__wrapper">
  <div class="row">
    <div class="col-12">
      <div class="card">
        <div class="card-header">
          <strong>Executives</strong> <small>List</small>
        </div>

        <div class="card-body">
          <div class="table-responsive">
            <table class="table table-striped table-bordered zero-configuration">
              <thead>
                <tr>
                  <th>#</th>
                  <th>Executive Name</th>
                  <th>Username</th>
                  <th>Address</th>
                  <th class="text-center">Email</th>
                  <th class="text-center">Status</th>
                  <th class="text-center">Action</th>
                </tr>
              </thead>
              <tbody>
                @foreach($executives as $executive)
                <tr>
                  <td></td>
                  <td>{{$executive->name}}</td>
                  <td>{{$executive->userName}}</td>
                  <td>{{$executive->address}}</td>
                  <td class="text-center">{{$executive->email}}</td>
                  <td class="text-center">
                    @if($executive->IsActive == null)
                      <span class='btn btn-outline-secondary'>Inactive</span>
                    @else
                      <span class='btn btn-outline-success'>Active</span>
                    @endif
                  </td>
                  <td class="text-center">
                    <a href='/executives/{{$executive->id}}/edit' class='btn btn-success btn-sm'>
                      <span class='fa fa-desktop'></span>
                      <span class='hidden-sm hidden-sm hidden-md'>Edit</span>
                    </a>&nbsp;

                    <!-- Delete button wired to delegated SweetAlert handler -->
                    <a href='/executives/{{$executive->id}}/delete' class='btn btn-danger btn-sm js-delete-executive' data-delete-url='/executives/{{$executive->id}}/delete' style='color: white;'>
                      <span class='fa fa-pencil'></span>
                      <span class='hidden-sm hidden-sm hidden-md'> Delete</span>
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
    var btn = e.target.closest('.js-delete-executive');
    if(!btn) return;
    e.preventDefault();
    var url = btn.getAttribute('data-delete-url') || btn.getAttribute('href');
    ensureSwal(function(){
      Swal.fire({
        title: 'Delete Executive?',
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

