<?php

function getMenuItems()
{
    $allowedItems = [];
    if (auth()->user()) {
        $v = new \App\Http\Controllers\UserPermissionsController();
        $systemModules = $v->getAllowedPermissionSystemModules(auth()->user()->UserID);
        foreach ($systemModules as $systemModule) {
            $allowedItems[] = $systemModule['strSlug'];
        }
    }

    return [
        [
            'name' => 'Work Orders',
            'icon' => 'fa fa-add',
            'id' => '1',
            'is_allow' => in_array('work-orders', $allowedItems),
            'is_active' => request()->is(['createjobs',
                'getJobStarted',
                'getjobsdata',
                'wmaxlanding',
                'qc1','qc2',
                'wmaxweigh',
                'wmaxreprint',
                'wmaxregrade',
                'wmaxstockchange',
                'wmaxretest',
                'wmaxscrap',
                'galvReport',
                'wire-draw/headers',
                'wire-draw/qcscreen',
                'wire-draw/weight',
                'roofworkorders',
                'roofingReport',
                'roofingReprint',
                'printLabelPage/White Mesh',
                'printLabelPage/Black Mesh',
                '/printLabelPage/Field Fence',
                'printLabelPage/Nails',
                'printLabelPage/C Clips',
                'printLabelPage/Netting',
                'diamondMeshWorkOrders',
                '/printLabelPage/Diamond Mesh',
                'diamondMeshReprint',
                'diamondMeshReport',
                'printLabelPage/Galv Wire',
                'printLabelPage/Razor',
                'productionCapture'
            ]),
            'submenuitems1' => [
                [
                    'name' => 'Barbed Wire',
                    'icon' => 'fa mi-barb',
                    'id' => '1a',
                    'is_allow' => in_array('barbed-wire', $allowedItems),
                    'is_active' => request()->is([
                        'createjobs',
                        'getJobStarted',
                        'getjobsdata'
                    ]),
                    'submenuitems' => [
                        [
                            'name' => 'Create Work Order',
                            'href' => '/createjobs',
                            'is_active' => request()->is('createjobs'),
                            'is_allow' => in_array('barbed-wire-create-work-orders', $allowedItems)
                        ],
                        [
                            'name' => 'Work In Progress',
                            'href' => '/getJobStarted',
                            'is_active' => request()->is('getJobStarted'),
                            'is_allow' => in_array('work-in-progress', $allowedItems),
                        ],
                        [
                            'name' => 'Work Orders Data',
                            'href' => '/getjobsdata',
                            'is_active' => request()->is('getjobsdata'),
                            'is_allow' => in_array('work-orders-data', $allowedItems),
                        ],
                    ],
                ],
                [
                    'name' => 'Galv',
                    'icon' => 'fa mi-galv',
                    'id' => '1b',
                    'is_allow' => in_array('galv', $allowedItems),
                    'is_active' => request()->is(['wmaxlanding',
                        'qc1',
                        'qc2',
                        'wmaxweigh',
                        'wmaxreprint',
                        'wmaxregrade',
                        'wmaxstockchange',
                        'wmaxretest',
                        'wmaxscrap',
                        'galvReport']),
                    'submenuitems' => [
                        [
                            'name' => 'Create Work Orders',
                            'href' => '/wmaxlanding',
                            'is_active' => request()->is('wmaxlanding'),
                            'is_allow' => in_array('work-orders-data-create-work-orders', $allowedItems),
                        ],
                        [
                            'name' => 'QC Phase 1',
                            'href' => '/qc1',
                            'is_active' => request()->is('qc1'),
                            'is_allow' => in_array('qc-phase-1', $allowedItems),
                        ],
                        [
                            'name' => 'QC Phase 2',
                            'href' => '/qc2',
                            'is_active' => request()->is('qc2'),
                            'is_allow' => in_array('qc-phase-2', $allowedItems),
                        ],
                        [
                            'name' => 'Weigh',
                            'href' => '/wmaxweigh',
                            'is_active' => request()->is('wmaxweigh'),
                            'is_allow' => in_array('galv-weigh', $allowedItems),
                        ],
                        [
                            'name' => 'Re-Print',
                            'href' => '/wmaxreprint',
                            'is_active' => request()->is('wmaxreprint'),
                            'is_allow' => in_array('re-print', $allowedItems),
                        ],
                        [
                            'name' => 'Regrade',
                            'href' => '/wmaxregrade',
                            'is_active' => request()->is('wmaxregrade'),
                            'is_allow' => in_array('regrade', $allowedItems),
                        ],
                        [
                            'name' => 'Stock Change',
                            'href' => '/wmaxstockchange',
                            'is_active' => request()->is('wmaxstockchange'),
                            'is_allow' => in_array('stock-change', $allowedItems),
                        ],
                        [
                            'name' => 'Retest',
                            'href' => '/wmaxretest',
                            'is_active' => request()->is('wmaxretest'),
                            'is_allow' => in_array('retest', $allowedItems),
                        ],
                        [
                            'name' => 'Scrap Weigh',
                            'href' => '/wmaxscrap',
                            'is_active' => request()->is('wmaxscrap'),
                            'is_allow' => in_array('scrap-weigh', $allowedItems),
                        ],
                        [
                            'name' => 'QC Report',
                            'href' => '/galvReport',
                            'is_active' => request()->is('galvReport'),
                            'is_allow' => in_array('qc-report', $allowedItems),
                        ],
                    ],
                ],
                [
                    'name' => 'Wire Draw',
                    'icon' => 'fa mi-roof',
                    'id' => '1m',
                    'is_allow' => in_array('wire-draw', $allowedItems),
                    'is_active' => request()->is(['wire-draw/headers',
                        'wire-draw/qcscreen',
                        'wire-draw/weight',]),
                    'submenuitems' => [
                        [
                            'name' => 'Headers',
                            'href' => '/wire-draw/headers',
                            'is_active' => request()->is('wire-draw/headers'),
                            'is_allow' => in_array('headers', $allowedItems),
                        ],
                        [
                            'name' => 'QC Phase',
                            'href' => '/wire-draw/qcscreen',
                            'is_active' => request()->is('wire-draw/qcscreen'),
                            'is_allow' => in_array('qc-phase', $allowedItems),
                        ],
                        [
                            'name' => 'Weigh',
                            'href' => '/wire-draw/weight',
                            'is_active' => request()->is('wire-draw/weight'),
                            'is_allow' => in_array('wire-draw-weigh', $allowedItems),
                        ],
                    ],
                ],
                [
                    'name' => 'Roofing',
                    'icon' => 'fa mi-roof',
                    'id' => '1c',
                    'is_allow' => in_array('roofing', $allowedItems),
                    'is_active' => request()->is(['roofworkorders',
                        'roofingReport',
                        'roofingReprint',]),
                    'submenuitems' => [
                        [
                            'name' => 'Create Work Orders',
                            'href' => '/roofworkorders',
                            'is_active' => request()->is('roofworkorders'),
                            'is_allow' => in_array('roofing-create-work-orders', $allowedItems),
                        ],
                        [
                            'name' => 'Roofing Report',
                            'href' => '/roofingReport',
                            'is_active' => request()->is('roofingReport'),
                            'is_allow' => in_array('roofing-create-work-orders', $allowedItems),
                        ],
                        [
                            'name' => 'Reprint Label',
                            'href' => '/roofingReprint',
                            'is_active' => request()->is('roofingReprint'),
                            'is_allow' => in_array('roofing-reprint-label', $allowedItems),
                        ],
                    ],
                ],
                [
                    'name' => 'White Mesh',
                    'icon' => 'fa mi-wire',
                    'id' => '1d',
                    'is_active' => request()->is('printLabelPage/White Mesh'),
                    'is_allow' => in_array('white-mesh', $allowedItems),
                    'submenuitems' => [
                        [
                            'name' => 'Print Label',
                            'href' => '/printLabelPage/White Mesh',
                            'is_active' => request()->is('printLabelPage/White Mesh'),
                            'is_allow' => in_array('print-label', $allowedItems), 
                        ],
                    ],
                ],
                [
                    'name' => 'Black Mesh',
                    'icon' => 'fa mi-wire',
                    'id' => '1e',
                    'is_active' => request()->is('printLabelPage/Black Mesh'),
                    'is_allow' => in_array('black-mesh', $allowedItems),
                    'submenuitems' => [
                        [
                            'name' => 'Print Label',
                            'href' => '/printLabelPage/Black Mesh',
                            'is_active' => request()->is('printLabelPage/White Mesh'),
                            'is_allow' => in_array('print-label', $allowedItems),
                        ],
                    ],
                ],
                [
                    'name' => 'Field Fence',
                    'icon' => 'fa mi-wireFence',
                    'id' => '1f',
                    'is_active' => request()->is('/printLabelPage/Field Fence'),
                    'is_allow' => in_array('field-fence', $allowedItems),
                    'submenuitems' => [
                        [
                            'name' => 'Print Label',
                            'href' => '/printLabelPage/Field Fence',
                            'is_active' => request()->is('/printLabelPage/Field Fence'),
                            'is_allow' => in_array('print-label', $allowedItems),
                        ],
                    ],
                ],
                [
                    'name' => 'Nails',
                    'icon' => 'fa mi-nails',
                    'id' => '1g',
                    'is_active' => request()->is('printLabelPage/Nails'),
                    'is_allow' => in_array('nails', $allowedItems),
                    'submenuitems' => [
                        [
                            'name' => 'Print Label',
                            'href' => '/printLabelPage/Nails',
                            'is_active' => request()->is('printLabelPage/Nails'),
                            'is_allow' => in_array('print-label', $allowedItems),
                        ],
                    ],
                ],
                [
                    'name' => 'C Clips',
                    'icon' => 'fa mi-clips',
                    'id' => '1i',
                    'is_active' => request()->is('printLabelPage/C Clips'),
                    'is_allow' => in_array('c-clips', $allowedItems),
                    'submenuitems' => [
                        [
                            'name' => 'Print Label',
                            'href' => '/printLabelPage/C Clips',
                            'is_allow' => in_array('c-clipsprint-label', $allowedItems),
                            'is_active' => request()->is('printLabelPage/C Clips'),
                        ],
                    ],
                ],
                [
                    'name' => 'Netting',
                    'icon' => 'fa mi-clips',
                    'id' => '1j',
                    'is_active' => request()->is('printLabelPage/Netting'),
                    'is_allow' => in_array('netting', $allowedItems),
                    'submenuitems' => [
                        [
                            'name' => 'Print Label',
                            'href' => '/printLabelPage/Netting',
                            'is_active' => request()->is('printLabelPage/Netting'),
                            'is_allow' => in_array('print-label', $allowedItems),
                        ],
                    ],
                ],
                [
                    'name' => 'Diamond Mesh',
                    'icon' => 'fa mi-wire',
                    'id' => '1k',
                    'is_active' => request()->is(['diamondMeshWorkOrders','diamondMeshReprint','diamondMeshReport','/printLabelPage/Diamond Mesh']),
                    'is_allow' => in_array('diamond-mesh', $allowedItems),
                    'submenuitems' => [
                        [
                            'name' => 'Create Work Orders',
                            'href' => '/diamondMeshWorkOrders',
                            'is_active' => request()->is('diamondMeshWorkOrders'),
                            'is_allow' => in_array('diamond-mesh-create-work-orders', $allowedItems),
                        ],
                        [
                            'name' => 'Print Label',
                            'href' => '/printLabelPage/Diamond Mesh',
                            'is_active' => request()->is('/printLabelPage/Diamond Mesh'),
                            'is_allow' => in_array('diamond-mesh-print-label', $allowedItems),
                        ],
                        [
                            'name' => 'Reprint Label',
                            'href' => '/diamondMeshReprint',
                            'is_active' => request()->is('diamondMeshReprint'),
                            'is_allow' => in_array('diamond-mesh-reprint-label', $allowedItems),
                        ],
                        [
                            'name' => 'Diamond Mesh Report',
                            'href' => '/diamondMeshReport',
                            'is_active' => request()->is('diamondMeshReport'),
                            'is_allow' => in_array('diamond-mesh-report', $allowedItems),
                        ],
                    ],
                ],
                [
                    'name' => 'Galv Wire',
                    'icon' => 'fa mi-barb',
                    'id' => '1l',
                    'is_active' => request()->is('printLabelPage/Galv Wire'),
                    'is_allow' => in_array('galv-wire', $allowedItems),
                    'submenuitems' => [
                        [
                            'name' => 'Print Label',
                            'href' => '/printLabelPage/Galv Wire',
                            'is_active' => request()->is('printLabelPage/Galv Wire'),
                            'is_allow' => in_array('galv-wire-print-label', $allowedItems),
                        ],
                    ],
                ],
                [
                    'name' => 'Razor Wire',
                    'icon' => 'fa mi-barb',
                    'id' => '1m',
                    'is_allow' => in_array('razor-wire', $allowedItems),
                    'is_active' => request()->is('printLabelPage/Razor'),
                    'submenuitems' => [
                        [
                            'name' => 'Print Label',
                            'href' => '/printLabelPage/Razor',
                            'is_active' => request()->is('printLabelPage/Razor'),
                            'is_allow' => in_array('razor-wire-print-label', $allowedItems),
                        ],
                    ],
                ],
                [
                    'name' => 'Production Capture',
                    'href' => '/productionCapture',
                    'id' => '4c',
                    'is_active' => request()->is('productionCapture'),
                    'is_allow' => in_array('production-capture', $allowedItems),
                ],
            ],
        ],
        [
            'name' => 'Dispatch',
            'icon' => 'fa fa-truck',
            'id' => '2',
            'is_allow' => in_array('dispatch', $allowedItems),
            'is_active' => request()->is(['customergridlookup',
                'pickingPlanner',
                'viewAwaitingtoinvoice',
                'liveBulkPicking',
                'viewpickingtickets',
                'loadTracking'
            ]),
            'submenuitems1' => [
                [
                    'name' => 'Customer Grid Lookup',
                    'href' => '/customergridlookup',
                    'is_active' => request()->is('customergridlookup'),
                    'is_allow' => in_array('customer-grid-lookup', $allowedItems),
                ],
                [
                    'name' => 'Load Planning',
                    'id' => '2a',
                    'is_allow' => in_array('load-planning', $allowedItems),
                    'is_active' => request()->is(['pickingPlanner','viewAwaitingtoinvoice']),
                    'submenuitems' => [
                        [
                            'name' => 'Picking Planner',
                            'href' => '/pickingPlanner',
                            'is_active' => request()->is('pickingPlanner'),
                            'is_allow' => in_array('picking-planner', $allowedItems),
                        ],
                        [
                            'name' => 'Routes To Invoice',
                            'href' => '/viewAwaitingtoinvoice',
                            'is_active' => request()->is('viewAwaitingtoinvoice'),
                            'is_allow' => in_array('routes-to-invoice', $allowedItems),
                        ],
                    ],
                ],
                [
                    'name' => 'Loading',
                    'id' => '2b',
                    'is_allow' => in_array('loading', $allowedItems),
                    'is_active' => request()->is(['liveBulkPicking', 'viewpickingtickets', 'loadTracking']),
                    'submenuitems' => [
                        [
                            'name' => 'Picking Status',
                            'href' => '/liveBulkPicking',
                            'is_active' => request()->is('liveBulkPicking'),
                            'is_allow' => in_array('picking-status', $allowedItems),
                        ],
                        [
                            'name' => 'Truck Loading',
                            'href' => '/viewpickingtickets',
                            'is_active' => request()->is('viewpickingtickets'),
                            'is_allow' => in_array('truck-loading', $allowedItems), 
                        ],
                        [
                            'name' => 'Truck Load Tracker',
                            'href' => '/loadTracking',
                            'is_active' => request()->is('loadTracking'),
                            'is_allow' => in_array('truck-load-tracker', $allowedItems), 
                        ],
                    ],
                ],
            ],
        ],
        [
            'name' => 'Stock Control',
            'icon' => 'fa fa-line-chart',
            'id' => '3',
            'is_allow' => in_array('stock-control', $allowedItems), 
            'is_active' => request()->is(['getUpliftmentPage', 'issuestock', 'ibt']),
            'submenuitems1' => [
                [
                    'name' => 'Returns',
                    'id' => '3b',
                    'is_allow' => in_array('returns', $allowedItems), 
                    'submenuitems' => [
                        [
                            'name' => '1',
                            'is_allow' => in_array(1, $allowedItems), 
                        ],
                        [
                            'name' => '2',
                            'is_allow' => in_array(2, $allowedItems),
                        ],
                    ],
                ],
                [
                    'name' => 'Upliftment Vouchers',
                    'id' => '3c',
                    'is_active' => request()->is(['getUpliftmentPage', 'issuestock']),
                    'is_allow' => in_array('upliftment-vouchers', $allowedItems),
                    'submenuitems' => [
                        [
                            'name' => 'Upliftments',
                            'href' => '/getUpliftmentPage',
                            'is_active' => request()->is('getUpliftmentPage'),
                            'is_allow' => in_array('upliftments', $allowedItems), 
                        ],
                    ],
                ],
                [
                    'name' => 'Stock Issue',
                    'href' => '/issuestock',
                    'icon' => 'fa fa-line-chart',
                    'is_active' => request()->is('issuestock'),
                    'is_allow' => in_array('stock-issue', $allowedItems),
                ],
                [
                    'name' => 'IBT',
                    'href' => '/ibt',
                    'icon' => 'fa fa-line-chart',
                    'is_active' => request()->is('ibt'),
                    'is_allow' => in_array('ibt', $allowedItems),
                ],
            ],
        ],
        [
            'name' => 'Inventory',
            'icon' => 'fa fa-archive',
            'id' => '4',
            'is_allow' => in_array('inventory', $allowedItems),
            'is_active' => request()->is([
                'exceptionmovementreport',
                'stockLocation',
                'recievingwarehousereport',
                'galvmodulecomms'
            ]),
            'submenuitems1' => [
                [
                    'name' => 'Stock on Hand',
                    'id' => '4a',
                    'is_active' => request()->is('stockLocation'),
                    'is_allow' => in_array('stock-on-hand', $allowedItems),
                    'submenuitems' => [
                        [
                            'name' => 'Stock Location',
                            'href' => '/stockLocation',
                            'is_active' => request()->is('stockLocation'),
                            'is_allow' => in_array('stock-location', $allowedItems),
                        ],
                    ],
                ],
                [
                    'name' => 'Stock Count',
                    'id' => '4b',
                    'is_active' => request()->is('exceptionmovementreport'),
                    'is_allow' => in_array('stock-count', $allowedItems),
                    'submenuitems' => [
                        [
                            'name' => 'Exception Movement Report',
                            'href' => '/exceptionmovementreport',
                            'is_active' => request()->is('exceptionmovementreport'),
                            'is_allow' => in_array('exception-movement-report', $allowedItems),
                        ],
                    ],
                ],
                [
                    'name' => 'Recieving Movement',
                    'href' => '/recievingwarehousereport',
                    'is_active' => request()->is('recievingwarehousereport'),
                    'is_allow' => in_array('recieving-movement', $allowedItems),
                ],
                [
                    'name' => 'Galv Module Logs',
                    'href' => '/galvmodulecomms',
                    'is_active' => request()->is('galvmodulecomms'),
                    'is_allow' => in_array('galv-module-logs', $allowedItems),
                ],
            ],
        ],
        [
            'name' => 'Setup',
            'icon' => 'fa fa-cog',
            'id' => '5',
            'is_allow' => in_array('setup', $allowedItems),
            'is_active' => request()->is([
                'creategrouppage',
                'createuserpage',
                'modifyuserleaderpage',
                'drivers',
                'trucks',
                'routes1',
                'departmentpage',
                'subDepartments',
                'machines',
                'bulkMapping',
                'nailsInner',
                'createPalletConfig',
                'LocationsAndBins',
                'labelspage',
                'mapitemsmachinesdept',
                'labelmapping',
                'galvcustomer',
                'galvProducts',
                'wire-draw/customers',
                'wire-draw/products',
                '/wire-draw/rod-supplier',
                'wire-draw/stands',
                'galvscale',
                'galvcreateprodspec',
                'galveditprodspec',
                'stockIssueTypes',
                'syncing',
                'areapage',
                'system-modules'
            ]),
            'submenuitems1' => [
                [
                    'name' => 'Users/Groups',
                    'id' => '5a',
                    'is_allow' => in_array('usersgroups', $allowedItems),
                    'is_active' => request()->is(['creategrouppage', 'createuserpage', 'modifyuserleaderpage']),
                    'submenuitems' => [
                        [
                            'name' => 'Groups',
                            'href' => '/creategrouppage',
                            'is_active' => request()->is('creategrouppage'),
                            'is_allow' => in_array('groups', $allowedItems), 
                        ],
                        [
                            'name' => 'Users',
                            'href' => '/createuserpage',
                            'is_active' => request()->is('createuserpage'),
                            'is_allow' => in_array('user', $allowedItems),
                        ],
                        [
                            'name' => 'Leaders',
                            'href' => '/modifyuserleaderpage',
                            'is_active' => request()->is('modifyuserleaderpage'),
                            'is_allow' => in_array('leaders', $allowedItems),
                        ],
                    ],
                ],
                [
                    'name' => 'Dispatch',
                    'id' => '5b',
                    'is_allow' => in_array('setup-dispatch', $allowedItems),
                    'is_active' => request()->is(['drivers', 'trucks', 'routes1']),
                    'submenuitems' => [
                        [
                            'name' => 'Drivers',
                            'href' => '/drivers',
                            'is_active' => request()->is('drivers'),
                            'is_allow' => in_array('drivers', $allowedItems),
                        ],
                        [
                            'name' => 'Trucks',
                            'href' => '/trucks',
                            'is_active' => request()->is('trucks'),
                            'is_allow' => in_array('trucks', $allowedItems),
                        ],
                        [
                            'name' => 'Routes',
                            'href' => '/routes1',
                            'is_active' => request()->is('routes1'),
                            'is_allow' => in_array('routes', $allowedItems),
                        ],
                    ],
                ],
                [
                    'name' => 'Work Orders',
                    'id' => '5c',
                    'is_allow' => in_array('setup-work-orders', $allowedItems),
                    'is_active' => request()->is([
                        'areapage',
                        'departmentpage',
                        'subDepartments',
                        'machines',
                        'bulkMapping',
                        'nailsInner',
                        'createPalletConfig',
                        'LocationsAndBins',
                        'labelspage',
                        'mapitemsmachinesdept',
                        'labelmapping',
                        'galvcustomer',
                        'galvProducts',
                        'wire-draw/customers',
                        'wire-draw/products',
                        '/wire-draw/rod-supplier',
                        'wire-draw/stands',
                        'galvscale',
                        'galvcreateprodspec',
                        'galveditprodspec',
                        'stockIssueTypes',
                        'syncing',
                        'system-modules'
                    ]),
                    'submenuitems' => [
                        [
                            'name' => 'Areas',
                            'href' => '/areapage',
                            'is_allow' => in_array('areas', $allowedItems),
                            'is_active' => request()->is('areapage')
                        ],
                        [
                            'name' => 'Departments',
                            'href' => '/departmentpage',
                            'is_allow' => in_array('departments', $allowedItems),
                            'is_active' => request()->is('departmentpage')
                        ],
                        [
                            'name' => 'Sub-Departments',
                            'href' => '/subDepartments',
                            'is_allow' => in_array('sub-departments', $allowedItems),
                            'is_active' => request()->is('subDepartments')
                        ],
                        [
                            'name' => 'Machines',
                            'href' => '/machines',
                            'is_allow' => in_array('machines', $allowedItems),
                            'is_active' => request()->is('machines')
                        ],
                        [
                            'name' => 'Bulk Mapping',
                            'href' => '/bulkMapping',
                            'is_allow' => in_array('bulk-mapping', $allowedItems),
                            'is_active' => request()->is('bulkMapping')
                        ],
                        [
                            'name' => 'Nails Inner',
                            'href' => '/nailsInner',
                            'is_allow' => in_array('nails-inner', $allowedItems),
                            'is_active' => request()->is('nailsInner')
                        ],
                        [
                            'name' => 'Pallet Configurations',
                            'href' => '/createPalletConfig',
                            'is_allow' => in_array('pallet-configurations', $allowedItems),
                            'is_active' => request()->is('createPalletConfig')
                        ],
                        [
                            'name' => 'Locations & Bins',
                            'href' => '/LocationsAndBins',
                            'is_allow' => in_array('locations-bins', $allowedItems),
                            'is_active' => request()->is('LocationsAndBins')
                        ],
                        [
                            'name' => 'Labels',
                            'href' => '/labelspage',
                            'is_allow' => in_array('labels', $allowedItems),
                            'is_active' => request()->is('labelspage')
                        ],
                        [
                            'name' => 'Map Product To Machine',
                            'href' => '/mapitemsmachinesdept',
                            'is_allow' => in_array('map-product-to-machine', $allowedItems),
                            'is_active' => request()->is('mapitemsmachinesdept')
                        ],
                        [
                            'name' => 'Map Label to Product Category',
                            'href' => '/labelmapping',
                            'is_allow' => in_array('map-label-to-product-category', $allowedItems),
                            'is_active' => request()->is('labelmapping')
                        ],
                        [
                            'name' => 'Galv Customers',
                            'href' => '/galvcustomer',
                            'is_allow' => in_array('galv-customers', $allowedItems),
                            'is_active' => request()->is('galvcustomer')
                        ],
                        [
                            'name' => 'Galv Products',
                            'href' => '/galvProducts',
                            'is_allow' => in_array('galv-products', $allowedItems),
                            'is_active' => request()->is('galvProducts')
                        ],
                        [
                            'name' => 'Wire Draw Customers',
                            'href' => '/wire-draw/customers',
                            'is_allow' => in_array('wire-draw-customers', $allowedItems),
                            'is_active' => request()->is('wire-draw/customers')
                        ],
                        [
                            'name' => 'Wire Draw Products',
                            'href' => '/wire-draw/products',
                            'is_allow' => in_array('wire-draw-products', $allowedItems),
                            'is_active' => request()->is('wire-draw/products')
                        ],
                        [
                            'name' => 'Wire Draw Rod Supplier',
                            'href' => '/wire-draw/rod-supplier',
                            'is_allow' => in_array('wire-draw-rod-supplier', $allowedItems),
                            'is_active' => request()->is('/wire-draw/rod-supplier')
                        ],
                        [
                            'name' => 'Stands',
                            'href' => '/wire-draw/stands',
                            'is_allow' => in_array('stands', $allowedItems),
                            'is_active' => request()->is('wire-draw/stands')
                        ],
                        [
                            'name' => 'Scales',
                            'href' => '/galvscale',
                            'is_allow' => in_array('scales', $allowedItems),
                            'is_active' => request()->is('galvscale')
                        ],
                        [
                            'name' => 'Create Galv Product Spec',
                            'href' => '/galvcreateprodspec',
                            'is_allow' => in_array('create-galv-product-spec', $allowedItems),
                            'is_active' => request()->is('galvcreateprodspec')
                        ],
                        [
                            'name' => 'Edit Galv Product Spec',
                            'href' => '/galveditprodspec',
                            'is_allow' => in_array('create-galv-product-spec', $allowedItems),
                            'is_active' => request()->is('galveditprodspec')
                        ],
                        [
                            'name' => 'Stock Issue Types',
                            'href' => '/stockIssueTypes',
                            'is_allow' => in_array('stock-issue-types', $allowedItems),
                            'is_active' => request()->is('stockIssueTypes')
                        ],
                    ],
                ],
                [
                    'name' => 'Data Syncing',
                    'href' => '/syncing',
                    'is_allow' => in_array('data-syncing', $allowedItems),
                    'is_active' => request()->is('syncing')
                ],
                [
                    'name' => 'System Modules',
                    'href' => '/system-modules',
                    'is_allow' => in_array('system-modules', $allowedItems),
                    'is_active' => request()->is('system-modules')
                ],
            ],
        ],
        [
            'name' => 'Print Pallet Labels',
            'href' => '/printpalletsselectdept',
            'icon' => 'fa mi-pallet',
            'is_allow' => in_array('print-pallet-labels', $allowedItems),
            'is_active' => request()->is('printpalletsselectdept'),
        ],
        [
            'name' => 'Product Label Printing',
            'href' => '/genericproductlabels',
            'icon' => 'fa mi-coil',
            'is_allow' => in_array('product-label-printing', $allowedItems),
            'is_active' => request()->is('genericproductlabels'),
        ],
        [
            'name' => 'Warehouse Printing',
            'href' => '/warehousepalletlabels',
            'icon' => 'fa mi-warehouse',
            'is_allow' => in_array('warehouse-printing', $allowedItems),
            'is_active' => request()->is('warehousepalletlabels'),
        ],
    ];
}