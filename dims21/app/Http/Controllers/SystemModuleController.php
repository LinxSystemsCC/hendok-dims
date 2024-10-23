<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\StoreSystemModuleInfoRequest;


class SystemModuleController extends Controller
{
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
        $systemModulesList = DB::connection('sqlsrv2')->select('EXEC GetSystemModulesListing');

        return response()->json($systemModulesList);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $nameList = DB::connection('sqlsrv2')->table('tblSystemModules')->select('strName','intAutoId')->get();

        return view('system-module.create',compact('nameList')); 
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
            'strName' => $request->get('moduleName'),
            'intParentId' => $request->get('intParentId'),
            'intAutoId' => $request->get('intAutoId'),
            'StatementType' => 'add'
        ];
        DB::connection('sqlsrv2')->statement('
                EXEC dbo.SystemModules
                    @intAutoId = :intAutoId,
	                @intParentsId = :intParentId ,
                    @strName = :strName ,
	                @StatementType = :StatementType
                ',$passData);

        return response()->json(['success' => true]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $nameList = DB::connection('sqlsrv2')->table('tblSystemModules')->select('strName','intAutoId')->get();
        $moduleData = DB::connection('sqlsrv2')->table('tblSystemModules')->where('intAutoId', $id)->first(); 

        return view('system-module.edit', compact('nameList', 'moduleData'));
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
        //dd($request);
        $passData = [
            'strName' => $request->get('moduleName'),
            'intParentId' => $request->get('intParentId'),
            'intAutoId' => $id,
            'StatementType' => 'update'
        ];
        DB::connection('sqlsrv2')->statement('
                EXEC dbo.SystemModules
                    @intAutoId = :intAutoId,
	                @intParentsId = :intParentId ,
                    @strName = :strName ,
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
        DB::connection('sqlsrv2')->statement('EXEC DeleteSystemModule ?', [$id]);
    
        return response()->json(['success' => true]);
    }

}
