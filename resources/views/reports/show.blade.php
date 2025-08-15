@extends('html.default')

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
<!-- SweetAlert2 CSS -->
<link href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css" rel="stylesheet">

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.all.min.js"></script>

@section('content')
<div class="container-fluid">
  <div class="animated fadeIn">
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header">
                    <h2>{{ $report->name }}</h2>
                    <p>{{ $report->description }}</p>
                      <div class="d-flex justify-content-end mb-3" >
                     <button class="btn btn-primary btn-sm pull-right"  data-bs-toggle="modal" 
        data-bs-target="#filterModal" 
        style="padding: 10px 20px; font-size: 16px; min-width: 100px;">
    <i class="fa fa-filter"></i> Filter and Download </button>            
                </div>
                </div>

                <div class="card-body">
                    <div class="datatable-dashv1-list custom-datatable-overright">
                        <div id="toolbar">
                    
                        </div>
                      <div class="table-responsive">
                           <form action="{{ route('custom_report.remove') }}" method="POST" id="removeSelectedRowsForm">
                            @csrf
                            <input type="hidden" name="report_id" value="{{ $report->id }}">

                            <button type="submit" class="btn btn-danger mb-3" onclick="return confirm('Are you sure you want to remove the selected rows?')">
                                Clear Selected Rows
                            </button>

                            <table class="table table-striped table-bordered file-export">
                                <thead>
                                    <tr>
                                        <th style="width: 50px;">
                                          
                                        </th>
                                        @foreach($config as $col)
                                            <th>{{ $col['label'] }}</th>
                                        @endforeach
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($fpurchaseorder as $index => $row)
                                    <tr>
                                        <td>
                                            <input type="checkbox" name="selected_rows[]" value="{{ $row->id }}" class="row-checkbox" />
                                        </td>
                                        @foreach($config as $col)
                                        @php
                                            $value = '';

                                            if (!empty($col['blank'])) {
                                                $value = $col['default'] ?? '';
                                            } elseif (!empty($col['column'])) {
                                                $columnName = $col['column'];
                                                $value = $row->$columnName ?? $col['default'] ?? '';
                                            } elseif (empty($col['column']) && isset($col['default'])) {
                                                $value = $col['default'];
                                            }
                                        @endphp
                                        <td>{{ $value }}</td>
                                        @endforeach
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </form>
                     </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


<!-- Filter Modal -->
<div class="modal fade" id="filterModal" tabindex="-1" aria-labelledby="filterModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <form action="{{ route('filter.route') }}" method="POST">
      @csrf
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="filterModalLabel">Select Filters</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>

        <div class="modal-body">
          <input type="hidden" name="report_id" value="{{ $report->id }}">
          <div class="mb-3">
            <input type="checkbox" id="select_all_filters" /> 
            <label for="select_all_filters"><strong>Select All</strong></label>
          </div>

          <div class="table-responsive">
            <table class="table table-sm table-striped table-bordered">
              <thead>
                <tr>
                  <th style="width: 50px;">#</th>
                  <th>Filter Value</th>
                  <th style="width: 70px;">Select</th>
                </tr>
              </thead>
              <tbody>
                @foreach($filters as $index => $filter)
                  <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $filter }}</td>
                    <td class="text-center">
                      <input class="form-check-input filter-checkbox" type="checkbox" name="selected_filters[]" value="{{ $filter }}" id="filter_{{ $index }}">
                    </td>
                  </tr>
                @endforeach
              </tbody>
            </table>
          </div>
        </div>

        <div class="modal-footer">
          <button type="submit" class="btn btn-primary">Apply Filters</button>
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        </div>
      </div>
    </form>
  </div>
</div>

<!-- Script for Select All -->
<script>
document.getElementById('select_all').addEventListener('click', function() {
    document.querySelectorAll('.filter-checkbox').forEach(cb => cb.checked = this.checked);
});
</script>


  </div>
</div>
@endsection

<script>
document.getElementById('select_all').addEventListener('click', function() {
    let checkboxes = document.querySelectorAll('.filter-checkbox');
    checkboxes.forEach(cb => cb.checked = this.checked);
});
</script>

<script>
    document.getElementById('select_all_rows').addEventListener('change', function () {
        const checked = this.checked;
        document.querySelectorAll('.row-checkbox').forEach(cb => cb.checked = checked);
    });
</script>

<script>
document.getElementById('select_all_filters').addEventListener('click', function() {
    const checked = this.checked;
    document.querySelectorAll('.filter-checkbox').forEach(cb => cb.checked = checked);
});
</script>