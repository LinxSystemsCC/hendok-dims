<?php

namespace App\Models\WireDraw;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WireDrawHeaders extends Model
{
    use HasFactory;

    protected $table = 'tbl_wire_draw_header_lines';
    protected $primaryKey = 'intHeaderId';

    protected $fillable = [
        'intCustomerId',
        'intProductId',
        'intWireDrawMachineId',
        'strType',
        'fltMassRequired',
        'strReference',
        'intUserId'
    ];
}
