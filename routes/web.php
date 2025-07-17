<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\CompanyController;
use App\Http\Controllers\MasterController;
use App\Http\Controllers\ProcurementController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\PasswordResetLinkController;
use App\Http\Controllers\VendorController;
use App\Http\Controllers\RequisitionController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

use App\Http\Controllers\Auth\PasswordResetController;

//Route::get('forgot-password', [PasswordResetLinkController::class, 'request'])->name('password.request');
//Route::post('forgot-password', [PasswordResetController::class, 'email'])->name('password.email');
Route::get('reset-password/{token}', [PasswordResetController::class, 'resetForm'])->name('password.reset');
Route::post('reset-password', [PasswordResetController::class, 'reset'])->name('password.update');


Route::get('/forgot-password', function () {
    return view('auth.forgotpassword');
});

Route::get('/', function () {
    return view('auth.figma');
});


Route::get('/req', function () {
    return view('welcome');
});

Route::get('/stark', function () {
    return view('stark');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');


Route::middleware('auth')->group(function () {
     Route::get('/profile/{id}', [ProfileController::class, 'edit'])->name('profile.edit');
     Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');
     Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
     Route::get('/home', [UserController::class, 'home'])->name('home');
     Route::post('/executivehome/store', [UserController::class, 'executivehome'])->name('executivehome.store');

     //Users Routes
     Route::get('/users/parameters', [UserController::class, 'parameters'])->name('users.parameters');
     Route::get('/users/index', [UserController::class, 'index'])->name('users.index');
     Route::get('/users/create', [UserController::class, 'create'])->name('users.create');
     Route::post('/users/store', [UserController::class, 'store'])->name('users.store');
     Route::get('/users/show', [UserController::class, 'show'])->name('users.show');
     Route::get('/users/fetchData', [UserController::class, 'fetchData'])->name('users.fetchData');
     Route::post('/users/userRole', [UserController::class, 'userRole'])->name('users.userRole');
     Route::get('/users/{id}/delete', [UserController::class, 'userdelete'])->name('user.delete');
     Route::get('/users/{id}/edit', [UserController::class, 'useredit'])->name('edit.delete');
     Route::get('/users/{id}/unlock', [UserController::class, 'userunlock'])->name('edit.unlock');
     Route::put('/users/{id}/update', [UserController::class, 'update'])->name('user.update');

     //Company
     Route::get('/companies/index', [CompanyController::class, 'companyindex'])->name('companies.index');
     Route::get('/companies/create', [UserController::class, 'companycreate'])->name('companies.create');
     Route::post('/companies/store', [CompanyController::class, 'store'])->name('companies.store');
     Route::get('/company/{id}/delete', [CompanyController::class, 'companydelete'])->name('company.delete');
     Route::get('/company/{id}/edit', [CompanyController::class, 'companyedit'])->name('company.edit');
     Route::get('/company/{id}/configure', [CompanyController::class, 'configure'])->name('company.configure');
     Route::put('/company/{id}/update', [CompanyController::class, 'companyUpdate'])->name('company.update');

     Route::get('/users/index', [UserController::class, 'index'])->name('users.index');
     Route::get('/users/create', [UserController::class, 'create'])->name('users.create');
     Route::post('/users/store', [UserController::class, 'store'])->name('users.store');
       
     //Executive
     Route::get('/executives/index', [CompanyController::class, 'executivesindex'])->name('executives.index');
     Route::get('/executives/create', [CompanyController::class, 'executivescreate'])->name('executives.create');
     Route::post('/executives/store', [CompanyController::class, 'executivesstore'])->name('executives.store');

     //Master Pages
     Route::get('/master/manageRole', [MasterController::class, 'manageRole'])->name('master.manageRole');
     Route::get('/master/manageRole', [MasterController::class, 'manageRole'])->name('master.manageRole');
     Route::post('/userrole/store', [UserController::class, 'userrolestore'])->name('userrole.store');
     Route::get('/manageRole/{id}/editrole', [MasterController::class, 'editrole'])->name('editrole');
     Route::get('/manageRole/{id}/delete', [MasterController::class, 'delete'])->name('delete');
     Route::get('/bankaccount/{id}/delete', [MasterController::class, 'bankaccountdelete'])->name('bankaccount.delete');
     Route::get('/department/{id}/delete', [MasterController::class, 'departmentdelete'])->name('department.delete');
     Route::get('/department/{id}/edit', [MasterController::class, 'departmentedit'])->name('department.edit');
     Route::get('/bankaccount/{id}/edit', [MasterController::class, 'bankaccountedit'])->name('bankaccount.edit');
     Route::put('/bankaccount/{id}/update', [MasterController::class, 'bankaccountupdate'])->name('bankaccount.update');
     Route::put('/role/update/{id}', [MasterController::class, 'update'])->name('roleUpdate');
     Route::get('/master/banks', [MasterController::class, 'banks'])->name('master.banks');
     Route::get('/master/bankAccount', [MasterController::class, 'bankAccount'])->name('master.bankAccount');
     Route::post('/banks/store', [MasterController::class, 'banksStore'])->name('banks.store');
     Route::post('/department/store', [MasterController::class, 'departmentStore'])->name('department.store');
     Route::put('/department/{id}/update', [MasterController::class, 'departmentUpdate'])->name('department.update');
     Route::post('/bankaccount/store', [MasterController::class, 'bankaccountStore'])->name('bankaccount.store');
     Route::get('/master/departments', [MasterController::class, 'department'])->name('master.department');


     //Procurement
     Route::get('/procurement/createrequisition', [ProcurementController::class, 'createrequisition'])->name('procurement.createrequisition');
     Route::get('/procurement/indexrequisition', [ProcurementController::class, 'indexrequisition'])->name('procurement.indexrequisition');
     Route::get('/procurement/myrequisition', [ProcurementController::class, 'myrequisition'])->name('procurement.myrequisition');
     Route::post('/requisition/store', [ProcurementController::class, 'requisitionstore'])->name('procurement.requisitionstore');
     Route::put('/procurement/{id}/approve', [ProcurementController::class, 'requisitionapproval'])->name('procurement.requisitionapproval');
     Route::get('/procurement/{id}/logs', [ProcurementController::class, 'logs'])->name('procurement.logs');
     Route::put('/procurement/{id}/rejection', [ProcurementController::class, 'requisitionrejection'])->name('procurement.rejection');
     Route::put('/procurement/{id}/sendbackrequistion', [ProcurementController::class, 'sendbackrequistion'])->name('procurement.sendbackrequistion');
     Route::get('/procurement/indexpurchaseorder', [ProcurementController::class, 'indexpurchaseorder'])->name('procurement.indexpurchaseorder');
     Route::get('/procurement/mypurchaseorder', [ProcurementController::class, 'mypurchaseorder'])->name('procurement.mypurchaseorder');
     Route::get('/procurement/managepurchaseorder', [ProcurementController::class, 'managepurchaseorder'])->name('procurement.managepurchaseorder');
     Route::get('/procurement/{id}/purchaseorder', [ProcurementController::class, 'purchaseorder'])->name('procurement.purchaseorder');
     Route::post('/procurement/purchaseorderrelease', [ProcurementController::class, 'purchaseorderrelease'])->name('purchaseorder.release');
     Route::post('/procurement/downloadrequisitions', [ProcurementController::class, 'downloadrequisitions'])->name('procurement.downloadrequisitions');
     Route::get('/procurement/{id}/viewrequisition', [ProcurementController::class, 'viewrequisition'])->name('procurement.viewrequisition');
     Route::get('/procurement/{id}/download', [ProcurementController::class, 'generateAndMergePDFs'])->name('procurement.download');
     Route::get('/procurement/{id}/editrequisition', [ProcurementController::class, 'editrequisition'])->name('procurement.editrequisition');
     Route::put('/procurement/{id}/updaterequisition', [ProcurementController::class, 'updaterequisition'])->name('procurement.updaterequisition');
     Route::put('/purchaseorder/update/{id}', [ProcurementController::class, 'updatepurchaseorder'])->name('procurement.updatepurchaseorder');
     Route::get('/procurement/{id}/viewpurchaseorder', [ProcurementController::class, 'viewpurchaseorder'])->name('procurement.viewpurchaseorder');
     Route::get('/procurement/{id}/accept', [ProcurementController::class, 'approvepurchaseorder'])->name('procurement.approvepurchaseorder');
     Route::put('/procurement/{id}/bankAccount', [ProcurementController::class, 'approvepurchaseorderbankAccount'])->name('procurement.bankAccount');
     Route::put('/procurement/{id}/reject', [ProcurementController::class, 'rejectpurchaseorder'])->name('procurement.rejectpurchaseorder');
     Route::put('/procurement/{id}/pop', [ProcurementController::class, 'pop'])->name('procurement.pop');
     Route::get('/procurement/{id}/paymentRelease', [ProcurementController::class, 'paymentRelease'])->name('procurement.paymentRelease');
      Route::get('/procurement/{id}/view', [ProcurementController::class, 'view'])->name('procurement.view');
     Route::put('/procurement/{id}/sendback', [ProcurementController::class, 'sendbackpurchaseorder'])->name('procurement.updatepurchaseorder');
     Route::get('download-pdf/{filename}', [YourController::class, 'downloadPDF'])->name('download.pdf');
     Route::get('/procurement/createVendor', [ProcurementController::class, 'createVendor'])->name('procurement.createVendor');



     //Reports
     Route::get('/reports/requisitionreport', [ReportController::class, 'requisitionreport'])->name('reports.requisitionreport');
     Route::post('/reports/filteredrequisitionreport', [ReportController::class, 'requisitionfiltered'])->name('requisition.filtered');
     Route::post('/procurement/filter', [ProcurementController::class, 'requisitionfilter'])->name('requisition.filter');
     Route::post('/procurement/purhcasefilter', [ProcurementController::class, 'purchaseorderfilter'])->name('purchaseorder.filter');
     Route::post('/reports/filteredpurchaseorderreport', [ReportController::class, 'purchaseorderfiltered'])->name('purchaseorder.filtered');
     Route::get('/reports/purchaseorderreport', [ReportController::class, 'purchaseorderreport'])->name('reports.purchaseorderreport');
     Route::get('/reports/albarak', [ReportController::class, 'albarak'])->name('reports.albarak');
     Route::get('/reports/fnb', [ReportController::class, 'fnb'])->name('reports.fnb');
     Route::get('/reports/standardbank', [ReportController::class, 'standardbank'])->name('reports.standardbank');
     Route::get('/reports/waitingpurchaseorder', [ReportController::class, 'waitingpurchaseorder'])->name('reports.waitingpurchaseorder');


     Route::prefix('vendors')->group(function () {
        Route::get('/create', [VendorController::class, 'create']);
        Route::post('/store', [VendorController::class, 'store']);
        Route::get('/banking', [VendorController::class, 'bankingForm']);
        Route::post('/store-banking', [VendorController::class, 'storeBanking']);
        Route::get('/index', [VendorController::class, 'index']);
    });
    
    Route::get('/vendors/view/{id}', [VendorController::class, 'show']);
    Route::get('/vendors/delete/{id}', [VendorController::class, 'delete']);
    Route::get('/vendors/edit/{id}', [VendorController::class, 'edit']);
    Route::put('/vendors/update/{id}', [VendorController::class, 'update']);

    Route::get('/vendors/approval', [VendorController::class, 'showApprovalPage'])->name('vendors.approval');
    Route::post('/vendors/approval/{id}', [VendorController::class, 'handleApprovalAction'])->name('vendors.approvalAction');
    Route::get('/vendors/approval/details/{id}', [VendorController::class, 'showApprovalDetails'])->name('vendors.approval.details');
    Route::get('/vendors/approval/view/{id}', [VendorController::class, 'viewApprovalDetails'])->name('vendors.approval.view');
    Route::post('/vendors/approval/{id}', [VendorController::class, 'handleApprovalAction'])->name('vendors.approvalAction');



// Vendor Types
Route::prefix('vendor-types')->name('vendor-types.')->group(function () {
    Route::get('/', [VendorController::class, 'vendorTypeIndex'])->name('index');
    Route::post('/store', [VendorController::class, 'vendorTypeStore'])->name('store');
    Route::get('/{id}/edit', [VendorController::class, 'vendorTypeEdit'])->name('edit');
    Route::post('/{id}/update', [VendorController::class, 'vendorTypeUpdate'])->name('update');
    Route::delete('/{id}', [VendorController::class, 'vendorTypeDestroy'])->name('destroy');
});


Route::prefix('classifications')->group(function () {
    Route::get('/create', [VendorController::class, 'createClassification'])->name('classifications.create');
    Route::post('/store', [VendorController::class, 'storeClassification'])->name('classifications.store');
    Route::get('/{id}/edit', [VendorController::class, 'editClassification'])->name('classifications.edit');
    Route::put('/{id}/update', [VendorController::class, 'updateClassification'])->name('classifications.update');
    Route::delete('/{id}', [VendorController::class, 'deleteClassification'])->name('classifications.destroy');

});


    Route::get('banks/{id}/edit', [MasterController::class, 'bankEdit'])->name('bank.edit');
    Route::put('banks/{id}/update', [MasterController::class, 'bankUpdate'])->name('bank.update');
    Route::get('banks/{id}/delete', [MasterController::class, 'bankDelete'])->name('bank.delete');


Route::get('/form/configure', [RequisitionController::class, 'configureForm'])->name('form.configure');
Route::post('/form/configure', [RequisitionController::class, 'storeFormConfiguration'])->name('form.configure.store');


Route::get('/reports/create', [ReportController::class, 'create'])->name('reports.create');
Route::post('/reports', [ReportController::class, 'store'])->name('reports.store');
Route::get('/reports/{id}', [ReportController::class, 'show'])->name('reports.show');
Route::get('/reports', [ReportController::class, 'index'])->name('reports.index');

Route::delete('/reports/destroy/{id}', [ReportController::class, 'destroy'])->name('reports.destroy');

//Route::get('/requisition/create', [RequisitionController::class, 'createRequisition'])->name('requisition.create');
//Route::post('/requisition/store', [RequisitionController::class, 'storeRequisition'])->name('requisition.store');

});

require __DIR__.'/auth.php';
