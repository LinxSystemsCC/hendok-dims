<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class UserPermissionsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('userpermissions.index');
    }

    /**
     * This function is use for get permissions list.
     */
    public function getPermissionsList(Request $request, $userid)
    {
        $parentId = $request->get('parent') != '#' ? $request->get('parent') : null;
        $getSystemModulesList = DB::select('EXEC [dbo].[sp_GetPermissionsList] ?, ?', [$parentId, $userid]);
        $formattedData = collect($getSystemModulesList)->map(function ($item) {
            return [
                'id' => $item->ID,
                'text' => $item->name,
                'children' => true,
                'icon' => 'ki-outline ki-abstract-13',
                'state' => ['selected' => $item->isChecked == 1]
            ];
        });

        return response()->json($formattedData);
    }

    /**
     * This function is use for save user permissions.
     */
    public function saveUserPermissions(Request $request, $userid)
    {
        $childIds = $request->input('childIds');
        if (!is_null($request->input('parentIds'))) {
            $parentIds = $request->input('parentIds');
        } else {
            $parentIds = [];
        }
        $childIdsString = implode(',', $childIds);
        $parentIdsString = implode(',', $parentIds);
        DB::statement('EXEC sp_InsertUserPermissionsIfNotExist ?', [$userid]);
        DB::statement('EXEC sp_UpdateUserPermissions ?, ?, ?', [$childIdsString, $parentIdsString, $userid]);

        return response()->json(['success' => true]);
    }

    /**
     * This function is use for allowed permission system modules.
     */
    public function getAllowedPermissionSystemModules($userid)
    {
        $userPermissions = DB::select('EXEC sp_GetAllowedPermissionSystemModules ?', [$userid]);
        $userPermissions = json_decode(json_encode($userPermissions), true);

        return $userPermissions;
    }
}