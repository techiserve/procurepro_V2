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
                            <button id="copyBtn"><img src="assets/img/copy-icon.png" alt=""> Copy</button>
                            <div id="copyPopup" class="copy-popup"></div>
                        </li>
                        <li>
                            <button id="csvBtn"><img src="assets/img/csv-icon.png" alt=""> CSV</button>
                            <input type="file" id="csvFile" accept=".csv" style="display:none;" />
                        </li>
                        <li>
                            <button id="excelBtn"><img src="assets/img/excel-icon.png" alt=""> Excel</button>
                            <input type="file" id="excelFile" accept=".xlsx, .xls" style="display:none;">
                        </li>
                        <li>
                            <button id="pdfBtn"><img src="assets/img/pdf-icon.png" alt=""> PDF</button>
                            <input type="file" id="pdfFile" accept=".pdf" style="display:none;">
                        </li>
                        <li>
                            <button id="printBtn"> <img src="assets/img/print-icon.png" alt=""> Print</button>
                        </li>
        </ul>
        <div class="requesition-search">
            <input type="search" id="tableSearch" placeholder="Search Here.........">
            <button><img src="assets/img/search-icon.png" alt=""></button>
        </div>
    </div>

    <div class="requesition-table">
        <table id="example" class="display responsive nowrap" style="width:100%">
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
            <li><button><img src="assets/img/pagi-arrow-left.png" alt=""></button></li>
            <li><p>0 to {{ count($users) }}</p></li>
            <li><button><img src="assets/img/pagi-arrow-next.png" alt=""></button></li>
        </ul>
    </div>
</div>

{{-- Include SweetAlert2 --}}
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.all.min.js"></script>

{{-- Optional: Table export/print JS functions --}}

        <script>
document.getElementById("copyBtn").addEventListener("click", function (e) {
    let table = document.getElementById("myTable");
    let text = "";
    for (let row of table.rows) {
        let cells = [...row.cells].map(cell => cell.innerText.trim());
        text += cells.join("\t") + "\n";
    }

    navigator.clipboard.writeText(text).then(() => {
        let popup = document.getElementById("copyPopup");
        popup.style.opacity = 1; // Make visible first

        let btnRect = e.target.getBoundingClientRect();

        // Center above button
        popup.style.left = (btnRect.left + (btnRect.width / 2) - (120 / 2)) + "px";
        popup.style.top = (btnRect.top - 35) + "px";

        // Fade out after 1s
        setTimeout(() => {
            popup.style.opacity = 0;
        }, 1000);
    });
});
</script>

<script>
// Click on CSV button opens file picker
document.getElementById('csvBtn').addEventListener('click', function() {
    document.getElementById('csvFile').click();
});

// When file selected, read CSV
document.getElementById('csvFile').addEventListener('change', function(e) {
    let file = e.target.files[0];
    if (!file) return;

    let reader = new FileReader();
    reader.onload = function(e) {
        let text = e.target.result;
        let rows = text.split('\n').map(row => row.split(','));

        let table = document.getElementById('myTable');
        table.innerHTML = ""; // Clear old data

        rows.forEach((row, i) => {
            let tr = document.createElement('tr');
            row.forEach(cell => {
                let td = document.createElement(i === 0 ? 'th' : 'td');
                td.textContent = cell.trim();
                tr.appendChild(td);
            });
            table.appendChild(tr);
        });
    };
    reader.readAsText(file);
});
</script>

<script>
document.getElementById('excelBtn').addEventListener('click', () => {
    document.getElementById('excelFile').click();
});

document.getElementById('excelFile').addEventListener('change', (e) => {
    let file = e.target.files[0];
    if (!file) return;

    let reader = new FileReader();
    reader.onload = (event) => {
        let data = new Uint8Array(event.target.result);
        let workbook = XLSX.read(data, { type: 'array' });
        let sheetName = workbook.SheetNames[0];
        let sheet = XLSX.utils.sheet_to_json(workbook.Sheets[sheetName], { header: 1 });

        loadTable(sheet);
    };
    reader.readAsArrayBuffer(file);
});
</script>
<script>
document.getElementById('pdfBtn').addEventListener('click', () => {
    document.getElementById('pdfFile').click();
});

document.getElementById('pdfFile').addEventListener('change', (e) => {
    let file = e.target.files[0];
    if (!file) return;

    let fileReader = new FileReader();
    fileReader.onload = function() {
        let typedarray = new Uint8Array(this.result);

        pdfjsLib.getDocument(typedarray).promise.then(pdf => {
            pdf.getPage(1).then(page => {
                page.getTextContent().then(textContent => {
                    let text = textContent.items.map(item => item.str).join(" ");
                    alert("PDF text: " + text); // Example, you can parse into table
                });
            });
        });
    };
    fileReader.readAsArrayBuffer(file);
});
</script>
<script>
document.getElementById('printBtn').addEventListener('click', () => {
    let printContents = document.getElementById('myTable').outerHTML;
    let win = window.open('', '', 'height=600,width=800');
    win.document.write('<html><head><title>Print</title></head><body>');
    win.document.write(printContents);
    win.document.write('</body></html>');
    win.document.close();
    win.print();
});
</script>
<script>
function loadTable(data) {
    let table = document.getElementById('myTable');
    table.innerHTML = "";
    data.forEach((row, i) => {
        let tr = document.createElement('tr');
        row.forEach(cell => {
            let td = document.createElement(i === 0 ? 'th' : 'td');
            td.textContent = cell;
            tr.appendChild(td);
        });
        table.appendChild(tr);
    });
}
</script>
<script>
document.getElementById('printBtn').addEventListener('click', () => {
    let table = document.getElementById('myTable').cloneNode(true);
    let win = window.open('', '', 'height=600,width=800');
    win.document.write('<html><head><title>Print</title>');
    win.document.write('<link rel="stylesheet" href="assets/css/bootstrap.min.css">');
    win.document.write('<style>table{border-collapse:collapse;width:100%;}th,td{border:1px solid #000;padding:5px;}</style>');
    win.document.write('</head><body>');
    win.document.write(table.outerHTML);
    win.document.write('</body></html>');
    win.document.close();
    win.print();
});
</script>
@endsection
