<?php

namespace App\Http\Controllers;
use App\Models\userrole;
use App\Models\User;
use App\Models\Company;
use App\Models\CompanyRole;
use App\Models\FormField;
use App\Models\CustomReport;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use App\Models\Frequisition;
use App\Models\Fpurchaseorder;
use App\Models\Executive;
use App\Models\ExecutiveRole;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Alert;

use Illuminate\Http\Request;

class CompanyController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function companyindex()
    {
            
      
        $companies = Company::all();
        
        return view('companies.index', compact('companies'));
    }


    public function executivesindex()
    {
        $executives = Executive::where('companyId', Auth::user()->companyId)->get();

        return view('executives.index', compact('executives'));
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function executivesstore(Request $request)
    {
     
      //   dd($request->all());
        if(User::where('email', $request->email)->exists()) {

            return redirect()->back()->with('error', 'Executive already exists!');
        }
       
  

        $executive = new Executive();
        $executive->name = $request->executiveName;
        $executive->email = $request->email;
        $executive->password = Hash::make($request->password);
        $executive->userName = $request->username;
        // $executive->companyId = $request->compan[0];
        $executive->address = $request->address;
        $executive->isActive = 1;     
        $executive->save();

       if($executive){

        $user = new User();
        $user->name = $request->executiveName;
        $user->email = $request->email;
        $user->password = Hash::make($request->password);
        $user->username =  $request->username;
        // $user->companyId = $request->compan[0];
        $user->executiveId = $executive->id;
        $user->userrole = 3;  
        $user->isActive = 1;    
        $user->save();

       }

    
        $companies =  $request->company_ids;

        // Create executive roles for each selected company
       foreach ($companies as $company) {

        //dd((int) $company->id);
            $executiveRole = new ExecutiveRole();
            $executiveRole->executiveId = $executive->id;
            $executiveRole->userId = $user->id;
            $executiveRole->companyId = $company;
            $executiveRole->roleId = 3; // Assuming roleId 1 is for executives
            $executiveRole->status = 1; // Assuming status 1 means active
            $executiveRole->createdBy = Auth::user()->id; // Assuming created by current user
            $executiveRole->IsActive = 1; // Assuming IsActive means the role is active
            $executiveRole->save();
        }


 

        if($user && $executive){
     
            return redirect()->route('executives.create')->with('success', 'Executive created successfully!');
        }
          return redirect()->route('executives.create')->with('error', 'Failed to create Executive!');
      
    }




    public function executivescreate()
    {

         $companies = Company::all();

        return view('executives.create', compact('companies'));

    }

    public function store(Request $request)
    {
      
        $user = User::where('email', $request->email)->first();
       $company = Company::where('email', $request->email)->first();
        if($user){
           
              return redirect()->route('companies.create')->with('warning', 'Sorry buddy, this email has already been used!');

         }
        // elseif($company){
        //     if($company->domain == $request->companydomain){
           
        //       return redirect()->route('companies.create')->with('warning', 'Sorry buddy, this domain has already been used!');
        //     }
        // }
 
        $company = new Company();
        $company->name = $request->companyname;
      //  $company->email = $request->email;
      //  $company->password = Hash::make($request->password);
       // $company->companyname =  $request->companyname;
        $company->domain = $request->companydomain;
        $company->username =  $request->username;
        $company->contactPerson = $request->contactPerson;
        $company->address = $request->address;
        $company->vendor_source = $request->vendor_source;
        $company->isActive = $request->IsActive;
        $company->email =  $request->email;      
        $company->save();


        if($company){

        $user = new User();
        $user->name = $request->contactPerson;
        $user->email = $request->email;
        $user->password = Hash::make($request->password);
        $user->username =  $request->username;
        $company->vendor_source = $request->vendor_source;
       // $user->phonenumber = $request->phonenumber;
        $user->companyId = $company->id;
        $user->userrole = 3;
        $user->isActive = 1;      
        $user->save();

         }

         //
          $fields = $request->input('fields');
         /// dd($fields);
 foreach ($fields as $field) {

    // Normalize field name: lowercase and remove spaces
    $normalizedName = strtolower(str_replace(' ', '', $field['name']));

    // Save form field configuration
    FormField::create([
        'companyId' => $company->id,
        'name' => $normalizedName,
        'label' => $field['label'],
        'type' => $field['type'],
    ]);

    // Dynamically add column to frequisitions table
    if (!Schema::hasColumn('frequisitions', $normalizedName)) {
        Schema::table('frequisitions', function (Blueprint $table) use ($field, $normalizedName) {
            switch ($field['type']) {
                case 'string':
                    $table->string($normalizedName)->nullable();
                    break;
                case 'integer':
                    $table->integer($normalizedName)->nullable();
                    break;
                case 'text':
                    $table->text($normalizedName)->nullable();
                    break;
                // Add more cases as needed
                default:
                    $table->string($normalizedName)->nullable();
            }
        });
    }

    // Dynamically add column to fpurchaseorders table
    if (!Schema::hasColumn('fpurchaseorders', $normalizedName)) {
        Schema::table('fpurchaseorders', function (Blueprint $table) use ($field, $normalizedName) {
            switch ($field['type']) {
                case 'string':
                    $table->string($normalizedName)->nullable();
                    break;
                case 'integer':
                    $table->integer($normalizedName)->nullable();
                    break;
                case 'text':
                    $table->text($normalizedName)->nullable();
                    break;
                // Add more cases as needed
                default:
                    $table->string($normalizedName)->nullable();
            }
        });
    }
}

    if($user && $company){

            return redirect()->route('companies.create')->with('success', 'Company created successfully!');
        }
          return redirect()->route('companies.create')->with('error', 'Failed to create Company!');

  }



    public function companyedit(string $id)
    {
        $company = Company::where('id', $id)->first();
        $dynamicFields = FormField::where('companyId','=',$id)->get();

        return view('companies.edit', compact('company','dynamicFields'));
    }



    public function companydelete($id)
    {
        
         $delete = Company::where('id', $id)->delete();

         $deleteUser = User::where('companyId', $id)->delete();

      
         return back()->with('success', 'Company deleted successfully!');

        
    }


     public function configure(string $id)
    {
        $company = Company::where('id', $id)->first();
        $fpurchaseorderColumns = \Schema::getColumnListing('fpurchaseorders');

        return view('companies.configure', compact('company','fpurchaseorderColumns'));

    }


        public function manageReports(string $id)
    {
         $company = Company::where('id', $id)->first();

         $reports = CustomReport::where('companyId','=', $id)->latest()->get();

        return view('reports.manageReports', compact('company','reports'));

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
    public function companyUpdate(Request $request, string $id)
    {

       // dd($request->all());

        $updaterequisition = Company::where('id', $id)->update([

            'name'  => $request->companyname,
            'domain'  => $request->companydomain,
            'username'  => $request->username,
            'contactPerson'  => $request->contactPerson,
            'address'  => $request->address,
            'email' => $request->email, 
            'vendor_source' => $request->vendor_source,
            'IsActive'  =>  $request->IsActive,
    
          ]);

          $users = User::where('companyId', $id)->update([

            'vendor_source' => $request->vendor_source,
    
          ]);

         if($request->new_password){

            $users = User::where('companyId', $id)->update([

                'password'  => Hash::make($request->new_password),
                'vendor_source' => $request->vendor_source,
                'email' => $request->email, 
    
              ]);
    
         }

   $dynamicFields = FormField::where('companyId','=',$id)->delete();

            $fields = $request->input('fields');
         /// dd($fields);
 foreach ($fields as $field) {

    // Normalize field name: lowercase and remove spaces
    $normalizedName = strtolower(str_replace(' ', '', $field['name']));

    // Save form field configuration
    FormField::create([
        'companyId' => $id,
        'name' => $normalizedName,
        'label' => $field['label'],
        'type' => $field['type'],
    ]);

    // Dynamically add column to frequisitions table
    if (!Schema::hasColumn('frequisitions', $normalizedName)) {
        Schema::table('frequisitions', function (Blueprint $table) use ($field, $normalizedName) {
            switch ($field['type']) {
                case 'string':
                    $table->string($normalizedName)->nullable();
                    break;
                case 'integer':
                    $table->integer($normalizedName)->nullable();
                    break;
                case 'text':
                    $table->text($normalizedName)->nullable();
                    break;
                // Add more cases as needed
                default:
                    $table->string($normalizedName)->nullable();
            }
        });
    }

    // Dynamically add column to fpurchaseorders table
    if (!Schema::hasColumn('fpurchaseorders', $normalizedName)) {
        Schema::table('fpurchaseorders', function (Blueprint $table) use ($field, $normalizedName) {
            switch ($field['type']) {
                case 'string':
                    $table->string($normalizedName)->nullable();
                    break;
                case 'integer':
                    $table->integer($normalizedName)->nullable();
                    break;
                case 'text':
                    $table->text($normalizedName)->nullable();
                    break;
                // Add more cases as needed
                default:
                    $table->string($normalizedName)->nullable();
            }
        });
    }
}

   
      if($updaterequisition){

        return back()->with('success', 'Company Updated successfully!');

      }

         
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }


public function checkExecutive(Request $request)
{
    $user = User::where('email', $request->email)->first();
     
   // dd($user);
   //\Log::info('Check Executive:', ['user' => $user]);
    
    if (!$user) {
        return response()->json(['is_executive' => false, 'exists' => false]);
    }

    if ($user->executiveId) {

    $companyIds = ExecutiveRole::where('userId', $user->id)->pluck('companyId');
    $companies = Company::whereIn('id', $companyIds)->get(['id', 'name']);

    return response()->json([
        'is_executive' => !is_null($user->executiveId),
        'exists' => true,
        'companies' => $companies
    ]);

    }
    
}

}
