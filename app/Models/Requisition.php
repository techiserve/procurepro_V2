<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Requisition extends Model
{
    use HasFactory;

    protected $fillable = [

        'vendor',
        'services',

        'PropertyName',
        'TransactionDescription',
        'TaxTypeDescription',
         
        'SupplierCode',
        'PropertyCode',
        'TransactionCode',
        'TaxTypeCode',

        'paymentmethod',
        'department',
        'expenses',
        'projectcode',
        'amount',
        'file',
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
