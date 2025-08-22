@extends('html.default')
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>

@section('content')
<div class="body-content__header">
    <ul>
        <li><a href="#">Update Classification of Expense</a></li>
    </ul>
</div>

<div class="body-content__wrapper">
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
                            <div class="col-md-6">
                                <div class="form-col">
                                    <label for="name">Classification Name</label>
                                    <input type="text" class="form-control" id="name" name="name" placeholder="Enter Classification Name..." value="{{ $classification->name }}" required>
                                </div>
                            </div>

                               <div class="col-md-3 d-flex align-items-center">
                                <div class="form-check form-switch">
                                    <input class="form-check-input" type="checkbox" role="switch" name="active" value="1" id="flexSwitchActiveEdit" {{ $classification->active ? 'checked' : '' }} />
                                    <label class="form-check-label" for="flexSwitchActiveEdit">Active</label>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card-footer">
                        <div class="d-flex justify-content-end gap-2">
                            <button type="submit" class="btn btn-success" style="padding:10px 20px; font-size:16px; min-width:100px;">Update</button>
                            <a href="{{ route('classifications.create') }}" class="btn btn-danger" style="padding:10px 20px; font-size:16px; min-width:100px;">Back</a>
                        </div>
                    </div>
                </div>

            </form>

        </div>
    </div>
</div>
@endsection
