<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Auth;

class WareHouseManagementController extends Controller
{
    public function productscats(){
        $getProducts= DB::connection('barcoding')->select("Select * from viewWhsmainCats ORDER BY group1");
        return view('dims/whstmaincats')
            ->with('products',$getProducts);
    }
    public function getProductsnames($cat)
    {
        $getProducts= DB::connection('barcoding')->select("Select * from viewBarcodeCollecter
left outer join tblTempItemsAndBarcodes
on tblTempItemsAndBarcodes.strPastelCode = viewBarcodeCollecter.Code
where [GROUP 1] = '$cat' and strItemBarcode is null
ORDER BY [GROUP 2],[GROUP 3] ,Description_1 ");

        return view('dims/barcodecollector')
            ->with('products',$getProducts)->with('cat',$cat);
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
        $expdate = $request->get("expdate");
        $cat = $request->get("cat");

        DB::connection('barcoding')->table('tblTempItemsAndBarcodes')->insert(
            ['strPastelCode' => $itemCode, 'strItemBarcode' => $barcode,'strLocationName'=> $strLocationName,'dteExpiryDate'=>$expdate]
        );

        return redirect("getProductsnames/$cat");
    }

    public function stockmover(){
        return view('stockmover/stockmoverlanding');
    }
    public function scanshelffrom(){

        return view('stockmover/shelffrom');
    }
    public function goscanproductfrom(Request $request){
        $shelffrom = $request->get("shelffrom");
        //dd($shelffrom);
        return view('stockmover/productfrom')->with('shelffrom',$shelffrom);


    }

    public function goscanshelfto(Request $request){
        $shelffrom = $request->get("shelffrom");
        $productfrom = $request->get("productfrom");
        $Qty = $request->get("Qty");

        return view('stockmover/shelfto')->with('shelffrom',$shelffrom)->with('productfrom',$productfrom)->with('Qty',$Qty);


    }

    public function goscanproductto(Request $request){
        $shelffrom = $request->get("shelffrom");
        $productfrom = $request->get("productfrom");
        $Qty = $request->get("Qty");
        $shelfto = $request->get("shelfto");

        return view('stockmover/productto')->with('shelffrom',$shelffrom)->with('productfrom',$productfrom)->with('Qty',$Qty)->with('shelfto',$shelfto);
    }
    public function gofinish(Request $request){
        $shelffrom = $request->get("shelffrom");
        $productfrom = $request->get("productfrom");
        $Qty = $request->get("Qty");
        $shelfto = $request->get("shelfto");
        $productto= $request->get("productto");
        $confirmqty = $request->get("confirmqty");
        $expiry = $request->get("expiry");


        return view('stockmover/finishedstockmoving')->with('shelffrom',$shelffrom)
            ->with('productfrom',$productfrom)
            ->with('productto',$productto)
            ->with('Qty',$Qty)
            ->with('confirmqty',$confirmqty)
            ->with('expiry',$expiry)
            ->with('shelfto',$shelfto);
    }
    public function savestockmover(Request $request){

        $shelffrom = $request->get("shelffrom");
        $productfrom = $request->get("productfrom");
        $Qty = $request->get("Qty");
        $shelfto = $request->get("shelfto");
        $productto= $request->get("productto");
        $confirmqty = $request->get("confirmqty");

        DB::connection('barcoding')->table('tblInventoryAndBinMover')->insert(
            ['strShelfFrom' => $shelffrom, 'strBarcodeFrom' => $productfrom,'strShelTo'=> $shelfto,'strBarcodeTo'=>$productto
                ,'mnyQtyFrom'=> $Qty,'mnyQtyTo'=>$confirmqty]
        );
    }

}
