<?php

namespace App\Traits;

use Illuminate\Support\Facades\DB;
use App\Models\WireDraw\WireDrawRodSupplier;
use App\Models\WireDraw\WireDrawRod;

trait UtilityTrait
{
    /**
     * This function is used for get the rod codes list
     */
    public function getRodCodesList()
    {
        return DB::connection('sqlsrv2')
            ->select("SELECT Code AS strPartNumber, Description_1 AS strPartDescription FROM tblSageFullStock WHERE ItemGroup = 'WR'");
    }

    /**
     * This function is used for get the supplier list
     */
    public function getSuppliersList()
    {
        return WireDrawRodSupplier::select('intRodSupplierId','strRodSupplierName')->get();
    }

    /**
     * This function is used for get the last job header rod id
     *
     * @param int $intJobNumber
     */
    public function getRodIdLastOfJobHeader($intJobNumber)
    {
        $intRodId = 0;
        $drawRod = WireDrawRod::select('intRodId')
            ->orderBy('created_at', 'desc')
            ->where('intJobNumber', $intJobNumber)
            ->first();

        if ($drawRod) {
            $intRodId = (int) $drawRod->intRodId;
        }

        return $intRodId;
    }
}
