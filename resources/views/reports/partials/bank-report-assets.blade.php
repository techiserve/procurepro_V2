<style>
    .bank-report-table th,
    .bank-report-table td {
        white-space: nowrap;
        vertical-align: middle;
    }
    .bank-report-table .bank-checkbox-col {
        width: 44px;
        min-width: 44px;
        text-align: center;
    }
    .bank-report-table .bank-row-checkbox,
    .bank-report-table [data-select-all] {
        margin: 0;
        cursor: pointer;
    }
    .bank-report-table td:first-child {
        text-align: center;
    }
</style>
<script defer src="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.all.min.js"></script>
<script defer src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/pdfmake.min.js"></script>
<script defer src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/vfs_fonts.js"></script>
<script defer src="{{ asset('assets/js/bank-report.js') }}"></script>
