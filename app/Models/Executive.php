<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Executive extends Model
{
    use HasFactory;
   
    protected $fillable = [

        'name',
        'userName',
        'confirmPassword',
        'password',
        'email',
        'address',
        'companyId',
        'IsActive'
       
    ];
}
