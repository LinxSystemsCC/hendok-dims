<?php

namespace App\Http\Controllers;
use App\Http\Controllers\SalesForm;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use \Cache;
use Illuminate\Support\Facades\Auth;

class KerstonSpecialController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
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
        $customerCode = $request->get('customerCode');
        $dateFrom = (new \DateTime($request->get('dateFrom')))->format('Y-m-d') ;
        $dateTo = (new \DateTime($request->get('dateTo')))->format('Y-m-d');
        $contractId = $request->get('contractId');
        $userID = Auth::user()->UserID;

        $GetCustomerSpecail = DB::connection('sqlsrv3')
            ->select('exec spCustomerSpecialFilter ?,?,?,?',
                array($customerCode,$dateFrom,$dateTo,$userID)
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
}