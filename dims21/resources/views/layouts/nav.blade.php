<div class="offcanvas offcanvas-start" tabindex="-1" id="offcanvasExample" aria-labelledby="offcanvasExampleLabel">
    <div class="offcanvas-header"><h2 class="offcanvas-title" id="offcanvasExampleLabel">NAVIGATION - DIMS23</h2>
        <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
    </div>
    <div class="offcanvas-body">
        <ul class="flex-column list-unstyled">

            {{-- Extras --}}
            <li class="mb-1">
                <a href="#" class="dropdown-toggle" role="button" data-bs-toggle="collapse" data-bs-target="#extras" aria-expanded="true" aria-current="true">
                    <span class="fa mi-extras"></span><b>Extras</b>
                </a>
                <div class="collapse" id="extras">
                    <ul class="list-unstyled ps-3 fw-normal pb-1 small">
                        <li>
                            <a href='{!!url("/getAwaitingStockbycustomer")!!}' onclick="window.open(this.href, 'getAwaitingStock','left=20,top=20,width=1250,height=1250,toolbar=1,resizable=0'); return false;"><span class="fa fa-circle-question fa-lg"></span>Awaiting Stock Orders</a>
                        </li>
                        <li>
                            <a href='{!!url("/getAwaitingStock")!!}' onclick="window.open(this.href, 'getAwaitingStock','left=20,top=20,width=1250,height=1250,toolbar=1,resizable=0'); return false;"><span class="fa fa-circle-question fa-lg"></span>Awaiting Stock Products</a>
                        </li>
                        <li>
                            <a href='{!!url("/pickingmain")!!}' onclick="window.open(this.href, 'bulkpicking','left=20,top=20,width=1250,height=1250,toolbar=1,resizable=0'); return false;"><span class="fa fa-circle-question fa-lg"></span>Bulk Picking</a>
                        </li>
    
                        @if($released !="0")
                        <li>
                            <a href='{!!url("/getordertorelease")!!}' onclick="window.open(this.href, 'getordertorelease','left=20,top=20,width=1250,height=1250,toolbar=1,resizable=0'); return false;"><span class="fa fa-circle-question fa-lg"></span>Order Release Screen</a>
                        </li>
                        @endif

                        <li>
                            <a href='{!!url("/stocksheetforstocktake")!!}' onclick="window.open(this.href, 'stocksheetforstocktake','left=20,top=20,width=1250,height=1250,toolbar=1,resizable=0'); return false;" ><span class="fa fa-circle-question fa-lg"></span>Stock Take Sheet</a>
                        </li>
                        <li>
                            <a href='{!!url("/viewproductbydate")!!}' onclick="window.open(this.href, 'viewproductbydate','left=20,top=20,width=1250,height=1250,toolbar=1,resizable=0'); return false;" ><span class="fa fa-circle-question fa-lg"></span>Products By Date</a>
                        </li>
                        
                        <li>
                            <a href='{!!url("/import_excel")!!}' onclick="window.open(this.href, 'pricelistimport','left=20,top=20,width=1250,height=1250,toolbar=1,resizable=0'); return false;" ><span class="fa fa-circle-question fa-lg"></span>DIMS Price List Import</a>
                        </li>
    
                        <li>
                            <a href='{!!url("/andNewSpecialKF")!!}' onclick="window.open(this.href, 'massGrid','left=20,top=20,width=1600,height=800,toolbar=1,resizable=0'); return false;" ><span class="fa fa-circle-question fa-lg"></span>Customer Specials</a>
                        </li>
                        <li>
                            <a href='{!!url("/searchSpecialKF")!!}' onclick="window.open(this.href, 'searchSpecialKF','left=20,top=20,width=1600,height=800,toolbar=1,resizable=0'); return false;" ><span class="fa fa-circle-question fa-lg"></span>Search Customer Specials</a>
                        </li>
                        <li>
                            <a href='{!!url("/stocktakecountspage")!!}'  onclick="window.open(this.href, 'stocktakecountspage','left=20,top=20,width=1800,height=750,toolbar=1,resizable=0'); return false;"><span class="fa fa-circle-question fa-lg"></span>Stock Take Counts Page</a>
                        </li>
                        <li>
                            <a href='{!!url("/stocktakegrid")!!}'  onclick="window.open(this.href, 'stocktakegrid','left=20,top=20,width=1800,height=750,toolbar=1,resizable=0'); return false;"><span class="fa fa-circle-question fa-lg"></span>Stock Take Grid Page</a>
                        </li>
                        <li>
                            <a href='{!!url("/grvgridpage")!!}'  onclick="window.open(this.href, 'grvgridpage','left=20,top=20,width=1800,height=750,toolbar=1,resizable=0'); return false;"><span class="fa fa-circle-question fa-lg"></span>GRV Grid Page</a>
                        </li>
                        <!--li>
                            <a href='{!!url("/massgridspecialscustomer")!!}' onclick="window.open(this.href, 'massGrid','left=20,top=20,width=1600,height=800,toolbar=1,resizable=0'); return false;" ><span class="fa fa-circle-question fa-lg"></span>Mass Customer Specials</a>
                        </li-->
                        <li>
                            <a href='{!!url("/pricelistview")!!}' onclick="window.open(this.href, 'pricelistview','left=20,top=20,width=1600,height=800,toolbar=1,resizable=0'); return false;" ><span class="fa fa-circle-question fa-lg"></span>Price List Information</a>
                        </li>
    
                        @if ($groupspecialAccess != "0")
                        <li>
                            <a href='{!!url("/groupspecials")!!}' onclick="window.open(this.href, 'roupspecials','left=20,top=20,width=1250,height=1250,toolbar=1,resizable=0'); return false;" ><span class="fa fa-circle-question fa-lg"></span>Group Specials</a>
                        </li>
                        @endif
    
                        
                        <li>
                            <a href='{!!url("/combospecials")!!}' onclick="window.open(this.href, 'combospecials','left=20,top=20,width=1250,height=1250,toolbar=1,resizable=0'); return false;" ><span class="fa fa-circle-question fa-lg"></span>POS Combo Specials</a>
                        </li>
    
                        @if($console !="0")
                        <li>
                            <a href='{!!url("/managementSearch")!!}' onclick="window.open(this.href, 'managementSearch','left=20,top=20,width=1500,height=1250,toolbar=1,resizable=0'); return false;" ><span class="fa fa-circle-question fa-lg"></span>Management Console</a>
                        </li>
                        @endif
    
                        <li>
    
                            <a href='{!!url("/getreportLayout")!!}' onclick="window.open(this.href, 'reports','left=20,top=20,width=1500,height=1000,toolbar=1,resizable=0'); return false;" ><span class="fa fa-circle-question fa-lg"></span>Reports</a>
                        </li>
    
                        <li>
                            <a href='{!!url("/customersalespage")!!}' onclick="window.open(this.href, 'salescustomers','left=20,top=20,width=1200,height=950,toolbar=1,resizable=0'); return false;"><span class="fa fa-circle-question fa-lg"></span>Customer Sales</a>
                        </li>
    
                        <li>
                            <a href='{!!url("/getdriverscashoff")!!}' onclick="window.open(this.href, 'getdriverscashoff','left=20,top=20,width=1000,height=950,toolbar=1,resizable=0'); return false;"><span class="fa fa-circle-question fa-lg"></span>Drivers Cashoff</a>
                        </li>
    
                        <li>
                            <a href='{!!url("/viewdailycash")!!}' onclick="window.open(this.href, 'viewdailycash','left=20,top=20,width=1000,height=950,toolbar=1,resizable=0'); return false;"><span class="fa fa-circle-question fa-lg"></span>Daily Sales</a>
                        </li>
    
    
                        @if ($things != "0")
                        <li>
                            <a href='{!!url("/getViewCallLogger")!!}' onclick="window.open(this.href, 'viewdailycash','left=20,top=20,width=1000,height=950,toolbar=1,resizable=0'); return false;"><span class="fa fa-circle-question fa-lg"></span>Call Logger</a>
                        </li>
                        @endif
    
                        <li style="display: none;">
                            <a href='{!!url("/gridPickingSlipCollectios")!!}'  onclick="window.open(this.href, 'gridPickingSlipCollectios','left=20,top=20,width=1500,height=500,toolbar=1,resizable=0'); return false;"><span class="fa fa-circle-question fa-lg"></span>Picking Slips</a>
                        </li>
                        @if(env('APP_STOCK_COUNT_PALLADIUM') =='TRUE')
                        <li>
                            <a href='{!!url("/getPickingDeptPalladium")!!}'  onclick="window.open(this.href, 'getPickingDept','left=20,top=20,width=1800,height=750,toolbar=1,resizable=0'); return false;"><span class="fa fa-circle-question fa-lg"></span>Stock Sheet</a>
                        </li>
                            @else
                            <li>
                                <a href='{!!url("/getPickingDept")!!}'  onclick="window.open(this.href, 'getPickingDept','left=20,top=20,width=1800,height=750,toolbar=1,resizable=0'); return false;"><span class="fa fa-circle-question fa-lg"></span>Stock Sheet</a>
                            </li>
                        @endif
                        @if ($creditreport != "0")
                        <li>
                            <a href='{!!url("/creditNoteReasonsView")!!}'  onclick="window.open(this.href, 'creditNoteReasonsView','left=20,top=20,width=1800,height=750,toolbar=1,resizable=0'); return false;"><span class="fa fa-circle-question fa-lg"></span>Credit Note Report</a>
                        </li>
                        @endif
                        <li>
                            <a href='{!!url("/viewBlockedAccount")!!}'  onclick="window.open(this.href, 'viewBlockedAccount','left=20,top=20,width=1800,height=750,toolbar=1,resizable=0'); return false;"><span class="fa fa-circle-question fa-lg"></span>Blocked Orders</a>
                        </li>
                        <li>
                            <a href='{!!url("/getNoStockItem")!!}'  onclick="window.open(this.href, 'viewBlockedAccount','left=20,top=20,width=1800,height=750,toolbar=1,resizable=0'); return false;"><span class="fa fa-circle-question fa-lg"></span>No Stock Item</a>
                        </li>
                        <li>
                            <a href='{!!url("/viewStatusReport")!!}'  onclick="window.open(this.href, 'viewBlockedAccount','left=20,top=20,width=1800,height=750,toolbar=1,resizable=0'); return false;"><span class="fa fa-circle-question fa-lg"></span>Progress and Status Report</a>
                        </li>
                    </ul>
                </div>
            </li>

            {{-- C-Panel --}}
            <li class="mb-1">
                <a href="#" class="dropdown-toggle" role="button" data-bs-toggle="collapse" data-bs-target="#cpanel" aria-expanded="true" aria-current="true">
                    <span class="fa mi-cpanel"></span><b>C-Panel</b>
                </a>
                <div class="collapse" id="cpanel">
                    <ul class="list-unstyled ps-3 fw-normal pb-1 small">
                        @if($drivers !="0")
                        <li>
                            <a href='{!!url("/driverspage")!!}'  onclick="window.open(this.href, 'driverspage','left=20,top=20,width=1250,height=1250,toolbar=1,resizable=0'); return false;"><span class="fa fa-circle-question fa-lg"></span>Drivers</a>
                        </li>
                        @endif
    
                        <li>
                            <a href='{!!url("/deliveryaddresspage")!!}'  onclick="window.open(this.href, 'deliveryaddresspage','left=20,top=20,width=1250,height=1250,toolbar=1,resizable=0'); return false;"><span class="fa fa-circle-question fa-lg"></span>Delivery Address Editor</a>
                        </li>
                        @if($grid !=0)
                        <li>
                            <a href='{!!url("/grid_Users")!!}'  onclick="window.open(this.href, 'users','left=20,top=20,width=1250,height=1250,toolbar=1,resizable=0'); return false;"><span class="fa fa-circle-question fa-lg"></span>Users</a>
                        </li>
                        @endif
                        @if($transfers !="0")
                        <li>
                            <a href='{!!url("/transfersstatus")!!}'  onclick="window.open(this.href, 'transfersstatus','left=20,top=20,width=1600,height=999,toolbar=1,resizable=0'); return false;"><span class="fa fa-circle-question fa-lg"></span>Transfers </a>
                        </li>
                        @endif
                        @if (  Auth::user()->Administrator ==1)
                        <li>
                            <a href='{!!url("/getorderlocksdeleterpage")!!}' onclick="window.open(this.href, 'getorderlocksdeleterpage','left=20,top=20,width=600,height=900,toolbar=1,resizable=0'); return false;"><span class="fa fa-circle-question fa-lg"></span>Order Locks Deleter</a>
                        </li>
                        @endif
                        <li>
                            <a href='{!!url("/assets")!!}'  onclick="window.open(this.href, 'assets','left=20,top=20,width=1600,height=999,toolbar=1,resizable=0'); return false;"><span class="fa fa-circle-question fa-lg"></span>Assets</a>
                        </li>
                            @if($trucks !="0")
                        <li>
                            <a href='{!!url("/trucks")!!}'  onclick="window.open(this.href, 'trucks','left=20,top=20,width=1250,height=1250,toolbar=1,resizable=0'); return false;"><span class="fa fa-circle-question fa-lg"></span>Trucks</a>
                        </li>
                            @endif
                        @if($routes !="0")
                        <li>
                            <a href='{!!url("/routes1")!!}'  onclick="window.open(this.href, 'routes','left=20,top=20,width=1250,height=1250,toolbar=1,resizable=0'); return false;"><span class="fa fa-circle-question fa-lg"></span>Routes</a>
                        </li>
                        @endif
                        <li>
                            <a href='{!!url("/glcodes")!!}'  onclick="window.open(this.href, 'routes','left=20,top=20,width=1250,height=1250,toolbar=1,resizable=0'); return false;"><span class="fa fa-circle-question fa-lg"></span>GL Codes</a>
                        </li>
                        <li style="display: none;">
                            <a href='{!!url("/usersCrud")!!}'  onclick="window.open(this.href, 'users','left=20,top=20,width=1250,height=1250,toolbar=1,resizable=0'); return false;"><span class="fa fa-circle-question fa-lg"></span>Users</a>
                        </li>
                            @if($ordertypes !="0")
                        <li>
                            <a href='{!!url("/ordertypes")!!}'  onclick="window.open(this.href, 'ordertypes','left=20,top=20,width=1250,height=1250,toolbar=1,resizable=0'); return false;"><span class="fa fa-circle-question fa-lg"></span>Order Types</a>
                        </li>
                            @endif
                        <li>
                            <a href='{!!url("/getuseractionsBydate")!!}'  onclick="window.open(this.href, 'getuseractionsBydate','left=20,top=20,width=1200,height=1000,toolbar=1,resizable=0'); return false;"><span class="fa fa-circle-question fa-lg"></span>User Actions</a>
                        </li>
                            <li>
                            <a href='{!!url("/liveBulkPicking")!!}'  onclick="window.open(this.href, 'liveBulkPicking','left=20,top=20,width=1200,height=1000,toolbar=1,resizable=0'); return false;"><span class="fa fa-circle-question fa-lg"></span>Picking Screen</a>
                        </li>
                        @if($salesperformance !="0")
                        <li>
                            <a href='{!!url("/salesPerformanceview")!!}'  onclick="window.open(this.href, 'telesalesperformance','left=20,top=20,width=1200,height=1000,toolbar=1,resizable=0'); return false;"><span class="fa fa-circle-question fa-lg"></span>Sales Performance</a>
                        </li>
                        @endif
                        @if($creditnotes !=0)
                        <li>
                            <a href='{!!url("/viewCreditLimit")!!}'  onclick="window.open(this.href, 'creditLimitNotes','left=20,top=20,width=1200,height=1000,toolbar=1,resizable=0'); return false;"><span class="fa fa-circle-question fa-lg"></span>Credit Limit Notes</a>
                        </li>
                        @endif
    
                        <li>
                            <a href='{!!url("/getProductsStopedBuying")!!}'  onclick="window.open(this.href, 'getProductsStopedBuying','left=20,top=20,width=1200,height=1000,toolbar=1,resizable=0'); return false;"><span class="fa fa-circle-question fa-lg"></span>Stopped Buying</a>
                        </li>
    
                        <li>
                            <a href='{!!url("/brands")!!}'  onclick="window.open(this.href, 'brands','left=20,top=20,width=1250,height=1250,toolbar=1,resizable=0'); return false;"><span class="fa fa-circle-question fa-lg"></span>Brands</a>
                        </li>
                        <li style="display: none;">
                            <a href='{!!url("/taxes")!!}'  onclick="window.open(this.href, 'taxes','left=20,top=20,width=1250,height=1250,toolbar=1,resizable=0'); return false;"><span class="fa fa-circle-question fa-lg"></span>Taxes</a>
                        </li>
                        <li>
                            <a href='{!!url("/pickingteam")!!}'  onclick="window.open(this.href, 'pickingteam','left=20,top=20,width=1250,height=1250,toolbar=1,resizable=0'); return false;"><span class="fa fa-circle-question fa-lg"></span>Picking Team</a>
                        </li>
                        <li>
                            <a href='{!!url("/groupbrands")!!}'  onclick="window.open(this.href, 'groupbrands','left=20,top=20,width=1250,height=1250,toolbar=1,resizable=0'); return false;"><span class="fa fa-circle-question fa-lg"></span>Group Brands</a>
                        </li>
                            @if($remoteorders !=0)
                        <li>
                            <a href='{!!url("/remoteorders")!!}'  onclick="window.open(this.href, 'webstore','left=20,top=20,width=900,height=900,toolbar=1,resizable=0'); return false;"><span class="fa fa-circle-question fa-lg"></span>Remote Orders</a>
                        </li>
                            @endif
                            @if($briefcase !=0)
                        <li>
                            <a href='{!!url("/missedvisit")!!}'  onclick="window.open(this.href, 'briefcase','left=20,top=20,width=1650,height=900,toolbar=1,resizable=0'); return false;"><span class="fa fa-circle-question fa-lg"></span>Salesman Briefcase</a>
                        </li>
                            @endif
                            @if($loyalty !=0)
                        <li>
                            <a href='{!!url("/registercards")!!}'  onclick="window.open(this.href, 'registercards','left=20,top=20,width=1650,height=900,toolbar=1,resizable=0'); return false;"><span class="fa fa-circle-question fa-lg"></span>Business Loyalty Cards</a>
                        </li>
                        <li>
                            <a href='{!!url("/registercardswalking")!!}'  onclick="window.open(this.href, 'registercardswalking','left=20,top=20,width=1650,height=900,toolbar=1,resizable=0'); return false;"><span class="fa fa-circle-question fa-lg"></span>Personal Loyalty Cards</a>
                        </li>
                            @endif
                        @if($pospanel !=0)
                        <li>
                            <a href='{!!url("/viewassignuserstotill")!!}/{{(new \DateTime())->format('Y-m-d')}}'  onclick="window.open(this.href, 'viewassignuserstotill','left=20,top=20,width=1650,height=900,toolbar=1,resizable=0'); return false;"><span class="fa fa-circle-question fa-lg"></span>POS Panel</a>
                        </li>
                        @endif
    
                        @if($messaging !=0)
                        <li>
                            <a href='http://linxsystems.co.za/Publish/DIMS%20-%20Network%20Messenger/DIMS%20-%20Network%20Messenger.application'  onclick="window.open(this.href, 'messageapp','left=20,top=20,width=500,height=400,toolbar=1,resizable=0'); return false;"><span class="fa fa-circle-question fa-lg"></span>Download Messaging App</a>
                        </li>
                        @endif
                        @if($webstoremassage !=0)
                        <li>
                            <a href='{!!url("/WebstoreMessages")!!}' onclick="window.open(this.href, 'WebstoreMessages','left=20,top=20,width=1000,height=950,toolbar=1,resizable=0'); return false;"><span class="fa fa-circle-question fa-lg"></span>Webstore Messages</a>
                        </li>
                        @endif
                        @if($printeredit !=0)
                        <li>
                            <a href='{!!url("/PathEditor")!!}' onclick="window.open(this.href, 'PathEditor','left=20,top=20,width=1000,height=950,toolbar=1,resizable=0'); return false;"><span class="fa fa-circle-question fa-lg"></span>Edit Printer Paths</a>
                        </li>
                        @endif
                        <li>
                            <a href='{!!url("/viewDeletedOrders")!!}' onclick="window.open(this.href, 'viewDeletedOrders','left=20,top=20,width=1000,height=950,toolbar=1,resizable=0'); return false;"><span class="fa fa-circle-question fa-lg"></span>Deleted Orders</a>
                        </li>
                    </ul>
                </div>
            </li>

            <li>
                <a href='{!!url("/customerflexgrid")!!}' onclick="window.open(this.href, 'customerflexgrid','left=20,top=20,width=1250,height=1250,toolbar=1,resizable=0'); return false;" ><span class="fa mi-customers"></span><b>Customers</b></a>
            </li>

            @if($customerspecials !="0")
            <li>
                <a href='{!!url("/specials")!!}' onclick="window.open(this.href, 'specials','left=20,top=20,width=1250,height=1250,toolbar=1,resizable=0'); return false;" ><span class="fa mi-customerspecials"></span><b>Customer Special</b></a>
            </li>
            @endif

            <li>
                <a href='{!!url("/overallspecials")!!}' onclick="window.open(this.href, 'overallspecials','left=20,top=20,width=1250,height=1250,toolbar=1,resizable=0'); return false;" ><span class="fa mi-overallspecials"></span><b>Overall Specials</b></a>
            </li>

            <li>
                <a href='{!!url("/massProducts")!!}' onclick="window.open(this.href, 'massp','left=20,top=20,width=1250,height=1250,toolbar=1,resizable=0'); return false;" ><span class="fa mi-products"></span><b>Products</b></a>
            </li>

            @if($backorders !="0")
            <li>
                <a href='{!!url("/remoteordersbackorders")!!}'  onclick="window.open(this.href, 'remoteordersbackorders','left=20,top=20,width=900,height=900,toolbar=1,resizable=0'); return false;"><span class="fa mi-backorders"></span><b>Back Orders</b></a>
            </li>
            @endif

            <li>
                <a href='{!!url("/backorders")!!}'  onclick="window.open(this.href, 'backorders','left=20,top=20,width=900,height=900,toolbar=1,resizable=0'); return false;"><span class="fa mi-backorders"></span><b>Back Orders</b></a>
            </li>

            <li>
                <a href='{!!url("/routeplanner")!!}' target="_blank"><span class="fa mi-routeplan"></span><b>Route Plan</b></a>
            </li>

            <li>
                <a href='{!!url("/groups")!!}'  onclick="window.open(this.href, 'groups','left=20,top=20,width=1250,height=1250,toolbar=1,resizable=0'); return false;"><span class="fa mi-groups"></span><b>Groups</b></a>
            </li>

            <li>
                <a href='{!!url("/webstore")!!}'  onclick="window.open(this.href, 'webstore','left=20,top=20,width=900,height=900,toolbar=1,resizable=0'); return false;"><span class="fa mi-webstore"></span><b>Web Store</b></a>
            </li>


        </ul>
    </div>
    
    <div class="d-flex justify-content-center w-100" style="position: absolute; bottom: 0;">
        <img  src="{{url('/images/logo-01.png')}}" style="height: 70px; padding:12px;">
    </div>
</div>