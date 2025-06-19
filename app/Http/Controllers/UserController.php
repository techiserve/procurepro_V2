<?php

namespace App\Http\Controllers;
use App\Models\userrole;
use App\Models\User;
use App\Models\Rolepermission;
use App\Models\Company;
use Alert;
use App\Models\Requisition;
use App\Models\Frequisition;
use App\Models\Sqlserver;
use App\Models\Bank;
use App\Models\Department;
use App\Models\Purchaseorder;
use App\Models\Fpurchaseorder;
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
       
         $users = User::where('userrole', '!=', 1)->where('companyId', Auth::user()->companyId)->get();

        return view('users.index', compact('users'));
    }

    public function home()
    { 
        
        $departments = Frequisition::where('status','=', 1)->where('companyId', Auth::user()->companyId)->count();
        $userCount  = Fpurchaseorder::where('status','=', 1)->where('companyId', Auth::user()->companyId)->count();
        $requisitions = Frequisition::where('companyId', Auth::user()->companyId)->count();
        $purchaseorders = Fpurchaseorder::where('companyId', Auth::user()->companyId)->count();

        $user = Auth::user()->userrole;

        if($user == 2 OR  Auth::user()->executiveId != null){
            $userId = Auth::user()->id;
            $companies = CompanyRole::where('userId','=',$userId)->first();
            $allcompanies = Company::where('companyId', Auth::user()->companyId)->get();
        
            if($companies == null){
        
            return view('home',compact('userCount','departments','requisitions','purchaseorders') );

            }else{

                $companies = CompanyRole::where('userId','=',$userId)->where('companyId', Auth::user()->companyId)->get();
     
              return view('executivehome',compact('companies','allcompanies'));

            }

        }else{
       
            return view('home',compact('userCount','departments','requisitions','purchaseorders') );
        }

       
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
         $roles = userrole::where('id' ,'>',3)->where('companyId', Auth::user()->companyId)->get();
         $departments  = Department::where('companyId', Auth::user()->companyId)->get();
    
        return view('users.create', compact('roles','departments'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
       
      //  dd($request->all());
      $searchemail = User::where('email','=', $request->email)->first();

      if($searchemail){

        return redirect()->route('users.create')->with('error', 'A user with this email already exists!');
      }
     

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


 public function userdelete($id)
 {
      $deleteuser = User::where('id', $id)->delete();
 
      if($deleteuser){
   
         return back()->with('success', 'User deleted successfully!');

     }else{

        return back()->with('error', 'Failed to delete User!');
     }

     
 }



 public function useredit($id)
 {
      $user = User::where('id', $id)->first();
      $roles = userrole::where('id' ,'>',3)->where('companyId', Auth::user()->companyId)->get();
      $departments = Department::where('companyId', Auth::user()->companyId)->get();
 
     return view('users.edit',compact('user','roles','departments'));
 }


  public function userunlock($id)
 {
       $user = User::where('id', $id)->update([
        'is_locked' => false,
        'login_attempts' => 0,
    ]);

    return back()->with('success', 'User account unlocked.');

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
        $user->companyId = Auth::user()->companyId;
        $user->description = $request->description; 
        $user->save();

        if($user){

            $permission = 'permission';

            foreach ($request->all() as $key => $value) {

            if ($value != null && $key != 'roleName' && $key != 'description' && $key != '_token') {
            
             $role = new Rolepermission();
             $role->role_id = $user->id;
             $role->companyId = Auth::user()->companyId;
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

        // dd($request->all());
        $user = User::findOrFail($id);

        // Update user fields
        $user->name = $request->name;
        //$user->username = $$request->username;
        $user->email = $request->email;
        $user->address = $request->address;
        $user->userrole = $request->role;
        $user->position = $request->position;
        $user->address = $request->address;
        $user->isActive = $request->IsActive;
        $user->phoneNumber = $request->phonenumber;
        $user->save();


    if($user){

       return redirect()->route('users.index')->with('success', 'User updated successfully!');

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
