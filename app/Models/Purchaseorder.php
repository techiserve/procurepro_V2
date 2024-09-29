<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Purchaseorder extends Model
{
    use HasFactory;

    
    protected $fillable = [

        'requisitionId',
        'vendor',
        'services',
        'paymentmethod',
        'department',
        'expenses',
        'projectcode',
        'amount',
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

}
