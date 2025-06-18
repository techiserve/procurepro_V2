<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FrequisitionVendor extends Model
{
    protected $table = 'frequisitionvendor';

    protected $fillable = [
        'vendor_final',
        'frequisition_id',
        'file_path',
        'amount',
        'status',
        'modal_vendor_name',
        'type',
        'vat_allocation',
        'supplier_code',
        'bank',
        'account_number',
        'account_type',
        'doc_path',
    ];
}
