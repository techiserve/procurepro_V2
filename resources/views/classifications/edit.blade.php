@extends('stack.layouts.admin')

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
@section('content')
<div class="content-header row">
                <div class="content-header-left col-md-6 col-12 mb-2">
                 
                    <div class="row breadcrumbs-top">
                        <div class="breadcrumb-wrapper col-12">
                  
                        </div>
                    </div>
                </div>


                <div class="content-header-right col-md-6 col-12 mb-md-0 mb-2">
                    <div class="btn-group float-md-right" role="group" aria-label="Button group with nested dropdown">
                        <div class="btn-group" role="group">
                       
                        </div>
                    </div>
                </div>
            </div>
            <div class="content-body">
                <!-- horizontal grid start -->
                <section class="horizontal-grid" id="horizontal-grid">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="card">
                            
                                <div class="card-content collapse show">
                                    <div class="card-body">
                                  
                                          <form method="POST" action="{{ route('classifications.update', $classification->id) }}">
                                            @csrf
                                            @method('PUT')
                                     <div class="row">
                                         <div class="col-sm-6">
                                            <div class="form-group">
                                                <label for="name">Classification Name</label>
                                                <input type="text" class="form-control" id="name" name="name" value="{{ $classification->name }}" required>
                                            </div>
                                            </div>

                                          <div class="col-sm-6">
                                            <div class="form-group" style="margin-top: 34px;">
                                                 <div class="form-check form-switch">
                                             <input type="checkbox" class="form-check-input" id="flexSwitchCheckDefault" name="active" value="1" {{ $classification->active ? 'checked' : '' }}>
                                              <label class="form-check-label" for="defaultCheck1">Active</label>
                                            </div>
                                             </div>
                                          </div>
                                        </div>

                                            <button type="submit" class="btn btn-success">Update</button>
                                            <a href="{{ route('classifications.create') }}" class="btn btn-secondary">Back</a>
                                        </form>  

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
                <!-- horizontal grid end -->

</div>
</div>
@endsection
