<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Departmentapproval extends Model
{
    use HasFactory;

    protected $fillable = [

        'department',
        'userId',
        'companyId',
        'departmentId',
        'approvalId',
        'roleId',
       
    ];
}
