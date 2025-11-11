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
    public function index($userid)
    {
        // 1️⃣ Get all permissions for the user
        $records = DB::select('EXEC [dbo].[sp_GetPermissionsList] ?', [$userid]);

        // 2️⃣ Convert to PHP array
        $modules = collect($records)->map(function ($r) {
            return [
                'id'        => $r->ID,
                'text'      => $r->name,
                'parent_id' => $r->parentId,
                'checked'   => (bool)$r->isChecked,
            ];
        })->toArray();

        // 3️⃣ Recursive tree builder (N-level)
        $buildTree = function ($parentId = null) use (&$buildTree, $modules) {
            $branch = [];
            foreach ($modules as $m) {
                if ($m['parent_id'] == $parentId) {
                    $children = $buildTree($m['id']);
                    $branch[] = [
                        'id'       => $m['id'],
                        'text'     => $m['text'],
                        'icon'     => 'ki-outline ki-abstract-13',
                        'state'    => [
                            'selected' => $m['checked'],
                            'opened'   => false // collapse all by default
                        ],
                        'children' => !empty($children) ? $children : [],
                    ];
                }
            }
            return $branch;
        };

        $treeData = $buildTree();

        // 4️⃣ Pass tree JSON to Blade
        return view('userpermissions.index', [
            'userid'   => $userid,
            'treeData' => json_encode($treeData, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES),
        ]);
    }

    public function getPermissionsList(Request $request, $userid)
    {
        // 1️⃣  Fetch all modules in one go
        $records = DB::select('EXEC [dbo].[sp_GetPermissionsList] ?', [$userid]);

        // 2️⃣  Convert to a convenient array
        $modules = collect($records)->map(function ($r) {
            return [
                'id'        => $r->ID,
                'text'      => $r->name,
                'parent_id' => $r->parentId,
                'checked'   => (bool)$r->isChecked,
            ];
        })->toArray();

        // 3️⃣  Recursive tree builder
        $buildTree = function ($parentId = null) use (&$buildTree, $modules) {
            $branch = [];
            foreach ($modules as $m) {
                if ($m['parent_id'] == $parentId) {
                    $children = $buildTree($m['id']);
                    $branch[] = [
                        'id'       => $m['id'],
                        'text'     => $m['text'],
                        'icon'     => 'ki-outline ki-abstract-13',
                        'state'    => ['selected' => $m['checked']],
                        'children' => !empty($children) ? $children : false,
                    ];
                }
            }
            return $branch;
        };

        // 4️⃣  Build top-level tree
        $tree = $buildTree();

        // 5️⃣  Return ready-to-use jsTree JSON
        return response()->json($tree);
    }

    /**
     * This function is use for save user permissions.
     */
    public function saveUserPermissions(Request $request, $userid)
    {
        $permissionIds = $request->input('permissionIds', []);

        // Convert array to comma-separated string for stored procedure
        $idsString = implode(',', $permissionIds);

        // Call simplified stored procedure
        DB::statement('EXEC sp_UpdateUserPermissionsSimple ?, ?', [$idsString, $userid]);

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