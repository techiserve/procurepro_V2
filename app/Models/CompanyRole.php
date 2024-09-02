<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CompanyRole extends Model
{
    use HasFactory;
   
    protected $fillable = [

        'userName',
        'userId',
        'companyId',
        'roleId',
        'isActive'
       
    ];
}
