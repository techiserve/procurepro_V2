@extends('html.default')

@section('content')
<div class="body-content__header">
    <ul>
        <li><a href="#">Vendor Type Edit</a></li>
        {{-- <li class="ms-auto">
            <a href="{{ route('vendor-types.index') }}" class="btn btn-primary btn-sm">
                <i class="fa fa-list"></i> Vendor Type List
            </a>
        </li> --}}
    </ul>
</div>

<div class="body-content__wrapper requesition-body">
    <form method="POST" action="/vendortype/update/{{$vendor->id}}" enctype="multipart/form-data">
        @method('PUT')
        @csrf

        <div class="card">
            <div class="card-header">
                <strong>Edit Vendor Type</strong>
            </div>

            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-col">
                            <label for="name">Name</label>
                            <input class="form-control" id="name" name="name" value="{{ $vendor->name }}" type="text" required>
                        </div>
                    </div>

                    <div class="col-md-2 d-flex align-items-center">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="active" name="active" value="1" @if($vendor->active) checked @endif>
                            <label class="form-check-label" for="active">Active</label>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card-footer">
                <div class="d-flex justify-content-end">
                    <a href="{{ route('vendor-types.index') }}" class="btn btn-danger" style="padding:10px 20px; font-size:16px; min-width:100px;">Cancel</a>
                    <button type="submit" class="btn btn-success" style="padding:10px 20px; font-size:16px; min-width:100px;">Save</button>
                </div>
            </div>
        </div>
    </form>
</div>
@endsection
