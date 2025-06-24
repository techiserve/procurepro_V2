<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ClassificationOfExpense extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'companyId','active'];
}