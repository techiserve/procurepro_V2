<?php

namespace App\Http\Controllers;
use App\Models\userrole;
use App\Models\User;
use App\Models\Sqlserver;
use App\Models\Bank;
use App\Models\Department;
use App\Models\Purchaseorder;
use App\Models\Departmentapproval;
use App\Models\Requisition;
use App\Models\RequisitionHistory;
use App\Models\Requisitionfile;
use App\Models\Bankaccount;
use App\Models\Company;
use Illuminate\Support\Facades\Storage;
use App\Models\Rolepermission;
use Alert;
use DB;
use App\Models\CompanyRole;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;


class ReportController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function requisitionreport()
    {

        $requisitions = Requisition::all();
        $vendors = DB::connection('sqlsrv')->table('Suppliers')->select('SupplierID', 'SupplierName')->get();   
        $servicetype = DB::connection('sqlsrv')->table('ServiceTypes')->get();
        $departments = Department::all();

      return view('reports.requisitionreport', compact('requisitions','vendors','servicetype','departments'));
    }



    public function requisitionfiltered(Request $request)
    {
        $query = Requisition::query();
         
       // dd($request->all());
        // Check for search inputs
        if ($request->filled('status')) {
            $query->where('status', 'like', '%' . $request->input('status') . '%');
        }
        if ($request->filled('service')) {
            $query->where('services', 'like', '%' . $request->input('service') . '%');
        }
        if ($request->filled('vendor')) {
            $query->where('vendor', 'like', '%' . $request->input('vendor') . '%');
        }
     
        if ($request->filled('start_date') && $request->filled('end_date')) {
            // If both start_date and end_date are provided
            $start_date = $request->input('start_date') . ' 00:00:00'; // Start of the start_date
            $end_date = $request->input('end_date') . ' 23:59:59';
            $query->whereBetween('created_at', [$start_date,$end_date]);
        } elseif ($request->filled('start_date')) {
            // If only start_date is provided
            $start_date = $request->input('start_date') . ' 00:00:00';
            $query->where('created_at', '>=', $start_date);
        } elseif ($request->filled('end_date')) {
            // If only end_date is provided
            $end_date = $request->input('end_date') . ' 23:59:59';
            $query->where('created_at', '<=', $end_date);
        }

        $requisitions = $query->get();

        $vendors = DB::connection('sqlsrv')->table('Suppliers')->select('SupplierID', 'SupplierName')->get();   
        $servicetype = DB::connection('sqlsrv')->table('ServiceTypes')->get();
        $departments = Department::all();

      return view('reports.filteredrequisitionreport', compact('requisitions','vendors','servicetype','departments'));
    }





    public function purchaseorderfiltered(Request $request)
    {
        $query = Purchaseorder::query();
         
       // dd($request->all());
        if ($request->filled('status')) {
            $query->where('status', 'like', '%' . $request->input('status') . '%');
        }
        if ($request->filled('service')) {
            $query->where('services', 'like', '%' . $request->input('service') . '%');
        }
        if ($request->filled('vendor')) {
            $query->where('vendor', 'like', '%' . $request->input('vendor') . '%');
        }
     
        if ($request->filled('start_date') && $request->filled('end_date')) {
            // If both start_date and end_date are provided
            $start_date = $request->input('start_date') . ' 00:00:00'; // Start of the start_date
            $end_date = $request->input('end_date') . ' 23:59:59';
            $query->whereBetween('created_at', [$start_date,$end_date]);
        } elseif ($request->filled('start_date')) {
            // If only start_date is provided
            $start_date = $request->input('start_date') . ' 00:00:00';
            $query->where('created_at', '>=', $start_date);
        } elseif ($request->filled('end_date')) {
            // If only end_date is provided
            $end_date = $request->input('end_date') . ' 23:59:59';
            $query->where('created_at', '<=', $end_date);
        }

        $requisitions = $query->get();

        $vendors = DB::connection('sqlsrv')->table('Suppliers')->select('SupplierID', 'SupplierName')->get();   
        $servicetype = DB::connection('sqlsrv')->table('ServiceTypes')->get();
        $departments = Department::all();

      return view('reports.filteredpurchaseorderreport', compact('requisitions','vendors','servicetype','departments'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function purchaseorderreport()
    {

        $requisitions = Purchaseorder::all();
        $vendors = DB::connection('sqlsrv')->table('Suppliers')->select('SupplierID', 'SupplierName')->get();   
        $servicetype = DB::connection('sqlsrv')->table('ServiceTypes')->get();
        $departments = Department::all();


        return view('reports.purchaseorderreport' , compact('requisitions','vendors','servicetype','departments'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function waitingpurchaseorder()
    {

        $requisitions = Purchaseorder::all();
        $vendors = DB::connection('sqlsrv')->table('Suppliers')->select('SupplierID', 'SupplierName')->get();   
        $servicetype = DB::connection('sqlsrv')->table('ServiceTypes')->get();
        $departments = Department::all();

        return view('reports.waitingpurchaseorder', compact('requisitions','vendors','servicetype','departments'));
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
