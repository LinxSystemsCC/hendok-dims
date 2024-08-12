<?php

namespace App\Models\WireDraw;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WireDrawProduct extends Model
{
    use HasFactory;
    protected $table = 'tblProductsWireDraw';
    protected $primaryKey = 'intProductId';

    protected $fillable = [
        'strProductName',
        'ftlWireSize',
        'strSizeTolerance',
        'strMPATolerance',
        'intCustomerId',
        'strSageCode'
    ];
}
