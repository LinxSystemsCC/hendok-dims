<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Traits\UtilityTrait;

class UserPermissionsSeeder extends Seeder
{
    use UtilityTrait;
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $userPermissions = [
            [
                'strName' => 'Work Orders',
                'intParentId' => null,
                'StatementType' => 'add',
                'intAutoId' => 1,
            ],
            [
                'strName' => 'Barbed Wire',
                'intParentId' => 1,
                'StatementType' => 'add',
                'intAutoId' => 2,
            ],
            [
                'strName' => 'Barbed Wire Create Work Orders',
                'intParentId' => 2,
                'StatementType' => 'add',
                'intAutoId' => 3,
            ],
            [
                'strName' => 'Work In Progress',
                'intParentId' => 2,
                'StatementType' => 'add',
                'intAutoId' => 4,
            ],
            [
                'strName' => 'Work Orders Data',
                'intParentId' => 2,
                'StatementType' => 'add',
                'intAutoId' => 5,
            ],
            [
                'strName' => 'Galv',
                'intParentId' => 1,
                'StatementType' => 'add',
                'intAutoId' => 6,
            ],
            [
                'strName' => 'Work Orders Data Create Work Orders',
                'intParentId' => 6,
                'StatementType' => 'add',
                'intAutoId' => 7,
            ],
            [
                'strName' => 'QC Phase 1',
                'intParentId' => 6,
                'StatementType' => 'add',
                'intAutoId' => 8,
            ],
            [
                'strName' => 'QC Phase 2',
                'intParentId' => 6,
                'StatementType' => 'add',
                'intAutoId' => 9,
            ],
            [
                'strName' => 'Galv Weigh',
                'intParentId' => 6,
                'StatementType' => 'add',
                'intAutoId' => 10,
            ],
            [
                'strName' => 'Re-Print',
                'intParentId' => 6,
                'StatementType' => 'add',
                'intAutoId' => 11,
            ],
            [
                'strName' => 'Regrade',
                'intParentId' => 6,
                'StatementType' => 'add',
                'intAutoId' => 12,
            ],
            [
                'strName' => 'Stock Change',
                'intParentId' => 6,
                'StatementType' => 'add',
                'intAutoId' => 13,
            ],
            [
                'strName' => 'Retest',
                'intParentId' => 6,
                'StatementType' => 'add',
                'intAutoId' => 14,
            ],
            [
                'strName' => 'Scrap Weigh',
                'intParentId' => 6,
                'StatementType' => 'add',
                'intAutoId' => 15,
            ],
            [
                'strName' => 'QC Report',
                'intParentId' => 6,
                'StatementType' => 'add',
                'intAutoId' => 16,
            ],
            [
                'strName' => 'Wire Draw',
                'intParentId' => 1,
                'StatementType' => 'add',
                'intAutoId' => 17,
            ],
            [
                'strName' => 'Headers',
                'intParentId' => 17,
                'StatementType' => 'add',
                'intAutoId' => 18,
            ],
            [
                'strName' => 'QC Phase',
                'intParentId' => 17,
                'StatementType' => 'add',
                'intAutoId' => 19,
            ],
            [
                'strName' => 'Wire Draw Weigh',
                'intParentId' => 17,
                'StatementType' => 'add',
                'intAutoId' => 20,
            ],
            [
                'strName' => 'Roofing',
                'intParentId' => 1,
                'StatementType' => 'add',
                'intAutoId' => 21,
            ],
            [
                'strName' => 'Roofing Create Work Orders',
                'intParentId' => 21,
                'StatementType' => 'add',
                'intAutoId' => 22,
            ],
            [
                'strName' => 'Roofing Report',
                'intParentId' => 21,
                'StatementType' => 'add',
                'intAutoId' => 23,
            ],
            [
                'strName' => 'Roofing Reprint Label',
                'intParentId' => 21,
                'StatementType' => 'add',
                'intAutoId' => 24,
            ],
            [
                'strName' => 'White Mesh',
                'intParentId' => 1,
                'StatementType' => 'add',
                'intAutoId' => 25,
            ],
            [
                'strName' => 'White Mesh Print Label',
                'intParentId' => 25,
                'StatementType' => 'add',
                'intAutoId' => 26,
            ],
            [
                'strName' => 'Black Mesh',
                'intParentId' => 25,
                'StatementType' => 'add',
                'intAutoId' => 27,
            ],
            [
                'strName' => 'Field Fence',
                'intParentId' => 1,
                'StatementType' => 'add',
                'intAutoId' => 28,
            ],
            [
                'strName' => 'Field Fence Print Label',
                'intParentId' => 28,
                'StatementType' => 'add',
                'intAutoId' => 29,
            ],
            [
                'strName' => 'Nails',
                'intParentId' => 1,
                'StatementType' => 'add',
                'intAutoId' => 30,
            ],
            [
                'strName' => 'Nails Print Label',
                'intParentId' => 30,
                'StatementType' => 'add',
                'intAutoId' => 31,
            ],
            [
                'strName' => 'C Clips',
                'intParentId' => 1,
                'StatementType' => 'add',
                'intAutoId' => 32,
            ],
            [
                'strName' => 'C Clips Print Label',
                'intParentId' => 32,
                'StatementType' => 'add',
                'intAutoId' => 33,
            ],
            [
                'strName' => 'Netting',
                'intParentId' => 1,
                'StatementType' => 'add',
                'intAutoId' => 34,
            ],
            [
                'strName' => 'Netting Print Label',
                'intParentId' => 34,
                'StatementType' => 'add',
                'intAutoId' => 35,
            ],
            [
                'strName' => 'Diamond Mesh',
                'intParentId' => 1,
                'StatementType' => 'add',
                'intAutoId' => 36,
            ],
            [
                'strName' => 'Diamond Mesh Create Work Orders',
                'intParentId' => 36,
                'StatementType' => 'add',
                'intAutoId' => 37,
            ],
            [
                'strName' => 'Diamond Mesh Print Label',
                'intParentId' => 36,
                'StatementType' => 'add',
                'intAutoId' => 38,
            ],
            [
                'strName' => 'Diamond Mesh Reprint Label',
                'intParentId' => 36,
                'StatementType' => 'add',
                'intAutoId' => 39,
            ],
            [
                'strName' => 'Diamond Mesh Report',
                'intParentId' => 36,
                'StatementType' => 'add',
                'intAutoId' => 40,
            ],
            [
                'strName' => 'Galv Wire',
                'intParentId' => 1,
                'StatementType' => 'add',
                'intAutoId' => 41,
            ],
            [
                'strName' => 'Galv Wire Print Label',
                'intParentId' => 41,
                'StatementType' => 'add',
                'intAutoId' => 42,
            ],
            [
                'strName' => 'Razor Wire',
                'intParentId' => 1,
                'StatementType' => 'add',
                'intAutoId' => 43,
            ],
            [
                'strName' => 'Razor Wire Print Label',
                'intParentId' => 43,
                'StatementType' => 'add',
                'intAutoId' => 44,
            ],
            [
                'strName' => 'Production Capture',
                'intParentId' => 1,
                'StatementType' => 'add',
                'intAutoId' => 45,
            ],
            [
                'strName' => 'Dispatch',
                'intParentId' => null,
                'StatementType' => 'add',
                'intAutoId' => 46,
            ],
            [
                'strName' => 'Customer Grid Lookup',
                'intParentId' => 46,
                'StatementType' => 'add',
                'intAutoId' => 47,
            ],
            [
                'strName' => 'Load Planning',
                'intParentId' => 46,
                'StatementType' => 'add',
                'intAutoId' => 48,
            ],
            [
                'strName' => 'Picking Planner',
                'intParentId' => 48,
                'StatementType' => 'add',
                'intAutoId' => 49,
            ],
            [
                'strName' => 'Routes To Invoice',
                'intParentId' => 48,
                'StatementType' => 'add',
                'intAutoId' => 50,
            ],
            [
                'strName' => 'Loading',
                'intParentId' => 46,
                'StatementType' => 'add',
                'intAutoId' => 51,
            ],
            [
                'strName' => 'Picking Status',
                'intParentId' => 51,
                'StatementType' => 'add',
                'intAutoId' => 52,
            ],
            [
                'strName' => 'Truck Loading',
                'intParentId' => 51,
                'StatementType' => 'add',
                'intAutoId' => 53,
            ],
            [
                'strName' => 'Truck Load Tracker',
                'intParentId' => 51,
                'StatementType' => 'add',
                'intAutoId' => 54,
            ],
            [
                'strName' => 'Stock Control',
                'intParentId' => null,
                'StatementType' => 'add',
                'intAutoId' => 55,
            ],
            [
                'strName' => 'Returns',
                'intParentId' => 55,
                'StatementType' => 'add',
                'intAutoId' => 56,
            ],
            [
                'strName' => '1',
                'intParentId' => 56,
                'StatementType' => 'add',
                'intAutoId' => 57,
            ],
            [
                'strName' => '2',
                'intParentId' => 56,
                'StatementType' => 'add',
                'intAutoId' => 58,
            ],
            [
                'strName' => 'Upliftment Vouchers',
                'intParentId' => 55,
                'StatementType' => 'add',
                'intAutoId' => 59,
            ],
            [
                'strName' => 'Upliftments',
                'intParentId' => 59,
                'StatementType' => 'add',
                'intAutoId' => 60,
            ],
            [
                'strName' => 'Stock Issue',
                'intParentId' => 55,
                'StatementType' => 'add',
                'intAutoId' => 61,
            ],
            [
                'strName' => 'IBT',
                'intParentId' => 55,
                'StatementType' => 'add',
                'intAutoId' => 62,
            ],
            [
                'strName' => 'Inventory',
                'intParentId' => null,
                'StatementType' => 'add',
                'intAutoId' => 63,
            ],
            [
                'strName' => 'Stock on Hand',
                'intParentId' => 63,
                'StatementType' => 'add',
                'intAutoId' => 64,
            ],
            [
                'strName' => 'Stock Location',
                'intParentId' => 64,
                'StatementType' => 'add',
                'intAutoId' => 65,
            ],
            [
                'strName' => 'Stock Count',
                'intParentId' => 63,
                'StatementType' => 'add',
                'intAutoId' => 66,
            ],
            [
                'strName' => 'Exception Movement Report',
                'intParentId' => 66,
                'StatementType' => 'add',
                'intAutoId' => 67,
            ],
            [
                'strName' => 'Recieving Movement',
                'intParentId' => 63,
                'StatementType' => 'add',
                'intAutoId' => 68,
            ],
            [
                'strName' => 'Galv Module Logs',
                'intParentId' => 63,
                'StatementType' => 'add',
                'intAutoId' => 69,
            ],
            [
                'strName' => 'Setup',
                'intParentId' => null,
                'StatementType' => 'add',
                'intAutoId' => 70,
            ],
            [
                'strName' => 'Users/Groups',
                'intParentId' => 70,
                'StatementType' => 'add',
                'intAutoId' => 71,
            ],
            [
                'strName' => 'User',
                'intParentId' => 70,
                'StatementType' => 'add',
                'intAutoId' => 72,
            ],
            [
                'strName' => 'Groups',
                'intParentId' => 71,
                'StatementType' => 'add',
                'intAutoId' => 73,
            ],
            [
                'strName' => 'Users',
                'intParentId' => 71,
                'StatementType' => 'add',
                'intAutoId' => 74,
            ],
            [
                'strName' => 'Leaders',
                'intParentId' => 71,
                'StatementType' => 'add',
                'intAutoId' => 75,
            ],
            [
                'strName' => 'Setup Dispatch',
                'intParentId' => 70,
                'StatementType' => 'add',
                'intAutoId' => 76,
            ],
            [
                'strName' => 'Drivers',
                'intParentId' => 75,
                'StatementType' => 'add',
                'intAutoId' => 77,
            ],
            [
                'strName' => 'Trucks',
                'intParentId' => 75,
                'StatementType' => 'add',
                'intAutoId' => 78,
            ],
            [
                'strName' => 'Routes',
                'intParentId' => 75,
                'StatementType' => 'add',
                'intAutoId' => 79,
            ],
            [
                'strName' => 'Setup Work Orders',
                'intParentId' => 70,
                'StatementType' => 'add',
                'intAutoId' => 80,
            ],
            [
                'strName' => 'Areas',
                'intParentId' => 79,
                'StatementType' => 'add',
                'intAutoId' => 81,
            ],
            [
                'strName' => 'Departments',
                'intParentId' => 79,
                'StatementType' => 'add',
                'intAutoId' => 82,
            ],
            [
                'strName' => 'Sub-Departments',
                'intParentId' => 79,
                'StatementType' => 'add',
                'intAutoId' => 83,
            ],
            [
                'strName' => 'Machines',
                'intParentId' => 79,
                'StatementType' => 'add',
                'intAutoId' => 84,
            ],
            [
                'strName' => 'Bulk Mapping',
                'intParentId' => 79,
                'StatementType' => 'add',
                'intAutoId' => 85,
            ],
            [
                'strName' => 'Nails Inner',
                'intParentId' => 79,
                'StatementType' => 'add',
                'intAutoId' => 86,
            ],
            [
                'strName' => 'Pallet Configurations',
                'intParentId' => 79,
                'StatementType' => 'add',
                'intAutoId' => 87,
            ],
            [
                'strName' => 'Locations & Bins',
                'intParentId' => 79,
                'StatementType' => 'add',
                'intAutoId' => 88,
            ],
            [
                'strName' => 'Labels',
                'intParentId' => 79,
                'StatementType' => 'add',
                'intAutoId' => 89,
            ],
            [
                'strName' => 'Map Product To Machine',
                'intParentId' => 79,
                'StatementType' => 'add',
                'intAutoId' => 90,
            ],
            [
                'strName' => 'Map Label to Product Category',
                'intParentId' => 79,
                'StatementType' => 'add',
                'intAutoId' => 91,
            ],
            [
                'strName' => 'Galv Customers',
                'intParentId' => 79,
                'StatementType' => 'add',
                'intAutoId' => 92,
            ],
            [
                'strName' => 'Galv Products',
                'intParentId' => 79,
                'StatementType' => 'add',
                'intAutoId' => 93,
            ],
            [
                'strName' => 'Wire Draw Customers',
                'intParentId' => 79,
                'StatementType' => 'add',
                'intAutoId' => 94,
            ],
            [
                'strName' => 'Wire Draw Products',
                'intParentId' => 79,
                'StatementType' => 'add',
                'intAutoId' => 95,
            ],
            [
                'strName' => 'Wire Draw Rod Supplier',
                'intParentId' => 79,
                'StatementType' => 'add',
                'intAutoId' => 96,
            ],
            [
                'strName' => 'Stands',
                'intParentId' => 79,
                'StatementType' => 'add',
                'intAutoId' => 97,
            ],
            [
                'strName' => 'Scales',
                'intParentId' => 79,
                'StatementType' => 'add',
                'intAutoId' => 98,
            ],
            [
                'strName' => 'Create Galv Product Spec',
                'intParentId' => 79,
                'StatementType' => 'add',
                'intAutoId' => 99,
            ],
            [
                'strName' => 'Edit Galv Product Spec',
                'intParentId' => 79,
                'StatementType' => 'add',
                'intAutoId' => 100,
            ],
            [
                'strName' => 'Stock Issue Types',
                'intParentId' => 79,
                'StatementType' => 'add',
                'intAutoId' => 101,
            ],
            [
                'strName' => 'Data Syncing',
                'intParentId' => 70,
                'StatementType' => 'add',
                'intAutoId' => 102,
            ],
            [
                'strName' => 'system-modules',
                'intParentId' => 70,
                'StatementType' => 'add',
                'intAutoId' => 103,
            ],
            [
                'strName' => 'Print Pallet Labels',
                'intParentId' => null,
                'StatementType' => 'add',
                'intAutoId' => 104,
            ],
            [
                'strName' => 'Product Label Printing',
                'intParentId' => null,
                'StatementType' => 'add',
                'intAutoId' => 105,
            ],
            [
                'strName' => 'Warehouse Printing',
                'intParentId' => null,
                'StatementType' => 'add',
                'intAutoId' => 106,
            ],
        ];

        // Loop through each permission
        foreach ($userPermissions as $userPermission) {
            $userPermission['slug'] = $this->createSlug($userPermission['strName']);
            DB::connection('sqlsrv2')->statement(
                '
                EXEC dbo.sp_SystemModules
                    @intAutoId = :intAutoId,
                    @intParentId = :intParentId,
                    @strName = :strName,
                    @strSlug = :slug,
                    @StatementType = :StatementType
            ',
                $userPermission,
            );
        }

        DB::connection('sqlsrv2')->statement(
            "
                UPDATE tblSystemModules
                SET strName = 'Print Label'
                WHERE strName = 'C Clips Print Label'
        
                UPDATE tblSystemModules
                SET strName = 'Create Work Orders'
                WHERE strName = 'Work Orders Data Create Work Orders'
        
                UPDATE tblSystemModules
                SET strName = 'Create Work Orders'
                WHERE strName = 'Diamond Mesh Create Work Orders'
        
                UPDATE tblSystemModules
                SET strName = 'Print Label'
                WHERE strName = 'Diamond Mesh Print Label'
        
                UPDATE tblSystemModules
                SET strName = 'Mesh Report'
                WHERE strName = 'Diamond Mesh Report'
        
                UPDATE tblSystemModules
                SET strName = 'Reprint Label'
                WHERE strName = 'Diamond Mesh Reprint Label'
        
                UPDATE tblSystemModules
                SET strName = 'Razor Wire Print Label'
                WHERE strName = 'Print Label'

                UPDATE tblSystemModules
                SET strName = 'Print Label'
                WHERE strName = 'Galv Wire Print Label'
        
                UPDATE tblSystemModules
                SET strName = 'Weigh'
                WHERE strName = 'Galv Weigh'
        
                UPDATE tblSystemModules
                SET strName = 'Print Label'
                WHERE strName = 'Field Fence Print Label'
        
                UPDATE tblSystemModules
                SET strName = 'Reprint Label'
                WHERE strName = 'Roofing Reprint Label'
        
                UPDATE tblSystemModules
                SET strName = 'Print Label'
                WHERE strName = 'White Mesh Print Label'
                
                UPDATE tblSystemModules
                SET strName = 'Print Label'
                WHERE strName = 'Nails Print Label'
        
                UPDATE tblSystemModules
                SET strName = 'Print Label'
                WHERE strName = 'Netting Print Label'
                
                UPDATE tblSystemModules
                SET strName = 'Dispatch'
                WHERE strName = 'Setup Dispatch'
        
                UPDATE tblSystemModules
                SET strName = 'Work Orders'
                WHERE strName = 'Setup Work Orders'
                
                UPDATE tblSystemModules
                SET strName = 'Work Orders'
                WHERE strName = 'Roofing Create Work Orders'

                UPDATE tblSystemModules
                SET strName = 'Weigh'
                WHERE strName = 'Wire Draw Weigh'

                UPDATE tblSystemModules
                SET strName = 'Create Work Orders'
                WHERE strName = 'Barbed Wire Create Work Orders'
            ",
        );
    }
}
