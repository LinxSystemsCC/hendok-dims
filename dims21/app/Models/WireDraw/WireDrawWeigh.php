<?php

namespace App\Models\WireDraw;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WireDrawWeigh extends Model
{
    use HasFactory;
    protected $table = 'tblWireDrawLines';
    protected $primaryKey = 'intOrderLineId';

    protected $fillable = [
        'intJobNumber',
        'intProductId',
        'intStand',
        'intStandId',
        'fltWeight',
        'intRodId',
        'intUserId',
    ];
}
