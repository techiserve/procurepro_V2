<?php

namespace App\Http\Controllers;

use App\Models\Vendor;
use App\Models\VendorType;
use App\Models\User;
use App\Models\Bank;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\ClassificationOfExpense;
use App\Models\VendorDocument;
use Illuminate\Support\Facades\Storage;


class VendorController extends Controller
{
    public function index()
    {    
        $vendors = Vendor::where('companyId', Auth::user()->companyId)->get();
        $users = User::where('companyId', Auth::user()->companyId)->get();
        $vendorTypes = VendorType::where('companyId', Auth::user()->companyId)->get();
        return view('vendors.index', compact('vendors','vendorTypes','users'));
    }

    public function store(Request $request)
    {
         $company = Auth::user()->companyId;
        $vendor = Vendor::create(array_merge(
            $request->only([
                'name', 'type','description', 'vat_registered',
                'contact_no_1', 'contact_no_2', 'supplier_code', 'vat_allocation',
                'finance_manager', 'address'
            ]),
            ['status' => 1,'companyId' => $company]
        ));
        session(['vendor_id' => $vendor->id]);
    //dd($request->vendor_documents);
        if ($request->hasFile('vendor_documents')) {
            foreach ($request->file('vendor_documents') as $index => $file) {
                $filename = time() . '_' . $file->getClientOriginalName();
                $path = $file->storeAs('uploads', $filename, 'public');
    
                VendorDocument::create([
                    'vendor_id' => $vendor->id,
                    'document_name' => $request->input('document_names')[$index] ?? 'Unnamed',
                    'file_path' => $path
                ]);
            }
        }
    
        return $request->input('is_frm_continue') === 'continue'
             ? redirect('/vendors/banking')->with('banks', Bank::all())
            : redirect('/vendors/index')->with('success', 'Vendor created successfully.');
    }


    public function bankingForm()
    {
        if (!session('vendor_id')) {
            return redirect('/vendors/create')->with('error', 'Please complete vendor info first.');
        }

         $banks = Bank::all();
        return view('vendors.banking', compact('banks'));
    }

    public function storeBanking(Request $request)
    {
        $vendor = Vendor::findOrFail(session('vendor_id'));
        $vendor->update([
            'bank_name' => $request->bank_name,
            'account_number' => $request->account_number,
            'account_type' => $request->account_type,
            'branch_code' => $request->branch_code,
            'status' => 2,
        ]);
        session()->forget('vendor_id');

        return redirect('/vendors/index')->with('success', 'Vendor and banking details saved.');
    }

    // ---------------- Vendor Type Logic Below ----------------

    public function vendorTypeIndex()
    {
        $vendorTypes = VendorType::where('companyId', Auth::user()->companyId)->get();
        return view('vendors.vendortype', compact('vendorTypes'));
    }

    public function vendorTypeStore(Request $request)
    {
         $company = Auth::user()->companyId;
        VendorType::create([
            'name' => $request->name,
            'companyId' => $company,
            'active' => $request->has('active'),
        ]);
        return redirect()->route('vendor-types.index')->with('success', 'Vendor type added.');
    }

    public function vendorTypeEdit($id)
    {
        $type = VendorType::findOrFail($id);
        return view('vendor_types.edit', compact('type'));
    }

    public function vendorTypeUpdate(Request $request, $id)
    {
        $type = VendorType::findOrFail($id);
        $type->update([
            'name' => $request->name,
            'active' => $request->has('active'),
        ]);
        return redirect()->route('vendors.vendortype')->with('success', 'Vendor type updated.');
    }

    public function vendorTypeDestroy($id)
    {
        VendorType::findOrFail($id)->delete();
        return redirect()->route('vendors.vendortype')->with('success', 'Vendor type deleted.');
    }

    public function createClassification()
    {
        $classifications = ClassificationOfExpense::where('companyId', Auth::user()->companyId)->get();
        return view('classifications.create', compact('classifications'));
    }
    
    public function storeClassification(Request $request)
    {
        $company = Auth::user()->companyId;
        $request->validate([
            'name' => 'required|string|max:255',
        ]);
    
        ClassificationOfExpense::create([
            'name' => $request->name,
            'companyId' => $company, 
            'active' => $request->has('active'),
        ]);
    
        return redirect()->route('classifications.create')->with('success', 'Classification created successfully.');
    }

    public function edit($id)
{
    $vendor = Vendor::with('documents')->findOrFail($id);
    $vendorTypes = VendorType::all(); // assuming VendorType is your list source
    $users = User::where('companyId','=',Auth::user()->companyId)->get();
    $finance = User::where('id','=', $vendor->finance_manager)->first();

    return view('vendors.edit', compact('vendor', 'users','vendorTypes','finance'));
}

public function update(Request $request, $id)
{
    $vendor = Vendor::findOrFail($id);

    $vendor->update(array_merge(
        $request->only([
            'name',
            'type',
            'description',
            'vat_registered',
            'vat_allocation',
            'contact_no_1',
            'contact_no_2',
            'supplier_code',
            'address',
            'finance_manager',
            'bank_name',
            'account_number',
            'account_type',
            'branch_code',
        ]),
        ['status' => 2]
    ));
    
  
    
        // Handle deleting existing documents
    if ($request->has('delete_documents')) {
        foreach ($request->delete_documents as $docId) {
            $doc = VendorDocument::find($docId);
            if ($doc) {
                Storage::disk('public')->delete($doc->file_path); // Delete file
                $doc->delete(); // Delete DB record
            }
        }
    }

    // Handle uploading new documents (with names)
    if ($request->has('new_documents')) {
        foreach ($request->new_documents as $index => $docData) {
            if (isset($docData['file']) && $request->file("new_documents.$index.file")) {
                $file = $request->file("new_documents.$index.file");
                $path = $file->store('vendor_docs', 'public');

                VendorDocument::create([
                    'vendor_id' => $vendor->id,
                    'document_name' => $docData['name'],
                    'file_path' => $path,
                ]);
            }
        }
    }

    return redirect('/vendors/index')->with('success', 'Vendor updated successfully.');
}

public function showApprovalPage()
{
    $vendors = Vendor::where('status', 2)->where('companyId', Auth::user()->companyId)->get();// status = Pending
    $users = User::where('companyId', Auth::user()->companyId)->get();
    return view('vendors.approval', compact('vendors','users'));
}

public function viewApprovalDetails($id)
{
    $vendor = Vendor::with('documents')->findOrFail($id);
    return view('vendors.approval-view', compact('vendor'));
}

public function handleApprovalAction(Request $request, $id)
{
    $vendor = Vendor::findOrFail($id);
    $action = $request->input('action');

    switch ($action) {
        case 'approve':
            $vendor->status = 3;
            $vendor->message = null;
            break;
        case 'return':
            $vendor->status = 4;
            $vendor->message = $request->input('message');
            break;
        case 'reject':
            $vendor->status = 5;
            $vendor->message = null;
            break;
        default:
            return back()->with('error', 'Invalid action.');
    }

    $vendor->save();

    return redirect()->route('vendors.approval')->with('success', 'Vendor status updated successfully.');
}



    public function editClassification($id)
    {
        $classification = ClassificationOfExpense::findOrFail($id);
        return view('classifications.edit', compact('classification'));
    }

    public function updateClassification(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'active' => 'required|boolean',
        ]);

        $classification = ClassificationOfExpense::findOrFail($id);
        $classification->update($request->only('name', 'active'));

        return redirect()->route('classifications.create')->with('success', 'Classification updated successfully.');
    }

    public function deleteClassification($id)
    {
        $classification = ClassificationOfExpense::findOrFail($id);
        $classification->delete();

        return redirect()->route('classifications.create')->with('success', 'Classification deleted successfully.');
    }

         public function delete($id)
        {
            $deleteuser = Vendor::where('id', $id)->delete();
        
            if($deleteuser){
        
                return back()->with('success', 'Vendor deleted successfully!');

            }else{

                return back()->with('error', 'Failed to delete Vendor!');
            }

            
        }

}
