<?php



namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use \Cache;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\SalesForm;
class MachinesAndTransfers extends Controller
{
    public function viewTransfersCrRec(){
        return view('dims/machinestransferlanding');
    }
    public function createTransfer(){
        
        $getMachines= DB::connection('sqlsrv3')
            ->select("select * from tblMachines ORDER BY strMachineName");
        return view('dims/createTransfer')->with('machines',$getMachines);
    }
    
    public function saveTransfer(Request $request){
        
        $UserId = Auth::user()->UserID;
        $UserName = Auth::user()->UserName;

                $machine = $request->get('machine');
                $prodcode = $request->get('prodcode');
                $linenumber = $request->get('linenumber');
                $qty = $request->get('qty');

                    $qrcode = $machine.";".$prodcode.";".$qty.";".$linenumber.";".$UserId.";".$UserName;

                        $getcommitorder = DB::connection('sqlsrv3')
                            ->select('exec spInsertTranfer ?,?,?,?,?,?,?',
                                array($qrcode,$UserId,$UserName,$qty,$linenumber,$machine,$prodcode)
                             );
    }
    public function receiveTransfer(){
        return view('dims/receiveTransfer');
    }
}