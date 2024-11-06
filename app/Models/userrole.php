<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class userrole extends Model
{
    use HasFactory;

    protected $fillable = [

        'name',
        'companyId',
        'description',
        'biroles_id'
       
    ];
}
