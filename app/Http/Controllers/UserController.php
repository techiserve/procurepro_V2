<?php

namespace App\Http\Controllers;
use App\Models\userrole;
use App\Models\User;
use App\Models\Rolepermission;
use App\Models\Company;
use Alert;
use App\Models\CompanyRole;
use Illuminate\Support\Facades\Auth;

use Illuminate\Support\Facades\Hash;

use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
           $user = Auth::user()->companyId;
        
         $users = User::where('companyId', '=', $user)->where('userrole', '>',1)->get();

        return view('users.index', compact('users'));
    }

    public function home()
    {
        $user = Auth::user()->userrole;

        if($user == 2 OR  Auth::user()->executiveId != null){
            $userId = Auth::user()->id;
            $companies = CompanyRole::where('userId','=',$userId)->first();
            $allcompanies = Company::all();
        
            if($companies == null){
        
            return view('home');

            }else{

                $companies = CompanyRole::where('userId','=',$userId)->get();
     
              return view('executivehome',compact('companies','allcompanies'));

            }
        }else{
       
            return view('home');
        }

       
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
         $roles = userrole::all();
    
        return view('users.create', compact('roles'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
       
      //  dd($request->all());

    if($request->password == $request->confirmpassword){

        $user = new User();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = Hash::make($request->password);
        $user->username =  $request->name;
        $user->phonenumber = $request->phonenumber;
        $user->position = $request->position;
        $user->address = $request->address;  
        $user->companyId = Auth::user()->companyId; 
        $user->department = $request->department;    
        $user->userrole = $request->role;   
        $user->isActive = $request->IsActive;     
        $user->save();

        if($user){

            //dd('saved........');
            return redirect()->route('users.create')->with('success', 'User created successfully!');
        }
          return redirect()->route('users.create')->with('error', 'Failed to create User!');
      //  dd('not saved.....');
    }else{

        return redirect()->route('users.create')->with('error', 'Passwords did not match!'); 
    }

 }




    public function companyindex()
    {

        return view('companies.index');
    }



    
    public function executivehome(Request $request)
    {
        $userId= Auth::user()->id;
        $request->company;
      //  dd($userId,$request->company);
       $companyRole = CompanyRole::where('userId','=',$userId)->where('companyId','=',$request->company)->first();
      // dd( $companyRole,$request->company);
        $updateCompany = User::where('id', '=', $userId)->update([

            'companyId' => $request->company,
            'userrole' => $companyRole->roleId
        ]);

        return view('home');
    }

    public function companystore(Request $request)
    {
       
        $user = new User();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = Hash::make(12345678);
        $user->username =  $request->username;
        $user->phonenumber = $request->phonenumber;
        $user->position = $request->position;
        $user->userrole_id = 1;      
        $user->save();

        if($user){

            dd('saved........');
          //  return redirect()->route('assets.create')->with('success', 'Asset created successfully!');
        }
        //  return redirect()->route('assets.create')->with('error', 'Failed to create Asset!');
        dd('not saved.....');
    }


    public function companycreate()
    {                
        return view('companies.create');
    }
    /**
     * Display the specified resource.
     */
    public function userrolestore(Request $request)
    {
         
        $user = new userrole();
        $user->name = $request->roleName;
        $user->description = $request->description; 
        $user->save();

        if($user){

            $permission = 'permission';

            foreach ($request->all() as $key => $value) {

            if ($value != null && $key != 'roleName' && $key != 'description' && $key != '_token') {
            
             $role = new Rolepermission();
             $role->role_id = $user->id;
             $role->permission = $value; 
             $role->save();
      
                }
            }

        }

        if($user && $role){
      
            return redirect()->route('master.manageRole')->with('success', 'User Role created successfully!');

        }else{

           return redirect()->route('master.manageRole')->with('error', 'Failed to create User Role!');
        }


    }


    public function parameters()
    {
       return view('users.parameters');
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
