<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Purchaseorder extends Model
{
    use HasFactory;

    
    protected $fillable = [

        'requisition_id',
        'vendor',
        'services',
        'paymentmethod',
        'department',
        'expenses',
        'projectcode',
        'amount',
        
        'PropertyName',
        'TransactionDescription',
        'TaxTypeDescription',
         
        'SupplierCode',
        'PropertyCode',
        'TransactionCode',
        'TaxTypeCode',

        'invoiceamount',
        'jobcardfile',
        'invoice',
        'userId',
        'status',
        'purchaseorderstatus',
        'balance',
        'approvallevel',
        'totalapprovallevels',
        'isActive',
        'reason',
        'approvedby',
        'releaseStatus',
        'uploadStatus'
       
    ];

    public function histories()
    {
        return $this->hasMany(RequisitionHistory::class, 'requisition_id', 'requisition_id');

    }

}
