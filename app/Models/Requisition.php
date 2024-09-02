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
}
