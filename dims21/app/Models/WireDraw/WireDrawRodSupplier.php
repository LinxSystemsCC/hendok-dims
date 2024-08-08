<?php

namespace App\Models\WireDraw;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WireDrawRodSupplier extends Model
{
    use HasFactory;

    protected $table = 'tblSuppliersWireDrawRod';
    protected $primaryKey = 'intRodSupplierId';
    protected $fillable = [
        'strRodSupplierName'
    ];
}
