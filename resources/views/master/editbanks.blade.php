@extends('html.default')

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" crossorigin="anonymous">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
@section('content')
<div class="body-content__header">
    <ul>
        <li><a href="#">Edit Bank</a></li>
    </ul>
</div>

<div class="body-content__wrapper">
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
              <div class="col-md-6">
                <div class="form-col">
                  <label for="name">Bank Name</label>
                  <input type="text" class="form-control" id="name" name="name" value="{{ $bank->name }}" placeholder="Enter Bank Name..." required>
                </div>
              </div>

              <div class="col-md-1 col-form-label d-flex align-items-center">
                <div class="form-check form-switch">
                  <input type="checkbox" class="form-check-input" id="flexSwitchCheckDefault" name="active" value="1" {{ $bank->active ? 'checked' : '' }}>
                  <label class="form-check-label" for="flexSwitchCheckDefault">Active</label>
                </div>
              </div>
            </div>

          </div>

          <div class="card-footer">
            <div class="d-flex justify-content-end">
              <button type="submit" class="btn btn-success" style="padding:10px 20px; font-size:16px; min-width:100px;">Update</button>
              <a href="{{ route('master.banks') }}" class="btn btn-danger" style="padding:10px 20px; font-size:16px; min-width:100px;">Back</a>
            </div>
          </div>
        </form>
      </div>

    </div>
  </div>
</div>
@endsection
