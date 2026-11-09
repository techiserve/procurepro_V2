<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Purchase Order {{ $purchaseOrder->requisitionNumber }}</title>
    <style>
        @page { margin: 40px 42px 48px; }
        body { font-family: DejaVu Sans, sans-serif; font-size: 10px; color: #253243; }
        h1 { margin: 0 0 4px; font-size: 20px; color: #123b5d; }
        h2 { margin: 20px 0 7px; font-size: 11px; color: #123b5d; text-transform: uppercase; }
        .subtitle { color: #637589; margin-bottom: 18px; }
        .rule { border-top: 2px solid #188a84; margin-bottom: 16px; }
        table { width: 100%; border-collapse: collapse; }
        td, th { padding: 7px 8px; border-bottom: 1px solid #e3e9ee; text-align: left; vertical-align: top; }
        th { color: #51677c; font-weight: bold; background: #f3f6f8; }
        .label { width: 24%; color: #637589; }
        .muted { color: #637589; }
        .note { margin-top: 17px; padding: 10px 12px; background: #eef6f5; border-left: 3px solid #188a84; }
        tr { page-break-inside: avoid; }
    </style>
</head>
<body>
    <h1>Purchase Order</h1>
    <div class="subtitle">Requisition {{ $purchaseOrder->requisitionNumber }} &nbsp;|&nbsp; PO #{{ $purchaseOrder->id }}</div>
    <div class="rule"></div>

    @php
        $status = [0 => 'Pending', 1 => 'Pending', 2 => 'Approved', 3 => 'Rejected', 4 => 'Returned'][$purchaseOrder->status] ?? 'Processing';
    @endphp
    <table>
        <tr><td class="label">Status</td><td>{{ $status }}</td><td class="label">Created</td><td>{{ $purchaseOrder->created_at?->format('d M Y, H:i') ?? '-' }}</td></tr>
        <tr><td class="label">Requester</td><td>{{ $requester?->name ?? '-' }}</td><td class="label">Department</td><td>{{ $department?->name ?? '-' }}</td></tr>
        <tr><td class="label">Vendor</td><td>{{ $vendorName ?: 'Not selected' }}</td><td class="label">Amount</td><td>{{ is_numeric($purchaseOrder->amount) ? number_format($purchaseOrder->amount, 2) : '-' }}</td></tr>
        <tr><td class="label">Invoice amount</td><td>{{ is_numeric($purchaseOrder->invoiceamount) ? number_format($purchaseOrder->invoiceamount, 2) : '-' }}</td><td></td><td></td></tr>
    </table>

    @if($details)
        <h2>Details</h2>
        <table>
            @foreach($details as $detail)
                <tr><td class="label">{{ $detail['label'] }}</td><td>{{ $detail['value'] }}</td></tr>
            @endforeach
        </table>
    @endif

    <h2>Activity Log</h2>
    <table>
        <thead><tr><th style="width: 21%">Date</th><th style="width: 23%">By</th><th>Action</th></tr></thead>
        <tbody>
            @forelse($history as $entry)
                <tr>
                    <td>{{ $entry->created_at?->format('d M Y, H:i') ?? '-' }}</td>
                    <td>{{ $entry->doneby ?: '-' }}</td>
                    <td>{{ $entry->action ?: '-' }}@if($entry->reason)<br><span class="muted">{{ $entry->reason }}</span>@endif</td>
                </tr>
            @empty
                <tr><td colspan="3" class="muted">No activity recorded.</td></tr>
            @endforelse
        </tbody>
    </table>

    <div class="note">
        <strong>PDF documents:</strong> {{ count($pdfPaths) }} attached after this summary.
        @if($skippedPdfs > 0)
            {{ $skippedPdfs }} missing or unreadable PDF {{ $skippedPdfs === 1 ? 'was' : 'were' }} omitted.
        @endif
        <span class="muted">Images and Word documents are not included.</span>
    </div>
</body>
</html>
