(function () {
  document.addEventListener('DOMContentLoaded', function () {
    const root = document.querySelector('[data-bank-report-root]');
    if (!root || !window.jQuery || !jQuery.fn.DataTable) return;

    const tableElement = root.querySelector('[data-bank-report-table]');
    const form = root.querySelector('[data-bank-clear-form]');
    const selectAll = tableElement.querySelector('[data-select-all]');
    const selectedCount = root.querySelector('[data-selected-count]');
    const clearSelected = root.querySelector('[data-clear-selected]');
    const clearAll = root.querySelector('[data-clear-all]');
    const table = jQuery(tableElement).DataTable({
      pageLength: 10,
      order: [[2, 'desc']],
      columnDefs: [{ targets: 0, orderable: false, searchable: false }],
      dom: 't<"dt-bottom"ip>',
      language: {
        emptyTable: 'No approved rows for this bank.',
        zeroRecords: 'No matching rows.'
      }
    });

    const rowCheckboxes = (options = {}) => table.rows(options).nodes().toArray()
      .map(row => row.querySelector('.bank-row-checkbox'))
      .filter(Boolean);
    const selectedIds = () => rowCheckboxes().filter(box => box.checked).map(box => box.value);

    function syncSelection() {
      const count = selectedIds().length;
      selectedCount.textContent = `${count} selected`;
      clearSelected.disabled = count === 0;
      const matching = rowCheckboxes({ search: 'applied' });
      const checked = matching.filter(box => box.checked).length;
      selectAll.checked = matching.length > 0 && checked === matching.length;
      selectAll.indeterminate = checked > 0 && checked < matching.length;
    }

    tableElement.addEventListener('change', function (event) {
      if (event.target.matches('.bank-row-checkbox')) syncSelection();
    });
    selectAll.addEventListener('change', function () {
      rowCheckboxes({ search: 'applied' }).forEach(box => { box.checked = selectAll.checked; });
      syncSelection();
    });
    table.on('draw', syncSelection);
    root.querySelector('#bankReportSearch').addEventListener('input', function () {
      table.search(this.value).draw();
    });
    syncSelection();

    function confirmClear(scope) {
      const ids = scope === 'selected' ? selectedIds() : [];
      if (scope === 'selected' && ids.length === 0) return;
      const count = scope === 'all' ? Number(form.dataset.totalRows) : ids.length;
      if (count === 0) return;
      const message = scope === 'all'
        ? `Clear all ${count} rows in this bank report, including rows outside current filters? The requisitions and orders will not be deleted.`
        : `Clear ${count} selected ${count === 1 ? 'row' : 'rows'} from this bank report? The requisitions and orders will not be deleted.`;
      const confirmation = window.Swal
        ? Swal.fire({ title: 'Are you sure?', text: message, icon: 'warning', showCancelButton: true, confirmButtonText: 'Yes, clear', confirmButtonColor: '#c92a3b' })
        : Promise.resolve({ isConfirmed: window.confirm(message) });

      confirmation.then(result => {
        if (!result.isConfirmed) return;
        form.querySelector('input[name="scope"]').value = scope;
        form.querySelectorAll('input[name="ids[]"]').forEach(input => input.remove());
        ids.forEach(id => {
          const input = document.createElement('input');
          input.type = 'hidden';
          input.name = 'ids[]';
          input.value = id;
          form.appendChild(input);
        });
        clearSelected.disabled = true;
        clearAll.disabled = true;
        form.submit();
      });
    }

    clearSelected.addEventListener('click', () => confirmClear('selected'));
    clearAll.addEventListener('click', () => confirmClear('all'));

    const plainText = html => {
      const element = document.createElement('div');
      element.innerHTML = String(html ?? '');
      return element.textContent.trim();
    };
    function exportData() {
      const columns = table.columns().header().toArray();
      const indexes = columns.flatMap((header, index) => header.dataset.bankExport === 'true' ? [index] : []);
      const headers = indexes.map(index => columns[index].dataset.exportLabel || columns[index].textContent.trim());
      const rows = table.rows({ search: 'applied' }).data().toArray()
        .map(row => indexes.map(index => plainText(row[index])));
      return { headers, rows };
    }

    root.querySelectorAll('[data-bank-export-action]').forEach(button => {
      button.addEventListener('click', async function () {
        const { headers, rows } = exportData();
        const filename = root.dataset.bankFilename;
        const action = button.dataset.bankExportAction;
        if (action === 'copy') {
          await navigator.clipboard.writeText([headers.join('\t'), ...rows.map(row => row.join('\t'))].join('\n'));
          if (window.Swal) Swal.fire({ title: 'Copied', icon: 'success', timer: 1200, showConfirmButton: false });
        } else if (action === 'csv') {
          const quote = value => '"' + String(value).replace(/"/g, '""') + '"';
          const csv = [headers, ...rows].map(row => row.map(quote).join(',')).join('\r\n');
          const url = URL.createObjectURL(new Blob([csv], { type: 'text/csv;charset=utf-8' }));
          const link = document.createElement('a');
          link.href = url;
          link.download = filename + '.csv';
          link.click();
          URL.revokeObjectURL(url);
        } else if (action === 'excel' && window.XLSX) {
          const workbook = XLSX.utils.book_new();
          XLSX.utils.book_append_sheet(workbook, XLSX.utils.aoa_to_sheet([headers, ...rows]), 'Report');
          XLSX.writeFile(workbook, filename + '.xlsx');
        } else if (action === 'pdf' && window.pdfMake) {
          pdfMake.createPdf({
            pageSize: headers.length > 10 ? 'A3' : 'A4',
            pageOrientation: 'landscape',
            content: [{ text: root.dataset.bankTitle, style: 'header' }, { table: { headerRows: 1, widths: Array(headers.length).fill('*'), body: [headers, ...rows] } }],
            styles: { header: { fontSize: 15, bold: true, margin: [0, 0, 0, 12] } },
            defaultStyle: { fontSize: headers.length > 10 ? 6 : 7 }
          }).download(filename + '.pdf');
        }
      });
    });
  });
})();
