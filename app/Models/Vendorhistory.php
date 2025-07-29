<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Vendorhistory extends Model
{
      use HasFactory;

    protected $fillable = [

        'vendor_id',
        'companyId',
        'department',
        'userId',
        'status',
        'approvallevel',
        'isActive',
        'doneby',
        'action',
        'reason'
       
    ];


    public function Vendor()
    {
        return $this->belongsTo(Vendor::class);
    }

}
