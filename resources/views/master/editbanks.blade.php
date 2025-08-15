@extends('html.default')

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" crossorigin="anonymous">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>

@section('content')
<div class="container-fluid">
  <div class="animated fadeIn">

    <div class="row">
      <div class="col-sm-12">

        <div class="card">
          <div class="card-header">
            <strong>Edit Bank</strong>
          </div>

          <div class="card-body">
            <form method="POST" action="{{ route('bank.update', $bank->id) }}">
              @csrf
              @method('PUT')

              <div class="row">
                <div class="col-sm-6">
                  <div class="form-group">
                    <label for="name">Bank Name</label>
                    <input type="text" class="form-control" id="name" name="name" value="{{ $bank->name }}" required>
                  </div>
                </div>

                <div class="col-sm-6">
                  <div class="form-group" style="margin-top: 34px;">
                    <div class="form-check form-switch">
                      <input type="checkbox" class="form-check-input" id="flexSwitchCheckDefault" name="active" value="1" {{ $bank->active ? 'checked' : '' }}>
                      <label class="form-check-label" for="defaultCheck1">Active</label>
                    </div>
                  </div>
                </div>
              </div>

              <div class="form-group mt-3">
                <button type="submit" class="btn btn-success">Update</button>
                <a href="{{ route('master.banks') }}" class="btn btn-secondary">Back</a>
              </div>

            </form>
          </div>

        </div>
      </div>
    </div>

  </div>
</div>
@endsection
