@extends('html.default')

@section('content')
<div class="body-content__header">
    <ul><li><a href="#">{{ $bankLabel }} Purchase Requisitions</a></li></ul>
</div>

<div class="body-content__wrapper requesition-body">
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center flex-wrap gap-2">
            <strong>{{ $bankLabel }} Purchase Requisitions</strong>
            <div class="d-flex gap-2">
                <button type="button" id="prBankCsv" class="btn btn-outline-secondary btn-sm" title="Download CSV">
                    <i class="fa fa-file-csv"></i> CSV
                </button>
                <button type="button" id="prBankExcel" class="btn btn-outline-secondary btn-sm" title="Download Excel">
                    <i class="fa fa-file-excel"></i> Excel
                </button>
                <button type="button" id="prBankPdf" class="btn btn-outline-secondary btn-sm" title="Download PDF">
                    <i class="fa fa-file-pdf"></i> PDF
                </button>
            </div>
        </div>

        <div class="card-body">
            <form method="GET" action="{{ url()->current() }}" class="row g-2 align-items-end mb-3">
                <div class="col-md-3">
                    <label for="date_from" class="form-label">From</label>
                    <input id="date_from" name="date_from" type="date" class="form-control" value="{{ $filters['date_from'] ?? '' }}">
                </div>
                <div class="col-md-3">
                    <label for="date_to" class="form-label">To</label>
                    <input id="date_to" name="date_to" type="date" class="form-control" value="{{ $filters['date_to'] ?? '' }}">
                </div>
                <div class="col-md-3">
                    <label for="department" class="form-label">Department</label>
                    <select id="department" name="department" class="form-control">
                        <option value="">All departments</option>
                        @foreach($departments as $departmentId => $departmentName)
                            <option value="{{ $departmentId }}" @selected(($filters['department'] ?? '') == $departmentId)>{{ $departmentName }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-3 d-flex gap-2">
                    <button type="submit" class="btn btn-primary">Filter</button>
                    <a href="{{ url()->current() }}" class="btn btn-outline-secondary">Clear</a>
                </div>
            </form>

            <div class="mb-3">
                <label for="prBankSearch" class="form-label">Search</label>
                <input id="prBankSearch" type="search" class="form-control" placeholder="Search requisitions">
            </div>

            <div class="table-responsive">
                <table id="prBankReportTable" class="table table-striped table-bordered display" style="width:100%">
                    <thead class="table-light">
                        <tr>
                            <th>Requisition</th>
                            <th>Date</th>
                            <th>Department</th>
                            <th>Vendor</th>
                            <th>Vendor Bank</th>
                            <th>Vendor Account</th>
                            <th>Account Type</th>
                            <th>Amount</th>
                            <th>Company Account</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($frequisitions as $requisition)
                            <tr>
                                <td>{{ $requisition->requisitionNumber }}</td>
                                <td>{{ optional($requisition->created_at)->format('Y-m-d') }}</td>
                                <td>{{ $departments[$requisition->department] ?? '' }}</td>
                                <td>{{ $requisition->bankReportVendorName() }}</td>
                                <td>{{ $requisition->selectedVendor?->bank }}</td>
                                <td>{{ $requisition->selectedVendor?->account_number }}</td>
                                <td>{{ $requisition->selectedVendor?->account_type }}</td>
                                <td>{{ number_format((float) $requisition->amount, 2) }}</td>
                                <td>{{ $requisition->bankAccountNumber }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/vfs_fonts.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function () {
    const table = $('#prBankReportTable').DataTable({
        pageLength: 10,
        order: [[1, 'desc']],
        dom: 't<"dt-bottom"ip>',
        language: { emptyTable: 'No approved requisitions for this bank.' }
    });
    document.getElementById('prBankSearch').addEventListener('input', function () {
        table.search(this.value).draw();
    });

    const title = @json($bankLabel . ' Purchase Requisitions');
    const filename = @json($bankSlug . '-purchase-requisitions');
    function exportData() {
        const headers = table.columns().header().toArray().map(cell => cell.textContent.trim());
        const rows = table.rows({ search: 'applied' }).data().toArray().map(row =>
            row.map(value => {
                const element = document.createElement('div');
                element.innerHTML = value;
                return element.textContent.trim();
            })
        );
        return { headers, rows };
    }

    document.getElementById('prBankCsv').addEventListener('click', function () {
        const { headers, rows } = exportData();
        const quote = value => '"' + String(value).replace(/"/g, '""') + '"';
        const csv = [headers, ...rows].map(row => row.map(quote).join(',')).join('\r\n');
        const url = URL.createObjectURL(new Blob([csv], { type: 'text/csv;charset=utf-8' }));
        const link = document.createElement('a');
        link.href = url;
        link.download = filename + '.csv';
        link.click();
        URL.revokeObjectURL(url);
    });

    document.getElementById('prBankExcel').addEventListener('click', function () {
        const { headers, rows } = exportData();
        const workbook = XLSX.utils.book_new();
        const worksheet = XLSX.utils.aoa_to_sheet([headers, ...rows]);
        XLSX.utils.book_append_sheet(workbook, worksheet, 'Requisitions');
        XLSX.writeFile(workbook, filename + '.xlsx');
    });

    document.getElementById('prBankPdf').addEventListener('click', function () {
        const { headers, rows } = exportData();
        pdfMake.createPdf({
            pageOrientation: 'landscape',
            content: [
                { text: title, style: 'header' },
                { table: { headerRows: 1, widths: Array(headers.length).fill('*'), body: [headers, ...rows] } }
            ],
            styles: { header: { fontSize: 15, bold: true, margin: [0, 0, 0, 12] } },
            defaultStyle: { fontSize: 7 }
        }).download(filename + '.pdf');
    });
});
</script>
@endsection
