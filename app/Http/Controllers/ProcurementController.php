<?php

namespace App\Http\Controllers;
use App\Models\userrole;
use App\Models\User;
use App\Models\Sqlserver;
use App\Models\Bank;
use App\Models\Department;
use App\Models\Purchaseorder;
use App\Models\Fpurchaseorder;
use App\Models\Vendor;
use App\Models\ClassificationOfExpense;
use App\Services\WhatsAppService;
use App\Models\Departmentapproval;
use App\Models\Requisition;
use App\Models\RequisitionHistory;
use App\Models\Requisitionfile;
use App\Models\Bankaccount;
use App\Models\VendorType;
use App\Models\Company;
use App\Models\FormField;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use App\Models\Frequisition;
use Barryvdh\DomPDF\Facade\Pdf;
use setasign\Fpdi\Fpdi;
use setasign\Fpdf\Fpdf;
use iio\libmergepdf\Merger;
use Illuminate\Support\Facades\Storage;
use App\Models\Rolepermission;
use Alert;
use DB;
use App\Models\CompanyRole;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\HtmlString;
use Symfony\Component\Mime\Part\TextPart;
use Symfony\Component\HttpFoundation\StreamedResponse;
use App\Mail\SendSampleEmail;
 
class ProcurementController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    
    public function createrequisition()
    {  

        $vendors = DB::connection('sqlsrv')->table('Suppliers')->select('SupplierID', 'SupplierName')->get();

        $servicetypes = DB::connection('sqlsrv')->table('ServiceTypes')->select('ServiceTypeDescription')->get();

        $properties = DB::connection('sqlsrv')->table('Properties')->select('PropertyName')->get();

        $transcations = DB::connection('sqlsrv')->table('TransactionCodes')->select('TransactionDescription')->get();

        $taxes = DB::connection('sqlsrv')->table('TaxTypes')->select('TaxTypeDescription')->get();

        $departments = Department::where('IsActive', '!=' , null)->where('companyId', Auth::user()->companyId)->get();

        $company = Company::where('id', Auth::user()->companyId)->first();

        $vendorTypes = VendorType::all();

        $banks = Bank::all();

        $expenses = ClassificationOfExpense::all();

          //  dd($expenses);

        if($company->vendor_source == "Vendor Management"){
           $vendors = Vendor::select(
                'id as SupplierID', 
                'name as SupplierName'
            )->get();
        }

       // dd($vendors);
        
        $formFields = FormField::where('companyId', Auth::user()->companyId)->get();

       $formFields->push((object)[
    'name' => 'department',
    'label' => 'Department',
    'type' => 'select',
    'options' => $departments, // Ensure $departments is passed to the view
]);
// dd($formFields);

        $expenses = ClassificationOfExpense::all();
        return view('procurement.createrequisition', compact('departments','vendors','banks','vendorTypes','expenses','servicetypes','properties','transcations','taxes','formFields','company'));
        //return view('procurement.createrequisition', compact('departments','vendors','formFields','company'));

    }



    public function createVendor()
    {
        $vendorTypes = VendorType::all();
        $users = User::where('companyId','=',Auth::user()->companyId)->get();
        return view('procurement.createVendor', compact('vendorTypes','users'));
    }


    /**
     * Show the form for creating a new resource.
     */
    public function indexrequisition()
    {

        // $emailData = [

        //        'title' => 'Test from Procure Pro',
        //        'body'  => 'This is a test email.'

        // ];

        // // Queue the email for background processing
        // Mail::to('itaivincent321@gmail.com')->queue(new SendSampleEmail($emailData));
        // dd('send mail');
        // $requisitions = Requisition::with('histories')->where('userId', Auth::user()->id)->where('companyId', Auth::user()->companyId)->orwhere('isActive', '=', 1)->where('companyId', Auth::user()->companyId)->orderby('id','desc')->get();
       // $vendors = DB::connection('sqlsrv')->table('Suppliers')->select('SupplierID', 'SupplierName')->get();   
       // $servicetype = DB::connection('sqlsrv')->table('ServiceTypes')->get();
        $roles = userrole::all(); 

        $formFields = FormField::where('companyId', Auth::user()->companyId)->get();
        //dd($formFields);
 
        $frequisitions = Frequisition::with('histories')->where('userId', Auth::user()->id)->where('companyId', Auth::user()->companyId)->orwhere('isActive', '=', 1)->where('companyId', Auth::user()->companyId)->orderby('id','desc')->get();
         //  dd($frequisitions);
        return view('procurement.indexfrequisiton', compact('formFields', 'frequisitions','roles'));
    }

    

    public function myrequisition()
    {

        $requisitions = Requisition::with('histories')->where('approvedby', Auth::user()->userrole)->where('status', '=', 1)->where('companyId', Auth::user()->companyId)->get();
        $roles = userrole::where('companyId', Auth::user()->companyId)->get(); 
     
        return view('procurement.myrequisiton', compact('requisitions','roles'));
    }

        public function viewrequisition(string $id)
    {
      
        $frequisition = Frequisition::where('id', $id)->first();
        $formFields = FormField::where('companyId', $frequisition->companyId)->get();
        $files = Requisitionfile::where('requisitionId', $id)->get();
        //$vendors = DB::connection('sqlsrv')->table('Suppliers')->select('SupplierID', 'SupplierName')->get();   
       // $servicetype = DB::connection('sqlsrv')->table('ServiceTypes')->get();
        $departments = Department::where('id', $frequisition->department)->first();
       // dd($frequisition);
        if(!$departments){
             
            return redirect()->route('procurement.myrequisition')->with('warning', 'The department was removed from Tagpay!');
        }

        $history = RequisitionHistory::where('frequisition_id', $id)->where('userId',  Auth::user()->id)->where('action','!=', 'Created Purchase Requisition')->where('action', '!=', 'Purchase Requisition Returned')->first();
    
        // return view('procurement.fviewrequisition', compact('frequisition','files','vendors','servicetype','formFields','history','departments'));
            
        return view('procurement.fviewrequisition', compact('frequisition','files','formFields','history','departments'));
    }



    public function editrequisition(string $id)
    {
     
        $frequisition = Frequisition::where('id', $id)->first();
        $formFields = FormField::where('companyId', $frequisition->companyId)->get();
        $files = Requisitionfile::where('requisitionId', $id)->get();
        $departments = Department::where('id', $frequisition->department)->first();

        return view('procurement.editfrequisition', compact('frequisition','formFields','files','departments'));
    }



    public function indexpurchaseorder()
    {
     
        $fpurchaseorders = Fpurchaseorder::with('histories')->where('userId', Auth::user()->id)->orwhere('isActive', '=', 1)->where('companyId', Auth::user()->companyId)->orderby('id','desc')->get();
        $roles = userrole::where('companyId', Auth::user()->companyId)->get();
       // $vendors = DB::connection('sqlsrv')->table('Suppliers')->select('SupplierID', 'SupplierName')->get();   
       // $servicetype = DB::connection('sqlsrv')->table('ServiceTypes')->get();
        $formFields = FormField::where('companyId', Auth::user()->companyId)->get();

        //  dd($fpurchaseorders);
        return view('procurement.indexfpurchaseorder', compact('fpurchaseorders','roles','formFields'));
    }


    public function mypurchaseorder()
    {
        $purchaseorders = Purchaseorder::with('histories')->where('approvedby', Auth::user()->userrole)->where('status', '=', 1)->where('companyId', Auth::user()->companyId)->get();
        $roles = userrole::where('companyId', Auth::user()->companyId)->get();

        return view('procurement.mypurchaseorder', compact('purchaseorders','roles'));
    }


    public function managepurchaseorder()
    {
    
        $purchaseorders = Purchaseorder::where('releaseStatus', '=', null)->where('companyId', Auth::user()->companyId)->get();
        $roles = userrole::where('companyId', Auth::user()->companyId)->get();

        return view('procurement.managepurchaseorder', compact('purchaseorders','roles'));
    }


    public function logs(string $id)
    { 

        $histories = RequisitionHistory::where('frequisition_id', '=', $id)->where('companyId', Auth::user()->companyId)->get();
        return view('procurement.logs', compact('histories'));

    }


    public function purchaseorder(string $id)
    {
     
        $purchaseorder = Fpurchaseorder::where('id', $id)->first();
        $formFields = FormField::where('companyId', $purchaseorder->companyId)->get();
        $history = RequisitionHistory::where('frequisition_id', $id)->where('userId',  Auth::user()->id)->where('action', '=', 'Purchase Order Approved')->first();
        $departments = Department::where('id', $purchaseorder->department)->first();

        return view('procurement.editfpurchaseorder', compact('purchaseorder','history','departments','formFields'));

    }


    public function purchaseorderrelease(Request $request)
    { 

      $selectedPurchaseOrders = $request->input('selected_items');
     
        if($request->input('action') == 'Complete_Selected_Orders'){
        
      if ($selectedPurchaseOrders) {
       

        foreach ($selectedPurchaseOrders as $orderId) {

            $purchaseOrder = PurchaseOrder::find($orderId);
            if($purchaseOrder->status == 2 ){
            if ($purchaseOrder) {
                $purchaseOrder->releaseStatus = 1; // Set status to 1 (or any status you want)
                $purchaseOrder->save();
            }
        }
        }

        return back()->with('success', 'Purchase Orders Completed!'); 

    }else{

        return back()->with('warning', 'Please select purchase orders!');

    }


  

}else{

    return $this->exportToCsv();
        
}


    }




    public function requisitionfilter(Request $request)
    {
        $query = Requisition::query();
         
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

        $requisitions = $query->where('companyId', Auth::user()->companyId)->get();

        $vendors = DB::connection('sqlsrv')->table('Suppliers')->select('SupplierID', 'SupplierName')->get();   
        $servicetype = DB::connection('sqlsrv')->table('ServiceTypes')->get();
        $departments = Department::where('companyId', Auth::user()->companyId)->get();
        $roles = userrole::where('companyId', Auth::user()->companyId)->get(); 

      return view('procurement.indexrequisiton', compact('requisitions','vendors','servicetype','departments','roles'));

    }



    public function purchaseorderfilter(Request $request)
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

        $purchaseorders = $query->where('companyId', Auth::user()->companyId)->get();

        $vendors = DB::connection('sqlsrv')->table('Suppliers')->select('SupplierID', 'SupplierName')->get();   
        $servicetype = DB::connection('sqlsrv')->table('ServiceTypes')->get();
        $departments = Department::where('companyId', Auth::user()->companyId)->get();
        $roles = userrole::where('companyId', Auth::user()->companyId)->get(); 

      return view('procurement.indexpurchaseorder', compact('purchaseorders','vendors','servicetype','departments','roles'));
    }






    public function updaterequisition(Request $request, $id)
    {

      
         $frequisition = Frequisition::findOrFail($id);
       // dd($frequisition);
        $departmentName = Department::where('id', $frequisition->department)->first();
        $level = Departmentapproval::where('mode','=','PR')->where('departmentId', $departmentName->id)->min('approvalId');
        $totalapprovallevels = Departmentapproval::where('mode','=','PR')->where('departmentId', $departmentName->id)->count();
        $approver = Departmentapproval::where('mode','=','PR')->where('departmentId', $departmentName->id)->where('approvalId', $level)->first();
  
        $frequisition = Frequisition::findOrFail($id);

            // Fetch dynamic form fields for this companyId or global fields (null)
            $formFields = FormField::where(function($query) use ($frequisition) {
                $query->where('companyId', $frequisition->companyId);
            })->pluck('name')->unique();

            // Update each field dynamically from the request
            foreach ($formFields as $fieldName) {
                if ($request->has($fieldName)) {
                    $frequisition->$fieldName = $request->input($fieldName);
                }
            }

            $frequisition->approvallevel = $level;
            $frequisition->totalapprovallevels = $totalapprovallevels;
            $frequisition->approvedby = $approver->roleId ?? null;
            $frequisition->isActive = 1;
            $frequisition->status = 1;

            $frequisition->save();

    //   $updaterequisition = Frequisition::where('id', $id)->update([

    //     'expenses'  => $request->expenses,
    //     'projectcode'  => $request->projectcode,
    //     'amount'  => $request->amount,
    //     'approvallevel'  => $level,
    //     'totalapprovallevels'  => $totalapprovallevels,
    //     'approvedby' => $approver->roleId, 
    //     'isActive'  => 1,
    //     'status'  => 1,

    //   ]);

      return redirect()->route('procurement.indexrequisition')->with('success', 'Requisition Updated successfully!');

    }



    private function exportToCsv()
    {
        // Fetch all purchase orders where status is 2
        $purchaseOrders = PurchaseOrder::where('status', 2)->where('releaseStatus', '=' , null)->get();

        $response = new StreamedResponse(function () use ($purchaseOrders) {
            $handle = fopen('php://output', 'w');  
            // Add CSV header
            fputcsv($handle, ['Supplier Code','Property Code','Transaction Code','Expense', 'Tax Code', 'Invoice Amount', 'Effective Date']);        
            // Add rows for purchase orders with status = 2
            foreach ($purchaseOrders as $purchaseOrder) {
                fputcsv($handle, [$purchaseOrder->SupplierCode, $purchaseOrder->PropertyCode, $purchaseOrder->TransactionCode, $purchaseOrder->expenses, $purchaseOrder->TaxTypeCode,$purchaseOrder->invoiceamount, $purchaseOrder->created_at->format('Ymd')]);
            }

            fclose($handle);
        });

        // Set headers for the CSV download
        $response->headers->set('Content-Type', 'text/csv');
        $response->headers->set('Content-Disposition', 'attachment; filename="purchase_orders.csv"');

        return $response;
    }

    
    public function viewpurchaseorder(string $id)
    {
  
        $fpurchaseorder = Fpurchaseorder::where('id', $id)->first();
        $departments = Department::where('id', $fpurchaseorder->department)->first();
        $invoice = 'uploads/' . $fpurchaseorder->invoice;
        $jobcard = 'uploads/' . $fpurchaseorder->jobcard;

         $formFields = FormField::where('companyId', $fpurchaseorder->companyId)->get();

       // dd($invoice);
        if  (Storage::disk('public')->exists($invoice)) {
            
            $invoicepath = Storage::disk('public')->url($invoice);
        }else{
            $invoicepath = null;

        }

   
        if  (Storage::disk('public')->exists($jobcard)) {
            
          //  $jobcardpath = Storage::get($jobcard);
            $jobcardpath = Storage::disk('public')->url($jobcard);
        }else{
            $jobcardpath = null;

        }
       // dd($invoicepath,$jobcardpath);
       $history = RequisitionHistory::where('frequisition_id', $id)->where('userId',  Auth::user()->id)->where('action', '=', 'Purchase Order Approved')
       ->orwhere('action', '=', 'Purchase Order Rejected')->where('frequisition_id', $id)->where('userId',  Auth::user()->id)
       ->orwhere('action', '!=', 'Purchase Order Returned')->where('frequisition_id', $id)->where('userId',  Auth::user()->id)->first();


        return view('procurement.viewfpurchaseorder', compact('fpurchaseorder','formFields','invoicepath','jobcardpath','history','departments'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function requisitionstore(Request $request,WhatsAppService $whatsapp)
    {

        $company = Company::where('id', Auth::user()->companyId)->first();
        $latest = Frequisition::where('requisitionNumber', 'LIKE', $company->name . '-%')
        ->orderBy('id', 'desc')
        ->first();

          if ($latest) {
        // Extract number part
        $lastNumber = (int) Str::after($latest->requisitionNumber, $company->name . '-');
        $newNumber = $lastNumber + 1;
    } else {
        $newNumber = 1;
    }

     $requisitionNumber = $company->name . '-' . str_pad($newNumber, 4, '0', STR_PAD_LEFT);
       //dd($requisitionNumber);
       $formFields = FormField::all();
       $data = [];

    // Collect dynamic form field data
    foreach ($formFields as $field) {
        if ($request->has($field->name)) {
            $data[$field->name] = $request->input($field->name);
        }
    }

    // Add additional static fields
    $data['userId'] = Auth::id();
    $data['requisitionNumber'] = $requisitionNumber;
    $data['companyId'] = Auth::user()->companyId;
    $data['status'] = 1;
    $data['isActive'] = 1;
   

    if ($request->has('department')) {
        $department = Department::find($request->input('department'));
        if ($department) {
            $level = Departmentapproval::where('mode','=','PR')->where('departmentId', $department->id)->min('approvalId');
            $totalApprovalLevels = Departmentapproval::where('mode','=','PR')->where('departmentId', $department->id)->count();
            $approver = Departmentapproval::where('mode','=','PR')->where('departmentId', $department->id)
                ->where('approvalId', $level)
                ->first();

            $data['approvallevel'] = $level;
            $data['totalapprovallevels'] = $totalApprovalLevels;
            if ($approver) {
                $data['approvedby'] = $approver->roleId;
            }
        }
    }

    // Filter out null values
    $filteredData = array_filter($data, function ($value) {
        return !is_null($value);
    });

    
    // Create the requisition
       $requisition = Frequisition::forceCreate($filteredData);
 

       if ($request->hasFile('file')) {
        // Loop through each file
        foreach ($request->file('file') as $file) {
            // Generate a unique name for the file
            $quotationfile = $file->store('uploads', 'public');

            $quotation =  Str::afterLast($quotationfile, '/');

            // Save the filename in the database
            $savefile = Requisitionfile::create([

                'requisitionId' => $requisition->id,
                'companyId'  =>Auth::user()->companyId,
                'file'  =>  $quotation,
                'userId'  =>Auth::user()->id,
                'path'  => 1,
                
               ]);
        }

    } 

    //    $emailData = $requisition->toArray();
      
    //     Mail::to('b.essop@techiserve.com')->queue(new SendSampleEmail($emailData));

       if($requisition){

    //     $to = "whatsapp:+263778440481";
    //     $message = "🔔 New requisition pending your approval. Login to your dashboard to view it.";
    //     // dd($to);
    //    $whatsapp->send($to, $message);

        return back()->with('success', 'Requisition created successfully!');
    }
      return back()->with('error', 'Failed to create Requiisition!');

    }



    public function updatepurchaseorder(Request $request,$id)
    {   
        
       //dd($request->all());
        $fpur = Fpurchaseorder::where('id', $id)->first();
        $freq = Frequisition::where('id', $fpur->frequisition_id)->first();
        $departmentName = Department::where('id', $freq->department)->first();
       // dd($freq);
        $level = Departmentapproval::where('mode','=','PO')->where('departmentId', $departmentName->id)->min('approvalId');
        //dd($level);
        $totalapprovallevels = Departmentapproval::where('mode','=','PO')->where('departmentId', $departmentName->id)->count();
        $approver = Departmentapproval::where('mode','=','PO')->where('departmentId', $departmentName->id)->where('approvalId', $level)->first();
  
        $request->validate([
            'invoice' => 'required|mimes:pdf,doc,docx,txt|max:9048',
        ]);

        // Store the file
        $invoicefilePath = $request->file('invoice')->store('uploads', 'public');

        $invoicefilePath =  Str::afterLast($invoicefilePath, '/');
       // dd($invoicefilePath);

        if ($request->hasFile('jobcard')) {
         $jobfilePath = $request->file('jobcard')->store('uploads', 'public');   
         $jobfilePath =  Str::afterLast($jobfilePath, '/');  
        }else{
            $jobfilePath = null;
        }

       $requisition = Fpurchaseorder::where('id',$id)->update([

        'invoiceamount'  =>$request->invoiceamount,
        'invoice'  => $invoicefilePath,
        'jobcardfile'  => $jobfilePath,
        'status'  => 1,
        'approvallevel'  => $level,
        'totalapprovallevels'  => $totalapprovallevels,
        'approvedby' => $approver->roleId, 
        'isActive'  => 1,
        
       ]);



       if($requisition){

        return redirect()->route('procurement.indexpurchaseorder')->with('success', 'Documents Uploaded successfully!');
    }
      return back()->with('error', 'Failed to update documents!');

    }

    /**
     * Display the specified resource.
     */
    public function requisitionapproval(string $id)
    {

        $frequisition = Frequisition::where('id', $id)->first();

        if($frequisition->approvallevel+1 > $frequisition->totalapprovallevels){
         
           // dd('zvapera');
            $updatedapprovallevel = $frequisition->approvallevel+1;
                 $updatereq = Frequisition::where('id', $id)->update([

                'approvallevel' =>  $updatedapprovallevel,
                'approvedby' => Auth::user()->userrole,
                'isActive'  => 1,
                'status'  => 2,

                 ]);   

   // gadzira purchase order then add upload file too

    $formFields = FormField::where(function ($query) use ($frequisition) {
        $query->Where('companyId', $frequisition->companyId);
    })->pluck('name')->unique();

   // dd( $formFields, $frequisition);

    // 3. Initialize data array to copy values from frequisition to fpurchaseorder
    $purchaseOrderData = [];

    foreach ($formFields as $fieldName) {
        // Check if the field exists on frequisition
        if (isset($frequisition->$fieldName)) {
            $purchaseOrderData[$fieldName] = $frequisition->$fieldName;
        }
    }

    // 4. Add other static or required fields if needed
    $purchaseOrderData['companyId'] = $frequisition->companyId;
    $purchaseOrderData['frequisition_id'] = $frequisition->id;
    $purchaseOrderData['requisitionNumber'] = $frequisition->requisitionNumber;
    $purchaseOrderData['userId'] = $frequisition->userId;
    $purchaseOrderData['department'] = $frequisition->department;
    $purchaseOrderData['status'] = 0; 
    $purchaseOrderData['approvallevel'] = 0;
    $purchaseOrderData['totalapprovallevels'] = 0;
    $purchaseOrderData['purchaseorderstatus'] = 1;
    $purchaseOrderData['isActive'] = 0;

   // dd($purchaseOrderData);
    // 5. Create the purchase order
    $fpurchaseorder = Fpurchaseorder::forceCreate($purchaseOrderData);


           $requisitiond = RequisitionHistory::create([

            'frequisition_id' => $frequisition->id,
            'amount'  => $frequisition->amount,
            'companyId'  =>Auth::user()->companyId,
            'userId'  =>Auth::user()->id,
            'status'  => 1,
            'approvallevel' =>  $updatedapprovallevel,
            'approvedby' => Auth::user()->userrole, 
            'isActive'  => 1,
            'action'  => "Purchase Requisition Approved and Purchase Order Created",
            'doneby' => Auth::user()->name
            
           ]);
    


        }else{
 
            $updatedapprovallevel = $frequisition->approvallevel+1;
            $approver = Departmentapproval::where('mode','=','PR')->where('departmentId', $frequisition->department)->where('approvalId', $updatedapprovallevel)->first();

            $updatereq = Frequisition::where('id', $id)->update([

                'approvallevel' =>  $updatedapprovallevel,
                'approvedby' => $approver->roleId,              

                 ]);   
               

                 $frequisitions = RequisitionHistory::create([

                    'companyId'  =>Auth::user()->companyId,
                    'frequisition_id' => $frequisition->id,
                    'amount'  => $frequisition->amount,
                    'userId'  =>Auth::user()->id,
                    'status'  => 1,
                    'approvallevel' =>  $updatedapprovallevel,
                    'approvedby' => Auth::user()->userrole, 
                    'isActive'  => 1,
                    'action'  => "Purchase Requisition Approved",
                    'doneby' => Auth::user()->name
                    
                   ]);
            
        }


        if($updatereq){

            
        return redirect()->route('procurement.myrequisition')->with('approved', true);

        }
    }


    public function requisitionrejection(Request $request, string $id)
    {

        $requisition = Frequisition::where('id', $id)->first();

                 $updatereq = Frequisition::where('id', $id)->update([

                'approvedby' => Auth::user()->userrole,
                'approvallevel' => $requisition->approvallevel,
                'reason' => $request->message,
                'isActive' => 0, 
                'status'  => 3,
           
                 ]);   



                 $requisition = RequisitionHistory::create([

                    'frequisition_id' => $requisition->id,
                    'amount'  => $requisition->amount,
                    'companyId'  =>Auth::user()->companyId,
                    'userId'  =>Auth::user()->id,
                    'status'  => 1,
                    'approvedby' => Auth::user()->userrole, 
                    'isActive'  => 1,
                    'action'  => "Purchase Requisition Rejected",
                    'doneby' => Auth::user()->name
                    
                   ]);


        if($updatereq){
   
         return redirect()->route('procurement.myrequisition')->with('success', 'Requisition order rejected!');

        }
    }



    public function sendbackrequistion(Request $request, string $id)
    {

        $requisition = Frequisition::where('id', $id)->first();

                 $updatereq = Frequisition::where('id', $id)->update([

                'approvedby' => Auth::user()->userrole,
                'approvallevel' => $requisition->approvallevel,
                'reason' => $request->message,
                'isActive' => 0, 
                'status'  => 4,

                 ]);  
                 
                 
                 $requisition = RequisitionHistory::create([

                    'frequisition_id' => $requisition->id,
                    'amount'  => $requisition->amount,
                    'companyId'  =>Auth::user()->companyId,
                    'userId'  =>Auth::user()->id,
                    'status'  => 1,
                    'approvallevel' =>  $requisition->approvallevel,
                    'approvedby' => Auth::user()->userrole, 
                    'isActive'  => 1,
                    'action'  => "Purchase Requisition Returned",
                    'doneby' => Auth::user()->name
                    
                   ]);


        if($updatereq){
   
         return redirect()->route('procurement.myrequisition')->with('success', 'Requisition returned!');

        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function approvepurchaseorder(string $id)
    {
 
        $requisition = Fpurchaseorder::where('id', $id)->first();

        if($requisition->approvallevel+1 > $requisition->totalapprovallevels){
         
            $updatedapprovallevel = $requisition->approvallevel;
                 $updatereq = Fpurchaseorder::where('id', $id)->update([

                'approvallevel' =>  $updatedapprovallevel,
                'approvedby' => Auth::user()->userrole,
                'isActive'  => 1,
                'status'  => 2,

                 ]);  
                 
                 

                 $requisitiond = RequisitionHistory::create([

                    'frequisition_id' => $requisition->requisition_id,
                    'amount'  => $requisition->amount,
                    'companyId'  =>Auth::user()->companyId,
                 //   'file'  => $quotation,
                    'userId'  =>Auth::user()->id,
                    'status'  => 1,
                    'approvallevel' =>  $updatedapprovallevel,
                    'approvedby' => Auth::user()->userrole, 
                    'isActive'  => 1,
                    'action'  => "Purchase Order Approved and Sent to Upload File",
                    'doneby' => Auth::user()->name
                    
                   ]);
            


        }else{
  
            $updatedapprovallevel = $requisition->approvallevel+1;
            $approver = Departmentapproval::where('mode','=','PO')->where('departmentId', $requisition->department)->where('approvalId', $updatedapprovallevel)->first();

            $updatereq = Fpurchaseorder::where('id', $id)->update([

                'approvallevel' =>  $updatedapprovallevel,
                'approvedby' => $approver->roleId,              

                 ]);   



                 $requisitiond = RequisitionHistory::create([

                    'frequisition_id' => $requisition->requisition_id,
                    'amount'  => $requisition->amount,
                    'companyId'  =>Auth::user()->companyId,
                    'userId'  =>Auth::user()->id,
                    'status'  => 1,
                    'approvallevel' =>  $updatedapprovallevel,
                    'approvedby' => Auth::user()->userrole, 
                    'isActive'  => 1,
                    'action'  => "Purchase Order Approved",
                    'doneby' => Auth::user()->name
                    
                   ]);
            

        }


        if($updatereq){
   
         return redirect()->route('procurement.mypurchaseorder')->with('success', 'Purchase order approved successfully!');

        }
    }

    public function rejectpurchaseorder(Request $request, string $id)
    {

        $requisition = Fpurchaseorder::where('id', $id)->first();

                 $updatereq = Fpurchaseorder::where('id', $id)->update([

                'approvedby' => Auth::user()->userrole,
                'approvallevel' => $requisition->approvallevel,
                'isActive' => 0, 
                'status'  => 3,
                'purchaseorderstatus'  => 3,
                'reason'  => $request->message,

                 ]);  
                                
                 
                 $requisitiond = RequisitionHistory::create([

                    'frequisition_id' => $requisition->requisition_id,
                    'amount'  => $requisition->amount,
                 //   'file'  => $quotation,
                    'userId'  =>Auth::user()->id,
                    'companyId'  =>Auth::user()->companyId,
                    'status'  => 1,
                   // 'approvallevel' =>  $updatedapprovallevel,
                    'approvedby' => Auth::user()->userrole, 
                    'isActive'  => 1,
                    'action'  => "Purchase Order Rejected",
                    'doneby' => Auth::user()->name
                    
                   ]);


        if($updatereq){
   
         return redirect()->route('procurement.mypurchaseorder')->with('success', 'Purchase order rejected!');

        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function sendbackpurchaseorder(Request $request, string $id)
    {

        $updatereq = Fpurchaseorder::where('id', $id)->update([

       'approvedby' => Auth::user()->userrole,
       'status'  => 4,
       'approvallevel'  => 0,
       'totalapprovallevels'  => 0,
       'purchaseorderstatus' => 4, 
       'isActive'  => 0,
       'reason'  => $request->message,

        ]);   


        $requisition = Fpurchaseorder::where('id', $id)->first();
        
        $requisitiond = RequisitionHistory::create([

            'frequisition_id' => $requisition->requisition_id,
            'amount'  => $requisition->amount,
            'userId'  =>Auth::user()->id,
            'companyId'  =>Auth::user()->companyId,
            'status'  => 1,
            'approvallevel' =>  0,
            'approvedby' => Auth::user()->userrole, 
            'isActive'  => 1,
            'action'  => "Purchase Order Returned",
            'doneby' => Auth::user()->name
            
           ]);

      if($updatereq){

      return redirect()->route('procurement.mypurchaseorder')->with('success', 'Purchase order sent back!');

      }

    }


    public function generateAndMergePDFs(string $id)
    {
        // Fetch company, user, history, and department data
        $company = Requisition::where('id', '=', $id)->first(); 
        $user = User::where('id', $company->userId)->first();
        $history = Requisitionhistory::where('requisition_id', $company->id)->get();
        $department = Department::where('id', $company->department)->first();
    
        // Step 2: Generate a PDF from the fetched data
        $pdf = Pdf::loadView('pdf.requisition', compact('company', 'user', 'history', 'department'));
    
        // Save the newly generated PDF
        $newPDFPath = storage_path('app/public/new_report.pdf');
        $pdf->save($newPDFPath);
    
        // Step 3: Retrieve existing PDF paths from the database (e.g., pdf_files table)
        $existingPDFs = Requisitionfile::where('requisitionId', '=', $id)->pluck('file')->toArray();
    
        // Create a merger instance
        $merger = new Merger();
    
        // Convert and add the newly created PDF
       // $convertedNewPDF = $this->convertPdfToVersion($newPDFPath);
        $merger->addFile($newPDFPath);
    
        // Convert and add existing PDFs
        foreach ($existingPDFs as $existingPDFPath) {
            $fullPath = storage_path('app/public/uploads/' . $existingPDFPath);
            $convertedExistingPDF = $this->convertPdfToVersion($fullPath);
            $merger->addFile($convertedExistingPDF);
        }
    
        // Merge and output
        $mergedPdf = $merger->merge();
    
        // Save the consolidated PDF
        $consolidatedPath = storage_path('app/public/consolidated_report.pdf');
        file_put_contents($consolidatedPath, $mergedPdf);
    
        // Return the merged PDF to the user
        return response()->download($consolidatedPath);
    }
    
    /**
     * Convert PDF to version 1.4 using Ghostscript.
     *
     * @param string $pdfPath
     * @return string Path to the converted PDF.
     */
    private function convertPdfToVersion(string $pdfPath): string
    {
        // Define the path for the converted PDF
        $convertedPdfPath = pathinfo($pdfPath, PATHINFO_DIRNAME) . '/' . pathinfo($pdfPath, PATHINFO_FILENAME) . '_converted.pdf';
    
        // Ghostscript command
        $command = "gs -sDEVICE=pdfwrite -dCompatibilityLevel=1.4 -dNOPAUSE -dBATCH -sOutputFile={$convertedPdfPath} {$pdfPath}";
    
        // Execute the command
        $output = [];
        $returnVar = 0;
        exec($command, $output, $returnVar);

       // dd($returnVar);
    
        if ($returnVar !== 0) {
            // Handle the error (you may want to log this or throw an exception)
            throw new \Exception('PDF conversion failed for ' . $pdfPath);
        }
    
        return $convertedPdfPath;
    }



    public function downloadrequisitions(Request $request)
    {
        $requisitionIds = $request->input('requisition_ids');
        $consolidatedPDFs = [];
   
        foreach ($requisitionIds as $id) {
            // Fetch requisition data and create PDF (same process as before)
            $company = Requisition::where('id' ,'=', $id)->first();
            $user = User::where('id', $company->userId)->first();
            $history = Requisitionhistory::where('requisition_id', $company->id)->get();
            $department = Department::where('id', $company->department)->first();
            // Step 2: Generate a PDF from the fetched data
            $pdf = Pdf::loadView('pdf.requisition', compact('company','user','history','department'));
            $newPDFPath = storage_path("app/public/new_report_{$id}.pdf");
            $pdf->save($newPDFPath);
            
            // Merge with existing PDFs as per your original logic
            $existingPDFs = Requisitionfile::where('requisitionId', '=', $id)->pluck('file')->toArray();
            $merger = new Merger();
            $merger->addFile($newPDFPath);
            foreach ($existingPDFs as $existingPDFPath) {

                $fullPath = storage_path('app/public/uploads/' . $existingPDFPath);
                $convertedExistingPDF = $this->convertPdfToVersion($fullPath);
                $merger->addFile($convertedExistingPDF);

            }
            $mergedPdf = $merger->merge();
            $consolidatedPDFPath = storage_path("app/public/consolidated_report_{$id}.pdf");
            file_put_contents($consolidatedPDFPath, $mergedPdf);
            $consolidatedPDFs[] = $consolidatedPDFPath;
        }
    
        // Use Laravel's Storage to create the zip
        $zipFileName = 'consolidated_requisitions.zip';
        $zipPath = storage_path('app/public/' . $zipFileName);
    
        // Create a new zip
        $zip = new \ZipArchive();
        if ($zip->open($zipPath, \ZipArchive::CREATE | \ZipArchive::OVERWRITE) === TRUE) {
            foreach ($consolidatedPDFs as $pdfPath) {
                $zip->addFile($pdfPath, basename($pdfPath));
            }
            $zip->close();
        }
    
        return response()->download($zipPath)->deleteFileAfterSend(true);
    }
    



    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
