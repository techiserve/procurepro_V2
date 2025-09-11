@extends('html.default')

@section('content')
<div class="body-content__header">
    <ul>
        <li><a href="#">ProcurePro Requisitions</a></li>
    </ul>
</div>

<div class="body-content__wrapper requesition-body">
    <div class="requesition-top">
        <ul class="requesition-btn-list">
            <li>
                <button id="reqCopyBtn"><img src="{{ asset('assets/img/copy-icon.png') }}" alt=""> Copy</button>
                <div id="reqCopyPopup" class="copy-popup"></div>
            </li>
            <li>
                <button id="reqCsvBtn"><img src="{{ asset('assets/img/csv-icon.png') }}" alt=""> CSV</button>
            </li>
            <li>
                <button id="reqExcelBtn"><img src="{{ asset('assets/img/excel-icon.png') }}" alt=""> Excel</button>
            </li>
            <li>
                <button id="reqPdfBtn"><img src="{{ asset('assets/img/pdf-icon.png') }}" alt=""> PDF</button>
            </li>
            <li>
                <button id="reqPrintBtn"><img src="{{ asset('assets/img/print-icon.png') }}" alt=""> Print</button>
            </li>
        </ul>

        <div class="requesition-search">
            <input type="search" id="reqTableSearch" placeholder="Search requisitions...">
            <button><img src="{{ asset('assets/img/search-icon.png') }}" alt=""></button>
        </div>
    </div>

    <div class="requesition-table">
        <!-- IMPORTANT: id="requisitionTable" -->
        <table id="requisitionTable" class="display responsive nowrap" style="width:100%">
            <thead>
                <tr>
                    <th class="text-center">Unique ID</th>
                    <th class="text-center">Status</th>
                    <th class="text-center">Description</th>
                    <th class="text-center">Amount</th>
                    <th class="text-center">Method Payment</th>
                    <th class="text-center">Vendor Registered</th>
                    <th class="text-center">Vendor ID</th>
                    <th class="text-center">Supplier Code</th>
                    <th class="text-center">Project Code</th>
                    <th class="text-center">Class of Expenses</th>
                    <th class="text-center">Reference</th>
                    <th class="text-center">First Line App (ID)</th>
                    <th class="text-center">Finance Manager (ID)</th>
                    <th class="text-center">MD (ID)</th>
                    <th class="text-center">First Line Approved</th>
                    <th class="text-center">Finance Approved</th>
                    <th class="text-center">MD Approved</th>
                    <th class="text-center">General LGR Alloc</th>
                    <th class="text-center">Bank ID</th>
                    <th class="text-center">Added By (ID)</th>
                    <th class="text-center">Notes</th>
                    <th class="text-center">Created Date</th>
                    <th class="text-center">Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach($requisitions as $req)
                <tr>
                    <td class="text-center">{{ $req->unique_id }}</td>

                    <td class="text-center">
                        @php
                            $status = (string)$req->status_code;
                            $badgeClass = match($status) {
                                'Approved' => 'btn-outline-success',
                                'Pending', 'In Review' => 'btn-outline-info',
                                'Rejected', 'Declined' => 'btn-outline-danger',
                                default => 'btn-outline-secondary'
                            };
                        @endphp
                        <button type="button" class="btn {{ $badgeClass }}"><span class="fa fa-info-circle"></span> {{ $status }}</button>
                    </td>

                    <td class="text-center">{{ $req->description }}</td>
                    <td class="text-center">
                        @php
                            $amt = is_numeric($req->amount) ? number_format($req->amount, 2) : $req->amount;
                        @endphp
                        {{ $amt }}
                    </td>

                    <td class="text-center">{{ $req->method_payment }}</td>
                    <td class="text-center">{{ $req->vendor_registered }}</td>
                    <td class="text-center">{{ $req->vendor_id }}</td>
                    <td class="text-center">{{ $req->supplier_code }}</td>
                    <td class="text-center">{{ $req->project_code }}</td>
                    <td class="text-center">{{ $req->class_of_expenses }}</td>
                    <td class="text-center">{{ $req->reference }}</td>
                    <td class="text-center">{{ $req->first_line_app }}</td>

                    {{-- NOTE: field name kept exactly as provided: "finanace_manager" --}}
                    <td class="text-center">{{ $req->finanace_manager }}</td>
                    <td class="text-center">{{ $req->MD }}</td>

                    <td class="text-center">
                        @if($req->first_line_approved == 1)
                            <span class="badge badge-success">Yes</span>
                        @else
                            <span class="badge badge-secondary">No</span>
                        @endif
                    </td>
                    <td class="text-center">
                        {{-- NOTE: field name kept exactly as provided: "finanace_manager_approved" --}}
                        @if($req->finanace_manager_approved == 1)
                            <span class="badge badge-success">Yes</span>
                        @else
                            <span class="badge badge-secondary">No</span>
                        @endif
                    </td>
                    <td class="text-center">
                        @if($req->md_approved == 1)
                            <span class="badge badge-success">Yes</span>
                        @else
                            <span class="badge badge-secondary">No</span>
                        @endif
                    </td>

                    <td class="text-center">{{ $req->general_lgr_alloc }}</td>
                    <td class="text-center">{{ $req->bank_id }}</td>
                    <td class="text-center">{{ $req->added_by_id }}</td>
                    <td class="text-center">{{ $req->notes }}</td>
                    <td class="text-center">{{ $req->created_date }}</td>

                    {{-- Make Action column sortable by giving it a data-order key (use Unique ID) --}}
                    <td class="text-center" data-order="{{ $req->unique_id }}">
                        <a href='/procureprorequisition/{{ $req->unique_id }}/view' class="btn btn-icon btn-success">
                            <i class=""></i> Documents
                        </a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div class="requesition-bottom">
        <div class="page-number">
            <label>Records per page:</label>
            <select id="reqPageLength">
                <option value="10" selected>10</option>
                <option value="25">25</option>
                <option value="50">50</option>
            </select>
        </div>

        <ul class="requesition-pagination">
            <!-- DataTables will handle actual paging; these are just decorative -->
            <li><button id="reqPrev"><img src="{{ asset('assets/img/pagi-arrow-left.png') }}" alt=""></button></li>
            <li><p id="reqRange">0 to {{ count($requisitions) }}</p></li>
            <li><button id="reqNext"><img src="{{ asset('assets/img/pagi-arrow-next.png') }}" alt=""></button></li>
        </ul>
    </div>
</div>

{{-- SweetAlert2 --}}
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.all.min.js"></script>

{{-- jQuery + DataTables (core + responsive) --}}
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
// ===== DataTable init =====
(function() {
  const tableEl = document.getElementById('requisitionTable');
  if (!tableEl) return;

  // Initialize DataTable and expose as window.reqDT
  window.reqDT = $(tableEl).DataTable({
    responsive: true,
    processing: false,
    serverSide: false, // set true if you switch to server-side later
    pageLength: 10,
    lengthChange: false,
    info: true,
    order: [[0, 'desc']], // sort by Unique ID (adjust if needed)

    // ➜ Make Action column sortable so it looks/behaves like the others
    columnDefs: [
      { targets: -1, searchable: false },               // keep search off for Action, but allow ordering
      { targets: [2, 10, 22], responsivePriority: 1 },  // important cols on small screens
    ],

    dom: 't<"dt-bottom"ip>' // we'll use our own top controls
  });

  // Wire up custom search
  document.getElementById('reqTableSearch')?.addEventListener('input', function() {
    window.reqDT.search(this.value).draw();
  });

  // Records-per-page selector
  document.getElementById('reqPageLength')?.addEventListener('change', function() {
    window.reqDT.page.len(parseInt(this.value, 10)).draw();
  });

  // Prev/Next buttons (optional convenience)
  document.getElementById('reqPrev')?.addEventListener('click', () => window.reqDT.page('previous').draw('page'));
  document.getElementById('reqNext')?.addEventListener('click', () => window.reqDT.page('next').draw('page'));

  // Update range label
  const rangeEl = document.getElementById('reqRange');
  if (rangeEl) {
    window.reqDT.on('draw', function() {
      const info = window.reqDT.page.info();
      rangeEl.textContent = `${info.start + 1} to ${info.end} of ${info.recordsDisplay}`;
    });
    window.reqDT.draw(false);
  }
})();

// ===== Utils =====
const stripHtml = (html) => {
  const div = document.createElement('div');
  div.innerHTML = html;
  return div.textContent || div.innerText || '';
};

// Helper to pull headers and visible rows from DataTable
function getReqTableData() {
  const headers = window.reqDT.columns().header().toArray().map(th => th.innerText.trim());
  const rows = [];
  window.reqDT.rows({ search: 'applied' }).every(function () {
    const data = this.data().map(c => stripHtml(c));
    rows.push(data);
  });
  return { headers, rows };
}

// ===== COPY =====
document.getElementById('reqCopyBtn')?.addEventListener('click', function(e) {
  const { headers, rows } = getReqTableData();
  const text = [headers.join('\t'), ...rows.map(r => r.join('\t'))].join('\n');
  navigator.clipboard.writeText(text).then(() => {
    const popup = document.getElementById('reqCopyPopup');
    popup.textContent = 'Copied!';
    popup.style.opacity = 1;
    const btnRect = e.target.getBoundingClientRect();
    popup.style.left = (btnRect.left + (btnRect.width/2) - 60) + 'px';
    popup.style.top  = (btnRect.top - 35) + 'px';
    setTimeout(() => popup.style.opacity = 0, 1000);
  });
});

// ===== CSV =====
document.getElementById('reqCsvBtn')?.addEventListener('click', function() {
  const { headers, rows } = getReqTableData();
  const esc = (s) => '"' + String(s).replace(/"/g, '""') + '"';
  const lines = [headers.map(esc).join(',')].concat(rows.map(r => r.map(esc).join(',')));
  const blob = new Blob([lines.join('\n')], { type: 'text/csv' });
  const url = URL.createObjectURL(blob);
  const a = Object.assign(document.createElement('a'), { href: url, download: 'requisitions.csv' });
  a.click(); URL.revokeObjectURL(url);
});

// ===== EXCEL (xlsx) =====
document.getElementById('reqExcelBtn')?.addEventListener('click', function() {
  const { headers, rows } = getReqTableData();
  const wb = XLSX.utils.book_new();
  const ws = XLSX.utils.aoa_to_sheet([headers, ...rows]);
  XLSX.utils.book_append_sheet(wb, ws, 'Requisitions');
  XLSX.writeFile(wb, 'requisitions.xlsx');
});

// ===== PDF (pdfmake) =====
document.getElementById('reqPdfBtn')?.addEventListener('click', function() {
  const { headers, rows } = getReqTableData();
  const body = [
    headers.map(h => ({ text: h, style: 'tableHeader' })),
    ...rows
  ];
  const docDefinition = {
    content: [
      { text: 'Requisitions', style: 'header' },
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
  pdfMake.createPdf(docDefinition).download('requisitions.pdf');
});

// ===== PRINT =====
document.getElementById('reqPrintBtn')?.addEventListener('click', function() {
  const { headers, rows } = getReqTableData();
  let html = "<table border='1' style='border-collapse:collapse;width:100%'>";
  html += "<thead><tr>" + headers.map(h => `<th style='padding:6px;text-align:left'>${h}</th>`).join('') + "</tr></thead>";
  html += "<tbody>";
  rows.forEach(r => {
    html += "<tr>" + r.map(c => `<td style='padding:6px'>${c}</td>`).join('') + "</tr>";
  });
  html += "</tbody></table>";
  const w = window.open('');
  w.document.write(`<html><head><title>Print Requisitions</title></head><body>${html}</body></html>`);
  w.document.close(); w.focus(); w.print(); w.close();
});
</script>
@endsection
