<?php

namespace Tests\Feature;

use App\Http\Controllers\ProcurementController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\MasterController;
use App\Models\User;
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
            $table->string('bankAccountName')->nullable();
            $table->integer('releaseStatus')->nullable();
            $table->timestamps();
        });
        Schema::create('form_fields', function (Blueprint $table) {
            $table->id();
            $table->integer('companyId');
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
}
