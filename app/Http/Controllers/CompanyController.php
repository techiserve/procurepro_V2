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
use Illuminate\Support\Facades\DB;
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
        if (is_array($companies) && count($companies) > 0) {

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

 
        $company = new Company();
        $company->name = $request->companyname;
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
            

            foreach ($fields as $field) {
                // Normalize field name: lowercase and remove spaces
                $normalizedName = strtolower(str_replace(' ', '', $field['name']));
                
                // Prepare options data
                $options = null;
                if ($field['type'] === 'dropdown' && isset($field['options']) && !empty($field['options'])) {
                    // Convert comma-separated string to array, trim whitespace, and store as JSON
                    $optionsArray = array_map('trim', explode(',', $field['options']));
                    $options = json_encode($optionsArray);
                }

                // Save form field configuration with options
                FormField::create([
                    'companyId' => $company->id,
                    'name' => $normalizedName,
                    'label' => $field['label'],
                    'type' => $field['type'],
                    'options' => $options, // Store dropdown options as JSON
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
                            case 'checkbox':
                                $table->boolean($normalizedName)->nullable()->default(false);
                                break;
                            case 'dropdown':
                                $table->string($normalizedName)->nullable(); // Store selected option value
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
                            case 'checkbox':
                                $table->boolean($normalizedName)->nullable()->default(false);
                                break;
                            case 'dropdown':
                                $table->string($normalizedName)->nullable(); // Store selected option value
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
       // dd($dynamicFields);

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
    public function executiveedit(string $id)
    {
        $executive = Executive::where('id', $id)->first();
        $companies = Company::all();
        $executiveRoles = ExecutiveRole::where('executiveId', $id)->get();
        $executiveCompanyIds = $executiveRoles->pluck('companyId')->toArray();
         //dd( $executiveCompanyIds, $executiveRoles , $executive);
        if (!$executive) {

            return redirect()->back()->with('error', 'Executive not found!');
        }

        return view('executives.edit', compact('executive', 'companies', 'executiveRoles','executiveCompanyIds'));
    }


    public function update(Request $request, $id)
{
 
    DB::beginTransaction();

    try {
        // Update Executive manually
        DB::table('executives')->where('id', $id)->update([
            'name' => $request->executiveName,
            'userName' => $request->username,
            'email' => $request->email,
            'address' => $request->address,
        ]);

        // Update User (manually find and update using executiveId)
        $user = DB::table('users')->where('executiveId', $id)->first();

        if ($user) {
            $userData = [
                'email' => $request->email,
                'username' => $request->username,
            ];

            if ($request->filled('password')) {
                $userData['password'] = Hash::make($request->password);
            }

            DB::table('users')->where('id', $user->id)->update($userData);
        }

                        // Sync executive_roles (manually remove and insert)
                        $existingRoles = DB::table('executive_roles')
                    ->where('executiveId', $id)
                    ->pluck('companyId', 'id'); // [role_id => companyId]

                // 2. Handle input
                $newCompanyIds = collect($request->company_ids ?? []);
                $existingCompanyIds = collect($existingRoles->values());

                // 3. Identify companies to add and to disable (optional)
                $toAdd = $newCompanyIds->diff($existingCompanyIds);
                $toDisable = $existingCompanyIds->diff($newCompanyIds);

                // 4. Add new roles
                $roleInserts = [];

                foreach ($toAdd as $companyId) {
                    $roleInserts[] = [
                        'executiveId' => $id,
                        'userId' => $user->id ?? null,
                        'roleId' => 3,
                        'status' => 1,
                        'createdBy' => Auth::id(),
                        'companyId' => $companyId,
                        'created_at' => now(),
                        'updated_at' => now(),
                    ];
                }

                if (!empty($roleInserts)) {
                    DB::table('executive_roles')->insert($roleInserts);
                }

                // 5. Optional: Disable roles that are no longer selected
                if ($toDisable->isNotEmpty()) {
                    DB::table('executive_roles')
                        ->where('executiveId', $id)
                        ->whereIn('companyId', $toDisable)
                        ->delete();
                }

                 DB::commit();

        return redirect()->back()->with('success', 'Executive updated successfully.');

    } catch (\Exception $e) {
        DB::rollBack();
        return redirect()->back()->with('error', 'Error updating executive: ' . $e->getMessage());
    }
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

    // Prepare options if type is dropdown
    $options = null;
    if (isset($field['type']) && $field['type'] === 'dropdown') {
        $rawOptions = isset($field['options']) ? $field['options'] : '';
        $splitOptions = array_map('trim', explode(',', $rawOptions));
        $options = json_encode($splitOptions);
    }

    // Save form field configuration
    FormField::create([
        'companyId' => $id,
        'name' => $normalizedName,
        'label' => $field['label'],
        'type' => $field['type'],
        'options' => $options, // null for non-dropdowns, JSON string for dropdown
    ]);

    // Add column to frequisitions if not exists
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
                case 'checkbox':
                    $table->boolean($normalizedName)->nullable();
                    break;
                case 'dropdown':
                    $table->string($normalizedName)->nullable();
                    break;
                default:
                    $table->string($normalizedName)->nullable();
            }
        });
    }

    // Add column to fpurchaseorders if not exists
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
                case 'checkbox':
                    $table->boolean($normalizedName)->nullable();
                    break;
                case 'dropdown':
                    $table->string($normalizedName)->nullable();
                    break;
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
    public function executivedelete(string $id)
    {
       // dd($id);
        $executive = Executive::where('id', $id)->first();
        if (!$executive) {
            return redirect()->back()->with('error', 'Executive not found!');
        }
        // Delete the executive
        $executive->delete();   
        // Also delete the associated user
        User::where('executiveId', $id)->delete();  
        // Delete the executive roles associated with this executive
        ExecutiveRole::where('executiveId', $id)->delete();  

        return redirect()->route('executives.index')->with('success', 'Executive deleted successfully!');
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
