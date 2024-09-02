<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;


class SQLServerModel extends Model
{
    protected $connection = 'sqlsrv';
    protected $table = 'your_table_name';
}
