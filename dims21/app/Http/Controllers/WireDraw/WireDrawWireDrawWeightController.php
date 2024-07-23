<?php

namespace App\Http\Controllers\WireDraw;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class WireDrawWireDrawWeightController extends Controller
{
    public function index(){
        return view('warehouse.wiredraw.qcphase.index');
    }
}
