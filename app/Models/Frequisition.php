<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Frequisition extends Model
{
    use HasFactory;

    protected $guarded = [];

        protected $fillable = [
  
        'companyId',
        'requisitionNumber',
        'userId',
        'status',
        'uploadStatus',
        'pop',
        'approvallevel',
        'totalapprovallevels',
        'isActive',
        'reason',
        'approvedby',
        'bankAccountName',
        'bankAccountNumber',
        'bankAccountType'
       
    ];

    public function selectedVendor()
    {
        return $this->hasOne(FrequisitionVendor::class, 'frequisition_id')->where('status', 1);
    }


    public function histories()
    {
        return $this->hasMany(RequisitionHistory::class);
    }
}
