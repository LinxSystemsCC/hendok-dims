<?php

namespace App\Imports;

use App\Models\KerstonFoodsSpecialExcel;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class SpecialsImport implements ToCollection,WithHeadingRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
 
    public function collection(Collection $rows)
    {
        $pool = '012345-6789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ-';
        $t=time();
        $randomString = substr(str_shuffle(str_repeat($pool, 10)), 0, 10);
        $ID = $t.$randomString;
       // dd($ID);
        DB::connection('sqlsrv3')->table('tblSpecialsImportIds')->insert(
            ['strContractRef' => $ID,'intUserId'=>Auth::user()->UserID
            ]);
        foreach ($rows as $row) 
        {
            KerstonFoodsSpecialExcel::create([
                'productCode'  => $row['code'],
         'decPrice'   => $row['price'],
         'strContractRef'   => $ID
            ]);
        }
        //spInsertIntotblSpecialsImportIds
    }
}
