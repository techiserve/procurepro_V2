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
use App\Models\Fpurchaseorder;
use App\Models\Vendor;
use App\Models\Frequisition;
use App\Models\RequisitionHistory;
use App\Models\Requisitionfile;
use App\Models\FormField;
use App\Models\Bankaccount;
use App\Models\Company;
use App\Models\CustomReport;
use Illuminate\Support\Facades\Storage;
use App\Models\Rolepermission;
use Alert;
use DB;
use App\Models\CompanyRole;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use ZipArchive;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\ArrayExport;

class ReportController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function requisitionreport()
    {

        $requisitions = Requisition::where('companyId', Auth::user()->companyId)->get();
        $vendors = DB::connection('sqlsrv')->table('Suppliers')->select('SupplierID', 'SupplierName')->get();   
        $servicetype = DB::connection('sqlsrv')->table('ServiceTypes')->get();
        $departments = Department::where('companyId', Auth::user()->companyId)->get();

       return view('reports.requisitionreport', compact('requisitions','vendors','servicetype','departments'));

    }



    public function requisitionfiltered(Request $request)
    {
        $query = Frequisition::query();
         
        if ($request->filled('status')) {
            $query->where('status', 'like', '%' . $request->input('status') . '%');
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

        $frequisitions = $query->where('companyId', Auth::user()->companyId)->get();

         $vendors = Frequisition::where('companyId', Auth::user()->companyId)
            ->select('vendor')
            ->groupBy('vendor')
            ->distinct()
            ->get();
        $servicetype = DB::connection('sqlsrv')->table('ServiceTypes')->get();
        $departments = Department::where('companyId', Auth::user()->companyId)->get();
        $roles = userrole::all(); 
        $formFields = FormField::where('companyId', Auth::user()->companyId)->get();

      return view('reports.filteredrequisitionreport', compact('frequisitions','vendors','servicetype','departments','formFields','roles'));

    }





    public function purchaseorderfiltered(Request $request)
    {
        $query = Fpurchaseorder::query();
         
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

        $fpurchaseorders = $query->where('companyId', Auth::user()->companyId)->get();
 
        $servicetype = DB::connection('sqlsrv')->table('ServiceTypes')->get();
        $departments = Department::where('companyId', Auth::user()->companyId)->get();
         $vendors = Frequisition::where('companyId', Auth::user()->companyId)
            ->select('vendor')
            ->groupBy('vendor')
            ->distinct()
            ->get();
        $servicetype = DB::connection('sqlsrv')->table('ServiceTypes')->get();
        $departments = Department::where('companyId', Auth::user()->companyId)->get();
        $roles = userrole::all(); 
        $formFields = FormField::where('companyId', Auth::user()->companyId)->get();

      return view('reports.filteredpurchaseorderreport', compact('fpurchaseorders','vendors','servicetype','departments','formFields','roles'));

    }

    /**
     * Show the form for creating a new resource.
     */
    public function purchaseorderreport()
    {

        $requisitions = Purchaseorder::where('companyId', Auth::user()->companyId)->get();
        $vendors = DB::connection('sqlsrv')->table('Suppliers')->select('SupplierID', 'SupplierName')->get();   
        $servicetype = DB::connection('sqlsrv')->table('ServiceTypes')->get();
        $departments = Department::where('companyId', Auth::user()->companyId)->get();


        return view('reports.purchaseorderreport' , compact('requisitions','vendors','servicetype','departments'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function waitingpurchaseorder()
    {

        $requisitions = Purchaseorder::where('companyId', Auth::user()->companyId)->get();
        $vendors = DB::connection('sqlsrv')->table('Suppliers')->select('SupplierID', 'SupplierName')->get();   
        $servicetype = DB::connection('sqlsrv')->table('ServiceTypes')->get();
        $departments = Department::where('companyId', Auth::user()->companyId)->get();

        return view('reports.waitingpurchaseorder', compact('requisitions','vendors','servicetype','departments'));
    }


    public function fnb()
    {        
          $fpurchaseorder = Fpurchaseorder::where('companyId', Auth::user()->companyId)->where('bankAccountName','=','FNB/RMB')->where('releaseStatus','=', null)->get();
          //dd($fpurchaseorder);
          $vendors = DB::connection('sqlsrv')->table('Suppliers')->select('SupplierID', 'SupplierName')->get();   
          $servicetype = DB::connection('sqlsrv')->table('ServiceTypes')->get();
          $departments = Department::where('companyId', Auth::user()->companyId)->get();

        return view('reports.fnb', compact('fpurchaseorder','departments','vendors','servicetype'));
    }




        public function albarak()
    {        
          $fpurchaseorder = Fpurchaseorder::where('companyId', Auth::user()->companyId)->where('bankAccountName','=','Albaraka Bank')->where('releaseStatus','=', null)->get();
          $vendors = DB::connection('sqlsrv')->table('Suppliers')->select('SupplierID', 'SupplierName')->get();   
          $servicetype = DB::connection('sqlsrv')->table('ServiceTypes')->get();
          $departments = Department::where('companyId', Auth::user()->companyId)->get();

        return view('reports.albarak', compact('fpurchaseorder','departments','vendors','servicetype'));
    }


        public function standardbank()
    {        
          $fpurchaseorder = Fpurchaseorder::where('companyId', Auth::user()->companyId)->where('bankAccountName','=','Standard Bank')->where('releaseStatus','=', null)->get();
          $vendors = DB::connection('sqlsrv')->table('Suppliers')->select('SupplierID', 'SupplierName')->get();   
          $servicetype = DB::connection('sqlsrv')->table('ServiceTypes')->get();
          $departments = Department::where('companyId', Auth::user()->companyId)->get();

        return view('reports.standardbank', compact('fpurchaseorder','departments','vendors','servicetype'));
    }
    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    public function store(Request $request)
    {

            $validated = $request->validate([
            'report_name' => 'required|string',
            'report_description' => 'nullable|string',
            'columns' => 'required|array|min:1',
            'columns.*.label' => 'required|string',
            'columns.*.table' => 'nullable|string',
            'columns.*.column' => 'nullable|string',
            'columns.*.blank' => 'nullable|boolean',
            'columns.*.default' => 'nullable|string',
        ]);

        CustomReport::create([
            'companyId' => $request->companyId,
            'name' => $validated['report_name'],
            'description' => $request->filterfield,
            'config' => json_encode($validated['columns'])
        ]);

    
        return back()->with('success', 'Report created successfully!');
   
    }

        public function show($id)
        {
            $report = CustomReport::findOrFail($id);
            $config = json_decode($report->config, true);

            // Get only non-blank columns to query from fpurchaseorder
            $columns = collect($config)
                ->filter(fn($col) => empty($col['blank']) && !empty($col['column']))
                ->pluck('column')
                ->unique()
                ->prepend('id')
                ->toArray();

            $fpurchaseorder = DB::table('fpurchaseorders')
                ->where('companyId', Auth::user()->companyId)
                ->where('uploadStatus', '=', null)
                ->select($columns)
                ->get();


               // dd($fpurchaseorder);
          $filters = DB::table('fpurchaseorders')
            ->where('companyId', Auth::user()->companyId)
            ->where('uploadStatus', '=', null)
            ->select($report->description)
            ->groupBy($report->description)
            ->pluck($report->description)
            ->toArray();  

         // dd($filters);

            return view('reports.show', compact('report', 'config', 'fpurchaseorder','filters'));
        }


      public function index()
        {

            $reports = CustomReport::where('companyId','=', Auth::user()->companyId)->latest()->get();
            $fpurchaseorderColumns = \Schema::getColumnListing('fpurchaseorder');

            return view('reports.index', compact('reports','fpurchaseorderColumns'));
        }

    /**
     * Update the specified resource in storage.
     */
 
public function filter(Request $request)
{
    $reportId = $request->input('report_id');
    $selectedFilters = $request->input('selected_filters', []);

    // Get report config
    $report = CustomReport::findOrFail($reportId);
    $config = json_decode($report->config, true);

    // DB columns from config
    $dbColumns = collect($config)
        ->filter(fn($col) => empty($col['blank']) && !empty($col['column']))
        ->pluck('column')
        ->unique()
        ->toArray();

    // Fetch only relevant DB columns
    $fpurchaseorders = DB::table('fpurchaseorders')
        ->where('companyId', Auth::user()->companyId)
        ->where('uploadStatus', '=', null)
        ->select($dbColumns)
        ->get();
       // dd($fpurchaseorders);

    // Prepare ZIP file
    $zipFile = storage_path('app/filtered_exports.zip');
    $zip = new ZipArchive;
    $zip->open($zipFile, ZipArchive::CREATE | ZipArchive::OVERWRITE);

    foreach ($selectedFilters as $filterValue) {
        // Filter dataset by this filter value (adjust column name if needed)
        // Here I’m assuming we filter by a column that exists in $dbColumns
        // e.g. 'season' or 'status'
        $columnName = $report->description;

        // $filteredRows = $fpurchaseorders->filter(function ($row) use ($filterValue, $columnName) {
        //     return isset($row->$columnName) && $row->$columnName == $filterValue;
        // });

        $filteredRows = $fpurchaseorders;

        dd($filteredRows,$filterValue);

        // Build CSV content
        $csvContent = '';

        // Header row
        $headers = collect($config)->pluck('label')->toArray();
        $csvContent .= implode(',', $headers) . "\n";

        // Data rows
        foreach ($filteredRows as $row) {
            $rowData = [];

            foreach ($config as $col) {
                $value = '';

                if (!empty($col['blank'])) {
                    $value = $col['default'] ?? '';
                } elseif (!empty($col['column'])) {
                    $columnName = $col['column'];
                    $value = $row->$columnName ?? $col['default'] ?? '';
                } elseif (empty($col['column']) && isset($col['default'])) {
                    $value = $col['default'];
                }

                // Escape CSV-safe
                $value = str_replace('"', '""', $value);
                $rowData[] = "\"{$value}\"";
            }

            $csvContent .= implode(',', $rowData) . "\n";
        }

        // Save temp CSV
        $tempCsvPath = storage_path("app/{$filterValue}.csv");
        file_put_contents($tempCsvPath, $csvContent);

        // Add to ZIP
        $zip->addFile($tempCsvPath, "{$filterValue}.csv");
    }

    $zip->close();

    // Download ZIP
    return response()->download($zipFile)->deleteFileAfterSend(true);
}

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
       // dd($id);

    $report = CustomReport::findOrFail($id);
    $report->delete();

    return redirect()->route('reports.index')
        ->with('success', 'Report deleted successfully.');
    }



         public function custom_report_remove(Request $request)
        {

             $reportId = $request->input('report_id');
            $selectedRowIds = $request->input('selected_rows', []);

            if (empty($selectedRowIds)) {
                return back()->with('error', 'No rows selected.');
            }
           
            //dd($selectedRowIds);
            // Perform your removal logic here, e.g., delete from fpurchaseorders by IDs
            DB::table('fpurchaseorders')->whereIn('id', $selectedRowIds)->update([

                'uploadStatus' => '1', // Assuming you want to set releaseStatus to null

            ]);

            return back()->with('success', count($selectedRowIds) . ' rows removed successfully.');

        }

   
}

