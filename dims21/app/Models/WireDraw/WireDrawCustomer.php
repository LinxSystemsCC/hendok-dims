<?php

namespace App\Models\WireDraw;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WireDrawCustomer extends Model
{
    use HasFactory;
    protected $table = 'tblCustomersWireDraw';
    protected $primaryKey = 'intCustomerId';

    protected $fillable = [
        'strCustomerName'
    ];
}
