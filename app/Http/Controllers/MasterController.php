<?php

namespace App\Http\Controllers;
use App\Models\userrole;
use App\Models\User;
use App\Models\Bank;
use App\Models\Department;
use App\Models\Departmentapproval;
use App\Models\Bankaccount;
use App\Models\Company;
use App\Models\Rolepermission;
use Alert;
use App\Models\CompanyRole;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class MasterController extends Controller
{
    public function manageRole()
    {
         $users = userrole::where('id' ,'>',3)->get();
    
        return view('master.manageRole', compact('users'));
    }


    public function department()
    {
         $roles = userrole::where('id' ,'>',3)->get();
    
        return view('master.department',compact('roles'));
    }

    public function banks()
    {  
        $companyId = Auth::user()->companyId;

        $banks = Bank::where('companyId', $companyId )->get();

        return view('master.banks', compact('banks'));
    }


    public function bankAccount()
    {  
        $companyId = Auth::user()->companyId;

        $banks = Bank::where('companyId', $companyId)->get();
        $bankaccounts = Bankaccount::where('companyId', $companyId )->get();

        return view('master.bankAccount', compact('banks','bankaccounts'));
    }

    public function banksStore(Request $request)
    {  

        $userId = Auth::user()->id;
        $companyId = Auth::user()->companyId;
       
        $bank = new Bank();
        $bank->name = $request->bankname;
        $bank->companyId =  $companyId;
        $bank->userId =  $userId;
        $bank->isActive =  $request->IsActive;     
        $bank->save();

        if($bank){

            return back()->with('success', 'Bank created successfully!');
        }
          return back()->with('error', 'Failed to create Bank!');
       
    }

    public function bankaccountStore(Request $request)
    {  

        $userId = Auth::user()->id;
        $companyId = Auth::user()->companyId;


        $bank = new Bankaccount();
        $bank->bankName = $request->bank;
        $bank->branch = $request->branchname;
        $bank->accountName = $request->accountname;
        $bank->accountType = $request->accounttype;
        $bank->accountNumber = $request->accountnumber;
        $bank->accountPurpose = $request->accountpurpose;
        $bank->branchCode = $request->branchcode;
        $bank->companyId =  $companyId;
        $bank->userId =  $userId;
        $bank->isActive =  $request->IsActive;     
        $bank->save();

        if($bank){

            return back()->with('success', 'Bank Account created successfully!');
        }
          return back()->with('error', 'Failed to create Bank Account!');
       
    }

    public function editrole($id)
    {
         $role = userrole::where('id', $id)->first();
         $permissions = Rolepermission::where('role_id', $id)->pluck('permission')->toArray();
    
        return view('master.editRole', compact('role','permissions'));
    }


    public function update(Request $request, string $id)
    {

          $updateRole = userrole::where('id', $id)->update([

            'name' => $request->roleName,
            'description' => $request->description,
            
          ]);

          if($updateRole){

            $clearPermission = Rolepermission::where('role_id',$id)->delete();
            $permission = 'permission';

            foreach ($request->all() as $key => $value) {

            if ($value != null && $key != 'roleName' && $key != 'description' && $key != '_token' && $key != '_method') {
            
             $role = new Rolepermission();
             $role->role_id = $id;
             $role->permission = $value; 
             $role->save();
      
                }
            }

        }

        if($updateRole && $role){
      
            return back()->with('success', 'Role updated successfully!');

        }else{

           return back()->with('error', 'Failed to update role!');
        }

    
    }


    public function departmentStore(Request $request)
    {  

        $userId = Auth::user()->id;
        $companyId = Auth::user()->companyId;

        $executive = new Department();
        $executive->name = $request->departmentname;
        $executive->userId = $userId;
        $executive->companyId = $companyId;
        $executive->IsActive = $request->IsActive;     
        $executive->save();
    

        $approval = $request->input('approval');
        $userrole = $request->input('role');

        if($executive){

        foreach($approval as $key => $n ) {

            $arrData[] = array(

                $companyrole = Departmentapproval::create([

                    'department' => $executive->name,
                    'userId' => $userId,
                    'approvalId' =>$approval[$key],
                    'companyId' => $companyId,
                    'departmentId'  => $executive->id,
                    'roleId'  => $userrole[$key]
                    
                ])
            );

        }

        }


        if($executive){

            return back()->with('success', 'Department created successfully!');
        }
          return back()->with('error', 'Failed to create Department!');
       
    }


    public function delete($id)
    {
         $role = userrole::where('id', $id)->delete();
         $permissions = Rolepermission::where('role_id', $id)->delete();
    

         if($permissions && $role){
      
            return back()->with('success', 'Role deleted successfully!');

        }else{

           return back()->with('error', 'Failed to delete role!');
        }
    }

}
