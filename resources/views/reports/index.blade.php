@extends('stack.layouts.admin')

@section('content')
<div class="container-fluid">
  <div class="animated fadeIn">
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header">
                    <strong> Custom Reports</strong>
                    {{-- <button class="btn btn-primary btn-sm pull-right"  data-toggle="modal" data-target="#filterModal" style="padding: 10px 20px; font-size: 16px; min-width: 100px;"><i class="fa fa-filter"></i> Filter</button> --}}
                    <!-- <a href="/growers/" class="btn btn-primary btn-sm pull-right"><i style="color:white;" class="fa fa-align-justify"></i> Filter Requisitions</a> -->
               
                </div>

                <div class="card-body">
                    <div class="datatable-dashv1-list custom-datatable-overright">
                        <div id="toolbar">
                    
                        </div>
                         
                        <table class="table table-striped table-bordered file-export">
                        <thead>
                        <tr>
                            <th>Name</th>
                            <th>Description</th>
                            <th>Action</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($reports as $report)
                            <tr>
                            <td>{{ $report->name }}</td>
                            <td>{{ $report->description }}</td>
                            <td>
                                <a href="{{ route('reports.show', $report->id) }}" class="btn btn-primary btn-sm">View Report</a>
                               <form action="{{ route('reports.destroy', $report->id) }}" method="POST" style="display:inline-block;" onsubmit="return confirm('Are you sure you want to delete this report?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                            </form>
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
</div>
@endsection
