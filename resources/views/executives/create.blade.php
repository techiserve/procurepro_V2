@extends('html.default')

@section('content')
<div class="body-content__header">
  <ul>

    <li><a href="#">Executive Registration</a></li>
    
  </ul>
</div>

<div class="body-content__wrapper">
  <div class="row">
    <div class="col-12">

      <form method="post" action="/executives/store" name="add_name" id="multiple_assign">
        @csrf
        <div class="card">
          <div class="card-header">
            <strong>Executive Registration</strong>
          </div>

          <div class="card-body">
            <!-- Row 1 -->
            <div class="row">
              <div class="col-md-6"><br>
                <div class="form-col">
                  <label for="grower_nam">Executive Name</label>
                  <input class="form-control" id="grower_nam" name="executiveName" type="text" placeholder="Executive Name">
                </div>
              </div>

              <div class="col-md-6"><br>
                <div class="form-col">
                  <label for="username">Username</label>
                  <input class="form-control" id="username" name="username" type="text" placeholder="Username">
                </div>
              </div>
            </div>

            <!-- Row 2 -->
            <div class="row">
              <div class="col-md-6">
                <div class="form-col">
                  <label for="grower_address">Password</label>
                  <input class="form-control" id="grower_address" name="password" type="password" placeholder="Password">
                </div>
              </div>

              <div class="col-md-6">
                <div class="form-col">
                  <label for="grower_address">Confirm Password</label>
                  <input class="form-control" id="grower_address" name="confirmPassword" type="password" placeholder="Confirm Password">
                </div>
              </div>
            </div>

            <!-- Row 3 -->
            <div class="row">
              <div class="col-md-6">
                <div class="form-col">
                  <label for="national_id">Email</label>
                  <input class="form-control" id="national_id" name="email" type="email" placeholder="Email">
                </div>
              </div>

              <div class="col-md-6">
                <div class="form-col">
                  <label for="exampleFormControlTextarea1">Address</label>
                  <textarea class="form-control" id="exampleFormControlTextarea1" name="address" rows="3"></textarea>
                </div>
              </div>
            </div>

            <hr style="border-color: black;">

            <!-- Companies selection table -->
            <div class="row">
              <div class="col-12">
                <div class="form-col">
                  <label><strong>Select Companies</strong></label>
                  <div class="table-responsive">
                    <table class="table table-bordered table-striped">
                      <thead>
                        <tr>
                          <th style="width: 50px;"><input type="checkbox" id="select-all"></th>
                          <th>Company Name</th>
                          <th>Email</th>
                          <th>Location</th>
                        </tr>
                      </thead>
                      <tbody>
                        @foreach($companies as $company)
                        <tr>
                          <td>
                            <input type="checkbox" name="company_ids[]" value="{{ $company->id }}" class="company-checkbox">
                          </td>
                          <td>{{ $company->name }}</td>
                          <td>{{ $company->email }}</td>
                          <td>{{ $company->contactPerson }}</td>
                        </tr>
                        @endforeach
                      </tbody>
                    </table>
                  </div>
                </div>
              </div>
            </div>

          </div>

          <div class="card-footer">
            <div class="d-flex justify-content-end" style="gap: 10px;">
              <input type="submit" class="btn btn-success" value="Save" style="padding:10px 20px; font-size:16px; min-width:100px;"/>
              <input type="reset" class="btn btn-danger" value="Cancel" style="padding:10px 20px; font-size:16px; min-width:100px;"/>
            </div>
          </div>

        </div>
      </form>

    </div>
  </div>
</div>
@endsection

<script>
  $(document).ready(function () {
    $('#select-all').click(function () {
      $('.company-checkbox').prop('checked', this.checked);
    });
  });
</script>
