<?php

namespace App\Imports;

use App\Models\KerstonFoodsSpecialExcel;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class SpecialsImport implements ToCollection,WithHeadingRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
 
    public function collection(Collection $rows)
    {
        foreach ($rows as $row) 
        {
            KerstonFoodsSpecialExcel::create([
                'productCode'  => $row['code'],
         'productDescription'   => $row['description'],
         'decCost'   => $row['cost'],
         'decPrice'    => $row['price'],
         'customerCode'  => $row['customercode'],
         'dateFrom'   => $row['datefrom'],
         'dateTo'   => $row['dateto'],
            ]);
        }
    }
}
