<?php

namespace App\Http\Controllers;
use App\Http\Controllers\SalesForm;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use \Cache;
use Illuminate\Support\Facades\Auth;
use Excel;
use App\Imports\SpecialsImport;
use App\Exports\SpecialsExport;


class KerstonSpecialController extends Controller
{ 
    public function export($SpecialHeaderId) 
    {
       // return Excel::download(new SpecialsExport(), 'specials.xlsx');
        return (new SpecialsExport($SpecialHeaderId))->download('specials.xlsx');
    }
    public function import() 
    {
        Excel::import(new SpecialsImport, 'specials.xlsx');
        
        return redirect('/')->with('success', 'All good!');
    }
    public function importexcel(Request $request){
        
        $this->validate($request, [
            'select_file'  => 'required|mimes:xls,xlsx'
           ]);
           $filefrompost = $request->file('select_file');
           $path = $request->file('select_file')->getRealPath();
           $data = Excel::import(new SpecialsImport, $filefrompost);
}
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function convertContractPriceBulk(Request $request){
        $contractId = $request->get('contractId');
        $pricelistid= $request->get('pricelist');
        $convertBulk = DB::connection('sqlsrv3')
            ->select('exec spConvertBulkPricelistCustSpec ?,?',
                array($contractId, $pricelistid)
            );

    }
    
    public function kerstonspecial()
    {
        //
        $sessionUserId = Auth::user()->UserID;
        $queryCustomers =DB::connection('sqlsrv3')->table("viewtblCustomers" )
            ->select('CustomerId','StoreName','CustomerPastelCode','CreditLimit','BalanceDue','UserField5','Email','Routeid','Discount','OtherImportantNotes','strRoute')
            ->where('StatusId',1)

            ->orderBy('CustomerPastelCode','ASC')->get();
            $queryProducts =DB::connection('sqlsrv3')->table("viewActiveProductWithVatForKFSpecials" )->select('ProductId','PastelCode','PastelDescription','UnitSize','Tax','Cost','QtyInStock','Margin','Alcohol','Available','PurchOrder','PL1','PL2','PL3','PL4','PL5','PL6')->orderBy('PastelDescription','ASC')->distinct()->get();

        return view('dims/kerstonspecials')
                ->with('products',$queryProducts)
                ->with('customers',$queryCustomers);
    }
    public function customerByDateOrContractSpecKF(Request $request)
    {
       
        $contractId = $request->get('contractId');

        $GetCustomerSpecail = DB::connection('sqlsrv3')
            ->select('exec spCustomerSpecialFilter ?',
                array($contractId)
            );
        return response()->json($GetCustomerSpecail);
        //spCustomerSpecialFilter
//SpecialHeaderId
    }
    public function andNewSpecialKF()
    {
        $queryCustomers =DB::connection('sqlsrv3')->table("viewtblCustomers" )->select('CustomerId','StoreName','CustomerPastelCode','CreditLimit','BalanceDue','UserField5','Email','Routeid','Discount','OtherImportantNotes','strRoute')->orderBy('CustomerPastelCode','ASC')->get();
        $queryProducts =DB::connection('sqlsrv3')->table("viewActiveProductWithVatForKFSpecials" )->select('ProductId','PastelCode','PastelDescription','UnitSize','Tax','Cost','QtyInStock','Margin','Alcohol','Available','PurchOrder','PL1','PL2','PL3','PL4','PL5','PL6')->orderBy('PastelDescription','ASC')->distinct()->get();

        return view('dims/add_new_customer_special_kf')
                ->with('products',$queryProducts)
                ->with('customers',$queryCustomers);
    }
    public function getCurrentHistoryCustomerSpecialsKF(Request $request){
        $customerCode = $request->get('customercode');
        $customerid =$request->get('customerId');
        
        $GetCustomerSpecail = DB::connection('sqlsrv3')
        ->select('exec spCustomerSpecialHistoryKF ?,?',
        array($customerCode,$customerid));

        return response()->json($GetCustomerSpecail);
        
    }
    public function getContractsPerCustomerID(Request $request){
        $customerid = $request->get('customerid');
        $getcontracts = DB::connection('sqlsrv3')
        ->select('exec spGetContractsPerCustomerId ?',
        array($customerid));
        
        return response()->json($getcontracts);
    }
     function getContractsPerCustomerIDWithDates(Request $request){
        $customerid = $request->get('customerid');
        $dateFrom =  $request->get('datefrom');
        $dateTo =  $request->get('dateto');
        $dateFrom = (new \DateTime($dateFrom))->format('Y-m-d');
        $dateTo = (new \DateTime($dateTo))->format('Y-m-d');
        
        
        $getcontracts = DB::connection('sqlsrv3')
        ->select('exec spGetContractsPerCustomerId ?,?,?',
        array($customerid,$dateFrom,$dateTo));
  
        
        return response()->json($getcontracts);
    }
}
/*class KerstonSpecialExportController implements FromQuery{
    
}*/