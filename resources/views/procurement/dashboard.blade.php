{{-- resources/views/dashboard/procurement.blade.php --}}
@extends('html.default')

@section('title', 'Procurement Dashboard')

@section('content')
<div class="body-content__header">
  <ul>
    <li class="ms-auto">
      <div class="d-flex gap-2 align-items-center">
        <label for="months" class="form-label m-0">Range</label>
        <select id="months" class="form-select form-select-sm" style="width:auto;">
          <option value="6">6 months</option>
          <option value="12" selected>12 months</option>
          <option value="24">24 months</option>
        </select>

        {{-- NEW: Start/End date override --}}
        <input id="startDate" type="date" class="form-control form-control-sm" style="width:auto;">
        <input id="endDate" type="date" class="form-control form-control-sm" style="width:auto;">
        <button id="applyDateBtn" class="btn btn-outline-secondary btn-sm">Apply</button>
        <button id="clearDateBtn" class="btn btn-outline-dark btn-sm">Clear</button>

        {{-- Optional: scope by company --}}
        {{-- <input id="companyId" type="number" class="form-control form-control-sm" style="width:120px;" placeholder="Company ID"> --}}
        <button id="refreshBtn" class="btn btn-primary btn-sm">Refresh</button>
      </div>
    </li>
  </ul>
</div>

<div class="body-content__wrapper">
  <div class="mb-3 small text-muted">
    <span id="generatedAt"></span>
  </div>

  <div class="row g-3">
    <div class="col-12">
      <div class="card h-100">
        <div class="card-header"><strong>Monthly Spend (invoiceamount)</strong></div>
        <div class="card-body">
          <canvas id="spendByMonth" style="max-height:360px;"></canvas>
        </div>
      </div>
    </div>

    <div class="col-12 col-lg-6">
      <div class="card h-100">
        <div class="card-header"><strong>Spend by Category (expenses)</strong></div>
        <div class="card-body">
          <canvas id="spendByCategory" style="max-height:360px;"></canvas>
        </div>
      </div>
    </div>

    <div class="col-12 col-lg-6">
      <div class="card h-100">
        <div class="card-header"><strong>Top Vendors (Share)</strong></div>
        <div class="card-body">
          <canvas id="vendorShare" style="max-height:360px;"></canvas>
        </div>
      </div>
    </div>

    <div class="col-12">
      <div class="card h-100">
        <div class="card-header"><strong>Status Breakdown (Frequisitions)</strong></div>
        <div class="card-body">
          <canvas id="statusBreakdown" style="max-height:360px;"></canvas>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection

{{-- Chart.js --}}
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.3/dist/chart.umd.min.js"></script>
<script>
  document.addEventListener('DOMContentLoaded', () => {
    // Elements
    const monthsEl     = document.getElementById('months');
    const refreshBtn   = document.getElementById('refreshBtn');
    const generatedAt  = document.getElementById('generatedAt');
    const startDateEl  = document.getElementById('startDate');
    const endDateEl    = document.getElementById('endDate');
    const applyDateBtn = document.getElementById('applyDateBtn');
    const clearDateBtn = document.getElementById('clearDateBtn');

    const canvasIds = ['spendByMonth','spendByCategory','vendorShare','statusBreakdown'];
    const missingCanvas = canvasIds.find(id => !document.getElementById(id));
    if (!monthsEl || !refreshBtn || missingCanvas || !applyDateBtn || !clearDateBtn) {
      console.error('Dashboard init aborted. Missing element(s):', { monthsEl: !!monthsEl, refreshBtn: !!refreshBtn, missingCanvas, applyDateBtn: !!applyDateBtn, clearDateBtn: !!clearDateBtn });
      return;
    }

    let charts = {};

    // ZAR formatting
    function fmtCurrency(value) {
      try {
        return new Intl.NumberFormat('en-ZA', { style: 'currency', currency: 'ZAR', maximumFractionDigits: 0 }).format(value);
      } catch { return `R${value}`; }
    }

    function destroyCharts() {
      Object.values(charts).forEach(c => c?.destroy && c.destroy());
      charts = {};
    }

    // Fetch with optional date range
    async function fetchData() {
      const params = new URLSearchParams();

      // If both dates are filled, use them; else fall back to months
      const s = startDateEl.value;
      const e = endDateEl.value;

      if (s && e) {
        // Basic validation
        if (new Date(s) > new Date(e)) {
          alert('Start date must be before or equal to End date.');
          throw new Error('Invalid date range');
        }
        params.set('date_from', s); // YYYY-MM-DD
        params.set('date_to', e);   // YYYY-MM-DD
      } else {
        params.set('months', String(parseInt(monthsEl.value || '12', 10)));
      }

      // Optional company
      // const companyId = document.getElementById('companyId')?.value;
      // if (companyId) params.set('companyId', companyId);

      const url = `{{ route('api.procurement.dashboard') }}` + '?' + params.toString();
      const res = await fetch(url, { headers: { 'Accept': 'application/json' } });
      if (!res.ok) {
        const text = await res.text();
        console.error('Fetch failed', res.status, url, text);
        throw new Error(`${res.status} fetching ${url}`);
      }
      return await res.json();
    }

    function render(payload) {
      const { spendByMonth, spendByCategory, vendorShare, statusBreakdown, meta } = payload ?? {};
      if (generatedAt) generatedAt.textContent = meta?.generated_at ? `Data as of ${meta.generated_at}` : '';

      // 1) Monthly spend (line)
      const ctx1 = document.getElementById('spendByMonth')?.getContext('2d');
      charts.spendByMonth = new Chart(ctx1, {
        type: 'line',
        data: {
          labels: spendByMonth?.labels ?? [],
          datasets: [{
            label: 'Total',
            data: spendByMonth?.data ?? [],
            fill: true,
            tension: 0.35,
            borderWidth: 2,
            pointRadius: 2,
          }]
        },
        options: {
          responsive: true,
          maintainAspectRatio: false,
          scales: {
            y: { ticks: { callback: v => fmtCurrency(v) } },
            x: { ticks: { maxRotation: 0, autoSkip: true } }
          },
          plugins: {
            legend: { display: false },
            tooltip: { callbacks: { label: (ctx) => fmtCurrency(ctx.parsed.y) } }
          }
        }
      });

      // 2) Category donut
      const ctx2 = document.getElementById('spendByCategory')?.getContext('2d');
      charts.spendByCategory = new Chart(ctx2, {
        type: 'doughnut',
        data: {
          labels: spendByCategory?.labels ?? [],
          datasets: [{ data: spendByCategory?.data ?? [] }]
        },
        options: {
          cutout: '60%',
          plugins: {
            legend: { position: 'bottom' },
            tooltip: { callbacks: { label: (ctx) => `${ctx.label}: ${fmtCurrency(ctx.parsed)}` } }
          }
        }
      });

      // 3) Vendor share (horizontal bar)
      const ctx3 = document.getElementById('vendorShare')?.getContext('2d');
      charts.vendorShare = new Chart(ctx3, {
        type: 'bar',
        data: {
          labels: vendorShare?.labels ?? [],
          datasets: [{ label: 'Spend', data: vendorShare?.data ?? [] }]
        },
        options: {
          indexAxis: 'y',
          responsive: true,
          maintainAspectRatio: false,
          scales: { x: { ticks: { callback: v => fmtCurrency(v) } } },
          plugins: {
            legend: { display: false },
            tooltip: { callbacks: { label: (ctx) => fmtCurrency(ctx.parsed.x) } }
          }
        }
      });

      // 4) Status breakdown (bar)
      const ctx4 = document.getElementById('statusBreakdown')?.getContext('2d');
      charts.statusBreakdown = new Chart(ctx4, {
        type: 'bar',
        data: {
          labels: statusBreakdown?.labels ?? [],
          datasets: [{ label: 'Count', data: statusBreakdown?.data ?? [] }]
        },
        options: {
          responsive: true,
          maintainAspectRatio: false,
          plugins: { legend: { display: false } }
        }
      });
    }

    async function bootstrap() {
      destroyCharts();
      const payload = await fetchData();
      render(payload);
    }

    // Events
    refreshBtn.addEventListener('click', bootstrap);
    monthsEl.addEventListener('change', bootstrap);
    applyDateBtn.addEventListener('click', bootstrap);
    clearDateBtn.addEventListener('click', () => {
      startDateEl.value = '';
      endDateEl.value   = '';
      bootstrap();
    });

    // Initial
    bootstrap().catch(err => {
      console.error(err);
      alert('Failed to load procurement dashboard data. Open the console for details.');
    });
  });
</script>
