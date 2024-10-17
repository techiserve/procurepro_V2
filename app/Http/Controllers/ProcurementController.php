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

        $servicetype = DB::connection('sqlsrv')->table('ServiceTypes')->select('ServiceTypeDescription')->get();

        $properties = DB::connection('sqlsrv')->table('Properties')->select('PropertyName')->get();

        $transcations = DB::connection('sqlsrv')->table('TransactionCodes')->select('TransactionDescription')->get();

        $tax = DB::connection('sqlsrv')->table('TaxTypes')->select('TaxTypeDescription')->get();

        $departments = Department::where('companyId', Auth::user()->companyId)->get();

       // dd($vendors);

     return view('procurement.createrequisition', compact('departments','vendors','servicetype','properties','transcations','tax'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function indexrequisition()
    {

        $emailData = [

               'title' => 'Test from Procure Pro',
               'body'  => 'This is a test email.'

        ];

        // Queue the email for background processing
       // Mail::to('v.mhokore@techiserve.com')->queue(new SendSampleEmail($emailData));

        $requisitions = Requisition::with('histories')->where('userId', Auth::user()->id)->orwhere('approvedby', Auth::user()->userrole)->where('status', '!=', 1)->get();
        $roles = userrole::all(); 
       // dd($requisitions);

        return view('procurement.indexrequisiton', compact('requisitions','roles'));
    }

    

    public function myrequisition()
    {

        $requisitions = Requisition::with('histories')->where('approvedby', Auth::user()->userrole)->where('status', '=', 1)->get();
        $roles = userrole::all(); 
     
        return view('procurement.myrequisiton', compact('requisitions','roles'));
    }

    public function viewrequisition(string $id)
    {
     
        $purchaseorder = Requisition::where('id', $id)->first();
        $files = Requisitionfile::where('requisitionId', $id)->get();

        return view('procurement.viewrequisition', compact('purchaseorder','files'));
    }


    public function editrequisition(string $id)
    {
     
        $purchaseorder = Requisition::where('id', $id)->first();
        $files = Requisitionfile::where('requisitionId', $id)->get();

        return view('procurement.editrequisition', compact('purchaseorder','files'));
    }



    public function indexpurchaseorder()
    {
     
        $purchaseorders = Purchaseorder::with('histories')->where('userId', Auth::user()->id)->orwhere('approvedby', Auth::user()->userrole)->where('status', '!=', 1)->get();
        $roles = userrole::all();

         // dd($purchaseorders);
        return view('procurement.indexpurchaseorder', compact('purchaseorders','roles'));
    }


    public function mypurchaseorder()
    {
     
        $purchaseorders = Purchaseorder::with('histories')->where('approvedby', Auth::user()->userrole)->where('status', '=', 1)->get();
        $roles = userrole::all();

         // dd($purchaseorders);
        return view('procurement.mypurchaseorder', compact('purchaseorders','roles'));
    }


    public function managepurchaseorder()
    {
     
        $purchaseorders = Purchaseorder::where('releaseStatus', '=', null)->get();
        $roles = userrole::all();

        return view('procurement.managepurchaseorder', compact('purchaseorders','roles'));
    }


    public function logs(string $id)
    { 

        $histories = RequisitionHistory::where('requisition_id', '=', $id)->get();
        return view('procurement.logs', compact('histories'));

    }


    public function purchaseorder(string $id)
    {
     
        $purchaseorder = Purchaseorder::where('id', $id)->first();

        return view('procurement.editpurchaseorder', compact('purchaseorder'));
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

    }


    return back()->with('success', 'Purchase Orders Completed!');

}else{

    return $this->exportToCsv();
        
}


    }







    public function updaterequisition(Request $request, $id)
    {
        $level = Departmentapproval::where('departmentId', $request->department)->min('approvalId');
        $totalapprovallevels = Departmentapproval::where('departmentId', $request->department)->count();
        $approver = Departmentapproval::where('departmentId', $request->department)->where('approvalId', $level)->first();

      $updaterequisition = Requisition::where('id', $id)->update([

        'expenses'  => $request->expenses,
        'projectcode'  => $request->projectcode,
        'amount'  => $request->amount,
        'approvallevel'  => $level,
        'totalapprovallevels'  => $totalapprovallevels,
        'approvedby' => $approver->roleId, 
        'isActive'  => 1,
        'status'  => 1,

      ]);

      return redirect()->route('procurement.indexrequisition')->with('success', 'Requisition Updated successfully!');
    }



    private function exportToCsv()
    {
        // Fetch all purchase orders where status is 2
        $purchaseOrders = PurchaseOrder::where('status', 2)->get();

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


        $level = Departmentapproval::where('departmentId', $request->department)->min('approvalId');
        $totalapprovallevels = Departmentapproval::where('departmentId', $request->department)->count();
        $approver = Departmentapproval::where('departmentId', $request->department)->where('approvalId', $level)->first();

        $supplierCode = DB::connection('sqlsrv')->table('Suppliers')->where('SupplierName', $request->vendor)->select('SupplierCode')->first();
        $Properties = DB::connection('sqlsrv')->table('Properties')->where('PropertyName', $request->property)->select('PropertyCode')->first();
        $Transaction = DB::connection('sqlsrv')->table('TransactionCodes')->where('TransactionDescription', $request->transaction)->select('TransactionCode')->first();
        $Tax = DB::connection('sqlsrv')->table('TaxTypes')->where('TaxTypeDescription', $request->tax)->select('TaxTypeCode')->first();
        //dd($supplierCode->SupplierCode,$Properties,$Transaction,$Tax);

       $requisition = Requisition::create([

        'vendor' => $request->vendor,
        'services' => $request->service,
        'paymentmethod'  => $request->paymentmethod,
        'department'  => $request->department,
        'expenses'  => $request->expenses,
        'projectcode'  => $request->projectcode,
        'amount'  => $request->amount,

        'PropertyName'  => $request->property,
        'TransactionDescription'  => $request->transaction,
        'TaxTypeDescription'  => $request->tax,

        'SupplierCode' => $supplierCode->SupplierCode,
        'PropertyCode'  => $Properties->PropertyCode,
        'TransactionCode'  => $Transaction->TransactionCode,
        'TaxTypeCode'  => $Tax->TaxTypeCode,

        'userId'  =>Auth::user()->id,
        'status'  => 1,
        'approvallevel'  => $level,
        'totalapprovallevels'  => $totalapprovallevels,
        'approvedby' => $approver->roleId, 
        'isActive'  => 1,
        
       ]);
 

       if ($request->hasFile('file')) {
        // Loop through each file
        foreach ($request->file('file') as $file) {
            // Generate a unique name for the file
            $quotationfile = $file->store('uploads', 'public');

            $quotation =  Str::afterLast($quotationfile, '/');

            // Save the filename in the database
            $savefile = Requisitionfile::create([

                'requisitionId' => $requisition->id,
                'file'  =>  $quotation,
                'userId'  =>Auth::user()->id,
                'path'  => 1,
                
               ]);
        }

    } 

   // dd( $requisition->id);

    $requisitionhistory = RequisitionHistory::create([

        'requisition_id' => $requisition->id,
        'vendor' => $request->vendor,
        'services' => $request->service,
        'paymentmethod'  => $request->paymentmethod,
        //'department'  => $request->department,
        'expenses'  => $request->expenses,
        'projectcode'  => $request->projectcode,
        'amount'  => $request->amount,
     //   'file'  => $quotation,
        'userId'  =>Auth::user()->id,
        'status'  => 1,
        'approvallevel'  => $level,
        'totalapprovallevels'  => $totalapprovallevels,
        'approvedby' => $approver->roleId, 
        'isActive'  => 1,
        'action'  => "Created Purchase Requisition",
        'doneby' => Auth::user()->name
        
       ]);

       if($requisition && $savefile){

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

        return redirect()->route('procurement.indexpurchaseorder')->with('success', 'Documents Uploaded successfully!');
    }
      return back()->with('error', 'Failed to update documents!');

    }

    /**
     * Display the specified resource.
     */
    public function requisitionapproval(string $id)
    {

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

          // gadzira purchase order then add upload file too

          $requisition = Purchaseorder::create([

            'requisition_id' => $requisition->id,
            'vendor' => $requisition->vendor,
            'services' => $requisition->services,
            'paymentmethod'  => $requisition->paymentmethod,
            'department'  => $requisition->department,
            'expenses'  => $requisition->expenses,

            'PropertyName'  => $requisition->PropertyName,
            'TransactionDescription'  => $requisition->TransactionDescription,
            'TaxTypeDescription'  => $requisition->TaxTypeDescription,
    
            'SupplierCode' => $requisition->SupplierCode,
            'PropertyCode'  => $requisition->PropertyCode,
            'TransactionCode'  => $requisition->TransactionCode,
            'TaxTypeCode'  => $requisition->TaxTypeCode,

            'projectcode'  => $requisition->projectcode,
            'amount'  => $requisition->amount,
            'userId'  => $requisition->userId,
            'status'  => 0,
            'approvallevel'  => 0,
            'totalapprovallevels'  => 0,
            'purchaseorderstatus' => 1, 
            'isActive'  => 0,
            
           ]);


           $requisitiond = RequisitionHistory::create([

            'requisition_id' => $id,
            'amount'  => $requisition->amount,
         //   'file'  => $quotation,
            'userId'  =>Auth::user()->id,
            'status'  => 1,
            'approvallevel' =>  $updatedapprovallevel,
            'approvedby' => Auth::user()->userrole, 
            'isActive'  => 1,
            'action'  => "Purchase Requisition Approved and Purchase Order Created",
            'doneby' => Auth::user()->name
            
           ]);
    


        }else{
 
            $updatedapprovallevel = $requisition->approvallevel+1;
            $approver = Departmentapproval::where('departmentId', $requisition->department)->where('approvalId', $updatedapprovallevel)->first();

            $updatereq = Requisition::where('id', $id)->update([

                'approvallevel' =>  $updatedapprovallevel,
                'approvedby' => $approver->roleId,              

                 ]);   
               

                 $requisition = RequisitionHistory::create([

                    'requisition_id' => $requisition->id,
                    'amount'  => $requisition->amount,
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

            
        return redirect()->route('procurement.indexrequisition')->with('success', 'Requisition approved successfully!');

        }
    }


    public function requisitionrejection(Request $request, string $id)
    {

        $requisition = Requisition::where('id', $id)->first();

                 $updatereq = Requisition::where('id', $id)->update([

                'approvedby' => Auth::user()->userrole,
                'approvallevel' => $requisition->approvallevel,
                'reason' => $request->message,
                'isActive' => 0, 
                'status'  => 3,
           

                 ]);   



                 $requisition = RequisitionHistory::create([

                    'requisition_id' => $requisition->id,
                    'amount'  => $requisition->amount,
                    'userId'  =>Auth::user()->id,
                    'status'  => 1,
                    'approvedby' => Auth::user()->userrole, 
                    'isActive'  => 1,
                    'action'  => "Purchase Requisition Rejected",
                    'doneby' => Auth::user()->name
                    
                   ]);


        if($updatereq){
   
         return redirect()->route('procurement.indexrequisition')->with('success', 'Requisition order rejected!');

        }
    }



    public function sendbackrequistion(Request $request, string $id)
    {

        $requisition = Requisition::where('id', $id)->first();

                 $updatereq = Requisition::where('id', $id)->update([

                'approvedby' => Auth::user()->userrole,
                'approvallevel' => $requisition->approvallevel,
                'reason' => $request->message,
                'isActive' => 0, 
                'status'  => 4,

                 ]);  
                 
                 
                 $requisition = RequisitionHistory::create([

                    'requisition_id' => $requisition->id,
                    'amount'  => $requisition->amount,
                    'userId'  =>Auth::user()->id,
                    'status'  => 1,
                    'approvallevel' =>  $requisition->approvallevel,
                    'approvedby' => Auth::user()->userrole, 
                    'isActive'  => 1,
                    'action'  => "Purchase Requisition Returned",
                    'doneby' => Auth::user()->name
                    
                   ]);


        if($updatereq){
   
         return redirect()->route('procurement.indexrequisition')->with('success', 'Requisition returned!');

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
                 
                 

                 $requisitiond = RequisitionHistory::create([

                    'requisition_id' => $requisition->requisition_id,
                    'amount'  => $requisition->amount,
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
            $approver = Departmentapproval::where('departmentId', $requisition->department)->where('approvalId', $updatedapprovallevel)->first();

            $updatereq = Purchaseorder::where('id', $id)->update([

                'approvallevel' =>  $updatedapprovallevel,
                'approvedby' => $approver->roleId,              

                 ]);   



                 $requisitiond = RequisitionHistory::create([

                    'requisition_id' => $requisition->requisition_id,
                    'amount'  => $requisition->amount,
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
   
         return redirect()->route('procurement.indexpurchaseorder')->with('success', 'Purchase order approved successfully!');

        }
    }

    public function rejectpurchaseorder(Request $request, string $id)
    {

        $requisition = Purchaseorder::where('id', $id)->first();

                 $updatereq = Purchaseorder::where('id', $id)->update([

                'approvedby' => Auth::user()->userrole,
                'approvallevel' => $requisition->approvallevel,
                'isActive' => 0, 
                'status'  => 3,
                'purchaseorderstatus'  => 3,
                'reason'  => $request->message,

                 ]);  
                                
                 
                 $requisitiond = RequisitionHistory::create([

                    'requisition_id' => $requisition->requisition_id,
                    'amount'  => $requisition->amount,
                 //   'file'  => $quotation,
                    'userId'  =>Auth::user()->id,
                    'status'  => 1,
                   // 'approvallevel' =>  $updatedapprovallevel,
                    'approvedby' => Auth::user()->userrole, 
                    'isActive'  => 1,
                    'action'  => "Purchase Order Rejected",
                    'doneby' => Auth::user()->name
                    
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

        $updatereq = Purchaseorder::where('id', $id)->update([

       'approvedby' => Auth::user()->userrole,
       'status'  => 4,
       'approvallevel'  => 0,
       'totalapprovallevels'  => 0,
       'purchaseorderstatus' => 4, 
       'isActive'  => 0,
       'reason'  => $request->message,

        ]);   


        $requisition = Purchaseorder::where('id', $id)->first();
        
        $requisitiond = RequisitionHistory::create([

            'requisition_id' => $requisition->requisition_id,
            'amount'  => $requisition->amount,
            'userId'  =>Auth::user()->id,
            'status'  => 1,
            'approvallevel' =>  0,
            'approvedby' => Auth::user()->userrole, 
            'isActive'  => 1,
            'action'  => "Purchase Order Returned",
            'doneby' => Auth::user()->name
            
           ]);

      if($updatereq){

      return redirect()->route('procurement.indexpurchaseorder')->with('success', 'Purchase order sent back!');

      }

    }


    public function generateAndMergePDFs(string $id)
    {

        //dd('here');

        $data = Requisition::where('id' ,'=', $id)->first();

        // Step 2: Generate a PDF from the fetched data
        $pdf = Pdf::loadView('pdf.bank', compact('data'));

        // Save the newly generated PDF
        $newPDFPath = storage_path('app/public/new_report.pdf');
        $pdf->save($newPDFPath);

        // Step 3: Retrieve existing PDF paths from the database (e.g., pdf_files table)
        $existingPDFs = Requisitionfile::where('requisitionId','=', $id)->pluck('file')->toArray();
       // dd($existingPDFs);
        $merger = new Merger();

        // Add PDFs to merge
        $merger->addFile(storage_path('app/public/new_report.pdf'));
        foreach ($existingPDFs as $existingPDFPath) {
            $merger->addFile(storage_path('app/public/uploads/' . $existingPDFPath));
        }
        
        // Merge and output
        $mergedPdf = $merger->merge();
        
        // Save or output the merged PDF
        file_put_contents(storage_path('app/public/consolidated_report.pdf'), $mergedPdf);
        
        // Return the merged PDF to the user
        return response()->download(storage_path('app/public/consolidated_report.pdf'));
        
    }




    
    public function downloadrequisitions(Request $request)
    {
        $requisitionIds = $request->input('requisition_ids');
        $consolidatedPDFs = [];

         
        foreach ($requisitionIds as $id) {
            // Fetch requisition data and create PDF (same process as before)
            $data = Requisition::where('id', '=', $id)->first();
            $pdf = Pdf::loadView('pdf.bank', compact('data'));
            $newPDFPath = storage_path("app/public/new_report_{$id}.pdf");
            $pdf->save($newPDFPath);
            
            // Merge with existing PDFs as per your original logic
            $existingPDFs = Requisitionfile::where('requisitionId', '=', $id)->pluck('file')->toArray();
            $merger = new Merger();
            $merger->addFile($newPDFPath);
            foreach ($existingPDFs as $existingPDFPath) {
                $merger->addFile(storage_path('app/public/uploads/' . $existingPDFPath));
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
