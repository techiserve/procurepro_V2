<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bankaccount extends Model
{
    use HasFactory;

    protected $fillable = [

        'bankName',
        'branch',
        'accountName',
        'accountType',
        'accountNumber',
        'accountPurpose',
        'branchCode',
        'isActive',
        'companyId',
        'userId',
       
       
    ];
}
