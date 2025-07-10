@extends('stack.layouts.admin')

@section('content')
<div class="container-fluid">
  <div class="animated fadeIn">
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header">
                    <h2>{{ $report->name }}</h2>
                    <p>{{ $report->description }}</p>
                    {{-- <button class="btn btn-primary btn-sm pull-right"  data-toggle="modal" data-target="#filterModal" style="padding: 10px 20px; font-size: 16px; min-width: 100px;"><i class="fa fa-filter"></i> Filter </button> --}}
                    <!-- <a href="/growers/" class="btn btn-primary btn-sm pull-right"><i style="color:white;" class="fa fa-align-justify"></i> Filter Requisitions</a> -->
               
                </div>

                <div class="card-body">
                    <div class="datatable-dashv1-list custom-datatable-overright">
                        <div id="toolbar">
                    
                        </div>
                     <div class="table-responsive">
                       <table class="table table-striped table-bordered file-export">
                        <thead>
                            <tr>
                            @foreach($config as $col)
                                <th>{{ $col['label'] }}</th>
                            @endforeach
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($fpurchaseorder as $row)
                            <tr>
                                @foreach($config as $col)
                                @php
                                $value = '';
                                if (empty($col['blank']) && !empty($col['column'])) {
                                    $columnName = $col['column'];
                                    $value = $row->$columnName ?? '';
                                }
                                @endphp
                                <td>{{ $value }}</td>
                                @endforeach
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
</div>
@endsection
