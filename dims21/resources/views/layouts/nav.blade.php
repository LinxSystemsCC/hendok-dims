<div class="offcanvas offcanvas-start" tabindex="-1" id="offcanvasExample" aria-labelledby="offcanvasExampleLabel">
    <div class="offcanvas-header"><h2 class="offcanvas-title" id="offcanvasExampleLabel">NAVIGATION - DIMS23</h2>
        <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
    </div>
    <div class="offcanvas-body">
        <ul class="flex-column list-unstyled">
            {{-- Extras --}}
            <li class="nav-item dropdown">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
                    <span class="fa fa-archive fa-lg"></span><b>Extras</b>
                </a>
                <ul class="dropdown-menu" >
                    <li>
                        <a href='{!!url("/getAwaitingStockbycustomer")!!}' onclick="window.open(this.href, 'getAwaitingStock','left=20,top=20,width=1250,height=1250,toolbar=1,resizable=0'); return false;">Awaiting Stock Orders</a>
                    </li>
                    <li>
                        <a href='{!!url("/getAwaitingStock")!!}' onclick="window.open(this.href, 'getAwaitingStock','left=20,top=20,width=1250,height=1250,toolbar=1,resizable=0'); return false;">Awaiting Stock Products</a>
                    </li>
                    <li>
                        <a href='{!!url("/pickingmain")!!}' onclick="window.open(this.href, 'bulkpicking','left=20,top=20,width=1250,height=1250,toolbar=1,resizable=0'); return false;">Bulk Picking</a>
                    </li>

                    @if($released !="0")
                    <li>
                        <a href='{!!url("/getordertorelease")!!}' onclick="window.open(this.href, 'getordertorelease','left=20,top=20,width=1250,height=1250,toolbar=1,resizable=0'); return false;">Order Release Screen</a>
                    </li>
                    @endif

                    <li>
                        <a href='{!!url("/customerflexgrid")!!}' onclick="window.open(this.href, 'customerflexgrid','left=20,top=20,width=1250,height=1250,toolbar=1,resizable=0'); return false;" >Customers</a>
                    </li>
                    <li>
                        <a href='{!!url("/massProducts")!!}' onclick="window.open(this.href, 'massp','left=20,top=20,width=1250,height=1250,toolbar=1,resizable=0'); return false;" >Products</a>
                    </li>
                    <li>
                        <a href='{!!url("/stocksheetforstocktake")!!}' onclick="window.open(this.href, 'stocksheetforstocktake','left=20,top=20,width=1250,height=1250,toolbar=1,resizable=0'); return false;" >Stock Take Sheet</a>
                    </li>
                    <li>
                        <a href='{!!url("/viewproductbydate")!!}' onclick="window.open(this.href, 'viewproductbydate','left=20,top=20,width=1250,height=1250,toolbar=1,resizable=0'); return false;" >Products By Date</a>
                    </li>
                    @if($customerspecials !="0")
                    <li>
                        <a href='{!!url("/specials")!!}' onclick="window.open(this.href, 'specials','left=20,top=20,width=1250,height=1250,toolbar=1,resizable=0'); return false;" >Customer Special</a>
                    </li>
                    @endif
                    <li>
                        <a href='{!!url("/import_excel")!!}' onclick="window.open(this.href, 'pricelistimport','left=20,top=20,width=1250,height=1250,toolbar=1,resizable=0'); return false;" >DIMS Price List Import</a>
                    </li>

                    <li>
                        <a href='{!!url("/andNewSpecialKF")!!}' onclick="window.open(this.href, 'massGrid','left=20,top=20,width=1600,height=800,toolbar=1,resizable=0'); return false;" > Customer Specials</a>
                    </li>
                    <li>
                        <a href='{!!url("/searchSpecialKF")!!}' onclick="window.open(this.href, 'searchSpecialKF','left=20,top=20,width=1600,height=800,toolbar=1,resizable=0'); return false;" > Search Customer Specials</a>
                    </li>
                    <li>
                        <a href='{!!url("/stocktakecountspage")!!}'  onclick="window.open(this.href, 'stocktakecountspage','left=20,top=20,width=1800,height=750,toolbar=1,resizable=0'); return false;">Stock Take Counts Page</a>
                    </li>
                    <li>
                        <a href='{!!url("/stocktakegrid")!!}'  onclick="window.open(this.href, 'stocktakegrid','left=20,top=20,width=1800,height=750,toolbar=1,resizable=0'); return false;">Stock Take Grid Page</a>
                    </li>
                    <li>
                        <a href='{!!url("/grvgridpage")!!}'  onclick="window.open(this.href, 'grvgridpage','left=20,top=20,width=1800,height=750,toolbar=1,resizable=0'); return false;">GRV Grid Page</a>
                    </li>
                    <!--li>
                        <a href='{!!url("/massgridspecialscustomer")!!}' onclick="window.open(this.href, 'massGrid','left=20,top=20,width=1600,height=800,toolbar=1,resizable=0'); return false;" >Mass Customer Specials</a>
                    </li-->
                    <li>
                        <a href='{!!url("/pricelistview")!!}' onclick="window.open(this.href, 'pricelistview','left=20,top=20,width=1600,height=800,toolbar=1,resizable=0'); return false;" >Price List Information</a>
                    </li>

                    @if ($groupspecialAccess != "0")
                    <li>
                        <a href='{!!url("/groupspecials")!!}' onclick="window.open(this.href, 'roupspecials','left=20,top=20,width=1250,height=1250,toolbar=1,resizable=0'); return false;" >Group Specials</a>
                    </li>
                    @endif

                    <li>
                        <a href='{!!url("/overallspecials")!!}' onclick="window.open(this.href, 'overallspecials','left=20,top=20,width=1250,height=1250,toolbar=1,resizable=0'); return false;" >Overall Specials</a>
                    </li>
                    <li>
                        <a href='{!!url("/combospecials")!!}' onclick="window.open(this.href, 'combospecials','left=20,top=20,width=1250,height=1250,toolbar=1,resizable=0'); return false;" >POS Combo Specials</a>
                    </li>

                    @if($console !="0")
                    <li>
                        <a href='{!!url("/managementSearch")!!}' onclick="window.open(this.href, 'managementSearch','left=20,top=20,width=1500,height=1250,toolbar=1,resizable=0'); return false;" >Management Console</a>
                    </li>
                    @endif

                    <li>

                        <a href='{!!url("/getreportLayout")!!}' onclick="window.open(this.href, 'reports','left=20,top=20,width=1500,height=1000,toolbar=1,resizable=0'); return false;" >Reports</a>
                    </li>

                    @if($backorders !="0")
                    <li>
                        <a href='{!!url("/remoteordersbackorders")!!}'  onclick="window.open(this.href, 'remoteordersbackorders','left=20,top=20,width=900,height=900,toolbar=1,resizable=0'); return false;">Back Orders</a>
                    </li>
                    @endif

                    <li>
                        <a href='{!!url("/backorders")!!}'  onclick="window.open(this.href, 'backorders','left=20,top=20,width=900,height=900,toolbar=1,resizable=0'); return false;">Back Orders</a>
                    </li>

                    <li>
                        <a href='{!!url("/routeplanner")!!}' target="_blank">Route Plan</a>
                    </li>


                    <li>
                        <a href='{!!url("/customersalespage")!!}' onclick="window.open(this.href, 'salescustomers','left=20,top=20,width=1200,height=950,toolbar=1,resizable=0'); return false;">Customer Sales</a>
                    </li>

                    <li>
                        <a href='{!!url("/getdriverscashoff")!!}' onclick="window.open(this.href, 'getdriverscashoff','left=20,top=20,width=1000,height=950,toolbar=1,resizable=0'); return false;">Drivers Cashoff</a>
                    </li>

                    <li>
                        <a href='{!!url("/viewdailycash")!!}' onclick="window.open(this.href, 'viewdailycash','left=20,top=20,width=1000,height=950,toolbar=1,resizable=0'); return false;">Daily Sales</a>
                    </li>


                    @if ($things != "0")
                    <li>
                        <a href='{!!url("/getViewCallLogger")!!}' onclick="window.open(this.href, 'viewdailycash','left=20,top=20,width=1000,height=950,toolbar=1,resizable=0'); return false;">Call Logger</a>
                    </li>
                    @endif

                    <li style="display: none;">
                        <a href='{!!url("/gridPickingSlipCollectios")!!}'  onclick="window.open(this.href, 'gridPickingSlipCollectios','left=20,top=20,width=1500,height=500,toolbar=1,resizable=0'); return false;">Picking Slips</a>
                    </li>
                    @if(env('APP_STOCK_COUNT_PALLADIUM') =='TRUE')
                    <li>
                        <a href='{!!url("/getPickingDeptPalladium")!!}'  onclick="window.open(this.href, 'getPickingDept','left=20,top=20,width=1800,height=750,toolbar=1,resizable=0'); return false;">Stock Sheet</a>
                    </li>
                        @else
                        <li>
                            <a href='{!!url("/getPickingDept")!!}'  onclick="window.open(this.href, 'getPickingDept','left=20,top=20,width=1800,height=750,toolbar=1,resizable=0'); return false;">Stock Sheet</a>
                        </li>
                    @endif
                    @if ($creditreport != "0")
                    <li>
                        <a href='{!!url("/creditNoteReasonsView")!!}'  onclick="window.open(this.href, 'creditNoteReasonsView','left=20,top=20,width=1800,height=750,toolbar=1,resizable=0'); return false;">Credit Note Report</a>
                    </li>
                    @endif
                    <li>
                        <a href='{!!url("/viewBlockedAccount")!!}'  onclick="window.open(this.href, 'viewBlockedAccount','left=20,top=20,width=1800,height=750,toolbar=1,resizable=0'); return false;">Blocked Orders</a>
                    </li>
                    <li>
                        <a href='{!!url("/getNoStockItem")!!}'  onclick="window.open(this.href, 'viewBlockedAccount','left=20,top=20,width=1800,height=750,toolbar=1,resizable=0'); return false;">No Stock Item</a>
                    </li>
                    <li>
                        <a href='{!!url("/viewStatusReport")!!}'  onclick="window.open(this.href, 'viewBlockedAccount','left=20,top=20,width=1800,height=750,toolbar=1,resizable=0'); return false;">Progress and Status Report</a>
                    </li>
                </ul>
            </li>

            {{-- C-Panel --}}
            <li class="nav-item dropdown d-inline-flex w-100">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
                    <span class="fa fa-columns fa-lg"></span><b>C-Panel</b>
                </a>
                <ul class="dropdown-menu" >

                @if($drivers !="0")
                    <li>
                        <a href='{!!url("/driverspage")!!}'  onclick="window.open(this.href, 'driverspage','left=20,top=20,width=1250,height=1250,toolbar=1,resizable=0'); return false;">Drivers</a>
                    </li>
                    @endif

                    <li>
                        <a href='{!!url("/deliveryaddresspage")!!}'  onclick="window.open(this.href, 'deliveryaddresspage','left=20,top=20,width=1250,height=1250,toolbar=1,resizable=0'); return false;">Delivery Address Editor</a>
                    </li>
                    @if($grid !=0)
                    <li>
                        <a href='{!!url("/grid_Users")!!}'  onclick="window.open(this.href, 'users','left=20,top=20,width=1250,height=1250,toolbar=1,resizable=0'); return false;">Users</a>
                    </li>
                    @endif
                    @if($transfers !="0")
                    <li>
                        <a href='{!!url("/transfersstatus")!!}'  onclick="window.open(this.href, 'transfersstatus','left=20,top=20,width=1600,height=999,toolbar=1,resizable=0'); return false;">Transfers </a>
                    </li>
                    @endif
                    @if (  Auth::user()->Administrator ==1)
                    <li>
                        <a href='{!!url("/getorderlocksdeleterpage")!!}' onclick="window.open(this.href, 'getorderlocksdeleterpage','left=20,top=20,width=600,height=900,toolbar=1,resizable=0'); return false;">Order Locks Deleter</a>
                    </li>
                    @endif
                    <li>
                        <a href='{!!url("/assets")!!}'  onclick="window.open(this.href, 'assets','left=20,top=20,width=1600,height=999,toolbar=1,resizable=0'); return false;">Assets</a>
                    </li>
                        @if($trucks !="0")
                    <li>
                        <a href='{!!url("/trucks")!!}'  onclick="window.open(this.href, 'trucks','left=20,top=20,width=1250,height=1250,toolbar=1,resizable=0'); return false;">Trucks</a>
                    </li>
                        @endif
                    @if($routes !="0")
                    <li>
                        <a href='{!!url("/routes1")!!}'  onclick="window.open(this.href, 'routes','left=20,top=20,width=1250,height=1250,toolbar=1,resizable=0'); return false;">Routes</a>
                    </li>
                    @endif
                    <li>
                        <a href='{!!url("/glcodes")!!}'  onclick="window.open(this.href, 'routes','left=20,top=20,width=1250,height=1250,toolbar=1,resizable=0'); return false;">GL Codes</a>
                    </li>
                    <li style="display: none;">
                        <a href='{!!url("/usersCrud")!!}'  onclick="window.open(this.href, 'users','left=20,top=20,width=1250,height=1250,toolbar=1,resizable=0'); return false;">Users</a>
                    </li>
                        @if($ordertypes !="0")
                    <li>
                        <a href='{!!url("/ordertypes")!!}'  onclick="window.open(this.href, 'ordertypes','left=20,top=20,width=1250,height=1250,toolbar=1,resizable=0'); return false;">Order Types</a>
                    </li>
                        @endif
                    <li>
                        <a href='{!!url("/getuseractionsBydate")!!}'  onclick="window.open(this.href, 'getuseractionsBydate','left=20,top=20,width=1200,height=1000,toolbar=1,resizable=0'); return false;">User Actions</a>
                    </li>
                        <li>
                        <a href='{!!url("/liveBulkPicking")!!}'  onclick="window.open(this.href, 'liveBulkPicking','left=20,top=20,width=1200,height=1000,toolbar=1,resizable=0'); return false;">Picking Screen</a>
                    </li>
                    @if($salesperformance !="0")
                    <li>
                        <a href='{!!url("/salesPerformanceview")!!}'  onclick="window.open(this.href, 'telesalesperformance','left=20,top=20,width=1200,height=1000,toolbar=1,resizable=0'); return false;">Sales Performance</a>
                    </li>
                    @endif
                    @if($creditnotes !=0)
                    <li>
                        <a href='{!!url("/viewCreditLimit")!!}'  onclick="window.open(this.href, 'creditLimitNotes','left=20,top=20,width=1200,height=1000,toolbar=1,resizable=0'); return false;">Credit Limit Notes</a>
                    </li>
                    @endif

                    <li>
                        <a href='{!!url("/getProductsStopedBuying")!!}'  onclick="window.open(this.href, 'getProductsStopedBuying','left=20,top=20,width=1200,height=1000,toolbar=1,resizable=0'); return false;">Stopped Buying</a>
                    </li>

                    <li>
                        <a href='{!!url("/brands")!!}'  onclick="window.open(this.href, 'brands','left=20,top=20,width=1250,height=1250,toolbar=1,resizable=0'); return false;">Brands</a>
                    </li>
                    <li>
                        <a href='{!!url("/groups")!!}'  onclick="window.open(this.href, 'groups','left=20,top=20,width=1250,height=1250,toolbar=1,resizable=0'); return false;">Groups</a>
                    </li>
                    <li style="display: none;">
                        <a href='{!!url("/taxes")!!}'  onclick="window.open(this.href, 'taxes','left=20,top=20,width=1250,height=1250,toolbar=1,resizable=0'); return false;">Taxes</a>
                    </li>
                    <li>
                        <a href='{!!url("/pickingteam")!!}'  onclick="window.open(this.href, 'pickingteam','left=20,top=20,width=1250,height=1250,toolbar=1,resizable=0'); return false;">Picking Team</a>
                    </li>
                    <li>
                        <a href='{!!url("/groupbrands")!!}'  onclick="window.open(this.href, 'groupbrands','left=20,top=20,width=1250,height=1250,toolbar=1,resizable=0'); return false;">Group Brands</a>
                    </li>
                    <li>
                        <a href='{!!url("/webstore")!!}'  onclick="window.open(this.href, 'webstore','left=20,top=20,width=900,height=900,toolbar=1,resizable=0'); return false;">Web Store</a>
                    </li>
                        @if($remoteorders !=0)
                    <li>
                        <a href='{!!url("/remoteorders")!!}'  onclick="window.open(this.href, 'webstore','left=20,top=20,width=900,height=900,toolbar=1,resizable=0'); return false;">Remote Orders</a>
                    </li>
                        @endif
                        @if($briefcase !=0)
                    <li>
                        <a href='{!!url("/missedvisit")!!}'  onclick="window.open(this.href, 'briefcase','left=20,top=20,width=1650,height=900,toolbar=1,resizable=0'); return false;">Salesman Briefcase</a>
                    </li>
                        @endif
                        @if($loyalty !=0)
                    <li>
                        <a href='{!!url("/registercards")!!}'  onclick="window.open(this.href, 'registercards','left=20,top=20,width=1650,height=900,toolbar=1,resizable=0'); return false;">Business Loyalty Cards</a>
                    </li>
                    <li>
                        <a href='{!!url("/registercardswalking")!!}'  onclick="window.open(this.href, 'registercardswalking','left=20,top=20,width=1650,height=900,toolbar=1,resizable=0'); return false;">Personal Loyalty Cards</a>
                    </li>
                        @endif
                    @if($pospanel !=0)
                    <li>
                        <a href='{!!url("/viewassignuserstotill")!!}/{{(new \DateTime())->format('Y-m-d')}}'  onclick="window.open(this.href, 'viewassignuserstotill','left=20,top=20,width=1650,height=900,toolbar=1,resizable=0'); return false;"> POS Panel</a>
                    </li>
                    @endif

                    @if($messaging !=0)
                    <li>
                        <a href='http://linxsystems.co.za/Publish/DIMS%20-%20Network%20Messenger/DIMS%20-%20Network%20Messenger.application'  onclick="window.open(this.href, 'messageapp','left=20,top=20,width=500,height=400,toolbar=1,resizable=0'); return false;">Download Messaging App</a>
                    </li>
                    @endif
                        @if($webstoremassage !=0)
                        <li>
                            <a href='{!!url("/WebstoreMessages")!!}' onclick="window.open(this.href, 'WebstoreMessages','left=20,top=20,width=1000,height=950,toolbar=1,resizable=0'); return false;">Webstore Messages</a>
                        </li>
                        @endif
                        @if($printeredit !=0)
                        <li>
                            <a href='{!!url("/PathEditor")!!}' onclick="window.open(this.href, 'PathEditor','left=20,top=20,width=1000,height=950,toolbar=1,resizable=0'); return false;">Edit Printer Paths</a>
                        </li>
                        @endif
                        <li>
                            <a href='{!!url("/viewDeletedOrders")!!}' onclick="window.open(this.href, 'viewDeletedOrders','left=20,top=20,width=1000,height=950,toolbar=1,resizable=0'); return false;">Deleted Orders</a>
                        </li>

                </ul>
            </li>

            {{-- <li class="nav-item">
                <a class="nav-link active" aria-current="page">
                    <span class="fa fa-bars fa-lg"></span> Dashboard 
                </a>

            </li> --}}
        </ul>
    </div>
    
    <div class="d-flex justify-content-center w-100" style="position: absolute; bottom: 0;">
        <img  src="{{url('/images/logo-01.png')}}" style="height: 70px; padding:12px;">
    </div>
</div>