<?php

namespace App\Exports;

use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithHeadings;

class SpecialsExport implements FromQuery, WithHeadings
{
    use Exportable;

    public function __construct(string $SpecialHeaderId)
    {
        $this->SpecialHeaderId = $SpecialHeaderId;
    }
    public function headings(): array
    {
        return [
            'Code',
            'Description',
            'Cost',
            'Price',
            'CustomerCode',
            'DateFrom',
            'DateTo',
            'SpecialHeaderId',
        ];
    }

    public function query()
    {
        return DB::connection('sqlsrv3')->table("viewTblCustomerSpecialForExport" )
        ->where('SpecialHeaderId', $this->SpecialHeaderId)
        ->orderBy('SpecialHeaderId');
    }
}