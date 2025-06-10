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
        'approvallevel',
        'totalapprovallevels',
        'isActive',
        'reason',
        'approvedby'
       
    ];


    public function histories()
    {
        return $this->hasMany(RequisitionHistory::class);
    }
}
