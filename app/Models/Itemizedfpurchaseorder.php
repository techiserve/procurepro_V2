<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Itemizedfpurchaseorder extends Model
{
    use HasFactory;

    protected $fillable = [
        'requisition_id',
        'item',
        'description',
        'quantity',
        'price',
        'weight',
        'linetotal',
        'vat',
        'subtotal',
        'vattotal',
        'grandtotal',
    ];
}