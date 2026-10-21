<?php

namespace Tests\Feature;

use App\Http\Controllers\VendorController;
use App\Models\User;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Tests\TestCase;

class ReturnedVendorAccessTest extends TestCase
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
        Schema::create('vendors', function (Blueprint $table) {
            $table->id();
            $table->integer('companyId');
            $table->integer('status');
            $table->string('name');
            $table->string('message')->nullable();
            $table->string('finance_manager')->nullable();
            foreach (['type', 'description', 'vat_registered', 'vat_allocation', 'contact_no_1',
                'contact_no_2', 'supplier_code', 'address', 'bank_name', 'account_number',
                'account_type', 'branch_code'] as $column) {
                $table->string($column)->nullable();
            }
            $table->timestamps();
        });
        Schema::create('vendorhistories', function (Blueprint $table) {
            $table->id();
            $table->integer('vendor_id');
            $table->integer('companyId');
            $table->integer('userId');
            $table->string('action');
            $table->integer('status')->nullable();
            $table->integer('approvallevel')->nullable();
            $table->integer('isActive')->nullable();
            $table->string('doneby')->nullable();
            $table->string('reason')->nullable();
            $table->timestamps();
        });
        Schema::create('vendor_documents', function (Blueprint $table) {
            $table->id();
            $table->integer('vendor_id');
            $table->string('file_path')->nullable();
        });
        Schema::create('vendor_types', function (Blueprint $table) {
            $table->id();
            $table->integer('companyId');
            $table->string('name');
        });
        Schema::create('executive_roles', function (Blueprint $table) {
            $table->id();
            $table->integer('companyId');
            $table->integer('userId');
        });
        Schema::create('banks', function (Blueprint $table) {
            $table->id();
            $table->string('name');
        });

        foreach ([1 => 'Creator', 2 => 'Other User', 3 => 'Selected Approver'] as $id => $name) {
            User::forceCreate([
                'id' => $id, 'name' => $name, 'email' => "user$id@example.test",
                'companyId' => 1, 'userrole' => 4,
            ]);
        }
        DB::table('vendors')->insert([
            ['id' => 1, 'companyId' => 1, 'status' => 4, 'name' => 'Returned to creator', 'finance_manager' => 3],
            ['id' => 2, 'companyId' => 1, 'status' => 4, 'name' => 'Returned to other user', 'finance_manager' => 3],
            ['id' => 3, 'companyId' => 1, 'status' => 2, 'name' => 'Pending approval', 'finance_manager' => 3],
        ]);
        DB::table('vendorhistories')->insert([
            ['vendor_id' => 1, 'companyId' => 1, 'userId' => 1, 'action' => 'Created'],
            ['vendor_id' => 1, 'companyId' => 1, 'userId' => 3, 'action' => 'Returned'],
            ['vendor_id' => 2, 'companyId' => 1, 'userId' => 2, 'action' => 'Created'],
            ['vendor_id' => 2, 'companyId' => 1, 'userId' => 3, 'action' => 'Returned'],
            ['vendor_id' => 3, 'companyId' => 1, 'userId' => 1, 'action' => 'Created'],
        ]);
    }

    public function test_only_creator_sees_their_returned_request_in_vendor_lists(): void
    {
        $controller = app(VendorController::class);

        Auth::guard('web')->setUser(User::find(1));
        $this->assertSame([1, 3], $controller->index()->getData()['vendors']->pluck('id')->all());

        Auth::guard('web')->setUser(User::find(2));
        $this->assertSame([2, 3], $controller->index()->getData()['vendors']->pluck('id')->all());

        Auth::guard('web')->setUser(User::find(3));
        $this->assertSame([3], $controller->index()->getData()['vendors']->pluck('id')->all());
        $this->assertSame([3], $controller->myrequest()->getData()['vendors']->pluck('id')->all());
        $this->assertSame([3], $controller->showApprovalPage()->getData()['vendors']->pluck('id')->all());
    }

    public function test_other_users_cannot_open_update_or_delete_a_returned_request(): void
    {
        $this->withoutMiddleware(\App\Http\Middleware\VerifyCsrfToken::class);
        $this->actingAs(User::find(2))
            ->get('/vendors/edit/1')->assertForbidden();
        $this->put('/vendors/update/1', ['name' => 'Unauthorized change'])->assertForbidden();
        $this->get('/vendors/delete/1')->assertForbidden();
        $this->get('/vendors/approval/view/1')->assertNotFound();
        $this->post('/vendors/approval/1', ['action' => 'approve'])->assertForbidden();

        $this->assertSame('Returned to creator', DB::table('vendors')->where('id', 1)->value('name'));
        $this->assertSame(4, DB::table('vendors')->where('id', 1)->value('status'));
    }

    public function test_creator_can_edit_and_resubmit_returned_request_to_approver(): void
    {
        Auth::guard('web')->setUser(User::find(1));
        $this->assertSame(1, app(VendorController::class)->edit(1)->getData()['vendor']->id);

        app(VendorController::class)->update(Request::create('/', 'PUT', ['name' => 'Revised vendor']), 1);
        $this->assertSame('Revised vendor', DB::table('vendors')->where('id', 1)->value('name'));
        $this->assertSame(2, DB::table('vendors')->where('id', 1)->value('status'));

        Auth::guard('web')->setUser(User::find(3));
        $this->assertSame([1, 3], app(VendorController::class)->showApprovalPage()
            ->getData()['vendors']->pluck('id')->all());

        app(VendorController::class)->handleApprovalAction(Request::create('/', 'POST', [
            'action' => 'approve',
        ]), 1);
        $this->assertSame(3, DB::table('vendors')->where('id', 1)->value('status'));
    }

    public function test_only_creator_can_edit_pending_and_approved_vendors(): void
    {
        $this->withoutMiddleware(\App\Http\Middleware\VerifyCsrfToken::class);

        $this->actingAs(User::find(2))
            ->get('/vendors/edit/3')->assertForbidden();
        $this->put('/vendors/update/3', ['name' => 'Unauthorized change'])->assertForbidden();
        $this->assertSame('Pending approval', DB::table('vendors')->where('id', 3)->value('name'));

        $this->actingAs(User::find(3))
            ->post('/vendors/approval/3', ['action' => 'approve'])->assertRedirect();
        $this->assertSame(3, DB::table('vendors')->where('id', 3)->value('status'));
        $this->get('/vendors/edit/3')->assertForbidden();
        $this->put('/vendors/update/3', ['name' => 'Approver change'])->assertForbidden();

        Auth::guard('web')->setUser(User::find(1));
        $this->assertSame(3, app(VendorController::class)->edit(3)->getData()['vendor']->id);
        app(VendorController::class)->update(Request::create('/', 'PUT', ['name' => 'Creator change']), 3);
        $this->assertSame('Creator change', DB::table('vendors')->where('id', 3)->value('name'));
    }
}
