@extends('html.default')

@section('content')
<div class="body-content__header">
    <ul>
        <li><a href="#">Users List</a></li>
    </ul>
    <a href="/users/create" class="btn-requisition-list"><i class="icon-20"></i> Add User</a>
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

    <div class="requesition-table">
        <!-- IMPORTANT: id="myTable" -->
        <table id="myTable" class="display responsive nowrap" style="width:100%">
            <thead>
                <tr>
                    <th class="text-center">Name</th>
                    <th class="text-center">Position</th>
                    <th class="text-center">Phone Number</th>
                    <th class="text-center">Email</th>
                    <th class="text-center">Status</th>
                    <th class="text-center">Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach($users as $user)
                <tr>
                    <td class="text-center">{{ $user->name }}</td>
                    <td class="text-center">{{ $user->position }}</td>
                    <td class="text-center">{{ $user->phoneNumber }}</td>
                    <td class="text-center">{{ $user->email }}</td>
                    <td class="text-center">
                        @if($user->isActive == 1 && $user->is_locked != 1)
                            <button type="button" class="btn btn-outline-success"><span class="fa fa-check-circle"></span> Active</button>
                        @elseif($user->isActive != 1 && $user->is_locked != 1)
                            <button type="button" class="btn btn-outline-danger"><span class="fa fa-check-circle"></span> InActive</button>
                        @elseif($user->is_locked == 1)
                            <button type="button" class="btn btn-outline-danger"><span class="fa fa-check-circle"></span> Locked</button>
                        @else
                            <button type="button" class="btn btn-outline-info"><span class="fa fa-check-circle"></span> Unsigned</button>
                        @endif
                    </td>
                    <td class="text-center">
                        <a href="/users/{{ $user->id }}/edit" class="btn btn-icon btn-info mr-1">
                            <i class="fa fa-pencil"></i> Edit
                        </a>
                        <a href="#" class="btn btn-icon btn-danger mr-1" onclick="
                            event.preventDefault();
                            Swal.fire({
                                title: 'Delete User?',
                                text: 'You won\'t be able to undo this!',
                                icon: 'warning',
                                showCancelButton: true,
                                confirmButtonText: 'Continue',
                                cancelButtonText: 'Cancel'
                            }).then((result) => {
                                if (result.isConfirmed) {
                                    window.location.href = '/users/{{ $user->id }}/delete';
                                }
                            });
                        ">
                            <i class="fa fa-trash"></i> Delete
                        </a>
                        @if($user->is_locked == 1)
                            <a href="/users/{{ $user->id }}/unlock" class="btn btn-icon btn-success mr-1">
                                <i class="fa fa-check-circle"></i> Unlock
                            </a>
                        @endif
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div class="requesition-bottom">
        <div class="page-number">
            <label>Records per page:</label>
            <select>
                <option value="10">10</option>
                <option value="25">25</option>
                <option value="50">50</option>
            </select>
        </div>
        <ul class="requesition-pagination">
            <li><button><img src="{{ asset('assets/img/pagi-arrow-left.png') }}" alt=""></button></li>
            <li><p>0 to {{ count($users) }}</p></li>
            <li><button><img src="{{ asset('assets/img/pagi-arrow-next.png') }}" alt=""></button></li>
        </ul>
    </div>
</div>

{{-- SweetAlert2 --}}
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.all.min.js"></script>

{{-- pdfmake for PDF --}}
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/vfs_fonts.js"></script>

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
    content: [
      { text: "Users Table", style: "header" },
      {
        table: { headerRows: 1, widths: Array(headers.length).fill('*'), body }
      }
    ],
    styles: {
      header: { fontSize: 16, bold: true, margin: [0, 0, 0, 10] },
      tableHeader: { bold: true, fillColor: "#eeeeee" }
    },
    pageOrientation: 'landscape'
  };
  pdfMake.createPdf(docDefinition).download("table.pdf");
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
