<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Auth;
use Illuminate\Support\Carbon;

class ProWeightController extends Controller
{
    public function index()
    {
        $dateFrom = Carbon::today()->subMonth()->toDateString();
        $dateTo = Carbon::today()->toDateString();

        $horses = DB::connection('sqlsrv3')->select("SELECT * FROM viewTeamLeaderHorses");
        $trailers = DB::connection('sqlsrv3')->select("SELECT * FROM viewTrailers");

        $data = DB::connection('sqlsrv3')->select("EXEC usp_R_ProWeighData '$dateFrom', '$dateTo'");
        
        return view("warehouse.pro_weigh.index")
            ->with('dateFrom', $dateFrom)
            ->with('dateTo', $dateTo)
            ->with('horses', $horses)
            ->with('trailers', $trailers)
            ->with('data', $data);
    }

    public function getProWeighData(Request $request) {
        $dateFrom = $request->get("dateFrom");
        $dateTo = $request->get("dateTo");

        $result= DB::connection('sqlsrv3')->select("EXEC usp_R_ProWeighData '$dateFrom', '$dateTo'");
        return response()->json($result);
    }

    public function updateProWeighData(Request $request) {
        $TICKET_NUMBER = $request->get("TICKET_NUMBER");
        $REG_NUMBER = $request->get("REG_NUMBER");
        $FIRST_WEIGHT = $request->get("FIRST_WEIGHT");

        dd("EXEC usp_U_ProWeighData '$TICKET_NUMBER', '$REG_NUMBER', '$FIRST_WEIGHT'");

        $result= DB::connection('sqlsrv3')->select("EXEC usp_U_ProWeighData '$TICKET_NUMBER', '$REG_NUMBER', '$FIRST_WEIGHT'");

        return response()->json($result);
    }

}
