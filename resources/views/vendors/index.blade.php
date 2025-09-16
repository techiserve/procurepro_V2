@extends('html.default')

@section('content')
<div class="body-content__header">
    <ul>
        <li><a href="#">Vendors List</a></li>
    </ul>
    {{-- <a href="/procurement/createVendor" class="btn-requisition-list"><i class="icon-20"></i> Add Vendor</a> --}}
</div>

<div class="body-content__wrapper requesition-body">
    <div class="requesition-top">
        <ul class="requesition-btn-list">
            <li>
                <button id="copyBtn"><img src="{{ asset('assets/img/copy-icon.png') }}" alt=""> Copy</button>
                <div id="copyPopup" class="copy-popup"></div>
            </li>
            <li>
                <button id="csvBtn"><img src="{{ asset('assets/img/csv-icon.png') }}" alt=""> CSV</button>
            </li>
            <li>
                <button id="excelBtn"><img src="{{ asset('assets/img/excel-icon.png') }}" alt=""> Excel</button>
            </li>
            <li>
                <button id="pdfBtn"><img src="{{ asset('assets/img/pdf-icon.png') }}" alt=""> PDF</button>
            </li>
        </ul>

        <div class="requesition-search">
            <input type="search" id="tableSearch" placeholder="Search vendors...">
            <button><img src="{{ asset('assets/img/search-icon.png') }}" alt=""></button>
        </div>
    </div>

    <div class="requesition-table">
        <!-- IMPORTANT: id="myTable" to match JS below -->
        <table id="myTable" class="display responsive nowrap" style="width:100%">
            <thead>
                <tr>
                    <th class="text-center">Name</th>
                    <th class="text-center">Type</th>
                    <th class="text-center">Contact</th>
                    <th class="text-center">Finance Manager</th>
                    <th class="text-center">Bank</th>
                    <th class="text-center">Account #</th>
                    <th class="text-center">Status</th>
                    <th class="text-center">Action</th>
                </tr>
            </thead>
            <tbody>
                @forelse($vendors as $vendor)
                @php
                    $statusLabels = [
                        1 => ['text' => 'Incomplete', 'class' => 'btn btn-outline-secondary'],
                        2 => ['text' => 'Pending',    'class' => 'btn btn-outline-warning'],
                        3 => ['text' => 'Approved',   'class' => 'btn btn-outline-success'],
                        4 => ['text' => 'Returned',   'class' => 'btn btn-outline-info'],
                        5 => ['text' => 'Rejected',   'class' => 'btn btn-outline-danger'],
                    ];
                    $currentStatus = $statusLabels[$vendor->status] ?? ['text' => 'Unknown', 'class' => 'btn btn-outline-dark'];

                    // Resolve Finance Manager name (simple lookup from $users)
                    $fmName = '';
                    foreach ($users as $u) {
                        if ((int)$u->id === (int)$vendor->finance_manager) { $fmName = $u->name; break; }
                    }
                @endphp
                <tr>
                    <td class="text-center">{{ $vendor->name }}</td>
                    <td class="text-center">{{ $vendor->type }}</td>
                    <td class="text-center">{{ $vendor->contact_no_1 }}</td>
                    <td class="text-center">{{ $fmName }}</td>
                    <td class="text-center">{{ $vendor->bank_name }}</td>
                    <td class="text-center">{{ $vendor->account_number }}</td>
                    <td class="text-center">
                        <button type="button" class="{{ $currentStatus['class'] }}">
                            <span class="fa fa-check-circle"></span> {{ $currentStatus['text'] }}
                        </button>
                    </td>
                    <td class="text-center" data-order="{{ $vendor->name }}">
                        @if($vendor->status != 5)
                            <a href="/vendors/edit/{{ $vendor->id }}" class="btn btn-icon btn-info mr-1">
                                <i class="fa fa-pencil"></i> Edit
                            </a>
                            <a href="#" class="btn btn-icon btn-danger mr-1" onclick="
                                event.preventDefault();
                                Swal.fire({
                                    title: 'Delete Vendor?',
                                    text: 'You won\'t be able to undo this!',
                                    icon: 'warning',
                                    showCancelButton: true,
                                    confirmButtonText: 'Continue',
                                    cancelButtonText: 'Cancel'
                                }).then((result) => {
                                    if (result.isConfirmed) {
                                        window.location.href = '/vendors/delete/{{ $vendor->id }}';
                                    }
                                });
                            ">
                                <i class="fa fa-trash"></i> Delete
                            </a>
                        @endif

                        <!-- Logs -->
                        <a href="#" class="btn btn-icon btn-success mr-1" data-bs-toggle="modal" data-bs-target="#historyModal{{ $vendor->id }}">
                            <i class="fa fa-history"></i> Logs
                        </a>

                        <div class="modal fade" id="historyModal{{ $vendor->id }}" tabindex="-1" aria-labelledby="historyModalLabel{{ $vendor->id }}" aria-hidden="true">
                            <div class="modal-dialog modal-lg modal-dialog-scrollable">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="historyModalLabel{{ $vendor->id }}">Vendor Request Logs</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        @if($vendor->history->isEmpty())
                                            <p>No history found for this vendor.</p>
                                        @else
                                            <ul class="timeline">
                                                @foreach($vendor->history as $history)
                                                    @php $date = \Carbon\Carbon::parse($history->created_at); @endphp
                                                    <li class="timeline-item">
                                                        <div class="timeline-body">
                                                            <div class="timeline-meta">
                                                                <div class="d-inline-flex flex-column px-2 py-1 text-success-emphasis bg-success-subtle border border-success-subtle rounded-2 text-md-end">
                                                                    <span class="fw-bold">{{ $date->format('d F Y') }}</span>
                                                                    <span>{{ $date->format('g:ia') }}</span>
                                                                </div>
                                                            </div>
                                                            <div class="timeline-content timeline-indicator">
                                                                <div class="card border-0 shadow">
                                                                    <div class="card-body p-xl-4 position-relative">
                                                                        <h6 class="card-subtitle text-secondary mb-3 position-absolute top-0 end-0">{{ $loop->iteration }}</h6>
                                                                        <h2 class="card-title mb-2">{{ $history->doneby }}</h2>
                                                                        <p class="card-text m-0">{{ $history->reason }}</p>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </li>
                                                @endforeach
                                            </ul>
                                        @endif
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- /Logs -->
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="8" class="text-center">No vendors found.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="requesition-bottom">
        <div class="page-number">
            <label>Records per page:</label>
            <select id="pageLength">
                <option value="10" selected>10</option>
                <option value="25">25</option>
                <option value="50">50</option>
            </select>
        </div>

        <ul class="requesition-pagination">
            <li><button id="prevBtn"><img src="{{ asset('assets/img/pagi-arrow-left.png') }}" alt=""></button></li>
            <li><p id="rangeLabel">0 to {{ count($vendors) }}</p></li>
            <li><button id="nextBtn"><img src="{{ asset('assets/img/pagi-arrow-next.png') }}" alt=""></button></li>
        </ul>
    </div>
</div>

{{-- SweetAlert2 (needed for Delete confirm) --}}
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.all.min.js"></script>

{{-- jQuery + DataTables (match inspiration versions) --}}
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<link  href="https://cdn.datatables.net/1.13.8/css/jquery.dataTables.min.css" rel="stylesheet"/>
<link  href="https://cdn.datatables.net/responsive/2.5.0/css/responsive.dataTables.min.css" rel="stylesheet"/>
<script src="https://cdn.datatables.net/1.13.8/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/responsive/2.5.0/js/dataTables.responsive.min.js"></script>

{{-- xlsx for Excel export --}}
<script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.20.2/xlsx.full.min.js"></script>

{{-- pdfmake for PDF --}}
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/vfs_fonts.js"></script>

<script>
// ===== DataTable init (clone of requisitions behavior) =====
(function() {
  const tableEl = document.getElementById('myTable');
  if (!tableEl) return;

  // Initialize DataTable and expose as window.vendorDT
  window.vendorDT = $(tableEl).DataTable({
    responsive: true,
    processing: false,
    serverSide: false,
    pageLength: 10,
    lengthChange: false,
    info: true,
    order: [[0, 'asc']], // sort by Name

    columnDefs: [
      { targets: -1, searchable: false },               // Action not searchable
      { targets: [0, 3, 6, 7], responsivePriority: 1 }, // keep key cols on small screens
    ],

    dom: 't<"dt-bottom"ip>' // table + (info/paging) at bottom; custom controls wired below
  });

  // Custom search box
  document.getElementById('tableSearch')?.addEventListener('input', function() {
    window.vendorDT.search(this.value).draw();
  });

  // Records-per-page selector (mirrors inspiration)
  document.getElementById('pageLength')?.addEventListener('change', function() {
    window.vendorDT.page.len(parseInt(this.value, 10)).draw();
  });

  // Prev/Next buttons
  document.getElementById('prevBtn')?.addEventListener('click', () => window.vendorDT.page('previous').draw('page'));
  document.getElementById('nextBtn')?.addEventListener('click', () => window.vendorDT.page('next').draw('page'));

  // Update range label: "X to Y of Z"
  const rangeEl = document.getElementById('rangeLabel');
  if (rangeEl) {
    window.vendorDT.on('draw', function() {
      const info = window.vendorDT.page.info();
      rangeEl.textContent = `${info.start + 1} to ${info.end} of ${info.recordsDisplay}`;
    });
    window.vendorDT.draw(false);
  }
})();

// ===== Utils =====
const stripHtml = (html) => {
  const div = document.createElement('div');
  div.innerHTML = html;
  return div.textContent || div.innerText || '';
};

// Helper to pull headers + visible rows from DataTable
function getTableData(dt) {
  const headers = dt.columns().header().toArray().map(th => th.innerText.trim());
  const rows = [];
  dt.rows({ search: 'applied' }).every(function () {
    const data = this.data().map(c => stripHtml(c));
    rows.push(data);
  });
  return { headers, rows };
}

// ===== COPY =====
document.getElementById('copyBtn')?.addEventListener('click', function(e) {
  const dt = window.vendorDT; if (!dt) return;
  const { headers, rows } = getTableData(dt);
  const text = [headers.join('\t'), ...rows.map(r => r.join('\t'))].join('\n');
  navigator.clipboard.writeText(text).then(() => {
    const popup = document.getElementById('copyPopup');
    if (!popup) return;
    popup.textContent = 'Copied!';
    popup.style.opacity = 1;
    const btnRect = e.target.getBoundingClientRect();
    popup.style.left = (btnRect.left + (btnRect.width/2) - 60) + 'px';
    popup.style.top  = (btnRect.top - 35) + 'px';
    setTimeout(() => popup.style.opacity = 0, 1000);
  });
});

// ===== CSV =====
document.getElementById('csvBtn')?.addEventListener('click', function() {
  const dt = window.vendorDT; if (!dt) return;
  const { headers, rows } = getTableData(dt);
  const esc = (s) => '"' + String(s).replace(/"/g, '""') + '"';
  const lines = [headers.map(esc).join(',')].concat(rows.map(r => r.map(esc).join(',')));
  const blob = new Blob([lines.join('\n')], { type: 'text/csv' });
  const url = URL.createObjectURL(blob);
  const a = Object.assign(document.createElement('a'), { href: url, download: 'vendors.csv' });
  a.click(); URL.revokeObjectURL(url);
});

// ===== EXCEL (xlsx) =====
document.getElementById('excelBtn')?.addEventListener('click', function() {
  const dt = window.vendorDT; if (!dt) return;
  const { headers, rows } = getTableData(dt);
  const wb = XLSX.utils.book_new();
  const ws = XLSX.utils.aoa_to_sheet([headers, ...rows]);
  XLSX.utils.book_append_sheet(wb, ws, 'Vendors');
  XLSX.writeFile(wb, 'vendors.xlsx');
});

// ===== PDF (pdfmake) =====
document.getElementById('pdfBtn')?.addEventListener('click', function() {
  const dt = window.vendorDT; if (!dt) return;
  const { headers, rows } = getTableData(dt);
  const body = [
    headers.map(h => ({ text: h, style: 'tableHeader' })),
    ...rows
  ];
  const docDefinition = {
    content: [
      { text: 'Vendors', style: 'header' },
      {
        table: { headerRows: 1, widths: Array(headers.length).fill('*'), body }
      }
    ],
    styles: {
      header: { fontSize: 16, bold: true, margin: [0,0,0,10] },
      tableHeader: { bold: true, fillColor: '#eeeeee' }
    },
    pageOrientation: 'landscape'
  };
  pdfMake.createPdf(docDefinition).download('vendors.pdf');
});
</script>
@endsection
