<?php

namespace App\Http\Controllers;
use App\Models\userrole;
use App\Models\User;
use App\Models\Company;
use App\Models\CompanyRole;
use App\Models\FormField;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use App\Models\Frequisition;
use App\Models\Fpurchaseorder;
use App\Models\Executive;
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
     
        $executive = new Executive();
        $executive->name = $request->executiveName;
        $executive->email = $request->email;
        $executive->password = Hash::make($request->password);
        $executive->userName = $request->username;
        $executive->companyId = $request->compan[0];
        $executive->address = $request->address;
        $executive->isActive = 1;     
        $executive->save();

       if($executive){

        $user = new User();
        $user->name = $request->executiveName;
        $user->email = $request->email;
        $user->password = Hash::make($request->password);
        $user->username =  $request->username;
        $user->companyId = $request->compan[0];
        $user->executiveId = $executive->id;
        $user->userrole = 2;      
        $user->save();

        $company = $request->input('company');
        $userrole = $request->input('userrole');


        foreach($company as $key => $n ) {

            $arrData[] = array(

                $companyrole = CompanyRole::create([
                    'userId' => $user->id,
                    "companyId"=>$company[$key],
                    "roleId"=>$userrole[$key]
                ])
            );

        }

       }

        if($user && $executive){
     
            return redirect()->route('executives.create')->with('success', 'Executive created successfully!');
        }
          return redirect()->route('executives.create')->with('error', 'Failed to create Executive!');
      
    }




    public function executivescreate()
    {
        $companies = Company::where('id', Auth::user()->companyId)->get();

        return view('executives.create', compact('companies'));

    }

    public function store(Request $request)
    {
      
        $user = User::where('email', $request->email)->first();

        if($user){
           
              return redirect()->route('companies.create')->with('warning', 'Sorry buddy, this email has already been used!');
        }
 
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

            // Save form field configuration

            FormField::create([
                'companyId' => $company->id,
                'name' => $field['name'],
                'label' => $field['label'],
                'type' => $field['type'],
            ]);

            // Dynamically add column to requisitions table
            if (!Schema::hasColumn('frequisitions', $field['name'])) {
                Schema::table('frequisitions', function (Blueprint $table) use ($field) {
                    switch ($field['type']) {
                        case 'string':
                            $table->string($field['name'])->nullable();
                            break;
                        case 'integer':
                            $table->integer($field['name'])->nullable();
                            break;
                        case 'text':
                            $table->text($field['name'])->nullable();
                            break;
                        // Add more cases as needed
                        default:
                            $table->string($field['name'])->nullable();
                    }
                });
            }

            // Dynamically add column to purchaseorder table
                   if (!Schema::hasColumn('fpurchaseorders', $field['name'])) {
                Schema::table('fpurchaseorders', function (Blueprint $table) use ($field) {
                    switch ($field['type']) {
                        case 'string':
                            $table->string($field['name'])->nullable();
                            break;
                        case 'integer':
                            $table->integer($field['name'])->nullable();
                            break;
                        case 'text':
                            $table->text($field['name'])->nullable();
                            break;
                        // Add more cases as needed
                        default:
                            $table->string($field['name'])->nullable();
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

        return view('companies.edit', compact('company'));
    }



    public function companydelete($id)
    {
        
         $delete = Company::where('id', $id)->delete();

         $deleteUser = User::where('companyId', $id)->delete();

      
            return back()->with('success', 'Company deleted successfully!');

        
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
}
