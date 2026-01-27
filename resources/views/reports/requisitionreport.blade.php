@extends('html.default')

<style>
/* ----- DataTables Pagination Styling (Custom Template) ----- */

.dataTables_wrapper .dataTables_paginate {
    display: flex;
    justify-content: flex-end;
    margin-top: 15px;
}

.dataTables_wrapper .dataTables_paginate .paginate_button {
    background: #ffffff;
    border: 1px solid #ddd;
    padding: 6px 12px;
    margin: 0 4px;
    border-radius: 6px;
    cursor: pointer;
    color: #333 !important;
    font-size: 14px;
}

.dataTables_wrapper .dataTables_paginate .paginate_button:hover {
    background: #f8f8f8;
    border-color: #c9c9c9;
}

.dataTables_wrapper .dataTables_paginate .paginate_button.current {
    background: #0d6efd !important; 
    color: #fff !important;
    border-color: #0d6efd;
}

.dataTables_wrapper .dataTables_paginate .paginate_button.disabled {
    opacity: 0.5;
    cursor: not-allowed;
}

/* Replace default text arrows with your icons */
.dataTables_wrapper .dataTables_paginate .paginate_button.previous:before {
    content: url('{{ asset("assets/img/pagi-arrow-left.png") }}');
}
.dataTables_wrapper .dataTables_paginate .paginate_button.next:after {
    content: url('{{ asset("assets/img/pagi-arrow-next.png") }}');
}

/* Remove default text so only icons show */
.dataTables_wrapper .dataTables_paginate .paginate_button.previous,
.dataTables_wrapper .dataTables_paginate .paginate_button.next {
    font-size: 0 !important;
    padding: 6px 10px;
}

/* ------ Length Menu Styling ----- */
.dataTables_wrapper .dataTables_length {
    margin-bottom: 15px;
}

.dataTables_wrapper .dataTables_length select {
    padding: 4px 8px;
    border-radius: 6px;
    border: 1px solid #ddd;
    margin-left: 6px;
}

/* Mobile responsiveness */
@media(max-width: 768px){
    .dataTables_wrapper .dataTables_paginate {
        justify-content: center;
        flex-wrap: wrap;
    }

    .dataTables_wrapper .dataTables_length {
        text-align: center;
    }
}
</style>
@section('content')
<div class="body-content__header">
  <ul>
    <li><a href="#"><Ri:a>Requisition Summary</Ri:a></a></li>
    <li class="ms-auto"></li>
  </ul>
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
            <input type="search" id="tableSearch" placeholder="Search Here.........">
            <button><img src="{{ asset('assets/img/search-icon.png') }}" alt=""></button>
        </div>
    </div>

  <div class="card">

    {{-- BULK ACTION FORM (POST). IMPORTANT: Do NOT include any other forms inside this element --}}
  
    <div class="card-header d-flex align-items-center justify-content-end">
  <button type="button" class="btn btn-primary btn-sm"
          data-bs-toggle="modal" data-bs-target="#filterModal"
          style="padding:10px 20px; font-size:16px; min-width:120px;">
    <i class="fa fa-check-double"></i> Filter
  </button>
</div>

      <div class="card-body">
        <div class="table-responsive" style="overflow-x:auto; width:100%;">
          <table id="myTable"  class="display nowrap" style="width:100%">
            <thead class="table-light text-center">
              <tr>
               
                <th>Requisition #</th>
                @php
                  $hiddenFields = [];
                  $customLabels = [
                      'paymentmethod'   => 'Payment Method',
                      'payment_method'  => 'Payment Method',
                      'invoiceamount'   => 'Invoice Amount',
                  ];
                @endphp

                @foreach($formFields as $field)
                  @continue(in_array(strtolower($field->name), $hiddenFields))
                  @php
                    $fieldName = strtolower($field->name);
                    $label = $customLabels[$fieldName] ?? ucfirst($field->name);
                  @endphp
                  <th>{{ $label }}</th>
                @endforeach

                <th>Approved By</th>
                <th>Status</th>
                <th class="text-center" style="width: 280px;">Action</th>
              </tr>
            </thead>

            <tbody>
              @foreach($fpurchaseorders as $fpurchaseorder)
                @php $active = $fpurchaseorder->status; @endphp
                <tr>
             
                  <td>{{ $fpurchaseorder->requisitionNumber }}</td>

                  @php
                    $normalizedRequisition = [];
                    foreach ($fpurchaseorder->getAttributes() as $key => $value) {
                        $normalizedRequisition[strtolower(trim($key))] = $value;
                    }
                  @endphp

                  @foreach($formFields as $field)
                    @php $normalizedField = strtolower(trim($field->name)); @endphp
                    @continue(in_array($normalizedField, $hiddenFields))
                    <td>
                      @if ($normalizedField === 'department')
                        {{ $departments->firstWhere('id', $fpurchaseorder->department)->name ?? 'Unknown Department' }}
                      @else
                        {{ $normalizedRequisition[$normalizedField] ?? '' }}
                      @endif
                    </td>
                  @endforeach


                  <td class="text-center">
                    @foreach($roles as $role)
                      @if($fpurchaseorder->approvedby == $role->id)
                        {{ $role->name }}
                      @endif
                    @endforeach
                  </td>

                  <td class="text-center">
                    @if($fpurchaseorder->status == 0 || $fpurchaseorder->status == 1)
                      <button type="button" class="btn btn-outline-primary">
                        <span class="fa fa-spinner"></span> Pending
                      </button>
                    @elseif($fpurchaseorder->status == 2)
                      <button type="button" class="btn btn-outline-success">
                        <span class="fa fa-check-circle"></span> Approved
                      </button>
                    @elseif($fpurchaseorder->status == 3)
                      <button type="button" class="btn btn-outline-danger">
                        <span class="fa fa-times-circle"></span> Rejected
                      </button>
                    @elseif($fpurchaseorder->status == 4)
                      <button type="button" class="btn btn-outline-info">
                        <span class="fa fa-arrow-left"></span> Returned
                      </button>
                    @else
                      <button type="button" class="btn btn-outline-primary">
                        <span class="fa fa-spinner"></span> Processing
                      </button>
                    @endif
                  </td>

                  <td class="text-center" style="white-space: nowrap;">
                    {{-- NOTE: type="button" so they don't submit the bulk form --}}
                    <button type="button" class="btn btn-success btn-sm"
                            data-bs-toggle="modal" data-bs-target="#historyModal{{ $fpurchaseorder->id }}">
                      <span class="fa fa-history"></span> Logs
                    </button>

                    <a href="/procurement/{{ $fpurchaseorder->id }}/viewrequisition"
                       class="btn btn-info btn-sm">
                      <span class="fa fa-desktop"></span> View
                    </a>

                    {{-- <button type="button" class="btn btn-success btn-sm"
                            data-bs-toggle="modal" data-bs-target="#viewdocuments{{ $fpurchaseorder->id }}">
                      <span class="fa fa-file"></span> View Documents
                    </button> --}}
                  </td>
                </tr>
              @endforeach
            </tbody>
          </table>
        </div>
    <div class="requesition-bottom">
      
      </div>
    {{-- END BULK FORM --}}

    {{-- ===== Render modals OUTSIDE the bulk form to avoid nested forms ===== --}}
    @foreach($fpurchaseorders as $fpurchaseorder)
      {{-- View Documents Modal (no form needed) --}}
      <div class="modal fade" id="viewdocuments{{ $fpurchaseorder->id }}" tabindex="-1" aria-labelledby="viewdocuments{{ $fpurchaseorder->id }}Label" aria-hidden="true">
        <div class="modal-dialog modal-lg">
          <div class="modal-content">
            <div class="modal-header">
              <h4 class="modal-title" id="viewdocuments{{ $fpurchaseorder->id }}Label">
                <i class="fa fa-folder-open"></i> View Documents
              </h4>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="modal-body" style="font-size:14px;">
              @php
                $docs = [
                  'Quotation' => $fpurchaseorder->quotation ?? null,
                  'Invoice'   => $fpurchaseorder->invoice ?? null,
                  'POP'       => $fpurchaseorder->pop ?? null,
                  'Job Card'  => $fpurchaseorder->jobcard ?? null,
                ];
              @endphp

              @if(array_filter($docs))
                <div class="mt-2">
                  <table class="table table-sm table-bordered table-striped">
                    <thead>
                      <tr>
                        <th>#</th>
                        <th>Document Name</th>
                        <th>Action</th>
                      </tr>
                    </thead>
                    <tbody>
                      @php $counter = 1; @endphp
                      @foreach($docs as $label => $file)
                        @if($file)
                          <tr>
                            <td>{{ $counter++ }}</td>
                            <td>{{ $label }}</td>
                            <td>
                              <a href="{{ asset('storage/uploads/' . $file) }}" target="_blank" class="btn btn-sm btn-info">
                                View
                              </a>
                            </td>
                          </tr>
                        @endif
                      @endforeach
                    </tbody>
                  </table>
                </div>
              @else
                <div class="alert alert-info">
                  <i class="fa fa-info-circle"></i> No documents available for this purchase order.
                </div>
              @endif
            </div>

            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
          </div>
        </div>
      </div>

      {{-- History Modal (no form inside) --}}
      <div class="modal fade" id="historyModal{{ $fpurchaseorder->id }}" tabindex="-1" aria-labelledby="historyModal{{ $fpurchaseorder->id }}Label" aria-hidden="true">
        <div class="modal-dialog modal-lg">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="historyModal{{ $fpurchaseorder->id }}Label">Requisition Logs</h5>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
              <section class="bsb-timeline-7 py-3">
                <div class="container">
                  @if($fpurchaseorder->histories->isEmpty())
                    <div class="alert alert-info">
                      <i class="fa fa-info-circle"></i> No history found for this requisition.
                    </div>
                  @else
                    <ul class="timeline">
                      @foreach($fpurchaseorder->histories as $history)
                        @php $date = \Carbon\Carbon::parse($history->created_at); @endphp
                        <li class="timeline-item">
                          <div class="timeline-body">
                            <div class="timeline-meta">
                              <div class="d-inline-flex flex-column px-2 py-1 text-success-emphasis bg-success-subtle border rounded-2">
                                <span class="fw-bold">{{ $date->format('d F Y') }}</span>
                                <span>{{ $date->format('g:ia') }}</span>
                              </div>
                            </div>
                            <div class="timeline-content timeline-indicator">
                              <div class="card border-0 shadow">
                                <div class="card-body p-xl-4" style="position: relative;">
                                  <h6 class="card-subtitle text-secondary mb-3" style="position:absolute; top:10px; right:10px;">
                                    {{ $loop->iteration }}
                                  </h6>
                                  <h2 class="card-title mb-2">{{ $history->doneby }}</h2>
                                  <p class="card-text m-0">{{ $history->action }}</p>
                                </div>
                              </div>
                            </div>
                          </div>
                        </li>
                      @endforeach
                    </ul>
                  @endif
                </div>
              </section>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
          </div>
        </div>
      </div>

      {{-- POP Upload Modal (has its own PUT form, but NOT nested) --}}
      <div class="modal fade" id="pop{{ $fpurchaseorder->id }}" tabindex="-1" aria-labelledby="pop{{ $fpurchaseorder->id }}Label" aria-hidden="true">
        <div class="modal-dialog modal-md">
          <div class="modal-content">
            <div class="modal-header">
              <h4 class="modal-title" id="pop{{ $fpurchaseorder->id }}Label">
                <i class="fa fa-envelope"></i> Upload Proof of Payment
              </h4>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <form method="POST" action="/procurement/{{ $fpurchaseorder->id }}/pop" enctype="multipart/form-data">
              @csrf
              @method('put')

              <div class="modal-body" style="font-size:14px;">
                <div class="mb-3">
                  <label for="popfile{{ $fpurchaseorder->id }}" class="form-label">Upload document</label>
                  <input type="file" name="pop" id="popfile{{ $fpurchaseorder->id }}" class="form-control" required />
                </div>
              </div>

              <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary">
                  <span class="fa fa-upload"></span> Upload
                </button>
              </div>
            </form>
          </div>
        </div>
      </div>
    @endforeach
    {{-- ===== end modals ===== --}}

    {{-- Filter Modal --}}
<div class="modal fade" id="filterModal" tabindex="-1" aria-labelledby="filterModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-md">
    <form method="GET" action="{{ route('requisitionsummary.filtered') }}">
    
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title" id="filterModalLabel">Filter Purchase Req Summary</h4>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>

        <div class="modal-body">
          <div class="form-col">
            <label for="start_date">Date From</label>
            <input class="form-control" id="start_date" name="start_date" type="date">
          </div>

          <div class="form-col mt-3">
            <label for="end_date">Date To</label>
            <input class="form-control" id="end_date" name="end_date" type="date">
          </div>

          <div class="form-col mt-3">
            <label for="status">Status</label>
            <select id="status" name="status" class="form-control">
              <option value="">--Select Status--</option>
              <option value="2">Approved</option>
              <option value="3">Rejected</option>
             <option value="1">Pending</option>
            </select>
          </div>
          

          <div class="form-col mt-3">
            <label for="vendor">Vendor</label>
            <select id="vendor" name="vendor" class="form-control">
              <option value="">--Select Vendor--</option>
              @foreach($vendors as $vendor)
                <option value="{{ $vendor->vendor }}">{{ $vendor->vendor }}</option>
              @endforeach
            </select>
          </div>
        </div>

        <div class="modal-footer">
          <div class="d-flex justify-content-end gap-2 w-100">
            <button type="button" class="btn btn-danger" data-bs-dismiss="modal" style="padding:10px 20px; min-width:110px;">
              Close
            </button>
            <button type="submit" class="btn btn-success" style="padding:10px 20px; min-width:150px;">
              Filter Summary
            </button>
          </div>
        </div>
      </div>
    </form>
  </div>
</div>

  </div>
</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/vfs_fonts.js"></script>


<script>
$(document).ready(function () {

    // Initialize DataTable
    window.dt = $('#myTable').DataTable({
        responsive: true,
        paging: true,
        searching: true,
        lengthChange: true,   // <-- allows user to choose 10 / 25 / 50 / 100
        pageLength: 10,       // default number of rows
        lengthMenu: [[10, 25, 50, 100], [10, 25, 50, 100]],
        ordering: true,
        autoWidth: false,
        columnDefs: [
            { targets: '_all', className: 'text-center' }
        ]
    });

});
</script>

<script>
// Utility: strip HTML tags (so exports don't include raw <button> etc.)
const stripHtml = (html) => {
  const div = document.createElement('div');
  div.innerHTML = html;
  return div.textContent || div.innerText || '';
};

// If you have your own search input, wire it to DataTables:
document.getElementById('tableSearch')?.addEventListener('input', function() {
  window.dt.search(this.value).draw();
});

// ===== COPY =====
document.getElementById("copyBtn").addEventListener("click", function (e) {
  const headers = window.dt.columns().header().toArray().map(th => th.innerText.trim());
  const rows = [];
  window.dt.rows({ search: 'applied' }).every(function () {
    const data = this.data().map(c => stripHtml(c));
    rows.push(data);
  });
  const text = [headers.join('\t')].concat(rows.map(r => r.join('\t'))).join('\n');

  navigator.clipboard.writeText(text).then(() => {
    const popup = document.getElementById("copyPopup");
    popup.textContent = "Copied!";
    popup.style.opacity = 1;
    const btnRect = e.target.getBoundingClientRect();
    popup.style.left = (btnRect.left + (btnRect.width/2) - 60) + "px";
    popup.style.top  = (btnRect.top - 35) + "px";
    setTimeout(() => popup.style.opacity = 0, 1000);
  });
});

// ===== CSV =====
document.getElementById("csvBtn").addEventListener("click", function () {
  const headers = window.dt.columns().header().toArray().map(th => '"' + th.innerText.replace(/"/g,'""') + '"');
  const lines = [headers.join(',')];
  window.dt.rows({ search: 'applied' }).every(function () {
    const data = this.data().map(c => '"' + stripHtml(c).replace(/"/g,'""') + '"');
    lines.push(data.join(','));
  });
  const blob = new Blob([lines.join('\n')], { type: 'text/csv' });
  const url = URL.createObjectURL(blob);
  const a = Object.assign(document.createElement('a'), { href: url, download: 'table.csv' });
  a.click();
  URL.revokeObjectURL(url);
});

// ===== EXCEL (xlsx) =====
document.getElementById("excelBtn").addEventListener("click", function () {
  const headers = window.dt.columns().header().toArray().map(th => th.innerText.trim());
  const rows = [headers];
  window.dt.rows({ search: 'applied' }).every(function () {
    rows.push(this.data().map(c => stripHtml(c)));
  });
  const wb = XLSX.utils.book_new();
  const ws = XLSX.utils.aoa_to_sheet(rows);
  XLSX.utils.book_append_sheet(wb, ws, "Users");
  XLSX.writeFile(wb, "table.xlsx");
});

// ===== PDF (pdfmake) =====
document.getElementById("pdfBtn").addEventListener("click", function () {
  const headers = window.dt.columns().header().toArray().map(th => ({ text: th.innerText, style: 'tableHeader' }));
  const body = [headers];
  window.dt.rows({ search: 'applied' }).every(function () {
    body.push(this.data().map(c => stripHtml(c)));
  });

  const docDefinition = {
    pageOrientation: 'landscape',       // ✅ makes it landscape
    pageSize: 'A3',                     // ✅ gives more width for large tables
    content: [
      { text: "Requisition Summary", style: "header", alignment: "center" },
      {
        table: {
          headerRows: 1,
          widths: Array(headers.length).fill('auto'), // ✅ dynamic column widths
          body: body
        },
        layout: {
          fillColor: function (rowIndex, node, columnIndex) {
            return rowIndex === 0 ? '#eeeeee' : null;
          }
        }
      }
    ],
    styles: {
      header: { fontSize: 18, bold: true, margin: [0, 0, 0, 10] },
      tableHeader: { bold: true, fillColor: "#eeeeee" }
    }
  };

  pdfMake.createPdf(docDefinition).download("Requisition_Summary.pdf");
});

// ===== PRINT =====
document.getElementById("printBtn").addEventListener("click", function () {
  const headers = window.dt.columns().header().toArray().map(th => th.innerText);
  const rows = [];
  window.dt.rows({ search: 'applied' }).every(function () {
    rows.push(this.data().map(c => stripHtml(c)));
  });

  let html = "<table border='1' style='border-collapse:collapse;width:100%'>";
  html += "<thead><tr>" + headers.map(h => `<th>${h}</th>`).join("") + "</tr></thead>";
  html += "<tbody>";
  rows.forEach(r => {
    html += "<tr>" + r.map(c => `<td>${c}</td>`).join("") + "</tr>";
  });
  html += "</tbody></table>";

  const w = window.open("");
  w.document.write(`<html><head><title>Print Table</title></head><body>${html}</body></html>`);
  w.document.close();
  w.focus();
  w.print();
  w.close();
});
</script>
@endsection


<script src="https://unpkg.com/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
