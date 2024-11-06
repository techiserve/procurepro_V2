<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Requisitionfile extends Model
{
    use HasFactory;

    protected $fillable = [

        'requisitionId',
        'companyId',
        'file',
        'userId',
        'path',
  
       
    ];
}
