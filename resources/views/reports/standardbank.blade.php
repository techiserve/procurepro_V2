@extends('html.default')


@section('content')
<div class="body-content__header">
    <ul>
        <li><a href="#">Standard Bank Report</a></li>
    </ul>
</div>

<div class="body-content__wrapper requesition-body">
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center flex-wrap gap-2">
            <strong>Standard Bank Report</strong>
            <div class="d-flex align-items-center gap-2">
                <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#filterModal">
                    <i class="fa fa-filter"></i> Filter
                </button>
            </div>
        </div>

        <div class="card-body">
            <!-- Toolbar: export buttons + search -->
            <div class="d-flex justify-content-between align-items-center flex-wrap gap-2 mb-3">
                <ul class="requesition-btn-list mb-0">
                    <li>
                        <button id="copyStd"><i class="fa fa-copy"></i> Copy</button>
                        <div id="copyPopupStd" class="copy-popup"></div>
                    </li>
                    <li>
                        <button id="csvStd"><i class="fa fa-file-csv"></i> CSV</button>
                    </li>
                    <li>
                        <button id="excelStd"><i class="fa fa-file-excel"></i> Excel</button>
                    </li>
                    <li>
                        <button id="pdfStd"><i class="fa fa-file-pdf"></i> PDF</button>
                    </li>
                </ul>
                <div class="requesition-search">
                    <input type="search" id="stdSearch" class="form-control" placeholder="Search report...">
                    <button class="btn btn-outline-secondary" type="button"><i class="fa fa-search"></i></button>
                </div>
            </div>

            <div class="table-responsive">
                <table class="table table-striped table-bordered display responsive nowrap" id="standardBankReportTable" style="width:100%">
                    <thead class="table-light text-center">
                        <tr>
                            <th class="text-center">RECIPIENT NAME</th>
                            <th class="text-center">RECIPIENT ACCOUNT</th>
                            <th class="text-center">RECIPIENT ACCOUNT TYPE</th>
                            <th class="text-center">BRANCH</th>
                            <th class="text-center">AMOUNT</th>
                            <th class="text-center">OWN REFERENCES</th>
                            <th class="text-center">RECIPIENT REFERENCES</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($fpurchaseorder as $grower)
                            <tr class="text-center">
                                <td>{{ $grower->Vendor }}</td>
                                <td>{{ $grower->vendorbankAccountNumber }}</td>
                                <td>{{ $grower->vendorbankAccountType }}</td>
                                <td>{{ $grower->vendorbankBranch }}</td>
                                <td>{{ $grower->invoiceamount }}</td>
                                <td>{{ $grower->ownref }}</td>
                                <td>{{ $grower->benref }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <!-- Bottom controls -->
            <div class="d-flex justify-content-between align-items-center flex-wrap gap-2 mt-3">
                <div class="page-number d-flex align-items-center gap-2">
                    <label class="mb-0">Records per page:</label>
                    <select id="stdPageLength" class="form-select form-select-sm" style="width:auto;">
                        <option value="10" selected>10</option>
                        <option value="25">25</option>
                        <option value="50">50</option>
                        <option value="100">100</option>
                    </select>
                </div>

                <ul class="requesition-pagination mb-0">
                    <li><button id="prevStd" title="Previous"><i class="fa fa-angle-left"></i></button></li>
                    <li><p id="rangeLabelStd" class="mb-0 small">0 to {{ count($fpurchaseorder) }}</p></li>
                    <li><button id="nextStd" title="Next"><i class="fa fa-angle-right"></i></button></li>
                </ul>
            </div>
        </div>
    </div>
</div>

{{-- Filter Modal (Bootstrap 5) --}}
<div class="modal fade" id="filterModal" tabindex="-1" aria-labelledby="filterModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-md">
        <form method="post" action="{{ route('purchaseorder.filtered') }}" enctype="multipart/form-data" class="modal-content">
            {{ csrf_field() }}
            <div class="modal-header">
                <h4 class="modal-title" id="filterModalLabel">Filter Purchase Order Summary</h4>
                <button class="btn-close" type="button" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="modal-body">
                <div class="form-group mb-3">
                    <label for="start_date" class="form-label">Date From</label>
                    <input class="form-control" id="start_date" name="start_date" type="date">
                </div>
                <div class="form-group mb-3">
                    <label for="end_date" class="form-label">Date To</label>
                    <input class="form-control" id="end_date" name="end_date" type="date">
                </div>
                <div class="form-group mb-3">
                    <label for="status" class="form-label">Status</label>
                    <select name="status" id="status" class="form-select js-example-basic-single" style="width:100%;">
                        <option value="">--Select Status--</option>
                        <option value="2">Approved</option>
                        <option value="3">Rejected</option>
                        <option value="1">Pending</option>
                    </select>
                </div>
                <div class="form-group mb-0">
                    <label for="vendor" class="form-label">Vendor</label>
                    <select name="vendor" id="vendor" class="form-select js-example-basic-single" style="width:100%;">
                        <option value="">--Select Vendor--</option>
                        @foreach($vendors as $vendor)
                            <option value="{{ $vendor->SupplierName }}">{{ $vendor->SupplierName }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="modal-footer">
                <button class="btn btn-secondary" type="button" data-bs-dismiss="modal">Close</button>
                <button class="btn btn-primary" type="submit">Filter Summary</button>
            </div>
        </form>
    </div>
</div>

{{-- <link rel="stylesheet" href="https://unpkg.com/bootstrap@5.3.3/dist/css/bootstrap.min.css"> --}}
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.min.css">

{{-- DataTables (jQuery) --}}
<link href="https://cdn.datatables.net/1.13.8/css/jquery.dataTables.min.css" rel="stylesheet"/>
<link href="https://cdn.datatables.net/responsive/2.5.0/css/responsive.dataTables.min.css" rel="stylesheet"/>

<!-- Bootstrap JS Bundle -->
<script src="https://unpkg.com/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<!-- jQuery (required for Select2 & DataTables) -->
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<!-- Select2 JS -->
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

<!-- DataTables (jQuery) + Responsive plugin -->
<script src="https://cdn.datatables.net/1.13.8/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/responsive/2.5.0/js/dataTables.responsive.min.js"></script>

<!-- xlsx for Excel export -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.20.2/xlsx.full.min.js"></script>
<!-- pdfmake for PDF export -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/vfs_fonts.js"></script>

<script>

(function() {
  const tableEl = document.getElementById('standardBankReportTable');
  if (!tableEl) return;

  $.fn.dataTable.ext.errMode = 'none';
  $(tableEl).on('error.dt', function(e, settings, techNote, message){
    console.warn('DataTables:', message);
  });

  // Init DataTable
  window.stdDT = $(tableEl).DataTable({
    responsive: true,
    processing: false,
    serverSide: false,
    pageLength: 10,
    lengthChange: false,
    info: true,
    order: [[0, 'asc']], // sort by first column
    columnDefs: [
      { targets: '_all', className: 'text-center' },
      { targets: 4, className: 'text-end' } // AMOUNT right-align
    ],
    dom: 't<"dt-bottom"ip>',
    language: {
      emptyTable: "No rows found.",
      zeroRecords: "No matching rows."
    }
  });

  // Custom search
  document.getElementById('stdSearch')?.addEventListener('input', function() {
    window.stdDT.search(this.value).draw();
  });

  // Records-per-page selector
  document.getElementById('stdPageLength')?.addEventListener('change', function() {
    window.stdDT.page.len(parseInt(this.value, 10)).draw('page');
  });

  // Prev/Next buttons
  document.getElementById('prevStd')?.addEventListener('click', () => window.stdDT.page('previous').draw('page'));
  document.getElementById('nextStd')?.addEventListener('click', () => window.stdDT.page('next').draw('page'));

  // Range label
  const rangeEl = document.getElementById('rangeLabelStd');
  if (rangeEl) {
    window.stdDT.on('draw', function() {
      const info = window.stdDT.page.info();
      rangeEl.textContent = `${info.recordsDisplay ? info.start + 1 : 0} to ${info.end} of ${info.recordsDisplay}`;
    });
    window.stdDT.draw(false);
  }
})();

// ===== Utils for exports =====
const stripHtml = (html) => {
  const div = document.createElement('div');
  div.innerHTML = html;
  return div.textContent || div.innerText || '';
};

function getTableData(dt) {
  const headers = dt.columns().header().toArray().map(th => th.innerText.trim());
  const rows = [];
  dt.rows({ search: 'applied' }).every(function () {
    const data = this.data().map(c => stripHtml(c));
    rows.push(data);
  });
  return { headers, rows };
}

function hasRows(dt){ return dt && dt.rows({search:'applied'}).count() > 0; }

// ===== COPY =====
document.getElementById('copyStd')?.addEventListener('click', function(e) {
  const dt = window.stdDT; if (!hasRows(dt)) return;
  const { headers, rows } = getTableData(dt);
  const text = [headers.join('\t'), ...rows.map(r => r.join('\t'))].join('\n');
  navigator.clipboard.writeText(text).then(() => {
    const popup = document.getElementById('copyPopupStd');
    if (!popup) return;
    popup.textContent = 'Copied!';
    popup.style.opacity = 1;
    popup.style.position = 'fixed';
    const btnRect = e.target.getBoundingClientRect();
    popup.style.left = (btnRect.left + (btnRect.width/2) - 60) + 'px';
    popup.style.top  = (btnRect.top - 35) + 'px';
    setTimeout(() => popup.style.opacity = 0, 1000);
  });
});

// ===== CSV =====
document.getElementById('csvStd')?.addEventListener('click', function() {
  const dt = window.stdDT; if (!hasRows(dt)) return;
  const { headers, rows } = getTableData(dt);
  const esc = (s) => '"' + String(s).replace(/"/g, '""') + '"';
  const lines = [headers.map(esc).join(','), ...rows.map(r => r.map(esc).join(','))];
  const blob = new Blob([lines.join('\n')], { type: 'text/csv' });
  const url = URL.createObjectURL(blob);
  const a = Object.assign(document.createElement('a'), { href: url, download: 'standard-bank-report.csv' });
  document.body.appendChild(a); a.click(); a.remove(); URL.revokeObjectURL(url);
});

// ===== EXCEL (xlsx) =====
document.getElementById('excelStd')?.addEventListener('click', function() {
  const dt = window.stdDT; if (!hasRows(dt)) return;
  if (typeof XLSX === 'undefined') { alert('XLSX not loaded'); return; }
  const { headers, rows } = getTableData(dt);
  const wb = XLSX.utils.book_new();
  const ws = XLSX.utils.aoa_to_sheet([headers, ...rows]);
  XLSX.utils.book_append_sheet(wb, ws, 'Standard Bank');
  XLSX.writeFile(wb, 'standard-bank-report.xlsx');
});

// ===== PDF (pdfmake) =====
document.getElementById('pdfStd')?.addEventListener('click', function() {
  const dt = window.stdDT; if (!hasRows(dt)) return;
  if (typeof pdfMake === 'undefined') { alert('pdfMake not loaded'); return; }
  const { headers, rows } = getTableData(dt);
  const body = [ headers.map(h => ({ text: h, style: 'tableHeader' })), ...rows ];
  const docDefinition = {
    content: [
      { text: 'Standard Bank Report', style: 'header' },
      { table: { headerRows: 1, widths: Array(headers.length).fill('*'), body } }
    ],
    styles: {
      header: { fontSize: 16, bold: true, margin: [0,0,0,10] },
      tableHeader: { bold: true, fillColor: '#eeeeee' }
    },
    pageOrientation: 'landscape'
  };
  pdfMake.createPdf(docDefinition).download('standard-bank-report.pdf');
});

// Select2 inside modal
$(function(){
  $('.js-example-basic-single').select2({ theme: 'bootstrap-5', dropdownParent: $('#filterModal') });
  const filterModal = document.getElementById('filterModal');
  if (filterModal) {
    filterModal.addEventListener('shown.bs.modal', function () {
      $('.js-example-basic-single').select2({ theme: 'bootstrap-5', dropdownParent: $('#filterModal') });
      const end = document.getElementById('end_date');
      if (end && !end.value) end.value = new Date().toISOString().split('T')[0];
    });
  }
});
</script>
@endsection
