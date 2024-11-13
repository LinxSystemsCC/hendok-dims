<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use App\Http\Requests\StoreSystemModuleInfoRequest;
use App\Traits\UtilityTrait;

class SystemModuleController extends Controller
{
    use UtilityTrait;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('system-module.index');
    }

     /**
     * This function is use for get System Modules list
     */
    public function getSystemModules()
    {
        $systemModulesList = DB::connection('sqlsrv2')
            ->select('EXEC sp_GetSystemModulesListing');

        return response()->json($systemModulesList);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $parentSystemModules = DB::connection('sqlsrv2')
            ->table('tblSystemModules')
            ->select('strName','intAutoId')
            ->get();

        return view('system-module.create', compact('parentSystemModules'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreSystemModuleInfoRequest $request)
    {
        $passData = [
            'strName' => $request->get('strName'),
            'intParentId' => $request->get('intParentId'),
            'intAutoId' => $request->get('intAutoId'),
            'strSlug' => $this->createSlug($request->get('strName')),
            'StatementType' => 'add'
        ];
        DB::connection('sqlsrv2')->statement('
            EXEC dbo.sp_SystemModules
                @intAutoId = :intAutoId,
                @intParentId = :intParentId ,
                @strName = :strName ,
                @strSlug = :strSlug,
                @StatementType = :StatementType
            ',$passData);

        return response()->json(['success' => true]);
    }
    
    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $parentSystemModules = DB::connection('sqlsrv2')
            ->table('tblSystemModules')
            ->select('strName','intAutoId')
            ->get();

        $systemModule = DB::connection('sqlsrv2')
            ->table('tblSystemModules')
            ->where('intAutoId', $id)
            ->first(); 

        return view('system-module.edit', compact('parentSystemModules', 'systemModule'));
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(StoreSystemModuleInfoRequest $request, $id)
    {
        $passData = [
            'strName' => $request->get('strName'),
            'intParentId' => $request->get('intParentId'),
            'intAutoId' => $id,
            'strSlug' => '',
            'StatementType' => 'update'
        ];
        DB::connection('sqlsrv2')->statement('
            EXEC dbo.sp_SystemModules
                @intAutoId = :intAutoId,
                @intParentId = :intParentId ,
                @strName = :strName,
                @strSlug = :strSlug,
                @StatementType = :StatementType
            ',$passData);

        return response()->json(['success' => true]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        DB::connection('sqlsrv2')->statement('EXEC sp_DeleteSystemModule ?', [$id]);

        return response()->json(['success' => true]);
    }
}