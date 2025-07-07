<?php
/**
 * Created by PhpStorm.
 * User: Reginald
 * Date: 28/07/2017
 * Time: 03:54 PM
 */

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;

class UserFeature  extends Controller
{
    public function getDimsUsers()
    {
        $users = DB::connection('sqlsrv3')->table('tblDIMSUSERS')->select('UserID', 'UserName','Password', 'Administrator')->orderBy('UserName', 'asc')->get();
        return response()->json($users);
    }

   public function indexNew()
    {
        $data = DB::connection('sqlsrv2')->select('EXEC usp_R_GetEmailReportRecipients');
        $types = DB::connection('sqlsrv2')->select('EXEC GetAllEmailType');
        $users = DB::connection('sqlsrv2')->select('EXEC usp_R_GetDIMSUsers');

        return view('warehouse.ibt.indexnew', compact('data', 'types', 'users'));
    }

    public function getAll()
    {
        $data = DB::connection('sqlsrv2')->select('EXEC usp_R_GetEmailReportRecipients');
        return response()->json($data);
    }

    public function getUsers()
    {
        $users = DB::connection('sqlsrv2')->select('EXEC usp_R_GetDIMSUsers');
        return response()->json($users);
    }

    public function storeNew(Request $request)
    {
        $request->validate([
            'strType' => 'required|string',
            'intUserId' => 'required|integer',
            'strEmail' => 'required|email',
        ]);

        DB::connection('sqlsrv2')->statement('EXEC usp_C_EmailReportRecipient ?, ?, ?', [
            $request->input('strType'),
            $request->input('intUserId'),
            $request->input('strEmail')
        ]);

        return response()->json(['success' => true]);
    }

    public function fetch()
    {
        $data = DB::connection('sqlsrv2')->select('EXEC usp_R_GetEmailReportRecipients');
        return response()->json($data);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'strType' => 'required|string',
            'intUserId' => 'required|integer',
            'strEmail' => 'required|email',
        ]);

        DB::connection('sqlsrv2')->statement('EXEC usp_U_EmailReportRecipient ?, ?, ?, ?', [
            $id,
            $request->input('strType'),
            $request->input('intUserId'),
            $request->input('strEmail')
        ]);

        return response()->json(['success' => true]);
    }

    public function destroy($id)
    {
        DB::connection('sqlsrv2')->statement('EXEC usp_D_EmailReportRecipient ?', [$id]);
        return response()->json(['success' => true]);
    }

    public function getEmailTypes()
    {
        $types = DB::connection('sqlsrv2')->select('EXEC GetAllEmailType');
        return response()->json($types);
    }

    //Ending here
}
