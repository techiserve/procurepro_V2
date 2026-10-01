@php
    $bankReportsOpen = request()->is('reports/fnb', 'reports/albarak', 'reports/standardbank', 'reports/requisitions/*');
    $customReportsOpen = request()->is('reports', 'reports/create', 'itemizedreports*', 'dashboard/procurement') || request()->routeIs('reports.show');
    $summaryReportsOpen = request()->is('reports/requisitionreport', 'reports/purchaseorderreport', 'reports/filtered*');
    $procureProReportsOpen = request()->is('reports/procurepro*');
    $reportsOpen = request()->is('reports*', 'itemizedreports*', 'dashboard/procurement');
@endphp
<li class="{{ $reportsOpen ? 'active' : '' }}">
    <a href="#" aria-expanded="{{ $reportsOpen ? 'true' : 'false' }}"><i class="icon-9"></i> <span>Reports</span></a>
    <ul class="nav-right__sub reports-menu" @if($reportsOpen) style="display: block;" @endif>
        <li class="reports-menu__group">
            <details name="report-groups" @if($bankReportsOpen) open @endif>
                <summary>Bank Reports</summary>
                <ul class="reports-menu__links">
                    <li><a href="/reports/fnb" @if(request()->is('reports/fnb')) aria-current="page" @endif>PO FNB</a></li>
                    <li><a href="/reports/albarak" @if(request()->is('reports/albarak')) aria-current="page" @endif>PO Al Baraka</a></li>
                    <li><a href="/reports/standardbank" @if(request()->is('reports/standardbank')) aria-current="page" @endif>PO Standard Bank</a></li>
                    <li><a href="{{ route('reports.requisitions.fnb') }}" @if(request()->routeIs('reports.requisitions.fnb')) aria-current="page" @endif>PR FNB</a></li>
                    <li><a href="{{ route('reports.requisitions.albaraka') }}" @if(request()->routeIs('reports.requisitions.albaraka')) aria-current="page" @endif>PR Al Baraka</a></li>
                    <li><a href="{{ route('reports.requisitions.standardbank') }}" @if(request()->routeIs('reports.requisitions.standardbank')) aria-current="page" @endif>PR Standard Bank</a></li>
                </ul>
            </details>
        </li>
        <li class="reports-menu__group">
            <details name="report-groups" @if($customReportsOpen) open @endif>
                <summary>Custom Reports</summary>
                <ul class="reports-menu__links">
                    <li><a href="/reports" @if(request()->is('reports')) aria-current="page" @endif>Custom Reports</a></li>
                    <li><a href="/itemizedreports" @if(request()->is('itemizedreports')) aria-current="page" @endif>Itemized Custom Reports</a></li>
                    <li><a href="/dashboard/procurement" @if(request()->is('dashboard/procurement')) aria-current="page" @endif>Spend Overview Reports</a></li>
                </ul>
            </details>
        </li>
        <li class="reports-menu__group">
            <details name="report-groups" @if($summaryReportsOpen) open @endif>
                <summary>Summary Reports</summary>
                <ul class="reports-menu__links">
                    <li><a href="/reports/requisitionreport" @if(request()->is('reports/requisitionreport')) aria-current="page" @endif>Purchase Req Summary</a></li>
                    <li><a href="/reports/purchaseorderreport" @if(request()->is('reports/purchaseorderreport')) aria-current="page" @endif>Purchase Order Summary</a></li>
                </ul>
            </details>
        </li>
        <li class="reports-menu__group">
            <details name="report-groups" @if($procureProReportsOpen) open @endif>
                <summary>ProcurePro Reports</summary>
                <ul class="reports-menu__links">
                    <li><a href="/reports/procureprorequisition" @if(request()->is('reports/procureprorequisition')) aria-current="page" @endif>ProcurePro Requisition</a></li>
                    <li><a href="/reports/procurepropurchaseorder" @if(request()->is('reports/procurepropurchaseorder')) aria-current="page" @endif>ProcurePro Purchase Order</a></li>
                </ul>
            </details>
        </li>
    </ul>
</li>
