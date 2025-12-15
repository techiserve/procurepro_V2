@extends('html.default')

@section('styles')
<link rel="stylesheet" href="https://unpkg.com/bootstrap@5.3.3/dist/css/bootstrap.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

<!-- SweetAlert2 -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">

<!-- ✅ DataTables CSS -->
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.7/css/dataTables.bootstrap5.min.css">
@endsection

@section('content')
<div class="body-content__header">
    <ul>
        <li><a href="#">{{ $report->name }}</a></li>
    </ul>
    <p class="mt-2 mb-0 text-muted">{{ $report->description }}</p>
</div>

<div class="body-content__wrapper requesition-body">
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <strong>{{ $report->name }}</strong>
        <div class="d-flex align-items-center gap-2">
    <!-- 🔍 Custom Search Bar -->
   

    <!-- Filter Button -->
    <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#filterModal">
        <i class="fa fa-filter"></i> Filter and Download
    </button>
     <input type="search"
           id="tableSearch"
           class="form-control form-control-sm"
           placeholder="Search rows..."
           style="width: 250px;border-radius: 40px;height: 30px; padding-left: 12px;" />
</div>
        </div>

        <div class="card-body">
            <div class="table-responsive">
                <form action="{{ route('custom_report.remove') }}" method="POST" id="removeSelectedRowsForm">
                    @csrf
                    <input type="hidden" name="report_id" value="{{ $report->id }}">
                    <input type="hidden" name="type" value="{{ $type }}">
                    <button type="submit"
                            class="btn btn-danger mb-3"
                            onclick="return confirm('Are you sure you want to remove the selected rows?')">
                        Clear Selected Rows
                    </button>

                    <table class="table table-striped table-bordered" id="customReportDataTable">
                        <thead class="table-light">
                            <tr>
                                <th class="text-center" style="width: 50px;">
                                    <input type="checkbox" id="select_all_rows" class="form-check-input" />
                                </th>
                                @foreach($config as $col)
                                    <th>{{ $col['label'] }}</th>
                                @endforeach
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($fpurchaseorder as $index => $row)
                                <tr>
                                    <td class="text-center">
                                        <input type="checkbox" name="selected_rows[]" value="{{ $row->id }}" class="row-checkbox form-check-input" />
                                    </td>
                                    @foreach($config as $col)
                                        @php
                                            $value = '';
                                            if (!empty($col['blank'])) {
                                                $value = $col['default'] ?? '';
                                            } elseif (!empty($col['column'])) {
                                                $columnName = $col['column'];
                                                $value = $row->$columnName ?? ($col['default'] ?? '');
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

<!-- Filter Modal -->
<div class="modal fade" id="filterModal" tabindex="-1" aria-labelledby="filterModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <form action="{{ route('filter.route') }}" method="POST" class="modal-content">
      @csrf
      <div class="modal-header">
        <h5 class="modal-title" id="filterModalLabel">Select Filters</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>

      <div class="modal-body">
        <input type="hidden" name="report_id" value="{{ $report->id }}">
        <input type="hidden" name="type" value="{{ $type }}">
        <div class="mb-3 d-flex align-items-center gap-2">
          <input type="checkbox" id="select_all_filters" class="form-check-input" />
          <label for="select_all_filters" class="mb-0"><strong>Select All</strong></label>
        </div>

        <div class="table-responsive">
          <table class="table table-sm table-striped table-bordered">
            <thead>
              <tr>
                <th style="width: 50px;">#</th>
                <th>Filter Value</th>
                <th class="text-center" style="width: 70px;">Select</th>
              </tr>
            </thead>
            <tbody>
              @foreach($filters as $index => $filter)
                <tr>
                  <td>{{ $index + 1 }}</td>
                  <td>{{ $filter }}</td>
                  <td class="text-center">
                    <input class="form-check-input filter-checkbox"
                           type="checkbox"
                           name="selected_filters[]"
                           value="{{ $filter }}"
                           id="filter_{{ $index }}">
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
    </form>
  </div>
</div>
@endsection


<!-- ✅ Dependencies -->
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="https://unpkg.com/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.all.min.js"></script>

<!-- ✅ DataTables JS -->
<script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.7/js/dataTables.bootstrap5.min.js"></script>
<script>
document.addEventListener("DOMContentLoaded", function () {
    const tableEl = document.getElementById('customReportDataTable');
    if (!tableEl) return;

    // ✅ Initialize DataTable (jQuery style for v1.13.x)
    const table = $('#customReportDataTable').DataTable({
       // responsive: true,
        paging: true,
        searching: true,
        ordering: true,
        pageLength: 100,
        lengthMenu: [10, 25, 50, 100],
        // Hide the built-in search box so you only use the custom one
        dom: 'lrtip',
        language: {
            lengthMenu: "Show _MENU_ rows per page",
            info: "Showing _START_ to _END_ of _TOTAL_ rows",
            infoEmpty: "Showing 0 to 0 of 0 rows",
            infoFiltered: "(filtered from _MAX_ total rows)"
        }
    });

    // 🔍 Custom Search (from first code)
    const searchInput = document.getElementById('tableSearch');
    if (searchInput) {
        searchInput.addEventListener('input', function () {
            table.search(this.value).draw();
        });
    }

    // ✅ Track selected rows
    const selectedIds = new Set();
    const selectAll = document.getElementById('select_all_rows');

    // Select/deselect all visible
    selectAll?.addEventListener('change', function () {
        const checked = this.checked;
        table.rows({ page: 'current' }).every(function () {
            const tr = this.node();
            const checkbox = tr.querySelector('.row-checkbox');
            if (checkbox) {
                checkbox.checked = checked;
                const id = checkbox.value;
                if (checked) selectedIds.add(id);
                else selectedIds.delete(id);
            }
        });
    });

    // Handle individual checkbox toggle
    tableEl.addEventListener('change', function (e) {
        if (e.target.classList.contains('row-checkbox')) {
            const id = e.target.value;
            if (e.target.checked) selectedIds.add(id);
            else selectedIds.delete(id);
        }
    });

    // Keep selections persistent when paging
    table.on('draw', function () {
        table.rows({ page: 'current' }).every(function () {
            const tr = this.node();
            const checkbox = tr.querySelector('.row-checkbox');
            if (checkbox) checkbox.checked = selectedIds.has(checkbox.value);
        });
    });

    // Add hidden inputs for all selected IDs on submit
    const form = document.getElementById('removeSelectedRowsForm');
    form?.addEventListener('submit', function () {
        // ✅ 1. Remove old hidden fields
        form.querySelectorAll('.hidden-selected-id').forEach(el => el.remove());

        // ✅ 2. Remove names from visible checkboxes so they don't duplicate
        form.querySelectorAll('.row-checkbox[name="selected_rows[]"]').forEach(cb => {
            cb.removeAttribute('name');
        });

        // ✅ 3. Add one hidden input per unique selected ID
        selectedIds.forEach(id => {
            const input = document.createElement('input');
            input.type = 'hidden';
            input.name = 'selected_rows[]';
            input.value = id;
            input.classList.add('hidden-selected-id');
            form.appendChild(input);
        });
    });

    // ✅ Select All Filters in modal
    const selectAllFilters = document.getElementById('select_all_filters');
    if (selectAllFilters) {
        selectAllFilters.addEventListener('change', function () {
            const checked = this.checked;
            document.querySelectorAll('.filter-checkbox').forEach(cb => cb.checked = checked);
        });
    }
});
</script>

