<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ExecutiveRole extends Model
{
    use HasFactory;

        protected $fillable = [

        'executiveId',
        'userId',
        'companyId',
        'roleId',
        'status',
        'createdBy',
        'IsActive'
       
    ];
}
