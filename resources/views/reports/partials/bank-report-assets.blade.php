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
    .bank-report-table-host .dataTables_wrapper {
        overflow: visible;
    }
    .bank-report-pagination {
        display: flex;
        align-items: center;
        justify-content: space-between;
        flex-wrap: wrap;
        gap: 12px 20px;
        padding-top: 16px;
        font-size: 14px;
        color: #475569;
    }
    .bank-report-pagination .dataTables_length,
    .bank-report-pagination .dataTables_info,
    .bank-report-pagination .dataTables_paginate {
        display: block !important;
        float: none !important;
        margin: 0 !important;
        padding: 0 !important;
    }
    .bank-report-pagination .dataTables_length select {
        min-width: 80px;
        width: auto !important;
        display: inline-block !important;
        margin: 0;
        padding: 5px 8px;
        border: 1px solid #cbd5e1;
        border-radius: 4px;
        background: #fff;
    }
    .bank-report-pagination .dataTables_length label {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        margin: 0;
        white-space: nowrap;
    }
    .bank-report-pagination .dataTables_paginate {
        display: flex !important;
        align-items: center;
        flex-wrap: wrap;
        justify-content: flex-end;
        gap: 4px;
    }
    .bank-report-pagination .dataTables_paginate .paginate_button {
        display: inline-flex !important;
        align-items: center;
        justify-content: center;
        min-width: 34px;
        height: 34px;
        margin: 0 !important;
        padding: 0 8px !important;
        border: 1px solid #d3dce8 !important;
        border-radius: 4px;
        background: #fff !important;
        color: #1f5dbd !important;
        text-decoration: none !important;
    }
    .bank-report-pagination .dataTables_paginate .paginate_button:hover:not(.disabled):not(.current) {
        border-color: #1f5dbd !important;
        background: #eef5ff !important;
    }
    .bank-report-pagination .dataTables_paginate .paginate_button.current {
        border-color: #1f5dbd !important;
        background: #1f5dbd !important;
        color: #fff !important;
    }
    .bank-report-pagination .dataTables_paginate .paginate_button.disabled {
        opacity: .45;
        cursor: default;
    }
    @media (max-width: 600px) {
        .bank-report-pagination .dataTables_paginate {
            justify-content: flex-start;
        }
    }
</style>
<script defer src="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.all.min.js"></script>
<script defer src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/pdfmake.min.js"></script>
<script defer src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/vfs_fonts.js"></script>
@if($bankSlug === 'fnb')
<script defer src="{{ asset('assets/js/fnb-batch-export.js') }}?v={{ substr(hash_file('sha256', public_path('assets/js/fnb-batch-export.js')), 0, 12) }}"></script>
@endif
<script defer src="{{ asset('assets/js/bank-report.js') }}?v={{ substr(hash_file('sha256', public_path('assets/js/bank-report.js')), 0, 12) }}"></script>
