(function (root) {
  const headings = [
    'RECIPIENT NAME', 'RECIPIENT ACCOUNT', 'RECIPIENT ACCOUNT TYPE', 'BRANCHCODE',
    'AMOUNT', 'OWN REFERENCE', 'RECIPIENT REFERENCE',
    'EMAIL 1 NOTIFY', 'EMAIL 1 ADDRESS', 'EMAIL 1 SUBJECT',
    'EMAIL 2 NOTIFY', 'EMAIL 2 ADDRESS', 'EMAIL 2 SUBJECT',
    'EMAIL 3 NOTIFY', 'EMAIL 3 ADDRESS', 'EMAIL 3 SUBJECT',
    'EMAIL 4 NOTIFY', 'EMAIL 4 ADDRESS', 'EMAIL 4 SUBJECT',
    'EMAIL 5 NOTIFY', 'EMAIL 5 ADDRESS', 'EMAIL 5 SUBJECT',
    'FAX 1 NOTIFY', 'FAX 1 CODE', 'FAX 1 NUMBER', 'FAX 1 SUBJECT',
    'FAX 2 NOTIFY', 'FAX 2 CODE', 'FAX 2 NUMBER', 'FAX 2 SUBJECT',
    'SMS 1 NOTIFY', 'SMS 1 CODE', 'SMS 1 NUMBER',
    'SMS 2 NOTIFY', 'SMS 2 CODE', 'SMS 2 NUMBER'
  ];
  const accountTypes = {
    current: '1', cheque: '1', checking: '1',
    savings: '2', saving: '2', transmission: '3', bond: '4',
    'subscription share': '6', 'fnb card': 'F', wesbank: 'W'
  };

  function formatAccountType(value) {
    const type = String(value ?? '').trim();
    return accountTypes[type.toLowerCase()] || type;
  }

  function reportDate(date) {
    return new Intl.DateTimeFormat('en-GB', {
      timeZone: 'Africa/Johannesburg', day: '2-digit', month: '2-digit', year: 'numeric'
    }).format(date).replaceAll('/', '-');
  }

  function hashTotal(fromAccount, payments) {
    const accountNumbers = [fromAccount, ...payments.map(payment => payment.values[1])];
    if (accountNumbers.some(number => !/^\d+$/.test(String(number ?? '').trim()))) {
      throw new Error('The company and recipient account numbers must contain only digits for the FNB batch total.');
    }
    const total = accountNumbers.reduce((sum, number) => sum + BigInt(String(number).trim()), 0n);
    return total.toString().slice(-12).padStart(12, '0');
  }

  function buildRows(payments, date = new Date()) {
    if (!payments.length) throw new Error('There are no FNB payments to download.');
    const accounts = [...new Set(payments.map(payment => String(payment.fromAccount ?? '').trim()))];
    if (accounts.length !== 1 || !accounts[0]) {
      throw new Error('This FNB batch needs one company account. Check that every payment has the same selected FNB account.');
    }

    const blankRow = () => Array(headings.length).fill('');
    const title = blankRow();
    title[0] = 'BInSol - U ver 1.00';
    const dateRow = blankRow();
    dateRow[0] = reportDate(date);
    const accountRow = blankRow();
    accountRow[0] = accounts[0];
    accountRow[1] = hashTotal(accounts[0], payments);

    const paymentRows = payments.map(payment => {
      const row = blankRow();
      const values = payment.values;
      for (let index = 0; index < 7; index++) row[index] = String(values[index] ?? '').trim();
      row[2] = formatAccountType(row[2]);
      const amount = Number(row[4].replace(/,/g, ''));
      if (row[4] && Number.isFinite(amount)) row[4] = amount.toFixed(2);
      return row;
    });

    return [title, dateRow, accountRow, headings.slice(), ...paymentRows];
  }

  function toCsv(rows) {
    const field = value => {
      const text = String(value ?? '');
      return /[",\r\n]/.test(text) ? '"' + text.replace(/"/g, '""') + '"' : text;
    };
    return rows.map(row => row.map(field).join(',')).join('\r\n') + '\r\n';
  }

  const exporter = { headings, buildRows, toCsv };
  root.FnbBatchExport = exporter;
  if (typeof module === 'object' && module.exports) module.exports = exporter;
})(typeof window !== 'undefined' ? window : globalThis);
