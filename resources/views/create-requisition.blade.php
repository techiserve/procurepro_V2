@extends('stack.layouts.admin')

@section('content')

    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">Dashboard</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Dashboard </li>
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
   


      <h1>Create Requisition</h1>
    @if(session('success'))
        <p style="color: green;">{{ session('success') }}</p>
    @endif
    <form method="POST" action="{{ route('requisition.store') }}">
        @csrf
        @foreach($formFields as $field)
            <div>
                <label>{{ $field->label }}</label>
                @if($field->type === 'text')
                    <textarea name="{{ $field->name }}"></textarea>
                @else
                    <input type="{{ $field->type === 'integer' ? 'number' : 'text' }}" name="{{ $field->name }}">
                @endif
            </div>
        @endforeach
        <button type="submit">Submit</button>
    </form>

</div>
@endsection
