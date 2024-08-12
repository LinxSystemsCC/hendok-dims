<?php

namespace App\Models\WireDraw;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WireDrawRod extends Model
{
    use HasFactory;
    protected $table = 'tblwiredrawrods';
    protected $primaryKey = 'intRodId';

    protected $fillable = [
        'dtmDate',
        'intJobNumber',
        'intRodSupplier',
        'strRodCode',
        'strCastNumber',
        'strSerialNumber',
        'strBatchNumber',
        'fltRodElongation',
        'fltRodMpa',
        'intUserId',
        'fltRodWeigh'
    ];
}
