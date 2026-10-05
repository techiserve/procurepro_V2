@if(session('success'))
    <div class="alert alert-success mb-3" role="status">{{ session('success') }}</div>
@endif
<div class="d-flex justify-content-between align-items-end flex-wrap gap-3 mb-3">
    <div style="min-width:240px; flex:1; max-width:420px;">
        <label for="bankReportSearch" class="form-label">Search</label>
        <input id="bankReportSearch" type="search" class="form-control" placeholder="Search {{ $reportType === 'pr' ? 'requisitions' : 'purchase orders' }}">
    </div>
    <form method="POST" action="{{ route('reports.bank.clear', ['type' => $reportType, 'bank' => $bankSlug]) }}" data-bank-clear-form data-total-rows="{{ $totalReportRows }}" class="d-flex align-items-center flex-wrap gap-2">
        @csrf
        <input type="hidden" name="scope" value="selected">
        <span data-selected-count class="small text-muted me-1">0 selected</span>
        <button type="button" data-clear-selected class="btn btn-outline-danger btn-sm" disabled>
            <i class="fa fa-eraser" aria-hidden="true"></i> Clear selected
        </button>
        <button type="button" data-clear-all class="btn btn-outline-secondary btn-sm" @disabled($totalReportRows === 0) title="Clear every row in this bank report, including rows outside current filters">
            <i class="fa fa-list-check" aria-hidden="true"></i> Clear all
        </button>
    </form>
</div>
