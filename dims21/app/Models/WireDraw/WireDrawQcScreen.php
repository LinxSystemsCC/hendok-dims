<?php

namespace App\Models\WireDraw;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WireDrawQcScreen extends Model
{
    use HasFactory;
    protected $table = 'tblWireDrawQCCheck';
    protected $primaryKey = 'intQcId';

    protected $fillable = [
        'intJobNumber',
        'intProductId',
        'intStand',
        'strTensileTicketNumber',
        'strMpa',
        'fltWireSize'
    ];
}
