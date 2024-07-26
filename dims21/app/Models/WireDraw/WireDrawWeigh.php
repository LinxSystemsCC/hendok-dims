<?php

namespace App\Models\WireDraw;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WireDrawWeigh extends Model
{
    use HasFactory;
    protected $table = 'tblWireDrawHeaderLines';
    protected $primaryKey = 'intorderlinsId';

    protected $fillable = [
        'intjobNumber',
        'intproductId',
        'intstand',
        'intStandId',
        'fltweight',
    ];
}
