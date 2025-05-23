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
         $users = userrole::where('id' ,'>',3)->where('companyId', Auth::user()->companyId)->get();
    
        return view('master.manageRole', compact('users'));
    }


    public function department()
    {
         $roles = userrole::where('id' ,'>',3)->where('companyId', Auth::user()->companyId)->get();
         $departments = Department::where('companyId', Auth::user()->companyId)->get();
         $users = User::where('companyId', Auth::user()->companyId)->get();
    
        return view('master.department',compact('roles','departments','users'));
    }

    public function banks()
    {  
        $companyId = Auth::user()->companyId;

        $banks = Bank::all();

        return view('master.banks', compact('banks'));
    }


    public function bankAccount()
    {  
        $companyId = Auth::user()->companyId;

        $banks = Bank::all();
        $bankaccounts = Bankaccount::all();

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

      //  dd($request->all());

        $userId = Auth::user()->id;
        $companyId = Auth::user()->companyId;

        $executive = new Department();
        $executive->name = $request->departmentname;
        $executive->userId = $userId;
        $executive->companyId = $companyId;
        $executive->IsActive = $request->IsActive;   
        $executive->po = $request->po;     
        $executive->save();
    

        $approval = $request->input('approval');
        $userrole = $request->input('role');

        $second_approval = $request->input('secondary_approval');
        $second_userrole = $request->input('secondary_role');

       

        if($executive){

        foreach($approval as $key => $n ) {

            $arrData[] = array(

                $companyrole = Departmentapproval::create([

                    'department' => $executive->name,
                    'mode' => 'PR',
                    'userId' => $userId,
                    'approvalId' =>$approval[$key],
                    'companyId' => $companyId,
                    'departmentId'  => $executive->id,
                    'roleId'  => $userrole[$key]
                    
                ])
            );

        }  

        if($second_approval ){

          

          foreach($second_approval as $key => $n ) {

              if($second_approval[$key] != null){

            $arrData[] = array(

                $companyrole = Departmentapproval::create([

                    'department' => $executive->name,
                    'mode' => 'PO',
                    'userId' => $userId,
                    'approvalId' =>$second_approval[$key],
                    'companyId' => $companyId,
                    'departmentId'  => $executive->id,
                    'roleId'  => $second_userrole[$key]
                    
                ])
            );
        }

        }

        }




        }


        if($executive){

            return back()->with('success', 'Department created successfully!');
        }
          return back()->with('error', 'Failed to create Department!');
       
    }



    
    public function departmentUpdate(Request $request,$id)
    {  
      
       // dd($request->all(),$id);
        $userId = Auth::user()->id;
        $companyId = Auth::user()->companyId;
        $approval = $request->input('approval');
        $userrole = $request->input('role');

        
        $updatedepartment = Department::where('id', $id)->update([

           'name' => $request->departmentname,
           'IsActive' => $request->IsActive
        ]);

        $department = Department::where('id', $id)->first();
        $deleteroles = Departmentapproval::where('departmentId', $department->id )->delete();

        if($deleteroles){

            foreach($approval as $key => $n ) {
    
                $arrData[] = array(
    
                    $companyrole = Departmentapproval::create([
    
                        'department' => $department->name,
                        'userId' => $userId,
                        'approvalId' =>$approval[$key],
                        'companyId' => $companyId,
                        'departmentId'  => $department->id,
                        'roleId'  => $userrole[$key]
                        
                    ])
                );
    
            }
    
            }
        

        if($department){

            return redirect()->route('master.department')->with('success', 'Department updated successfully!');
        }
          return redirect()->route('master.department')->with('error', 'Failed to update Department!');
       
    }


    public function delete($id)
    {
         $role = userrole::where('id', $id)->delete();
         $permissions = Rolepermission::where('role_id', $id)->delete();
         $users = User::where('userrole', $id)->update([

           'isActive' => null

         ]);
    

         if($permissions && $role){
      
            return back()->with('success', 'Role deleted successfully!');

        }else{

           return back()->with('error', 'Failed to delete role!');
        }

        
    }



    public function bankaccountupdate(Request $request, string $id)
    {

    $record = Bankaccount::findOrFail($id);

     $record->update($request->only(['bankName', 'branch','accountName','accountType','accountNumber','accountPurpose','branchCode']));

     if($record){

        return redirect()->route('master.bankAccount')->with('success', 'Bank Account updated successfully!');

     }

    }

    

    public function bankaccountdelete($id)
    {
         $bank = Bankaccount::where('id', $id)->delete();
    
         if($bank){
      
            return back()->with('success', 'Bank Account deleted successfully!');

        }else{

           return back()->with('error', 'Failed to delete bank account!');
        }

        
    }

    public function departmentdelete($id)
    {
         $department = Department::where('id', $id)->delete();
         $da = Departmentapproval::where('departmentId', $id)->delete();
    
         if($department){
      
            return back()->with('success', 'Department  deleted successfully!');

        }else{

           return back()->with('error', 'Failed to delete department!');
        }

        
    }

    public function departmentedit($id)
    {
         $department = Department::where('id', $id)->first();
         $da = Departmentapproval::where('departmentId', $id)->get();
         $roles = Userrole::where('companyId', Auth::user()->companyId)->get();
   
         return view('master.departmentedit',compact('department','da','roles'));
        
    }

    public function bankaccountedit($id)
    {
         $bank = Bankaccount::where('id', $id)->first();
         $banks = Bank::all();
    
        return view('master.editbank',compact('bank','banks'));
    }

}
