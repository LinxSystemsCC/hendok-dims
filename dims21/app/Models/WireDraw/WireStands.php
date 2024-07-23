<?php

namespace App\Models\WireDraw;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WireStands extends Model
{
    use HasFactory;
    protected $table = 'tblStands';
    protected $primaryKey = 'intStandId';

    protected $fillable = [
        'strStandName',
        'fltStandMass',
        'intDepartmentId',
    ];
}
