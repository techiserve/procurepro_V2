@extends('html.default')

@section('content')
<div class="body-content__header">
    <ul>
        <li><a href="#">Vendor Type Edit</a></li>
    </ul>
</div>

<div class="body-content__wrapper requesition-body">
    <form method="POST" action="/vendortype/update/{{$vendor->id}}" enctype="multipart/form-data">
        @method('PUT')
        @csrf
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <strong>Edit Vendor Type</strong>
                <a href="{{ route('vendor-types.index') }}" class="btn btn-primary btn-sm">
                    <i class="fa fa-list"></i> Vendor Type List
                </a>
            </div>

            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="name">Name</label>
                            <input class="form-control" id="name" name="name" value="{{ $vendor->name }}" type="text" required>
                        </div>
                    </div>

                    <div class="col-md-6 d-flex align-items-center">
                        <div class="form-check mt-2">
                            <input class="form-check-input" type="checkbox" id="active" name="active" value="1" @if($vendor->active) checked @endif>
                            <label class="form-check-label" for="active">
                                Active
                            </label>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card-footer d-flex justify-content-end">
                <a href="{{ route('vendor-types.index') }}" class="btn btn-secondary me-2">Cancel</a>
                <button type="submit" class="btn btn-primary">Save</button>
            </div>
        </div>
    </form>
</div>
@endsection
