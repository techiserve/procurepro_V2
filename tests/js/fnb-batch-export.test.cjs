const assert = require('node:assert/strict');
const test = require('node:test');
let headings;
let buildRows;
let toCsv;

test.before(async () => {
  await import('../../public/assets/js/fnb-batch-export.js');
  ({ headings, buildRows, toCsv } = globalThis.FnbBatchExport);
});

const sampleHeadings = 'RECIPIENT NAME,RECIPIENT ACCOUNT,RECIPIENT ACCOUNT TYPE,BRANCHCODE,AMOUNT,OWN REFERENCE,RECIPIENT REFERENCE,EMAIL 1 NOTIFY,EMAIL 1 ADDRESS,EMAIL 1 SUBJECT,EMAIL 2 NOTIFY,EMAIL 2 ADDRESS,EMAIL 2 SUBJECT,EMAIL 3 NOTIFY,EMAIL 3 ADDRESS,EMAIL 3 SUBJECT,EMAIL 4 NOTIFY,EMAIL 4 ADDRESS,EMAIL 4 SUBJECT,EMAIL 5 NOTIFY,EMAIL 5 ADDRESS,EMAIL 5 SUBJECT,FAX 1 NOTIFY,FAX 1 CODE,FAX 1 NUMBER,FAX 1 SUBJECT,FAX 2 NOTIFY,FAX 2 CODE,FAX 2 NUMBER,FAX 2 SUBJECT,SMS 1 NOTIFY,SMS 1 CODE,SMS 1 NUMBER,SMS 2 NOTIFY,SMS 2 CODE,SMS 2 NUMBER';

test('FNB batch uses the sample layout and only fills payment columns A-G', () => {
  const rows = buildRows([{ fromAccount: '63209517888', values: [
    'Milky Lane', '62225784158', '1', '250655', '50', 'Test twn ref', 'Ben 001'
  ] }], new Date('2026-10-16T08:00:00Z'));

  assert.equal(headings.length, 36);
  assert.equal(headings.join(','), sampleHeadings);
  assert.equal(rows.length, 5);
  assert.ok(rows.every(row => row.length === 36));
  assert.equal(rows[0][0], 'BInSol - U ver 1.00');
  assert.equal(rows[1][0], '16-10-2026');
  assert.deepEqual(rows[2].slice(0, 2), ['63209517888', '125435302046']);
  assert.deepEqual(rows[4].slice(0, 7), [
    'Milky Lane', '62225784158', '1', '250655', '50.00', 'Test twn ref', 'Ben 001'
  ]);
  assert.ok(rows[4].slice(7).every(value => value === ''));
  assert.equal(toCsv(rows).split('\r\n')[3], sampleHeadings);
  assert.equal(toCsv(rows).split('\r\n')[4],
    'Milky Lane,62225784158,1,250655,50.00,Test twn ref,Ben 001' + ','.repeat(29));
});

test('FNB batch maps familiar account types and escapes commas in CSV values', () => {
  const rows = buildRows([{ fromAccount: '00123', values: [
    'Example, Ltd', '000987', 'Savings', '250655', '1,234.5', '', ''
  ] }]);

  assert.equal(rows[4][2], '2');
  assert.equal(rows[4][5], 'reference Example, Ltd');
  assert.equal(rows[4][6], 'reference Example, Ltd');
  assert.equal(rows[4][4], '1234.50');
  assert.match(toCsv(rows).split('\r\n')[4], /^"Example, Ltd",000987,2,250655,1234\.50/);
});

test('FNB batch uses the supplied references and supports every listed account code', () => {
  const types = [
    ['Public Recipient', '0'], ['Current / Cheque', '1'], ['Savings', '2'],
    ['Transmission', '3'], ['Bond', '4'], ['Subscription Share', '6'],
    ['eWallet Pro', 'D'], ['eWallet Send Money', 'S'], ['FNB Card', 'F'],
    ['WesBank', 'W']
  ];
  const rows = buildRows(types.map(([label]) => ({
    fromAccount: '123', values: ['Recipient', '456', label, '250655', '10', 'My own', '']
  })));

  types.forEach(([, code], index) => {
    assert.equal(rows[index + 4][2], code);
    assert.equal(rows[index + 4][5], 'My own');
    assert.equal(rows[index + 4][6], 'reference Recipient');
  });
  assert.equal(buildRows([{ fromAccount: '123', values: ['Recipient', '456', 'D', '250655', '10', '', 'Entered'] }])[4][6], 'Entered');
});

test('FNB hash total changes with the recipients and preserves 12-digit precision', () => {
  const rows = buildRows([
    { fromAccount: '63209517888', values: ['First', '62225784158', '1', '250655', '50', '', ''] },
    { fromAccount: '63209517888', values: ['Second', '00000000001', '2', '250655', '75', '', ''] }
  ]);

  assert.equal(rows[2][1], '125435302047');
  assert.equal(rows[5][4], '75.00');
  assert.throws(() => buildRows([{ fromAccount: '63209517888', values: ['Bad', 'ABC123'] }]), /only digits/);
});

test('FNB batch refuses missing or mixed company accounts', () => {
  assert.throws(() => buildRows([]), /no FNB payments/);
  assert.throws(() => buildRows([{ fromAccount: '', values: [] }]), /one company account/);
  assert.throws(() => buildRows([
    { fromAccount: '111', values: [] }, { fromAccount: '222', values: [] }
  ]), /one company account/);
});
