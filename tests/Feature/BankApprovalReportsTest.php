<?php

namespace Tests\Feature;

use App\Http\Controllers\ProcurementController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\MasterController;
use App\Models\User;
use App\Models\Frequisition;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Tests\TestCase;

class BankApprovalReportsTest extends TestCase
{
    public function test_pr_bank_report_vendor_name_reads_either_database_column_case(): void
    {
        $requisition = new Frequisition();
        $requisition->setRawAttributes(['vendor' => 'Local Vendor']);
        $this->assertSame('Local Vendor', $requisition->bankReportVendorName());

        $requisition->setRawAttributes(['Vendor' => 'Hosted Vendor']);
        $this->assertSame('Hosted Vendor', $requisition->bankReportVendorName());

        $requisition->setRawAttributes(['vendor' => '', 'Vendor' => 'Hosted Vendor']);
        $this->assertSame('Hosted Vendor', $requisition->bankReportVendorName());
    }

    protected function setUp(): void
    {
        parent::setUp();

        config()->set('database.default', 'sqlite');
        config()->set('database.connections.sqlite.database', ':memory:');
        DB::purge('sqlite');

        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email');
            $table->integer('companyId');
            $table->integer('userrole');
            $table->timestamps();
        });
        Schema::create('departments', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->integer('companyId');
            $table->integer('notifications')->nullable();
            $table->integer('userId')->nullable();
            $table->integer('IsActive')->nullable();
            $table->integer('po')->nullable();
            $table->timestamps();
        });
        Schema::create('vendors', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->integer('companyId');
            $table->integer('status');
            $table->string('bank_name')->nullable();
            $table->string('account_number')->nullable();
            $table->string('account_type')->nullable();
            $table->string('branch_code')->nullable();
            $table->timestamps();
        });
        Schema::create('fpurchaseorders', function (Blueprint $table) {
            $table->id();
            $table->integer('companyId');
            $table->integer('department');
            $table->integer('frequisition_id')->nullable();
            $table->integer('userId')->nullable();
            $table->integer('approvallevel')->nullable();
            $table->integer('totalapprovallevels')->nullable();
            $table->integer('approvedby')->nullable();
            $table->integer('status');
            $table->string('requisitionNumber')->nullable();
            $table->integer('purchaseorderstatus')->nullable();
            $table->integer('isActive')->nullable();
            $table->string('bankAccountName')->nullable();
            $table->string('bankAccountNumber')->nullable();
            $table->string('bankAccountType')->nullable();
            $table->string('vendorbankAccountName')->nullable();
            $table->string('vendorbankAccountNumber')->nullable();
            $table->string('vendorbankAccountType')->nullable();
            $table->string('vendorbankBranch')->nullable();
            $table->integer('releaseStatus')->nullable();
            $table->timestamps();
        });
        Schema::create('form_fields', function (Blueprint $table) {
            $table->id();
            $table->integer('companyId');
            $table->string('name')->nullable();
        });
        Schema::create('itemizedfpurchaseorders', function (Blueprint $table) {
            $table->id();
            $table->integer('requisition_id');
        });
        Schema::create('frequisitions', function (Blueprint $table) {
            $table->id();
            $table->integer('companyId');
            $table->integer('userId');
            $table->integer('department');
            $table->integer('status');
            $table->integer('approvallevel');
            $table->integer('totalapprovallevels');
            $table->integer('approvedby');
            $table->integer('isActive')->nullable();
            $table->string('requisitionNumber');
            $table->string('vendor')->nullable();
            $table->decimal('amount', 15, 2)->nullable();
            $table->timestamps();
        });
        (require base_path('database/migrations/2026_09_30_000001_add_bank_account_to_frequisitions_table.php'))->up();
        Schema::create('frequisitionvendor', function (Blueprint $table) {
            $table->id();
            $table->integer('frequisition_id');
            $table->integer('status')->nullable();
            $table->string('vendor_final');
            $table->decimal('amount', 15, 2);
            $table->string('bank')->nullable();
            $table->string('account_number')->nullable();
            $table->string('account_type')->nullable();
            $table->string('branchCode')->nullable();
            $table->string('file_path')->nullable();
            $table->string('IsOneTimeVendor')->nullable();
            $table->string('modal_vendor_name')->nullable();
            $table->timestamps();
        });
        Schema::create('requisitionfiles', function (Blueprint $table) {
            $table->id();
            $table->integer('requisitionId');
            $table->integer('companyId');
            $table->integer('userId');
            $table->string('file')->nullable();
            $table->integer('path');
            $table->timestamps();
        });
        Schema::create('departmentapprovals', function (Blueprint $table) {
            $table->id();
            $table->string('mode');
            $table->string('department')->nullable();
            $table->integer('companyId')->nullable();
            $table->integer('userId')->nullable();
            $table->integer('departmentId');
            $table->integer('approvalId');
            $table->integer('roleId');
            $table->integer('IsBankAccount')->nullable();
            $table->timestamps();
        });
        Schema::create('bankaccounts', function (Blueprint $table) {
            $table->id();
            $table->integer('companyId');
            $table->string('bankName');
            $table->string('accountNumber');
            $table->string('accountType');
            $table->timestamps();
        });
        Schema::create('requisition_histories', function (Blueprint $table) {
            $table->id();
            $table->integer('companyId');
            $table->integer('frequisition_id');
            $table->integer('userId');
            $table->integer('status');
            $table->integer('approvallevel')->nullable();
            $table->integer('approvedby')->nullable();
            $table->decimal('amount', 15, 2)->nullable();
            $table->integer('isActive');
            $table->string('action');
            $table->string('doneby');
            $table->timestamps();
        });

        DB::table('departments')->insert(['id' => 1, 'name' => 'Operations', 'companyId' => 1, 'notifications' => 0]);
        $user = User::forceCreate(['id' => 2, 'name' => 'Approver', 'email' => 'approver@example.test', 'companyId' => 1, 'userrole' => 7]);
        Auth::guard('web')->setUser($user);
    }

    public function test_po_bank_reports_only_include_fully_approved_unreleased_orders(): void
    {
        DB::table('departmentapprovals')->insert([
            'mode' => 'PO', 'departmentId' => 1, 'approvalId' => 1, 'roleId' => 7, 'IsBankAccount' => 7,
        ]);
        foreach (['FNB/RMB' => 'fnb', 'Albaraka Bank' => 'albarak', 'Standard Bank' => 'standardbank'] as $bank => $method) {
            DB::table('fpurchaseorders')->insert([
                ['companyId' => 1, 'department' => 1, 'bankAccountName' => $bank, 'status' => 1, 'releaseStatus' => null],
                ['companyId' => 1, 'department' => 1, 'bankAccountName' => $bank, 'status' => 2, 'releaseStatus' => null],
                ['companyId' => 1, 'department' => 1, 'bankAccountName' => $bank, 'status' => 2, 'releaseStatus' => 1],
                ['companyId' => 2, 'department' => 1, 'bankAccountName' => $bank, 'status' => 2, 'releaseStatus' => null],
            ]);

            $orders = app(ReportController::class)->$method()->getData()['fpurchaseorder'];
            $this->assertCount(1, $orders);
            $this->assertSame(2, (int) $orders->first()->status);
        }
    }

    public function test_pr_bank_reports_only_include_fully_approved_requisitions_for_the_company(): void
    {
        DB::table('departmentapprovals')->insert([
            'mode' => 'PR', 'departmentId' => 1, 'approvalId' => 1, 'roleId' => 7, 'IsBankAccount' => 7,
        ]);
        foreach (['FNB/RMB' => 'fnbRequisitions', 'Albaraka Bank' => 'albarakaRequisitions', 'Standard Bank' => 'standardBankRequisitions'] as $bank => $method) {
            DB::table('frequisitions')->insert([
                ['companyId' => 1, 'userId' => 1, 'department' => 1, 'status' => 1, 'approvallevel' => 1, 'totalapprovallevels' => 2, 'approvedby' => 7, 'requisitionNumber' => $method . '-pending', 'bankAccountName' => $bank],
                ['companyId' => 1, 'userId' => 1, 'department' => 1, 'status' => 2, 'approvallevel' => 3, 'totalapprovallevels' => 2, 'approvedby' => 7, 'requisitionNumber' => $method . '-approved', 'bankAccountName' => $bank],
                ['companyId' => 2, 'userId' => 1, 'department' => 1, 'status' => 2, 'approvallevel' => 3, 'totalapprovallevels' => 2, 'approvedby' => 7, 'requisitionNumber' => $method . '-other-company', 'bankAccountName' => $bank],
            ]);

            $requisitions = app(ReportController::class)->$method(Request::create('/', 'GET'))->getData()['frequisitions'];
            $this->assertCount(1, $requisitions);
            $this->assertSame($method . '-approved', $requisitions->first()->requisitionNumber);
        }
    }

    public function test_pr_bank_approver_must_select_an_account_from_the_same_company(): void
    {
        DB::table('frequisitions')->insert([
            'id' => 1, 'companyId' => 1, 'userId' => 1, 'department' => 1,
            'status' => 1, 'approvallevel' => 1, 'totalapprovallevels' => 2,
            'approvedby' => 7, 'requisitionNumber' => 'PR-1',
        ]);
        DB::table('frequisitionvendor')->insert([
            'id' => 1, 'frequisition_id' => 1, 'vendor_final' => 'Supplier', 'amount' => 120.00,
        ]);
        DB::table('departmentapprovals')->insert([
            ['mode' => 'PR', 'departmentId' => 1, 'approvalId' => 1, 'roleId' => 7, 'IsBankAccount' => 7],
            ['mode' => 'PR', 'departmentId' => 1, 'approvalId' => 2, 'roleId' => 8, 'IsBankAccount' => null],
        ]);
        DB::table('bankaccounts')->insert([
            ['id' => 1, 'companyId' => 1, 'bankName' => 'FNB/RMB', 'accountNumber' => '12345', 'accountType' => 'Current'],
            ['id' => 2, 'companyId' => 2, 'bankName' => 'Standard Bank', 'accountNumber' => '67890', 'accountType' => 'Current'],
        ]);

        $controller = app(ProcurementController::class);
        try {
            $controller->requisitionapproval('1', Request::create('/', 'PUT', ['selected_vendor' => 1]));
            $this->fail('A bank account is required for this approval level.');
        } catch (ValidationException $exception) {
            $this->assertArrayHasKey('account_id', $exception->errors());
        }
        $this->assertNull(DB::table('frequisitionvendor')->where('id', 1)->value('status'));

        $this->expectException(ModelNotFoundException::class);
        $controller->requisitionapproval('1', Request::create('/', 'PUT', ['selected_vendor' => 1, 'account_id' => 2]));
    }

    public function test_pr_bank_approval_saves_account_and_advances_to_next_level(): void
    {
        DB::table('frequisitions')->insert([
            'id' => 1, 'companyId' => 1, 'userId' => 1, 'department' => 1,
            'status' => 1, 'approvallevel' => 1, 'totalapprovallevels' => 2,
            'approvedby' => 7, 'requisitionNumber' => 'PR-1',
        ]);
        DB::table('frequisitionvendor')->insert([
            'id' => 1, 'frequisition_id' => 1, 'vendor_final' => 'Supplier', 'amount' => 120.00,
        ]);
        DB::table('departmentapprovals')->insert([
            ['mode' => 'PR', 'departmentId' => 1, 'approvalId' => 1, 'roleId' => 7, 'IsBankAccount' => 7],
            ['mode' => 'PR', 'departmentId' => 1, 'approvalId' => 2, 'roleId' => 8, 'IsBankAccount' => null],
        ]);
        DB::table('bankaccounts')->insert([
            'id' => 1, 'companyId' => 1, 'bankName' => 'FNB/RMB', 'accountNumber' => '12345', 'accountType' => 'Current',
        ]);

        app(ProcurementController::class)->requisitionapproval('1', Request::create('/', 'PUT', [
            'selected_vendor' => 1, 'account_id' => 1,
        ]));

        $requisition = DB::table('frequisitions')->find(1);
        $this->assertSame('FNB/RMB', $requisition->bankAccountName);
        $this->assertSame('12345', $requisition->bankAccountNumber);
        $this->assertSame(2, (int) $requisition->approvallevel);
        $this->assertSame(1, (int) $requisition->status);
        $this->assertSame(1, (int) DB::table('frequisitionvendor')->where('id', 1)->value('status'));
    }

    public function test_final_pr_approval_keeps_selected_vendor_and_skips_po_without_po_flow(): void
    {
        DB::table('frequisitions')->insert([
            'id' => 1, 'companyId' => 1, 'userId' => 1, 'department' => 1,
            'status' => 1, 'approvallevel' => 1, 'totalapprovallevels' => 2,
            'approvedby' => 7, 'requisitionNumber' => 'APC-0005',
        ]);
        DB::table('frequisitionvendor')->insert([
            'id' => 1, 'frequisition_id' => 1, 'vendor_final' => 'Clover',
            'amount' => 3000, 'bank' => 'Vendor Bank', 'account_number' => '98765',
            'account_type' => 'Credit', 'IsOneTimeVendor' => 'yes',
        ]);
        DB::table('departmentapprovals')->insert([
            ['mode' => 'PR', 'departmentId' => 1, 'approvalId' => 1, 'roleId' => 7, 'IsBankAccount' => null],
            ['mode' => 'PR', 'departmentId' => 1, 'approvalId' => 2, 'roleId' => 8, 'IsBankAccount' => 8],
        ]);
        DB::table('bankaccounts')->insert([
            'id' => 1, 'companyId' => 1, 'bankName' => 'FNB/RMB',
            'accountNumber' => '12345', 'accountType' => 'Current',
        ]);

        $controller = app(ProcurementController::class);
        $controller->requisitionapproval('1', Request::create('/', 'PUT', ['selected_vendor' => 1]));
        $this->assertSame(1, (int) DB::table('frequisitionvendor')->where('id', 1)->value('status'));

        $secondApprover = User::forceCreate([
            'id' => 3, 'name' => 'Finance Manager', 'email' => 'finance@example.test',
            'companyId' => 1, 'userrole' => 8,
        ]);
        Auth::guard('web')->setUser($secondApprover);
        $controller->requisitionapproval('1', Request::create('/', 'PUT', [
            'selected_vendor' => 1, 'account_id' => 1,
        ]));

        $this->assertSame(2, (int) DB::table('frequisitions')->where('id', 1)->value('status'));
        $this->assertSame(1, (int) DB::table('frequisitionvendor')->where('id', 1)->value('status'));
        $this->assertSame(0, DB::table('fpurchaseorders')->where('frequisition_id', 1)->count());
        $reported = app(ReportController::class)->fnbRequisitions(Request::create('/', 'GET'))
            ->getData()['frequisitions']->first();
        $this->assertSame('98765', $reported->selectedVendor->account_number);
    }

    public function test_department_without_po_flow_does_not_create_po_approval_levels(): void
    {
        app(MasterController::class)->departmentStore(Request::create('/', 'POST', [
            'departmentname' => 'HR', 'IsActive' => 1,
            'approval' => [1, 2], 'role' => [7, 8],
            'is_default_primary' => 1,
        ]));

        $departmentId = DB::table('departments')->where('name', 'HR')->value('id');
        $this->assertSame(2, DB::table('departmentapprovals')->where('departmentId', $departmentId)->where('mode', 'PR')->count());
        $this->assertSame(0, DB::table('departmentapprovals')->where('departmentId', $departmentId)->where('mode', 'PO')->count());
    }

    public function test_department_create_and_edit_allow_only_one_bank_assignment_across_both_flows(): void
    {
        $controller = app(MasterController::class);
        $controller->departmentStore(Request::create('/', 'POST', [
            'departmentname' => 'Finance',
            'IsActive' => 1,
            'approval' => [1, 2],
            'role' => [7, 7],
            'is_default_primary' => 1,
            'secondary_approval' => [1],
            'secondary_role' => [8],
        ]));

        $departmentId = DB::table('departments')->where('name', 'Finance')->value('id');
        $this->assertNull(DB::table('departmentapprovals')->where('departmentId', $departmentId)->where('mode', 'PR')->where('approvalId', 1)->value('IsBankAccount'));
        $this->assertSame(7, (int) DB::table('departmentapprovals')->where('departmentId', $departmentId)->where('mode', 'PR')->where('approvalId', 2)->value('IsBankAccount'));
        $this->assertNull(DB::table('departmentapprovals')->where('departmentId', $departmentId)->where('mode', 'PO')->value('IsBankAccount'));

        $controller->departmentUpdate(Request::create('/', 'PUT', [
            'departmentname' => 'Finance',
            'IsActive' => 1,
            'approval_a' => [1, 2],
            'role_a' => [7, 8],
            'approval_b' => [1],
            'role_b' => [7],
            'is_default_secondary' => 0,
        ]), $departmentId);

        $this->assertSame(0, DB::table('departmentapprovals')->where('departmentId', $departmentId)->where('mode', 'PR')->whereNotNull('IsBankAccount')->count());
        $this->assertSame(7, (int) DB::table('departmentapprovals')->where('departmentId', $departmentId)->where('mode', 'PO')->value('IsBankAccount'));

        $controller->departmentUpdate(Request::create('/', 'PUT', [
            'departmentname' => 'Finance', 'approval_a' => [1], 'role_a' => [7],
            'approval_b' => [1], 'role_b' => [7],
        ]), $departmentId);
        $this->assertSame(0, DB::table('departmentapprovals')->where('departmentId', $departmentId)->whereNotNull('IsBankAccount')->count());
    }

    public function test_department_rejects_bank_assignments_in_both_flows(): void
    {
        $controller = app(MasterController::class);
        try {
            $controller->departmentStore(Request::create('/', 'POST', [
                'departmentname' => 'Finance', 'approval' => [1], 'role' => [7],
                'is_default_primary' => 0, 'secondary_approval' => [1],
                'secondary_role' => [8], 'is_default_secondary' => 0,
            ]));
            $this->fail('Both flows cannot assign bank accounts.');
        } catch (ValidationException $exception) {
            $this->assertArrayHasKey('is_default_primary', $exception->errors());
        }
        $this->assertDatabaseMissing('departments', ['name' => 'Finance']);

        try {
            $controller->departmentUpdate(Request::create('/', 'PUT', [
                'departmentname' => 'Operations', 'approval_a' => [1], 'role_a' => [7],
                'is_default_primary' => 0, 'approval_b' => [1], 'role_b' => [8],
                'is_default_secondary' => 0,
            ]), 1);
            $this->fail('Both flows cannot assign bank accounts.');
        } catch (ValidationException $exception) {
            $this->assertArrayHasKey('is_default_primary', $exception->errors());
        }
    }

    public function test_no_bank_assignment_means_no_bank_report_rows_or_po_modal(): void
    {
        DB::table('fpurchaseorders')->insert([
            'id' => 1, 'companyId' => 1, 'department' => 1, 'userId' => 3,
            'approvallevel' => 1, 'totalapprovallevels' => 2, 'approvedby' => 7,
            'bankAccountName' => 'FNB/RMB', 'status' => 2,
        ]);
        DB::table('frequisitions')->insert([
            'companyId' => 1, 'userId' => 3, 'department' => 1, 'status' => 2,
            'approvallevel' => 2, 'totalapprovallevels' => 2, 'approvedby' => 7,
            'requisitionNumber' => 'PR-1', 'bankAccountName' => 'FNB/RMB',
        ]);
        $reports = app(ReportController::class);
        $this->assertCount(0, $reports->fnb()->getData()['fpurchaseorder']);
        $this->assertCount(0, $reports->fnbRequisitions(Request::create('/', 'GET'))->getData()['frequisitions']);

        DB::table('departmentapprovals')->insert([
            'mode' => 'PR', 'departmentId' => 1, 'approvalId' => 1, 'roleId' => 7, 'IsBankAccount' => 7,
        ]);
        DB::table('fpurchaseorders')->where('id', 1)->update(['status' => 1]);
        $view = app(ProcurementController::class)->viewpurchaseorder('1');
        $this->assertSame(0, $view->getData()['departmentapproval']);
        $this->assertCount(0, $reports->fnb()->getData()['fpurchaseorder']);
        $this->assertCount(1, $reports->fnbRequisitions(Request::create('/', 'GET'))->getData()['frequisitions']);

        $this->expectException(HttpException::class);
        app(ProcurementController::class)->approvepurchaseorderbankAccount('1', Request::create('/', 'PUT', ['account_id' => 1]));
    }

    public function test_pr_bank_selection_reports_only_the_pr_and_carries_selected_vendor_to_po(): void
    {
        DB::table('frequisitions')->insert([
            'id' => 1, 'companyId' => 1, 'userId' => 1, 'department' => 1,
            'status' => 1, 'approvallevel' => 1, 'totalapprovallevels' => 1,
            'approvedby' => 7, 'requisitionNumber' => 'PR-1',
        ]);
        DB::table('frequisitionvendor')->insert([
            'id' => 1, 'frequisition_id' => 1, 'vendor_final' => 'One-time Supplier',
            'amount' => 120.00, 'bank' => 'Vendor Bank', 'account_number' => '98765',
            'account_type' => 'Savings', 'branchCode' => '250655', 'IsOneTimeVendor' => 'yes',
        ]);
        DB::table('frequisitionvendor')->insert([
            'id' => 2, 'frequisition_id' => 1, 'vendor_final' => 'Other Supplier',
            'amount' => 150.00, 'bank' => 'Other Bank', 'account_number' => '99999',
        ]);
        DB::table('departmentapprovals')->insert([
            'mode' => 'PR', 'departmentId' => 1, 'approvalId' => 1, 'roleId' => 7, 'IsBankAccount' => 7,
        ]);
        DB::table('departmentapprovals')->insert([
            'mode' => 'PO', 'departmentId' => 1, 'approvalId' => 1, 'roleId' => 8,
        ]);
        DB::table('bankaccounts')->insert([
            'id' => 1, 'companyId' => 1, 'bankName' => 'FNB',
            'accountNumber' => '12345', 'accountType' => 'Current',
        ]);

        app(ProcurementController::class)->requisitionapproval('1', Request::create('/', 'PUT', [
            'selected_vendor' => 1, 'account_id' => 1,
        ]));

        $order = DB::table('fpurchaseorders')->where('frequisition_id', 1)->first();
        $this->assertNull($order->bankAccountName);
        $this->assertNull($order->bankAccountNumber);
        $this->assertSame('Vendor Bank', $order->vendorbankAccountName);
        $this->assertSame('98765', $order->vendorbankAccountNumber);
        $this->assertSame('250655', $order->vendorbankBranch);

        $reports = app(ReportController::class);
        $reportedPr = $reports->fnbRequisitions(Request::create('/', 'GET'))->getData()['frequisitions'];
        $this->assertCount(1, $reportedPr);
        $this->assertSame('98765', $reportedPr->first()->selectedVendor->account_number);
        $this->assertNull(DB::table('frequisitionvendor')->where('id', 2)->value('status'));
        $this->assertCount(0, $reports->fnb()->getData()['fpurchaseorder']);
        DB::table('fpurchaseorders')->where('id', $order->id)->update([
            'status' => 2, 'bankAccountName' => 'FNB',
        ]);
        $this->assertCount(0, $reports->fnb()->getData()['fpurchaseorder']);
    }

    public function test_po_bank_selection_reports_only_the_po(): void
    {
        DB::table('frequisitions')->insert([
            'id' => 1, 'companyId' => 1, 'userId' => 1, 'department' => 1,
            'status' => 2, 'approvallevel' => 2, 'totalapprovallevels' => 1,
            'approvedby' => 7, 'requisitionNumber' => 'PR-1',
        ]);
        DB::table('frequisitionvendor')->insert([
            'id' => 1, 'frequisition_id' => 1, 'vendor_final' => 'Managed Supplier',
            'amount' => 120.00, 'status' => 1, 'bank' => 'Vendor Bank',
            'account_number' => '98765', 'account_type' => 'Current',
        ]);
        DB::table('fpurchaseorders')->insert([
            'id' => 1, 'companyId' => 1, 'department' => 1, 'frequisition_id' => 1,
            'userId' => 1, 'approvallevel' => 1, 'totalapprovallevels' => 1,
            'approvedby' => 7, 'status' => 1, 'requisitionNumber' => 'PR-1',
            'vendorbankAccountNumber' => '98765',
        ]);
        DB::table('departmentapprovals')->insert([
            'mode' => 'PO', 'departmentId' => 1, 'approvalId' => 1, 'roleId' => 7, 'IsBankAccount' => 7,
        ]);
        DB::table('bankaccounts')->insert([
            'id' => 1, 'companyId' => 1, 'bankName' => 'FNB/RMB',
            'accountNumber' => '12345', 'accountType' => 'Current',
        ]);

        app(ProcurementController::class)->approvepurchaseorderbankAccount('1', Request::create('/', 'PUT', [
            'account_id' => 1,
        ]));

        $this->assertNull(DB::table('frequisitions')->where('id', 1)->value('bankAccountName'));
        $this->assertNull(DB::table('frequisitions')->where('id', 1)->value('bankAccountNumber'));
        $this->assertSame(2, (int) DB::table('fpurchaseorders')->where('id', 1)->value('status'));
        $reports = app(ReportController::class);
        $this->assertCount(1, $reports->fnb()->getData()['fpurchaseorder']);
        DB::table('frequisitions')->where('id', 1)->update(['bankAccountName' => 'FNB/RMB']);
        $this->assertCount(0, $reports->fnbRequisitions(Request::create('/', 'GET'))->getData()['frequisitions']);
    }

    public function test_resubmission_uses_selected_vendor_source_for_each_row(): void
    {
        DB::table('frequisitions')->insert([
            'id' => 1, 'companyId' => 1, 'userId' => 1, 'department' => 1,
            'status' => 4, 'approvallevel' => 1, 'totalapprovallevels' => 1,
            'approvedby' => 7, 'requisitionNumber' => 'PR-1',
            'bankAccountName' => 'Old Bank',
        ]);
        DB::table('departmentapprovals')->insert([
            'mode' => 'PR', 'departmentId' => 1, 'approvalId' => 1, 'roleId' => 7,
        ]);
        DB::table('vendors')->insert([
            ['id' => 5, 'companyId' => 1, 'name' => 'Shared Name', 'status' => 3, 'bank_name' => 'Correct Bank', 'account_number' => '111', 'account_type' => 'Current', 'branch_code' => '123'],
            ['id' => 6, 'companyId' => 2, 'name' => 'Shared Name', 'status' => 3, 'bank_name' => 'Wrong Bank', 'account_number' => '999', 'account_type' => 'Savings', 'branch_code' => '999'],
        ]);

        app(ProcurementController::class)->updaterequisition(Request::create('/', 'PUT', [
            'vendor_final' => ['Shared Name', 'Walk-in'], 'vendor_id' => [5, ''],
            'is_one_time_vendor' => ['no', 'yes'], 'damount' => [100, 120],
            'bank' => ['', 'One-time Bank'], 'accountNumber' => ['', '222'],
            'accountType' => ['', 'Savings'], 'branchCode' => ['', '456'],
        ]), 1);

        $managed = DB::table('frequisitionvendor')->where('vendor_final', 'Shared Name')->first();
        $oneTime = DB::table('frequisitionvendor')->where('vendor_final', 'Walk-in')->first();
        $this->assertSame('Correct Bank', $managed->bank);
        $this->assertSame('111', $managed->account_number);
        $this->assertSame('123', $managed->branchCode);
        $this->assertSame('One-time Bank', $oneTime->bank);
        $this->assertSame('222', $oneTime->account_number);
        $this->assertSame('456', $oneTime->branchCode);
        $this->assertNull(DB::table('frequisitions')->where('id', 1)->value('bankAccountName'));

        DB::table('departmentapprovals')->where('departmentId', 1)->update(['IsBankAccount' => 7]);
        DB::table('departmentapprovals')->insert([
            'mode' => 'PO', 'departmentId' => 1, 'approvalId' => 1, 'roleId' => 8,
        ]);
        DB::table('bankaccounts')->insert([
            'id' => 1, 'companyId' => 1, 'bankName' => 'Standard Bank',
            'accountNumber' => '555', 'accountType' => 'Current',
        ]);
        app(ProcurementController::class)->requisitionapproval('1', Request::create('/', 'PUT', [
            'selected_vendor' => $managed->id, 'account_id' => 1,
        ]));

        $order = DB::table('fpurchaseorders')->where('frequisition_id', 1)->first();
        $this->assertSame('111', $order->vendorbankAccountNumber);
        $this->assertSame('Correct Bank', $order->vendorbankAccountName);
        $this->assertNull($order->bankAccountName);
        $reported = app(ReportController::class)->standardBankRequisitions(Request::create('/', 'GET'))
            ->getData()['frequisitions']->first();
        $this->assertSame('111', $reported->selectedVendor->account_number);
    }

    public function test_resubmission_rejects_incomplete_one_time_bank_details_before_updating(): void
    {
        DB::table('frequisitions')->insert([
            'id' => 1, 'companyId' => 1, 'userId' => 1, 'department' => 1,
            'status' => 4, 'approvallevel' => 1, 'totalapprovallevels' => 1,
            'approvedby' => 7, 'requisitionNumber' => 'PR-1',
        ]);

        try {
            app(ProcurementController::class)->updaterequisition(Request::create('/', 'PUT', [
                'vendor_final' => ['Walk-in'], 'is_one_time_vendor' => ['yes'],
                'damount' => [120], 'bank' => ['Vendor Bank'],
                'accountNumber' => [''], 'accountType' => ['Savings'], 'branchCode' => ['456'],
            ]), 1);
            $this->fail('Expected incomplete one-time banking details to be rejected.');
        } catch (ValidationException $e) {
            $this->assertArrayHasKey('accountNumber.0', $e->errors());
        }

        $this->assertSame(4, (int) DB::table('frequisitions')->where('id', 1)->value('status'));
        $this->assertSame(0, DB::table('frequisitionvendor')->count());
    }
}
