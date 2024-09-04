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

class ProcurementController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function createrequisition()
    {

        $vendors = DB::connection('sqlsrv')->table('Suppliers')->select('SupplierID', 'SupplierName')->get();
        // $vendors = [
        //     [
        //         'SupplierID' => 1,
        //         'SupplierName' => 'Supplier One',
        //     ],
        //     [
        //         'SupplierID' => 2,
        //         'SupplierName' => 'Supplier Two',
        //     ],
        //     [
        //         'SupplierID' => 3,
        //         'SupplierName' => 'Supplier Three',
        //     ],
            // Add as many suppliers as needed
       // ];

        $servicetype = DB::connection('sqlsrv')->table('ServiceTypes')->get();

    //    $servicetype = [
    //     [
    //         'ServiceTypeDescription' => ' One',
    //     ],
    //     [
    //         'ServiceTypeDescription' => ' Two',
    //     ],
    //     [
    //         'ServiceTypeDescription' => ' Three',
    //     ],
        // Add as many suppliers as needed
   //  ];

      //  dd($servicetype);

     $departments = Department::where('companyId', Auth::user()->companyId)->get();

     return view('procurement.createrequisition', compact('departments','vendors','servicetype'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function indexrequisition()
    {
     
        $requisitions = Requisition::where('userId', Auth::user()->id)->orwhere('approvedby', Auth::user()->userrole)->where('isActive', '=', 1)->get();

        return view('procurement.indexrequisiton', compact('requisitions'));
    }


    public function indexpurchaseorder()
    {
     
        $purchaseorders = Purchaseorder::where('userId', Auth::user()->id)->orwhere('approvedby', Auth::user()->userrole)->where('isActive', '=', 1)->get();

        return view('procurement.indexpurchaseorder', compact('purchaseorders'));
    }


    public function purchaseorder(string $id)
    {
     
        $purchaseorder = Purchaseorder::where('id', $id)->first();

        return view('procurement.editpurchaseorder', compact('purchaseorder'));
    }



    
    public function viewpurchaseorder(string $id)
    {
     
        $purchaseorder = Purchaseorder::where('id', $id)->first();

        $invoice = 'uploads/' . $purchaseorder->invoice;
        $jobcard = 'uploads/' . $purchaseorder->jobcard;

       // dd($invoice);
        if  (Storage::disk('public')->exists($invoice)) {
            
           // $invoicepath = Storage::get($invoice);
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



        return view('procurement.viewpurchaseorder', compact('purchaseorder','invoicepath','jobcardpath'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function requisitionstore(Request $request)
    {
       // dd($request->all());

        $level = Departmentapproval::where('departmentId', $request->department)->min('approvalId');
        $totalapprovallevels = Departmentapproval::where('departmentId', $request->department)->count();
        $approver = Departmentapproval::where('departmentId', $request->department)->where('approvalId', $level)->first();

       // dd($request->file('file'));

       $quotationfile = $request->file('file')->store('uploads', 'public');

       $quotation =  Str::afterLast($quotationfile, '/');


       $requisition = Requisition::create([

        'vendor' => $request->vendor,
        'services' => $request->service,
        'paymentmethod'  => $request->paymentmethod,
        'department'  => $request->department,
        'expenses'  => $request->expenses,
        'projectcode'  => $request->projectcode,
        'amount'  => $request->amount,
        'file'  => $quotation,
        'userId'  =>Auth::user()->id,
        'status'  => 1,
        'approvallevel'  => $level,
        'totalapprovallevels'  => $totalapprovallevels,
        'approvedby' => $approver->roleId, 
        'isActive'  => 1,
        
       ]);


       $file = Requisitionfile::create([

        'requisitionId' => $requisition->id,
        'file'  => $request->file,
        'userId'  =>Auth::user()->id,
        'path'  => 1,
        
       ]);


       if($requisition){

        return back()->with('success', 'Requisition created successfully!');
    }
      return back()->with('error', 'Failed to create Requiisition!');

    }



    public function updatepurchaseorder(Request $request,$id)
    {


        $level = Departmentapproval::where('departmentId', $request->department)->min('approvalId');
        $totalapprovallevels = Departmentapproval::where('departmentId', $request->department)->count();
        $approver = Departmentapproval::where('departmentId', $request->department)->where('approvalId', $level)->first();
       
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

       $requisition = Purchaseorder::where('id',$id)->update([

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

        return back()->with('success', 'Documents Uploaded succeffully!');
    }
      return back()->with('error', 'Failed to update documents!');

    }

    /**
     * Display the specified resource.
     */
    public function requisitionapproval(string $id)
    {
     //   dd($id);

        $requisition = Requisition::where('id', $id)->first();

        if($requisition->approvallevel+1 > $requisition->totalapprovallevels){
         
           // dd('zvapera');
            $updatedapprovallevel = $requisition->approvallevel+1;
                 $updatereq = Requisition::where('id', $id)->update([

                'approvallevel' =>  $updatedapprovallevel,
                'approvedby' => Auth::user()->userrole,
                'isActive'  => 1,
                'status'  => 2,

                 ]);   

          // gadzira purchase order
          $requisition = Purchaseorder::create([

            'requisitionId' => $requisition->id,
            'vendor' => $requisition->vendor,
            'services' => $requisition->services,
            'paymentmethod'  => $requisition->paymentmethod,
            'department'  => $requisition->department,
            'expenses'  => $requisition->expenses,
            'projectcode'  => $requisition->projectcode,
            'amount'  => $requisition->amount,
            'userId'  => $requisition->userId,
            'status'  => 0,
            'approvallevel'  => 0,
            'totalapprovallevels'  => 0,
            'purchaseorderstatus' => 1, 
            'isActive'  => 0,
            
           ]);


        }else{
 
            // dd('zviriko');
            $updatedapprovallevel = $requisition->approvallevel+1;
            $approver = Departmentapproval::where('departmentId', $requisition->department)->where('approvalId', $updatedapprovallevel)->first();

            $updatereq = Requisition::where('id', $id)->update([

                'approvallevel' =>  $updatedapprovallevel,
                'approvedby' => $approver->roleId,              

                 ]);   

         //   dd($approver);

        }


        if($updatereq){

            
        return back()->with('success', 'Requisition approved successfully!');

        }
    }


    public function requisitionrejection(Request $request, string $id)
    {

        $requisition = Requisition::where('id', $id)->first();

                 $updatereq = Requisition::where('id', $id)->update([

                'approvedby' => Auth::user()->userrole,
                'approvallevel' => $requisition->approvallevel,
                'isActive' => 0, 
                'status'  => 3,
                'purchaseorderstatus'  => 3,

                 ]);   


        if($updatereq){
   
         return redirect()->route('procurement.indexrequisition')->with('success', 'Requisition order rejected!');

        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function approvepurchaseorder(string $id)
    {
       // dd($id);
        $requisition = Purchaseorder::where('id', $id)->first();

        if($requisition->approvallevel+1 > $requisition->totalapprovallevels){
         
            $updatedapprovallevel = $requisition->approvallevel;
                 $updatereq = Purchaseorder::where('id', $id)->update([

                'approvallevel' =>  $updatedapprovallevel,
                'approvedby' => Auth::user()->userrole,
                'isActive'  => 1,
                'status'  => 2,

                 ]);   


        }else{
  
            $updatedapprovallevel = $requisition->approvallevel+1;
            $approver = Departmentapproval::where('departmentId', $requisition->department)->where('approvalId', $updatedapprovallevel)->first();

            $updatereq = Purchaseorder::where('id', $id)->update([

                'approvallevel' =>  $updatedapprovallevel,
                'approvedby' => $approver->roleId,              

                 ]);   

        }


        if($updatereq){
   
         return redirect()->route('procurement.indexpurchaseorder')->with('success', 'Purchase order approved successfully!');

        }
    }

    public function rejectpurchaseorder(Request $request, string $id)
    {
       // dd($request->all(),$id);

        $requisition = Purchaseorder::where('id', $id)->first();

                 $updatereq = Purchaseorder::where('id', $id)->update([

                'approvedby' => Auth::user()->userrole,
                'approvallevel' => $requisition->approvallevel,
                'isActive' => 0, 
                'status'  => 3,
                'purchaseorderstatus'  => 3,
                'reason'  => $request->message,

                 ]);   


        if($updatereq){
   
         return redirect()->route('procurement.indexpurchaseorder')->with('success', 'Purchase order rejected!');

        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function sendbackpurchaseorder(Request $request, string $id)
    {
       // dd($id,$request->all());
       // $requisition = Purchaseorder::where('id', $id)->first();

        $updatereq = Purchaseorder::where('id', $id)->update([

       'approvedby' => Auth::user()->userrole,
       'status'  => 4,
       'approvallevel'  => 0,
       'totalapprovallevels'  => 0,
       'purchaseorderstatus' => 4, 
       'isActive'  => 0,
       'reason'  => $request->message,

        ]);   


      if($updatereq){

      return redirect()->route('procurement.indexpurchaseorder')->with('success', 'Purchase order sent back!');

      }

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
