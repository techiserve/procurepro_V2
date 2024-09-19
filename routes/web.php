<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\CompanyController;
use App\Http\Controllers\MasterController;
use App\Http\Controllers\ProcurementController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;

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

Route::get('/', function () {
    return view('auth.login');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');


Route::middleware('auth')->group(function () {
     Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
     Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
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

     //Company
     Route::get('/companies/index', [CompanyController::class, 'companyindex'])->name('companies.index');
     Route::get('/companies/create', [UserController::class, 'companycreate'])->name('companies.create');
     Route::post('/companies/store', [CompanyController::class, 'store'])->name('companies.store');

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
     Route::get('/bankaccount/{id}/edit', [MasterController::class, 'bankaccountedit'])->name('bankaccount.edit');
     Route::put('/bankaccount/{id}/update', [MasterController::class, 'bankaccountupdate'])->name('bankaccount.update');
     Route::put('/role/update/{id}', [MasterController::class, 'update'])->name('roleUpdate');
     Route::get('/master/banks', [MasterController::class, 'banks'])->name('master.banks');
     Route::get('/master/bankAccount', [MasterController::class, 'bankAccount'])->name('master.bankAccount');
     Route::post('/banks/store', [MasterController::class, 'banksStore'])->name('banks.store');
     Route::post('/department/store', [MasterController::class, 'departmentStore'])->name('department.store');
     Route::post('/bankaccount/store', [MasterController::class, 'bankaccountStore'])->name('bankaccount.store');
     Route::get('/master/departments', [MasterController::class, 'department'])->name('master.department');


     //Procurement
     Route::get('/procurement/createrequisition', [ProcurementController::class, 'createrequisition'])->name('procurement.createrequisition');
     Route::get('/procurement/indexrequisition', [ProcurementController::class, 'indexrequisition'])->name('procurement.indexrequisition');
     Route::post('/requisition/store', [ProcurementController::class, 'requisitionstore'])->name('procurement.requisitionstore');
     Route::get('/procurement/{id}/approve', [ProcurementController::class, 'requisitionapproval'])->name('procurement.requisitionapproval');
     Route::get('/procurement/{id}/logs', [ProcurementController::class, 'logs'])->name('procurement.logs');
     Route::put('/procurement/{id}/rejection', [ProcurementController::class, 'requisitionrejection'])->name('procurement.rejection');
     Route::put('/procurement/{id}/sendbackrequistion', [ProcurementController::class, 'sendbackrequistion'])->name('procurement.sendbackrequistion');
     Route::get('/procurement/indexpurchaseorder', [ProcurementController::class, 'indexpurchaseorder'])->name('procurement.indexpurchaseorder');
     Route::get('/procurement/{id}/purchaseorder', [ProcurementController::class, 'purchaseorder'])->name('procurement.purchaseorder');
     Route::get('/procurement/{id}/viewrequisition', [ProcurementController::class, 'viewrequisition'])->name('procurement.viewrequisition');
     Route::put('/purchaseorder/update/{id}', [ProcurementController::class, 'updatepurchaseorder'])->name('procurement.updatepurchaseorder');
     Route::get('/procurement/{id}/viewpurchaseorder', [ProcurementController::class, 'viewpurchaseorder'])->name('procurement.viewpurchaseorder');
     Route::get('/procurement/{id}/accept', [ProcurementController::class, 'approvepurchaseorder'])->name('procurement.approvepurchaseorder');
     Route::put('/procurement/{id}/reject', [ProcurementController::class, 'rejectpurchaseorder'])->name('procurement.rejectpurchaseorder');
     Route::put('/procurement/{id}/sendback', [ProcurementController::class, 'sendbackpurchaseorder'])->name('procurement.updatepurchaseorder');


});

require __DIR__.'/auth.php';
