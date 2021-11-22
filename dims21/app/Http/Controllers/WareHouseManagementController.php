<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Auth;

class WareHouseManagementController extends Controller
{
    public function getProductsnames()
    {
        $getProducts= DB::connection('barcoding')->select("Select * from viewBarcodeCollecter
left outer join tblTempItemsAndBarcodes
on tblTempItemsAndBarcodes.strPastelCode = viewBarcodeCollecter.Code
ORDER BY [GROUP 2],[GROUP 3] ,Description_1 ");

        return view('dims/barcodecollector')
            ->with('products',$getProducts);
    }
    public function recordbarcode($productCode)
    {
        $getProducts= DB::connection('barcoding')->select("Select * from viewBarcodeCollecter  where Code='$productCode' ");

        return view('dims/barcodeform')
            ->with('products',$getProducts);
    }
    public function savebarcode(Request $request)
    {
        $itemCode = $request->get("Code");
        $barcode = $request->get("barcode");
        $strLocationName = $request->get("location");

        DB::connection('barcoding')->table('tblTempItemsAndBarcodes')->insert(
            ['strPastelCode' => $itemCode, 'strItemBarcode' => $barcode,'strLocationName'=> $strLocationName]
        );

        return redirect('getProductsnames');
    }
}
