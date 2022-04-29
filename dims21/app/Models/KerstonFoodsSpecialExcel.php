<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KerstonFoodsSpecialExcel extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'productCode','decPrice','strContractRef','contractID',
    ];

    /*enable timestamps as well.
    i think when they do try to import there should also */
    protected $connection = 'sqlsrv3';
    protected $primaryKey = 'intAuto';
    protected $table  = 'tblTempCustomerSpecials';
    
}
