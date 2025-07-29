<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Vendor extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'type',
        'description',
        'companyId',
        'vat_registered',
        'local_international',
        'contact_no_1',
        'contact_no_2',
        'supplier_code',
        'vat_allocation',
        'finance_manager',
        'address',
        'active',
        'status',
        'message',
        'bank_name',
        'account_number',
        'account_type',
        'branch_code',
    ];

    public function documents()
{
    return $this->hasMany(VendorDocument::class);
}

  public function history()
{
    return $this->hasMany(Vendorhistory::class);
}

}
