@extends('html.default')
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
@section('content')
<div class="container-fluid">
  <div class="animated fadeIn">
    <div class="row">
      <div class="col-sm-12">

        <!-- Edit Classification Form -->
        <form method="POST" action="{{ route('classifications.update', $classification->id) }}">
          @csrf
          @method('PUT')
          <div class="card">
            <div class="card-header">
              <strong>Update Classification of Expense</strong>
            </div>

            <div class="card-body">
              <div class="row">
                <div class="col-sm-6">
                  <div class="form-group">
                    <label for="name">Classification Name</label>
                    <input type="text" class="form-control" id="name" name="name" value="{{ $classification->name }}" required>
                  </div>
                </div>

                <div class="col-sm-6">
                  <div class="form-group" style="margin-top: 34px;">
                    <div class="checkbox">
                      <label>
                        <input type="checkbox" name="active" value="1" {{ $classification->active ? 'checked' : '' }}> Active
                      </label>
                    </div>
                  </div>
                </div>
              </div>
            </div>

            <div class="card-footer">
              <button type="submit" class="btn btn-success">Update</button>
              <a href="{{ route('classifications.create') }}" class="btn btn-secondary">Back</a>
            </div>
          </div>
        </form>

      </div>
    </div>
  </div>
</div>
@endsection

