<?php

use App\Http\Controllers\SalesForm;
use App\Http\Controllers\TabletLoadingApp;
use App\Http\Controllers\ArtificialCrud;
use App\Http\Controllers\RecentRegistered;
use App\Http\Controllers\DimsCommon;
use App\Http\Controllers\DriversController;
use App\Http\Controllers\MachinesAndTransfers;
use App\Http\Controllers\SalesFormFunctions;
use App\Http\Controllers\ApisContoller;
use App\Http\Controllers\OnlineOrders;
use App\Http\Controllers\ConsoleManagement;
use App\Http\Controllers\InvoicingController;
use App\Http\Controllers\UsersController;
use App\Http\Controllers\WareHouseController;
use App\Http\Controllers\WireDraw\WireDrawHeadersController;
use App\Http\Controllers\WireDraw\WireDrawqcscreenController;
use App\Http\Controllers\WireDraw\WireDrawStandsController;
use App\Http\Controllers\WireDraw\WireDrawWireDrawRodSupplierController;
use App\Http\Controllers\WireDraw\WireDrawWireDrawWeightController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\UserFeature;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\PDFController;
use App\Http\Controllers\Warehouse\GalvController;
use App\Http\Controllers\Warehouse\WarehouseSetupController;
use App\Http\Controllers\Warehouse\ProductionController;
use App\Http\Controllers\Warehouse\LoadingController;
use App\Http\Controllers\Warehouse\StockControlController;
use App\Http\Controllers\ApisController;
use App\Http\Controllers\Warehouse\StockTakeController;
use App\Http\Controllers\Warehouse\DiamondMeshController;
use App\Http\Controllers\Warehouse\RoofingController;
use App\Http\Controllers\WireDraw\WireDrawCustomersController;
use App\Http\Controllers\WireDraw\WireDrawProductsController;
use App\Http\Controllers\Warehouse\PlanningController;
use App\Http\Controllers\IbtController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
/*
Route::get('/', function () {
    return view('welcome');
});*/


Route::get('/', [WareHouseController::class,'dashboard']);
Route::post('getLiveDriversInfo', [ExternalFunctions::class, 'getLiveDriversInfo'] );
Auth::routes();

//Route::get('/home', 'SalesForm@index')->name('home');
// Route::get('home/',[SalesForm::class, 'index'])->name('home');
Route::get('home',[WareHouseController::class,'dashboard'])->name('home');
Route::get('sales',[SalesForm::class, 'index']);
Route::get('selectedCompany/{companyid}',[SalesForm::class, 'selectedCompany']);//STEEL
Route::get('pl', [SalesForm::class,'pl']);
Route::get('returns',[SalesForm::class,'returns']);
Route::get('getProductsStopedBuyingJSon',[SalesForm::class,'getProductsStopedBuyingJSon']);
Route::get('getProductsStopedBuying',[SalesForm::class,'getProductsStopedBuying'] );
Route::get('getCustomerStoppedBuyingJSon',[SalesForm::class,'getCustomerStoppedBuyingJSon'] );
Route::get('getCustomerStoppedBuying',[SalesForm::class,'getCustomerStoppedBuying']);
Route::get('/getCustomers', [SalesForm::class,'getCustomers']);
Route::get('/prod', [SalesForm::class,'getProducts']);
Route::get('ordersreport', [SalesForm::class,'ordersreport']);
Route::get('getOrdersreportinfo/{date1}/{date2}',[SalesForm::class,'getOrdersreportinfo']);
Route::get('/registered', [RecentRegistered::class,'index'])->name('registered');
Route::post('/updatecart', [ArtificialCrud::class,'updateCart']);
Route::post('/updatereordering',[ArtificialCrud::class,'updatereordering'] );
Route::post('/emptyCart', [ArtificialCrud::class,'deleteCartItems']);
Route::post('/cartreorderingremoveitem', [ArtificialCrud::class,'deleteReorderingItems']);
Route::get('/invoiceXXX/{invoiceno}/{type}',[ArtificialCrud::class,'invoiceDetails']);
Route::post('/reordering/', [ArtificialCrud::class,'reorderBasedOnSelectedInvoice']);
Route::get('/incompletOrders', [IncompletOrders::class,'incompletOrders']);
Route::get('testPhpgrid', [RecentRegistered::class,'testPhpgrid']);
Route::get('instocksheet',[RecentRegistered::class,'instocksheet']);


//Route::post('ItemSearchCreate', 'ItemSearchController@create');
Route::resource('shop', 'HomeController', ['only' => ['show']]);
Route::resource('cart', 'CartController');

Route::get('custCode',[SalesFormFunctions::class, 'CustomerCode']);
Route::get('getExportForm', [DimsExportController::class,'getExportForm']);
Route::get('getDimsUsers', [UserFeature::class,'getDimsUsers']);

//MACHINESANDTRANSFERS STARTS HERE!!!!
Route::get('viewTransfersCrRec',[MachinesAndTransfers::class,'viewTransfersCrRec']);
Route::get('createTransfer',[MachinesAndTransfers::class,'createTransfer']);
Route::post('saveTransfer',[MachinesAndTransfers::class,'saveTransfer']);
Route::get('receiveTransfer',[MachinesAndTransfers::class,'receiveTransfer']);

//MACHINESANDTRANSFERS ENDS HERE!!!!

//DIMS COMMON STARTS HERE!!!!
Route::get('getCommonRoutes', [DimsCommon::class,'getCommonRoutes']);
Route::get('PointGrid', [DimsCommon::class,'PointGrid']);
Route::get('customerPointsTrends', [DimsCommon::class,'customerPointsTrends']);
Route::get('cardsList', [DimsCommon::class,'cardsList']);
Route::get('getCartsGrid', [DimsCommon::class,'getCartsGrid']);
Route::get('getPointGrid', [DimsCommon::class,'getPointGrid']);
Route::post('increasePoints',[DimsCommon::class,'increasePoints'] );
Route::post('updatecustomerwebstoreinfo',[DimsCommon::class,'updatecustomerwebstoreinfo'] );
Route::get('viewStatusReport', 'DimsCommon@viewStatusRepoRoute::post(\'deletecard\', \'DimsCommon@deletecard\');
rt');
Route::get('getConsolidatedStatsReport', [DimsCommon::class,'getConsolidatedStatsReport']);
Route::get('massCustomer', [DimsCommon::class,'massCustomer']);
Route::get('massProducts', [DimsCommon::class,'massProducts']);
Route::get('getCostsPerdate',[DimsCommon::class,'getCostsPerdate']);
Route::get('viewdailycash',[DimsCommon::class,'viewdailycash']);
Route::get('viewDeletedOrders',[DimsCommon::class,'viewDeletedOrders'] );
Route::get('deleteordersJson/{datefrom}/{dateto}', [DimsCommon::class,'deleteordersJson']);
Route::get('customersalesperiod/{datefrom}/{dateto}', [DimsCommon::class,'customersalesperiod']);
Route::get('getdailycash/{datefrom}/{dateTo}',[DimsCommon::class,'getdailycash'] );
Route::get('customersalesperiodwebpage', [DimsCommon::class,'customersalesperiodwebpage']);
Route::get('advancedcustomerspecials',[DimsCommon::class,'advancedcustomerspecials'] );
Route::get('advancedcustomerspecialsJson',[DimsCommon::class,'advancedcustomerspecialsJson'] );
Route::post('masscustomerdatatable', [DimsCommon::class,'masscustomerdatatable'] );
Route::post('massproductdatatable',[DimsCommon::class,'massproductdatatable']);
Route::post('customerOrderListingHeader',[DimsCommon::class,'customerOrderListingHeader']);
Route::post('credentialsmatch', [DimsCommon::class,'credentialsmatch']);
Route::post('getAvailable', [DimsCommon::class,'getAvailable']);
Route::post('clearorderlocksperorder', [DimsCommon::class,'clearorderlocksperorder'] );
Route::get('massCustomerUpdate/{custId}', [DimsCommon::class,'massCustomerUpdate'] );
Route::get('customerorderpattern/{custId}',[DimsCommon::class,'customerorderpattern'] );
Route::get('spGetCostsPerDate/{date1}/{date2}', [DimsCommon::class,'spGetCostsPerDate'] );
Route::post('deletepatternline', [DimsCommon::class,'deletepatternline'] );
Route::get('getDeliveryDate', [DimsCommon::class,'getDeliveryDate']);
Route::get('dimsAdminUsers',[DimsCommon::class,'dimsAdminUsers']);
Route::post('restFullOrderLock',[DimsCommon::class,'restFullOrderLock']);
Route::post('restFullUnLockOrder', [DimsCommon::class,'restFullUnLockOrder']);
Route::post('deleteuserOrderLocks',[DimsCommon::class,'deleteuserOrderLocks']);
Route::post('updatebasicinfo', [DimsCommon::class,'updatebasicinfo']);
Route::post('updateContactInfo', [DimsCommon::class,'updateContactInfo']);
Route::post('updatePayments',[DimsCommon::class,'updatePayments']);
Route::post('insertIntoPushProducts', [DimsCommon::class,'insertIntoPushProducts']);
Route::post('insertIntoProhibitProducts',[DimsCommon::class,'insertIntoProhibitProducts']);
Route::post('removePushProducts', [DimsCommon::class,'removePushProducts']);
Route::post('removeProhibitProducts',[DimsCommon::class,'removeProhibitProducts']);
Route::get('productOnPush/{customerId}',[DimsCommon::class,'productOnPush']);
Route::get('productOnprohibit/{customerId}', [DimsCommon::class,'productOnprohibit']);
Route::get('specials',[DimsCommon::class,'specials']);
Route::get('customerspecialsbulkediting/{customercode}/{datefrom}/{dateto}', [DimsCommon::class,'customerspecialsbulkediting']);
Route::get('groupspecialsbulkediting/{customercode}/{datefrom}/{dateto}', [DimsCommon::class,'groupspecialsbulkediting']);
Route::get('getbulkeditingLandingage/{customercode}/{datefrom}/{dateto}', [DimsCommon::class,'getbulkeditingLandingage']);
Route::get('getgroupspecialbulkeditingLandingage/{groupId}/{datefrom}/{dateto}',[DimsCommon::class,'getgroupspecialbulkeditingLandingage']);
Route::get('groupspecials', [DimsCommon::class,'groupspecials']);
Route::get('overallspecials',[DimsCommon::class,'overallspecials']);
Route::get('andNewSpecial', [DimsCommon::class,'andNewSpecial']);
Route::get('customerspecialTemplate', [DimsCommon::class,'customerspecialTemplate']);
Route::get('checkifcustomerspecial/{date1}/{date2}', [DimsCommon::class,'checkifcustomerspecials']);
Route::get('getcheckifcustomerspecials', [DimsCommon::class,'getcheckifcustomerspecials']);
Route::get('addNewGroupSpecial', [DimsCommon::class,'addNewGroupSpecial']);
Route::get('managementSearch', [DimsCommon::class,'managementSearch']);
Route::post('updateDelvAdress', [DimsCommon::class,'updateDelvAdress']);
Route::post('XmlBulkEditingCustomerSpecials',[DimsCommon::class,'XmlBulkEditingCustomerSpecials']);
Route::post('XmlBulkEditingGroupSpecials', [DimsCommon::class,'XmlBulkEditingGroupSpecials']);
Route::get('managementcosoleresult/{consoletype}/{OrderId}/{InvoiceNo}/{ProductCode}', [ConsoleManagement::class,'managementcosoleresult']);
Route::post('createCustomerSpecials', [DimsCommon::class,'createCustomerSpecials']);
Route::post('XmlCreateCustomerSpecials',  [DimsCommon::class,'XmlCreateCustomerSpecials']);
Route::post('overallSpecialHeader', [DimsCommon::class,'overallSpecialHeader']);
Route::post('createGroupSpecials',  [DimsCommon::class,'createGroupSpecials']);
Route::post('createOverallSpecials',  [DimsCommon::class,'createOverallSpecials']);
Route::get('getTaxForSelectedProduct',  [DimsCommon::class,'getTaxForSelectedProduct']);
Route::post('customerByDateOrContract',  [DimsCommon::class,'customerByDateOrContract']);
Route::post('customerGroupByDateOrContract',  [DimsCommon::class,'customerGroupByDateOrContract']);
Route::get('viewgroupinexcel/{from}/{to}/{groupid}', [DimsCommon::class,'viewgroupinexcel'] );
Route::get('jsonViewgroupspecialExcel/{from}/{to}/{groupid}', [DimsCommon::class,'jsonViewgroupspecialExcel']);
Route::post('overallSpecailByDateOrContract', [DimsCommon::class,'overallSpecailByDateOrContract']);
Route::post('updatespeciialLine', [DimsCommon::class,'updatespeciialLine']);
Route::post('updategGroupSpecialLine', [DimsCommon::class,'updategGroupSpecialLine']);
Route::post('updateOverallSpecialLine', [DimsCommon::class,'updateOverallSpecialLine']);
Route::post('insertIntoTblPicking', [DimsCommon::class,'insertIntoTblPicking']);
Route::post('insertIntoTblPickingPerRoute',  [DimsCommon::class,'insertIntoTblPickingPerRoute']);
Route::post('startcopyingorderpatternhistorytoaccount', [DimsCommon::class,'startcopyingorderpatternhistorytoaccount']);
Route::post('deleteaddressonthecustomerdeliveryaddresstbl',  [DimsCommon::class,'deleteaddressonthecustomerdeliveryaddresstbl']);
Route::get('getDataFromManagementConsole', [DimsCommon::class,'getDataFromManagementConsole']);
Route::get('getDataFromManagementConsoleForAuditors', [DimsCommon::class,'getDataFromManagementConsoleForAuditors']);
Route::get('customerAddressLandingPage', [DimsCommon::class,'customerAddressLandingPage']);
Route::get('customerDeliveryAddress/{custcode}',[DimsCommon::class,'customerDeliveryAddress']);
Route::get('selectCustomerAddressToUpdate/{addressid}/{address1}/{address2}/{address3}/{address4}/{address5}/{customercode}', [DimsCommon::class,'deleteaddressonthecustomerdeliveryaddresstbl']);
Route::post('intoTblPrintedDoc', [DimsCommon::class,'intoTblPrintedDoc']);
Route::post('invoicedoc', [DimsCommon::class,'invoicedoc']);
Route::post('uploader',[DimsCommon::class,'uploader']);
Route::post('warehouseProductStockLookUp',[DimsCommon::class,'warehouseProductStockLookUp']);
Route::post('intoTblPrintedDocPickingSlips',[DimsCommon::class,'intoTblPrintedDocPickingSlips']);
Route::post('emailOrder',[DimsCommon::class,'InsertToEmail']);
Route::post('printInvoiceNow',[DimsCommon::class,'printInvoiceNow']);
Route::post('printTruckControlID', [DimsCommon::class,'printTruckControlID']);
Route::post('removeCustomerSpecial',[DimsCommon::class,'removeCustomerSpecial']);
Route::post('increasePriceUsingMargin',[DimsCommon::class,'increasePriceUsingMargin']);
Route::get('masscusterspecialdatefilter/{datefrom}/{dateto}/{marginless}/{margingreater}/{rep}',[DimsCommon::class,'masscusterspecialdatefilter']);
Route::get('changefiltereddatamassspecials/{dateFromFilter}/{dateToFilter}/{marginfilterless}/{marginfiltergreater}/{rep}', [DimsCommon::class,'changefiltereddatamassspecials']);
Route::get('getJsonCustomerGrid',[DimsCommon::class,'getJsonCustomerGrid']);
Route::post('removeGroupSpecial',[DimsCommon::class,'removeGroupSpecial']);
Route::post('deleteselectedgroupspeciallines', [DimsCommon::class,'deleteselectedgroupspeciallines']);
Route::post('deleteselectedcustomerspeciallines',[DimsCommon::class,'deleteselectedcumassCustomerstomerspeciallines']);
Route::post('removeOverallSpecial',[DimsCommon::class,'removeOverallSpecial']);
Route::post('verifyAuth', [DimsCommon::class,'verifyAuth']);
Route::post('changesalesman', [DimsCommon::class,'changesalesman']);
Route::post('changerouteonorder',[DimsCommon::class,'changerouteonorder']);
Route::post('masscustomerspecialupgrade',[DimsCommon::class,'masscustomerspecialupgrade']);
Route::post('verifyAuthOnAdmin', [DimsCommon::class,'verifyAuthOnAdmin']);
Route::post('verifyAuthCreditors',[DimsCommon::class,'verifyAuthCreditors']);
Route::post('AuthExternaOrders', [DimsCommon::class,'AuthExternaOrders']);
Route::post('verifyAuthOnAdminMargin', [DimsCommon::class,'verifyAuthOnAdminMargin']);
Route::post('verifyAuthGroupLeaders', [DimsCommon::class,'verifyAuthGroupLeaders']);
Route::post('communications', [DimsCommon::class,'communications']);
Route::post('clearAllLocksRestFull', [DimsCommon::class,'clearAllUserLocks']);
Route::post('doneextending',[DimsCommon::class,'doneextending']);
Route::post('doneextendinggroupspecials',[DimsCommon::class,'doneextendinggroupspecials']);
Route::post('updatecustomergridpricing',[DimsCommon::class,'updatecustomergridpricing']);
Route::get('invoiceLookUp', [DimsCommon::class,'invoiceLookUp']);
Route::get('customerLookUp',[DimsCommon::class,'customerLookUp']);
Route::get('marginControl',[DimsCommon::class,'marginControl']);
Route::get('viewCreditLimit', [DimsCommon::class,'viewCreditLimit']);
Route::get('customernoteshistory/{customerid}',[DimsCommon::class,'customernoteshistory']);
Route::get('getCreditLimitJson',[DimsCommon::class,'getCreditLimitJson']);
Route::get('getAgeAnalysis/{customerid}', [DimsCommon::class,'getAgeAnalysis']);
Route::POST('customernoteshistoryupdate',[DimsCommon::class,'customernoteshistoryupdate']);
Route::POST('customernoteshistoryinsert',[DimsCommon::class,'customernoteshistoryinsert']);
Route::POST('assignRouteToTheCustomer',[DimsCommon::class,'assignRouteToTheCustomer']);
Route::get('blnCompanyReports', [DimsCommon::class,'blnCompanyReports']);
Route::get('massgridspecialscustomer', [DimsCommon::class,'massgridspecialscustomer']);
Route::get('userpickingloadingperformancereport',[DimsCommon::class,'userpickingloadingperformancereport']);
Route::get('userpickingloadingperformancereportJson/{datefrom}/{dateto}', [DimsCommon::class,'userpickingloadingperformancereportJson']);
Route::get('pickingLiveGrid', [DimsCommon::class,'pickingLiveGrid']);
Route::get('driverLiveGrid', [DimsCommon::class,'driverLiveGrid']);
Route::get('custometPricingPage/{customerid}',[DimsCommon::class,'custometPricingPage']);
Route::get('custometPricingJson/{customerid}', [DimsCommon::class,'custometPricingJson']);
Route::get('customersalespage',[DimsCommon::class,'viewCreditLimit']);
Route::get('getDeliveryAddressOrderPattern/{account}/{addressid}',[DimsCommon::class,'getDeliveryAddressOrderPattern']);
Route::get('customersalesJson/{datefrom1}/{dateto1}/{datefrom2}/{dateto3}',[DimsCommon::class,'customersalesJson']);
Route::get('customerupdatepricingfromcustomerssalespage/{custcode}/{datefrom}/{dateto}/{datefrom2}/{dateto2}',[DimsCommon::class,'customerupdatepricingfromcustomerssalespage']);
Route::get('bulpickingbyBatch/{timestamp}',[DimsCommon::class,'bulpickingbyBatch']);
Route::get('UpdateDocument',[DimsCommon::class,'UpdateDocument']);
Route::post('updateDocumentupdate',[DimsCommon::class,'UpdateDocumentupdate']);
Route::get('/WebstoreMessages',[DimsCommon::class,'WebstoreMessages']);
Route::get('/getMessageGrid',[DimsCommon::class,'getMessageGrid'] );
Route::post('updateMessage',[DimsCommon::class,'updateMessage'] );

//DIMS COMMON ENDS HERE HERE!!!!

//SALES FORM FUNCTIONS STARTS HERE!!!
Route::post('custID', [SalesFormFunctions::class,'getCustomerID']);
Route::get('getAllProductsAndCosts', [SalesFormFunctions::class,'getAllProductsAndCosts']);
Route::get('getProductCodes',[SalesFormFunctions::class,'getProductCodes']);
Route::get('custDescription',[SalesFormFunctions::class,'CustomerDescription']);
Route::get('prodCode', [SalesFormFunctions::class,'ProductCode']);
Route::get('prodDesciption',[SalesFormFunctions::class,'ProductDescription']);
Route::get('deliveryTypes',[SalesFormFunctions::class,'getDeliverTypes']);
Route::post('updateCContactsOnOrder', [SalesFormFunctions::class,'updateCContactsOnOrder']);
Route::post('orderheaderAndOrderLines', [SalesFormFunctions::class,'orderheaderAndOrderLines']);
Route::post('getCutomerPriceOnOrderForm', [SalesFormFunctions::class,'returnProductPrice']);
Route::post('getCutomerPastInvoices', [SalesFormFunctions::class,'getCustomerPast10Invoices']);
Route::post('customerSpecials', [SalesFormFunctions::class,'getCustomerSpecials']);
Route::post('groupSpecials', [SalesFormFunctions::class,'getGroupSpecials']);
Route::post('combinedSpecials',[SalesFormFunctions::class,'combinedSpecials']);
Route::post('priceSearch', [SalesFormFunctions::class,'priceLookUpOntab']);
Route::post('insertOrderHeader',[SalesFormFunctions::class,'insertOrderHearder']);
Route::post('insertHeaderForOtherTrans', [SalesFormFunctions::class,'insertHeaderForOtherTrans']);
Route::post('insertOrderDetails',[SalesFormFunctions::class,'insertOrderDetails']);
Route::post('insertNewAddress',[SalesFormFunctions::class,'insertNewAddress']);
Route::post('jsonOrderDetails',[SalesFormFunctions::class,'postOrderDetailsAsJsonArray']);
Route::post('jsonOtherTransactionsLinesDetails', [SalesFormFunctions::class,'postOrderDetailsAsJsonArrayForOtherTransactions']);
Route::post('jsonOrderDetailsPos',[SalesFormFunctions::class,'postOrderDetailsAsJsonArrayPOS']);
Route::post('createbackorderonsplit',[SalesFormFunctions::class,'createbackorderonsplit']);
Route::post('printPickingSlipPerOrder', [SalesFormFunctions::class,'printPickingSlipPerOrder']);
Route::post('productsOnOrder', [SalesFormFunctions::class,'productsOnOrder']);
Route::post('countOnSalesOrder', [SalesFormFunctions::class,'countOnSalesOrder']);
Route::post('productsOnInvoiced',[SalesFormFunctions::class,'productsOnInvoiced']);
Route::post('getOrderPattern', [SalesFormFunctions::class,'getCustomerOderpattern']);
Route::post('getCustomerRoutes', [SalesFormFunctions::class,'getCustomerRouteWithOtherRoutesByPriority']);
Route::post('getOrderListing',[SalesFormFunctions::class,'getOrderListing']);
Route::post('getOrderListingOtherTrans',[SalesFormFunctions::class,'getOrderListingOtherTrans']);
Route::post('onCheckOrderHeader', [SalesFormFunctions::class,'onCheckOrderHeader']);
Route::post('checkIfOrderExistsWithOrderType', [SalesFormFunctions::class,'checkIfOrderExists']);
Route::post('onCheckOrderHeaderDetails', [SalesFormFunctions::class,'onCheckOrderHeaderDetails']);
Route::post('isClosedRoute',[SalesFormFunctions::class,'isClosedRoute']);
Route::post('onCheckOrderHeaderForOtherTrans', [SalesFormFunctions::class,'onCheckOrderHeaderForOtherTrans']);
Route::post('checkIfOrderExistsWithOrderTypeForOtherTrans', [SalesFormFunctions::class,'checkIfTransactionsExists']);
Route::post('onCheckOrderHeaderDetailsForOtherTrans', [SalesFormFunctions::class,'onCheckOrderHeaderDetailsForOtherTrans']);
Route::post('convertToSalesOrder', [SalesFormFunctions::class,'convertToSalesOrder']);
Route::post('treatAsQuote', [SalesFormFunctions::class,'treatAsQuote']);
Route::post('generalPriceChecking',[SalesFormFunctions::class,'generalPriceChecking']);
Route::post('advancedorderno', [SalesFormFunctions::class,'advancedOrderNo']);
Route::post('generalPriceCheckAndLastCost', [SalesFormFunctions::class,'generalPriceCheckAndLastCost']);
Route::post('getCallList',[SalesFormFunctions::class,'getCallList'] );
Route::post('getCallListNew',[SalesFormFunctions::class,'getCallListNew'] );
Route::post('insertCallistFilters', [SalesFormFunctions::class,'insertCallistFilters']);
Route::post('isCalled',[SalesFormFunctions::class,'insertCallID']);
Route::post('selectCustomerMultiAddress',[SalesFormFunctions::class,'selectCustomerMultiAddress']);
Route::post('copyOrdersToCustomers', [SalesFormFunctions::class,'copyOrdersToCustomers']);
Route::post('generatePDFForOrders',[SalesFormFunctions::class,'generatePDFForOrders']);
Route::post('countAddress', [SalesFormFunctions::class,'countAddress']);
Route::post('countomerSingleAddress', [SalesFormFunctions::class,'countomerSingleAddress']);
Route::post('createNewCustomDelvDate',[SalesFormFunctions::class,'spCreateNewtblCustomerDeliveryAddress']);
Route::post('getLastInsertedDate',[SalesFormFunctions::class,'getLastInsertedDate']);
Route::post('getProductStockOnHand', [SalesFormFunctions::class,'getProductStockOnHand']);
Route::post('deleteOrderDetails', [SalesFormFunctions::class,'DeleteOrderDetails']);
Route::post('DeleteOrderDetailsOrtherTrans',[SalesFormFunctions::class,'DeleteOrderDetailsOrtherTrans']);
Route::post('updateAuthHeader', [SalesFormFunctions::class,'updateAuthHeader']);
Route::post('selectAddressFromMultiAddressDeliveruyAddressId', [SalesFormFunctions::class,'selectAddressFromMultiAddressDeliveruyAddressId']);
Route::post('updateOrderHeader', [SalesFormFunctions::class,'UpdateOrderHearder']);
Route::post('deleteByHiddenToken', [SalesFormFunctions::class,'deleteByHiddenToken']);
Route::post('updateOrderHeaderForOtherTransactions', [SalesFormFunctions::class,'updateOrderHeaderForOtherTransactions']);
Route::post('tempDeliverAddress', [SalesFormFunctions::class,'tempDeliverAddress']);
Route::get('pointofsale',[SalesFormFunctions::class,'pointOfSale'] );
Route::post('posCashFloat',[SalesFormFunctions::class,'posCashFloat']);
Route::post('postPOSfloat',[SalesFormFunctions::class,'postPOSfloat']);
Route::post('deletePOSfloat',[SalesFormFunctions::class,'deletePOSfloat']);
Route::post('updateDiscount', [SalesFormFunctions::class,'updateDiscount']);
Route::post('copyInvoice', [SalesFormFunctions::class,'copyOrderToNewOrder']);
Route::post('adjustDispatch', [SalesFormFunctions::class,'adjustTheDispatchQtyOnPickingOrder']);
Route::post('printAdjustmentDispatch',[SalesFormFunctions::class,'printInvoiceFromPickingFormAdjustment']);
Route::post('createAbackOrder',[SalesFormFunctions::class,'createAbackOrder']);
Route::post('waitingForInvoiceNo', [SalesFormFunctions::class,'waitingForInvoiceNo']);
Route::post('checkifInvoiced',[SalesFormFunctions::class,'checkifInvoiced']);
Route::post('AssignInvoiceNumber', [SalesFormFunctions::class,'AssignInvoiceNumber']);
Route::post('toProcessPosTenderLines', [SalesFormFunctions::class,'toProcessPosTenderLines']);
Route::get('updatePosRoute', [SalesFormFunctions::class,'updatePosRoute']);
Route::get('getAllOrderIDs', [SalesFormFunctions::class,'getAllOrderIDs']);
Route::post('getCustomerOrderId', [SalesFormFunctions::class,'getCustomerOrderId']);
Route::post('productPriceLookUp', [SalesFormFunctions::class,'productPriceLookUp']);
Route::post('associatedItem',[SalesFormFunctions::class,'associatedItem']);
Route::post('changeDeliveryAddressOnNoInvoiceNo', [SalesFormFunctions::class,'changeDeliveryAddressOnNoInvoiceNo']);

//SALES FORM FUNCTIONS ENDS HERE!!!


//CONSOLE MANAGEMENT STARTS HERE !!!
Route::post('logMessageAjax',[ConsoleManagement::class,'logMessageAjax']);
Route::post('logMessageAuth', [ConsoleManagement::class,'logMessageAuth']);
Route::post('deleteallLinesOnOrder', [ConsoleManagement::class,'deleteallLinesOnOrder']);
Route::post('logMessageAuthMargin',[ConsoleManagement::class,'logMessageAuthMargin'] );

//CONSOLE MANAGEMENT ENDS HERE!!!

//TABLET LOADING APP STARTS HERE !!!
Route::get('routePlannerSuggestions/{date}/{ordertype}/{route}/{status}', [TabletLoadingApp::class,'TabletLoadingApp@routePlannerSuggestions']);
Route::post('getRouteData',[TabletLoadingApp::class,'getRouteData']);
Route::post('sequenceOrdersByMode', [TabletLoadingApp::class,'sequenceOrdersByMode']);
Route::post('sequenceOrdersByMode',[TabletLoadingApp::class,'sequenceOrdersByMode'] );
Route::post('resequenceOrders', [TabletLoadingApp::class,'resequenceOrders']);
Route::get('truckControlId',[TabletLoadingApp::class,'truckControlId']);
Route::get('pastels',[TabletLoadingApp::class,'pastels']);
Route::get('getmycustroutemap',[TabletLoadingApp::class,'getmycustroutemap']);
Route::get('pickingtickets',[TabletLoadingApp::class,'pickingtickets']);
Route::get('GetPickingReferenceProducts',[TabletLoadingApp::class,'GetPickingReferenceProducts']);
Route::get('pickingplanlist/{ref}',[TabletLoadingApp::class,'pickingplanlist']);
Route::get('plannickname/{ref}',[TabletLoadingApp::class,'plannickname']);
Route::get('pickingplanlisttest/{ref}',[TabletLoadingApp::class,'pickingplanlisttest']);
Route::get('pickingticketslist/{from}/{to}/{status}',[TabletLoadingApp::class,'pickingticketslist']);
Route::get('getProductToSelect',[TabletLoadingApp::class,'getProductToSelect']);
Route::post('assignTimeToPickingTicket',[TabletLoadingApp::class,'assignTimeToPickingTicket']);
Route::post('assignDepartureTimeToPickingTicket',[TabletLoadingApp::class,'assignDepartureTimeToPickingTicket']);
Route::post('assignTeamLeaderToPickingTicket',[TabletLoadingApp::class,'assignTeamLeaderToPickingTicket']);
Route::post('assignHorseToPickingTicket',[TabletLoadingApp::class,'assignHorseToPickingTicket']);
Route::post('assignTrailorToPickingTicket',[TabletLoadingApp::class,'assignTrailorToPickingTicket']);
Route::post('assignDriversToPickingTicket',[TabletLoadingApp::class,'assignDriversToPickingTicket']);
Route::post('assignTicketToPickingTicket',[TabletLoadingApp::class,'assignTicketToPickingTicket']);
Route::post('truckLoadUpdatePriortiyStatus',[TabletLoadingApp::class,'truckLoadUpdatePriortiyStatus']);
Route::post('completeTruckLoad',[TabletLoadingApp::class,'completeTruckLoad']);
Route::post('cancelTruckLoad',[TabletLoadingApp::class,'cancelTruckLoad']);
Route::post('sequencepickingplans',[TabletLoadingApp::class,'sequencepickingplans']);
Route::get('getIncompletePickingTickets',[TabletLoadingApp::class,'getIncompletePickingTickets']);
Route::get('getInstructions',[TabletLoadingApp::class,'getInstructions']);
Route::get('getTimeRequirements',[TabletLoadingApp::class,'getTimeRequirements']);
Route::post('assignInstruction',[TabletLoadingApp::class,'assignInstruction']);
Route::get('previewplan/{ref}',[TabletLoadingApp::class,'previewplan']);
Route::get('pickingticketslistnotdone/{ref}',[TabletLoadingApp::class,'pickingticketslistnotdone']);
Route::get('topuppickingplan/{ref}',[TabletLoadingApp::class,'topuppickingplan']);
Route::get('getPickingAuth',[TabletLoadingApp::class,'getPickingAuth']);
Route::post('updateplanlines',[TabletLoadingApp::class,'updateplanlines']);
Route::post('addplantoanotherplan',[TabletLoadingApp::class,'addplantoanotherplan']);
Route::post('pickingNickName',[TabletLoadingApp::class,'pickingNickName']);
Route::get('plannedmaproute',[TabletLoadingApp::class,'plannedmaproute']);
Route::get('routePlannerPrintPreview/{date}/{dateTo}/{ordertype}/{route}/{status}',[TabletLoadingApp::class,'routePlannerPrintPreview']);
Route::post('moveTheOrder',[TabletLoadingApp::class,'moveTheOrder']);
Route::post('moveTheOrderArray', [TabletLoadingApp::class,'moveTheOrderArray']);
Route::get('truckControlFromDate',[TabletLoadingApp::class,'truckControlFromDate']);
Route::get('amalgamation',[TabletLoadingApp::class,'amalgamation']);
Route::get('planningusingflex',[TabletLoadingApp::class,'planningusingflex']);
Route::get('arealook',[TabletLoadingApp::class,'arealook']);
Route::get('routemapper',[TabletLoadingApp::class,'routemapper']);
Route::get('jsonreturnroutemappers',[TabletLoadingApp::class,'jsonreturnroutemappers']);
Route::get('customerarealookup',[TabletLoadingApp::class,'customerarealookup']);
Route::get('arealookjson',[TabletLoadingApp::class,'arealookjson']);
Route::get('customerarealookupjson',[TabletLoadingApp::class,'customerarealookupjson']);
Route::get('retrieve/{del}/{route}/{ordertype}',[TabletLoadingApp::class,'retrieve']);
Route::get('driverFleetInfo/{del}/{route}/{ordertype}', [TabletLoadingApp::class,'driverFleetInfo']);
Route::get('bulkPickingPerUserJSON/{from}/{to}',[TabletLoadingApp::class,'bulkPickingPerUserJSON']);
Route::get('bulkPickingPerUserView', [TabletLoadingApp::class,'bulkPickingPerUserView']);
Route::get('designPickingInformationPerTeam/{del}/{route}/{ordertype}', [TabletLoadingApp::class,'designPickingInformationPerTeam']);
Route::get('truckControlSheetDetails', [TabletLoadingApp::class,'truckControlSheetDetails']);
Route::post('stopsUnmapped', [TabletLoadingApp::class,'stopsUnmapped']);
Route::post('getRouteDataMultiSelected', [TabletLoadingApp::class,'getRouteDataMultiSelected']);
Route::post('getPriotyCustOnly', [TabletLoadingApp::class,'getPriotyCustOnly']);
Route::post('getCustomerPlannedForPicking', [TabletLoadingApp::class,'getCustomerPlannedForPicking']);
Route::post('getcustomergeneralplanmap', [TabletLoadingApp::class,'getcustomergeneralplanmap']);
Route::post('PutMarkerOnTheMapDynamically', [TabletLoadingApp::class,'PutMarkerOnTheMapDynamically']);
Route::post('saveplan', [TabletLoadingApp::class,'saveplan']);
Route::post('jsongetproductbycat', [TabletLoadingApp::class,'jsongetproductbycat']);
Route::post('productsonamarker', [TabletLoadingApp::class,'productsonamarker']);
Route::post('updateplan', [TabletLoadingApp::class,'updateplan']);
Route::post('doneplanning', [TabletLoadingApp::class,'doneplanning']);
Route::get('routeplanner',[TabletLoadingApp::class,'routeplanner']);
Route::get('routePlannerExt', [TabletLoadingApp::class,'routePlannerExt']);
Route::get('getProgressPlan', [TabletLoadingApp::class,'getProgressPlan']);
Route::get('getProgressPlanCustByProducts', [TabletLoadingApp::class,'getProgressPlanCustByProducts']);
Route::get('invoicesnotprinting', [TabletLoadingApp::class,'invoicesnotprinting']);
Route::post('notifypickers',[TabletLoadingApp::class,'notifypickers']);
Route::get('liveBulkPicking', [TabletLoadingApp::class,'liveBulkPicking']);
Route::get('printLoadingSheet/{routingId}', [TabletLoadingApp::class,'printLoadingSheet']);
Route::get('getDrivers', [TabletLoadingApp::class,'getDrivers']);
Route::get('getTrucks', [TabletLoadingApp::class,'getTrucks']);
Route::get('getData/{orderdate}/{ordertype}/{routename}/{driver}/{assistant}/{truckname}/{assistanttwo}/{userid}',[TabletLoadingApp::class,'getData']);
Route::get('liveFleetDeliveries',[TabletLoadingApp::class,'liveFleetDeliveries']);
Route::get('driverreq_report',[TabletLoadingApp::class,'driverreq_report']);
Route::get('driverreq_reportJson/{date1}/{date2}', [TabletLoadingApp::class,'driverreq_reportJson']);
Route::get('driverreq_perrouteJson/{routeid}',[TabletLoadingApp::class,'driverreq_perrouteJson']);
Route::get('updatelogisticsinformation', [TabletLoadingApp::class,'updatelogisticsinformation']);
Route::get('ligisticsplan/{dates}', [TabletLoadingApp::class,'ligisticsplan']);
Route::get('LogisticsInsertMapRoute/{routingId}/{ot}/{route}',[TabletLoadingApp::class,'LogisticsInsertMapRoute']);
Route::get('createtripsheet', [TabletLoadingApp::class,'createtripsheet']);
Route::get('createtripsheetnotes', [TabletLoadingApp::class,'createtripsheetnotes']);
Route::post('getRoutingIdNotes',[TabletLoadingApp::class,'getRoutingIdNotes']);
Route::post('saveRoutingIdNotes', [TabletLoadingApp::class,'saveRoutingIdNotes']);
Route::get('routePlannerExtParam/{date}/{ordertype}/{route}/{status}', [TabletLoadingApp::class,'routePlannerExtParam']);
Route::get('planroute/{date}/{ordertype}/{route}/{status}', [TabletLoadingApp::class,'planroute']);
Route::get('routeplannermap',[TabletLoadingApp::class,'routeplannermap']);
Route::get('geoJson',[TabletLoadingApp::class,'geoJson']);
Route::get('drone',[TabletLoadingApp::class,'drone']);
Route::get('getRouteDifference',[TabletLoadingApp::class,'getRouteDifference']);
Route::get('ordersNotONDefaultRoutes', [TabletLoadingApp::class,'ordersNotONDefaultRoutes']);
Route::get('productontheminiorderform/{orderId}',[TabletLoadingApp::class,'spTabletLoading']);
Route::get('updateTableLoadingAppProducts', [TabletLoadingApp::class,'updateTableLoadingAppProducts']);
Route::post('sequencingTheStops', [TabletLoadingApp::class,'sequencingTheStops']);
Route::post('orderDetailsWithDeliveryAddress', [TabletLoadingApp::class,'orderDetailsWithDeliveryAddress']);
Route::post('orderDetailsWithDeliveryAddressOnOrder',[TabletLoadingApp::class,'orderDetailsWithDeliveryAddressOnOrder'] );
Route::post('forceinvoicetoprint', [TabletLoadingApp::class,'forceinvoicetoprint']);
Route::post('updateIQInvoices',[TabletLoadingApp::class,'updateIQInvoices']);
Route::post('forcecredits',[TabletLoadingApp::class,'forcecredits']);
Route::post('combineroutes',[TabletLoadingApp::class,'combineroutes']);
Route::post('updatepickingheader',[TabletLoadingApp::class,'updatepickingheader']);
Route::post('markreftobeapproved',[TabletLoadingApp::class,'markreftobeapproved']);
Route::post('updatepickingauthstatus',[TabletLoadingApp::class,'updatepickingauthstatus']);
Route::post('updatepickingheaderonthefly',[TabletLoadingApp::class,'updatepickingheaderonthefly']);
Route::post('cancelpickingplan',[TabletLoadingApp::class,'cancelpickingplan']);
Route::get('creditNoteReasonsJSonWithBook',[TabletLoadingApp::class,'creditNoteReasonsJSonWithBook']);
Route::get('ticketsdept/{ref}',[TabletLoadingApp::class,'ticketsdept']);
Route::get('markplandeleted',[TabletLoadingApp::class,'markplandeleted']);
Route::post('addtransport',[TabletLoadingApp::class,'addtransport']);
Route::post('maproutetoareinsert',[TabletLoadingApp::class,'maproutetoareinsert']);

//TABLET LOADING APP ENDS HERE !!!

//PRODUCT CONTROLLER STARTS HERE!!!
Route::get('viewproductbydate', [ProductsController::class,'viewproductbydate']);
Route::get('devexpressproducts', [ProductsController::class,'devExpressProductsgrid']);
Route::get('listProdutsToBePrinted', [ProductsController::class,'listProdutsToBePrinted']);
Route::get('listProdutsToBePrintedJson', [ProductsController::class,'listProdutsToBePrintedJson']);
Route::get('productbydatejson/{date1}/{date2}/{productId}', [ProductsController::class,'productbydatejson']);

Route::get('gridEditViewProducts', [ProductsController::class,'gridEditViewProducts']);
Route::get('selectPricelists', [ProductsController::class,'selectPricelists']);
Route::post('getPriceListUsed', [ProductsController::class,'getPriceListUsed']);
Route::get('getListPriceListPrices/{id}/{pricelistusedid}',[ProductsController::class,'getListPriceListPrices']);
Route::get('createnewpricelist/{newname}/{pricelistcopyfrom}/{groups}/{gp}/{effectivedate}',[ProductsController::class,'createnewpricelist']);
Route::post('postupdatepricelistinfo', [ProductsController::class,'postupdatepricelistinfo']);
Route::get('createpricelist',[ProductsController::class,'createpricelist']);
Route::get('getPriceListTemplate', [ProductsController::class,'getPriceListTemplate']);
Route::get('importexcelpricelist',[ProductsController::class,'importexcelpricelist']);
Route::get('getPricelistNamesAndViewInBulk', [ProductsController::class,'getPricelistNamesAndViewInBulk']);
Route::get('getBulkPriceLists',[ProductsController::class,'getBulkPriceLists']);
Route::get('extraProdInfoView/{prodid}/{code}',[ProductsController::class,'extraProdInfoView']);
Route::get('crowdpromotion',[ProductsController::class,'crowdpromotion']);
Route::get('updateproductsummary',[ProductsController::class,'updateproductsummary']);
Route::get('productdevexpress',[ProductsController::class,'productdevexpress']);
Route::get('getPickingTeams',[ProductsController::class,'getPickingTeams']);
Route::post('printbarcode', [ProductsController::class,'printbarcode']);
Route::post('sendstickerstoprinter', [ProductsController::class,'sendstickerstoprinter']);
Route::get('printPriceList',[ProductsController::class,'printPriceList']);
Route::get('printstickers',[ProductsController::class,'PrintProductBarcodeStickers']);
Route::get('viewlabelstickerstoprint', [ProductsController::class,'viewlabelstickerstoprint']);
Route::get('listChangedProducts/{dateFrom}/{dateTo}/{PriceList}',[ProductsController::class,'listChangedProducts']);
Route::post('printbulklabels',[ProductsController::class,'printbulklabels'] );
Route::post('printbulklabelsbyPricelist',[ProductsController::class,'printbulklabelsbyPricelist']);
Route::get('bulkgridforlabels', [ProductsController::class,'bulkgridforlabels']);
Route::get('getproductextrainformation/{prductId}',[ProductsController::class,'getproductextrainformation']);
Route::post('updategridproductsAndTeams',[ProductsController::class,'updategridproductsAndTeams']);
Route::post('savedatafromimport', [ProductsController::class,'savedatafromimport']);
Route::get('itemsOutOfStockBeforePicking',[ProductsController::class,'itemsOutOfStockBeforePicking']);
Route::get('getViewItemsOutOfStock', [ProductsController::class,'getViewItemsOutOfStock']);
Route::post('printAllBarcode', [ProductsController::class,'printAllBarcode']);
//PRODUCT CONTROLLER ENDS HERE!!!

//SALES QUOTE CONTROLLER STARTS HERE !!!
Route::get('salesquote',[SalesQuotes::class,'salesquote']);
Route::post('generateSalesQuote', [SalesQuotes::class,'generateSalesQuote']);
Route::post('createQuotesHeader',[SalesQuotes::class,'createQuotesHeader']);
Route::post('previewSaleQuotes',[SalesQuotes::class,'previewSaleQuotes']);
Route::post('viewSalesQuotes',[SalesQuotes::class,'viewSalesQuotes']);
Route::post('viewSalesQuotesConverted', [SalesQuotes::class,'viewSalesQuotesConverted']);
Route::post('startConvertingQuoteToOrder',[SalesQuotes::class,'startConvertingQuoteToOrder']);
Route::get('printTheQuote/{quoteId}', [SalesQuotes::class,'printTheQuote']);

//SALES QUOTE CONTROLLER ENDS HERE !!!

//EMAIL CONTROLLER STARTS HERE !!!
Route::post('email', [EmailController::class,'email']);
Route::post('emailSalesOrder', [EmailController::class,'emailSalesOrder']);

//EMAIL CONTROLLER ENDS HERE !!!


//DIMS REPORTS CONTROLLER STARTS HERE !!!
Route::get('reports', [DimsReports::class,'reports']);
Route::get('outstandingDriversCashoff', [DimsReports::class,'outstandingDriversCashoff']);
Route::get('getreportLayout',[DimsReports::class,'getreportLayout']);
Route::get('getreportAuthBelowMargin',[DimsReports::class,'getreportAuthBelowMargin']);
Route::get('getJsonAuthBelowMargin/{dateFrom}/{dateTo}', [DimsReports::class,'getJsonAuthBelowMargin']);
Route::get('getOrderPlacedAfterCutOff',[DimsReports::class,'getOrderPlacedAfterCutOff']);
Route::get('getJsonCutOffTime/{dateFrom}',[DimsReports::class,'getJsonCutOffTime']);
Route::get('dshb', [DimsReports::class,'dashboardSalesPerformance']);
Route::post('getPickingTeamsByDept', [DimsReports::class,'getPickingTeamsByDept']);
Route::post('getPickingTeamsByDeptPalladium',[DimsReports::class,'getPickingTeamsByDeptPalladium'] );
Route::get('getPickingDept', [DimsReports::class,'getPickingDept']);
Route::get('getPickingDeptPalladium',[DimsReports::class,'getPickingDeptPalladium']);
Route::get('printQuatation', [DimsReports::class,'quotationLayout']);
Route::get('showTripSheets', [DimsReports::class,'showTripSheets']);
Route::get('getTripSheetDetails/{routingId}',[DimsReports::class,'getTripSheetDetails']);
Route::get('reprintTripSheet/{routingId}',[DimsReports::class,'reprintTripSheet']);
Route::post('authorisationActions',[DimsReports::class,'Authorised']);
Route::post('getDayTripSheetList',[DimsReports::class,'getDayTripSheetList']);
Route::get('bulpickingPerRoutePreview/{pickingid}',[DimsReports::class,'bulpickingPerRoutePreview']);
Route::get('pickingbyteam/{array}/{deldate}/{ordertype}/{routeId}',[DimsReports::class,'pickingbyteam']);
Route::post('fetchData', [DimsReports::class,'fetchData']);
Route::post('selectBulkPickingHeader',[DimsReports::class,'selectBulkPickingHeader']);
Route::post('selectBulkBatchPickingHeader', [DimsReports::class,'selectBulkBatchPickingHeader']);
Route::post('createBulkpicking', [DimsReports::class,'createBulkpicking']);
Route::get('slackUser/{oType}/{route}/{Ddate}', [DimsReports::class,'slackUser']);
Route::post('getBinLocationByPickingTimes',[DimsReports::class,'getBinLocationByPickingTimes'] );
Route::post('gridResult',[DimsReports::class,'gridResult']);
Route::post('gridResultPalladium',[DimsReports::class,'gridResultPalladium']);
Route::get('top30Orders', [DimsReports::class,'top30Orders']);
Route::get('creditNoteReasonsView',[DimsReports::class,'creditNoteReasonsView'] );
Route::get('pickingmain', [DimsReports::class,'pickingSlipManue']);
Route::get('rptToSeeInTockVsOrders', [DimsReports::class,'rptToSeeInTockVsOrders']);
Route::get('getJsonSrockVsOrdered/{date1}/{date2}/{percentage}',[DimsReports::class,'getJsonSrockVsOrdered']);
Route::post('topOrdersOfACustomer',[DimsReports::class,'topOrdersOfACustomer']);
Route::post('contactDetailsOnOrder', [DimsReports::class,'contactDetailsOnOrder']);

//DIMS REPORTS CONTROLLER ENDS HERE !!!

//LOADING APP API CONTROLLER STARTS HERE !!!
Route::get('sendMessages', [LoadingAppAPIs::class,'sendMessages']);
Route::get('sendMessageJson',[LoadingAppAPIs::class,'sendMessageJson']);
Route::get('sendMessagePicking',[LoadingAppAPIs::class,'sendMessagePicking']);
Route::get('batchPrinting',[LoadingAppAPIs::class,'batchPrinting']);
Route::post('stockApi', [LoadingAppAPIs::class,'stockApi']);
Route::get('slack', [LoadingAppAPIs::class,'slack']);

//LOADING APP API CONTROLLER ENDS  HERE !!!

//SAGE Invoicing
Route::get('invoicepickings/{ref}', [InvoicingController::class,'invoicepickings']);
Route::get('printtripsheet/{ref}', [InvoicingController::class,'printtripsheet']);
Route::get('teamLeaderPrintTripSheet', [InvoicingController::class,'teamLeaderPrintTripSheet']);
Route::get('testWarehouseT/{ref}/{sonumber}/{ownerid}', [InvoicingController::class,'testWarehouseT']);
Route::get('invManualAdj/{ref}/{sonumber}/{ownerid}/{autoindex}/{dates}', [InvoicingController::class,'invManualAdj']);
Route::get('individualInvoicing', [InvoicingController::class,'individualInvoicing']);
Route::get('individualInvoicingAPITest/{ownersId}/{SoNumber}/{invoiceid}/{ref}/{userid}/{userName}', [InvoicingController::class,'individualInvoicingAPITest']);
Route::get('individualInvoicingAPI/{ownersId}/{SoNumber}/{invoiceid}/{ref}/{userid}/{userName}', [InvoicingController::class,'individualInvoicingAPI']);
Route::get('processInvoce', [InvoicingController::class,'processInvoce']);
Route::get('viewAwaitingtoinvoice', [InvoicingController::class,'viewAwaitingtoinvoice']);
Route::get('assignweighbridgeticket', [InvoicingController::class,'assignweighbridgeticket']);
Route::get('weightticketslist/{ref}', [InvoicingController::class,'weightticketslist']);
Route::get('saveweightticket', [InvoicingController::class,'saveweightticket']);
Route::get('whtransfers/{transfer}/{orderid}', [InvoicingController::class,'whtransfers']);
Route::get('processTransfertest/{transfer}', [InvoicingController::class,'processTransfertest']);
Route::get('trywarehouse', [InvoicingController::class,'trywarehouse']);
Route::get('getdimsmanuals', [InvoicingController::class,'getdimsmanuals']);
Route::get('getqrcode', [InvoicingController::class,'getqrcode']);
Route::get('qrcodeimage/{machine}/{qty}/{item}', [InvoicingController::class,'qrcodeimage']);
Route::post('dimsmanualadjustment', [InvoicingController::class,'dimsmanualadjustment']);
//Route::get('transactionAdj', [InvoicingController::class,'transactionAdj']);
Route::get('getRemainingBalance/{reference}/{trasferID}/{indexId}', [InvoicingController::class,'getRemainingBalance']);//$reference,$trasferID,$indexId
//SAGE Invoicing Ends Here

//PALLADIUMDIMSSTATUS CONTROLLER STARTS HERE !!!

Route::get('salesHeaderExported', [PalladiumDimsStatus::class,'salesHeaderExported']);
Route::post('updateSalesHeaderExportedStatus',[PalladiumDimsStatus::class,'updateSalesHeaderExportedStatus']);

//PALLADIUMDIMSSTATUS CONTROLLER ENDS HERE !!!

//CALL LIST CONTROLLER STARTS HERE !!!
Route::get('callist', [CallList::class,'index']);
Route::get('getViewCallLogger',[CallList::class,'getViewCallLoger']);
Route::get('callLogger',[CallList::class,'callLogger']);
Route::get('getphonebook', [CallList::class,'getPhoneBook']);
Route::get('savephonebook',[CallList::class,'savephonebook']);
Route::get('removePhoneBookContact',[CallList::class,'removePhoneBookContact']);
Route::get('customerphonebookcontacts',[CallList::class,'customerphonebookcontacts']);
Route::get('luck/{date}/{ext}/{file}',[CallList::class,'luck']);

//CALL LIST CONTROLLER ENDS HERE !!!


//CONFIGURATIONMANGER CONTROLLER STARTS HERE !!!

Route::get('..config',[ConfigurationManger::class,'index']);
Route::post('editconfig', [ConfigurationManger::class,'editconfig']);

//CONFIGURATIONMANGER CONTROLLER ENDS HERE !!!

// PICKING MANAGEMENT COTROLLER CONTROLLER STARTS HERE !!!
Route::get('gridPickingSlipCollectios', [PickingManagementCotroller::class,'gridPickingSlipCollectios']);
Route::post('updateiscollected', [PickingManagementCotroller::class,'updateiscollected']);
Route::post('reprintPickingSlip',[PickingManagementCotroller::class,'reprintPickingSlip']);

// PICKING MANAGEMENT COTROLLER CONTROLLER ENDS HERE !!!

/**********************************************************CRUD****************************************************************/

//DRIVERSCONTROLLER CONTROLLER BEGINS HERE !!!
Route::get('drivers', [DriversController::class,'readItems']);
Route::get('getRoutingIds', [DriversController::class,'getRoutingIds']);
Route::get('printDriversCashOff/{ref}', [DriversController::class,'printDriversCashOff']);
Route::get('creditRequisitionByRoutingId/{routingId}',[DriversController::class,'creditRequisitionByRoutingId']);
Route::get('getdriverscashoff',[DriversController::class,'getdriverscashoff']);
Route::get('CreditDeptComment/{orderdetailid}',[DriversController::class,'CreditDeptComment']);
Route::post('CreditDeptCommentUpdate',[DriversController::class,'CreditDeptCommentUpdate']);
Route::post('getDriversCashOffJson',[DriversController::class,'getDriversCashOffJson']);
Route::post('exportCashOff', [DriversController::class,'exportCashOff']);
Route::post('postDriversCashOff',[DriversController::class,'postDriversCashOff']);
Route::post('invoicessignedaroundpremises',[DriversController::class,'invoicessignedaroundpremises']);
Route::post('createnewsheet',[DriversController::class,'createnewsheet']);
Route::get('LiveDriverStops',[DriversController::class,'LiveDriverStops']);
Route::post('/addItem', [DriversController::class,'addItem']);
Route::post('/editItem', [DriversController::class,'editItem']);
Route::post('/deleteItem', [DriversController::class,'deleteItem']);
Route::get('trucks', [DriversController::class,'readTrucksItems']);
Route::post('/addTrucksItem',[DriversController::class,'addTrucksItem']);
Route::post('/editTrucksItem', [DriversController::class,'editTrucksItem']);
Route::post('/deleteTrucksItem',[DriversController::class,'deleteTrucksItem']);
Route::get('routes1',[DriversController::class,'readRoutesItems']);
Route::post('/addRoutesItem', [DriversController::class,'addRoutesItem']);
Route::post('/editRoutesItem',[DriversController::class,'editRoutesItem']);
Route::post('/deleteMappedRouteToArea',[DriversController::class,'deleteMappedRouteToArea']);
Route::post('/deleteRoutesItem',[DriversController::class,'deleteRoutesItem']);
Route::get('glcodes', [DriversController::class,'readGLCode']);
Route::get('driversperformancereport', [DriversController::class,'driversperformancereport']);
Route::get('getdriversandinfo/{date1}/{date2}', [DriversController::class,'getdriversandinfo']);
Route::get('getNoOfDelPerCustomer/{date1}/{date2}',[DriversController::class,'getNoOfDelPerCustomer']);
Route::get('driverspdfdocs',[DriversController::class,'driverspdfdocs']);
Route::get('cashupscheckinvoice/{invoice}', [DriversController::class,'cashupscheckinvoice']);
Route::post('postcashupscheckinvoice', [DriversController::class,'postcashupscheckinvoice']);
Route::get('noOfStops', [DriversController::class,'noOfStops']);
Route::get('getCashCollected',[DriversController::class,'getCashCollected']);
Route::get('cashCollectedReport/{dateFrom}/{dateTo}',[DriversController::class,'cashCollectedReport']);
Route::post('driverspdfdocsByInv', [DriversController::class,'driverspdfdocsByInv']);
Route::post('postPODSToTheAccounting',[DriversController::class,'postPODSToTheAccounting']);
Route::post('driverspdfdocsByInvsubinfo',[DriversController::class,'driverspdfdocsByInvsubinfo']);
Route::post('driverspdfdocsBytripsheet',[DriversController::class,'driverspdfdocsBytripsheet']);
Route::post('driverpdfdocrequisition',[DriversController::class,'driverpdfdocrequisition'] );
Route::post('isCheckedCashUp',[DriversController::class,'isCheckedCashUp']);
Route::post('/addGLCode', [DriversController::class,'addGLCode']);
Route::post('/editGLCode', [DriversController::class,'editGLCode']);
Route::post('/deleteGLCode',[DriversController::class,'deleteGLCode']);
Route::get('checkingDriversStockAndComment/{orderdetailId}', [DriversController::class,'checkingDriversStockAndComment']);
Route::post('updatereturndispatchmessage',[DriversController::class,'updatereturndispatchmessage']);
Route::post('getResendEmailJson',[DriversController::class,'getResendEmailJson']);
Route::get('getResendEmail', [DriversController::class,'getResendEmail']);
Route::post('postResendEmailJson',[DriversController::class,'postResendEmailJson']);

//DRIVERSCONTROLLER CONTROLLER ENDS HERE !!!

//USERS CONTROLLER CONTROLLER STARTS HERE !!!
Route::get('usersCrud', [UsersController::class,'readUser']);
Route::get('viewUserRole',[UsersController::class,'viewUserRole'] );
Route::post('systemrolesandgrouproles',[UsersController::class,'systemrolesandgrouproles'] );
Route::post('updateremoverole',[UsersController::class,'updateremoverole'] );
Route::get('salesPerformanceview', [UsersController::class,'salesPerformanceview']);
Route::get('userorders/{from}/{to}/{userid}/{username}', [UsersController::class,'userorders']);
Route::get('userorderslines/{orderid}', [UsersController::class,'userorderslines']);
Route::get('getUserOrders/{from}/{to}/{user}', [UsersController::class,'getUserOrders']);
Route::get('gridCustomermanagement/{users}/{routes}', [UsersController::class,'gridCustomermanagement']);
Route::get('salesPerformance/{datefrom}/{dateTo}', [UsersController::class,'salesPerformance']);
Route::post('/addUser', [UsersController::class,'addUser']);
Route::post('updategridroutes', [UsersController::class,'updategridroutes']);
// Route::post('/editUser',[UsersController::class,'editUser'] );
// Route::post('/deleteUser', [UsersController::class,'deleteUser']);
Route::get('grid_Users',[UsersController::class,'gridUsers']);
Route::get('jsonGetUsers',[UsersController::class,'jsonGetUsers']);
Route::post('updateUsers',[UsersController::class,'updateUsers']);
Route::post('updateuserpassword',[UsersController::class,'updateuserpassword']);
Route::post('updateuserinfo',[UsersController::class,'updateuserinfo']);
Route::get('PathEditor', [UsersController::class,'PathsAndEmails']);
Route::post('editUsers',[UsersController::class,'editUsers'] );

//USERS CONTROLLER CONTROLLER ENDS HERE !!!

//CONTROLPANEL CONTROLLER STARTS HERE !!!
Route::get('ordertypes',[ControlPanelController::class,'readOrderType'] );
Route::post('/addOrderType',[ControlPanelController::class,'addOrderType'] );
Route::post('/editOrderType', [ControlPanelController::class,'editOrderType']);
Route::post('/deleteOrderType',[ControlPanelController::class,'deleteOrderType'] );
Route::get('brands', [ControlPanelController::class,'readBrand']);
Route::post('/addBrand', [ControlPanelController::class,'addBrand']);
Route::post('/editBrand', [ControlPanelController::class,'editBrand']);
Route::post('/deleteBrand', [ControlPanelController::class,'deleteBrand']);
Route::get('groups',[ControlPanelController::class,'readGroup'] );
Route::post('/addGroup', [ControlPanelController::class,'addGroup']);
Route::post('/editGroup',[ControlPanelController::class,'editGroup'] );
Route::post('/deleteGroup',[ControlPanelController::class,'deleteGroup'] );
Route::get('taxes',[ControlPanelController::class,'readTax']);
Route::post('/addTax', [ControlPanelController::class,'addTax']);
Route::post('/editTax', [ControlPanelController::class,'editTax']);
Route::post('/deleteTax', [ControlPanelController::class,'deleteTax']);
Route::get('pickingteam',[ControlPanelController::class,'readPickingTeam'] );
Route::post('/addPickingTeam', [ControlPanelController::class,'addPickingTeam']);
Route::post('/editPickingTeam',[ControlPanelController::class,'editPickingTeam'] );
Route::post('/deletePickingTeam', [ControlPanelController::class,'deletePickingTeam']);
Route::get('groupbrands',[ControlPanelController::class,'readGroupBrand'] );
Route::post('/addGroupBrand', [ControlPanelController::class,'addGroupBrand']);
Route::post('/editGroupBrand', [ControlPanelController::class,'editGroupBrand']);
Route::post('/deleteGroupBrand',[ControlPanelController::class,'deleteGroupBrand'] );

//CONTROLPANEL CONTROLLER ENDS  HERE !!!

/**********************************************************APPS**************************************************************************************/

//JASPERREPORTS CONTROLLER STARTS HERE !!!
Route::get('testJaspr/{id}', [JasperReports::class,'testJaspr'] );
Route::get('CashOffPDF/{ref}/{type}',[JasperReports::class,'CashOffPDF']  );
Route::get('specialnsJasper/{id}/{dateFrom}/{dateTo}', [JasperReports::class,'specialnsJasper'] );
Route::get('pdforder/{id}',[JasperReports::class,'PDFOrders']  );
Route::get('PDFDelDate/{id}',[JasperReports::class,'PDFDelDate'] );
Route::get('overallSpecailJasper/{datefrom}/{dateto}',[JasperReports::class,'overallSpecailJasper']  );
Route::get('excelorder/{id}',[JasperReports::class,'EXCELOrders']  );
Route::get('groupSpecailJasper/{datefrom}/{dateto}/{groupid}',[JasperReports::class,'groupSpecailJasper']  );
Route::get('compilereports',[JasperReports::class,'compileExample']  );
Route::get('FreshOrders',[JasperReports::class,'FreshOrders']  );

//JASPERREPORTS CONTROLLER ENDS HERE !!!

//DEALSFROMTHEAPP CONTROLLER STARTS HERE !!!
Route::get('getDeals', [DealsFromTheApp::class,'getDealsNotYetApproved'] );
Route::get('approveadeal/{token}',[DealsFromTheApp::class,'approveADeal']  );
Route::get('rejectadeal/{token}', [DealsFromTheApp::class,'rejectADeal'] );
Route::get('approveddeal',[DealsFromTheApp::class,'approvedDeals']  );
Route::get('rejecteddeal',[DealsFromTheApp::class,'rejectedDeals']  );

//DEALSFROMTHEAPP CONTROLLER ENDS HERE !!!

//EXTERNAL FUNCTIONS  STARTS HERE !!!
Route::get('briefcaseDamages',[ExternalFunctions::class,'briefcaseDamages'] );
Route::get('getTransfers',[ExternalFunctions::class,'getTransfers'] );
Route::get('getInvoices/{customercode}/{from}/{to}',[ExternalFunctions::class,'getInvoices'] );
Route::get('transferblade',[ExternalFunctions::class,'transferblade'] );
Route::get('getTransfersJson/{date}/{dateTo}',[ExternalFunctions::class,'getTransfersJson'] );
Route::post('openorderdetailsformergedtransfers',[ExternalFunctions::class,'openorderdetailsformergedtransfers']);
Route::get('getTransfersJsonbydate/{date}', [ExternalFunctions::class,'getTransfersJsonbydate']);
Route::post('updateCheckedOrNotTrasfers',[ExternalFunctions::class,'updateCheckedOrNotTrasfers'] );
Route::post('checkUnCheckTransfers',[ExternalFunctions::class,'checkUnCheckTransfers'] );
Route::get('getWebstoreCustomers', [ExternalFunctions::class,'getWebstoreCustomers']);
Route::get('officemap', [ExternalFunctions::class,'officemap']);
Route::get('getWebstoreFile',[ExternalFunctions::class,'getWebstoreFile'] );
Route::get('brifcaseCustomerEdits',[ExternalFunctions::class,'brifcaseCustomerEdits'] );
Route::get('synchProducts', [ExternalFunctions::class,'synchProducts']);
Route::get('testWebstoreSpeed',[ExternalFunctions::class,'testWebstoreSpeed'] );
Route::get('damageshistory',[ExternalFunctions::class,'damageshistory'] );
Route::get('transfersstatus', [ExternalFunctions::class,'transfersstatus']);
Route::get('print_damages/{id}',[ExternalFunctions::class,'printDamages'] );
Route::get('process_damage/{id}',[ExternalFunctions::class,'processDamage'] );
Route::post('getDamgedLines', [ExternalFunctions::class,'getDamgedLines']);
Route::post('updatevisits', [ExternalFunctions::class,'updatevisits']);
Route::post('getDamagesHistoryHeader',[ExternalFunctions::class,'getDamagesHistoryHeader'] );
Route::post('updateWebstoremasterFileInfo',[ExternalFunctions::class,'updateWebstoremasterFileInfo'] );
Route::post('deleteDamagedLine',[ExternalFunctions::class,'deleteDamagedLine'] );
Route::post('saveupdateasset',[ExternalFunctions::class,'saveupdateasset'] );
Route::get('viewVisits',[ExternalFunctions::class,'viewVisits'] );
Route::get('viewDeals',[ExternalFunctions::class,'viewDeals'] );
Route::get('assets',[ExternalFunctions::class,'assets'] );
Route::get('crudasset/{id}',[ExternalFunctions::class,'crudasset'] );
Route::get('missedvisit', [ExternalFunctions::class,'viewMissedVisit']);
Route::get('notVisitedView',[ExternalFunctions::class,'notVisitedView'] );
Route::get('visitsdates/{datefrom}/{dateto}',[ExternalFunctions::class,'visitsdates'] );
Route::get('dealsdates/{datefrom}/{dateto}',[ExternalFunctions::class,'dealsdates'] );
Route::get('webstore', [ExternalFunctions::class,'webstore']);
Route::post('synchwebstore', [ExternalFunctions::class,'synchwebstore']);
Route::post('syncproducts', [ExternalFunctions::class,'syncproducts']);
Route::post('syncpricelistPrices',[ExternalFunctions::class,'syncpricelistPrices'] );
Route::post('syncpricelistStock',[ExternalFunctions::class,'syncpricelistStock'] );
Route::post('syncoverallspecials',[ExternalFunctions::class,'syncoverallspecials'] );
Route::post('synccustomers',[ExternalFunctions::class,'synccustomers'] );
Route::post('syncorderpattern',[ExternalFunctions::class,'syncorderpattern'] );
Route::post('syncpricelist', [ExternalFunctions::class,'syncpricelist']);
Route::post('syncgroupspecials',[ExternalFunctions::class,'syncgroupspecials'] );
Route::post('synccustomerspecials',[ExternalFunctions::class,'synccustomerspecials'] );
Route::get('restFullInvoices/{month}/{year}/{custcode}', [ExternalFunctions::class,'restFullInvoices']);
Route::get('returnPDF/{invoicenumber}',[ExternalFunctions::class,'returnPDF'] );
Route::get('visitsLog/{date1}/{date2}',[ExternalFunctions::class,'visitsLog'] );
Route::get('notVisitedLog/{date1}/{date2}',[ExternalFunctions::class,'notVisitedLog'] );
// EXTERNAL FUNCTIONS ENDS HERE !!!


//ONLINE ORDERS STARTS HERE!!!
Route::get('remoteorders',[OnlineOrders::class,'remoteorders'] );
Route::get('mymarketGetSales',[OnlineOrders::class,'mymarketGetSales'] );
Route::post('getMymarketOrdersToDealWith',[OnlineOrders::class,'getMymarketOrdersToDealWith'] );
Route::get('viewMyMarketOrders',[OnlineOrders::class,'viewMyMarketOrders'] );
Route::get('orderScreening', [OnlineOrders::class,'orderScreening']);
Route::post('testAPI',[OnlineOrders::class,'testAPI'] );
Route::post('deleteRemoteOrder', [OnlineOrders::class,'deleteRemoteOrder']);
Route::post('updateOnlineLinesAndHeaders',[OnlineOrders::class,'updateOnlineLinesAndHeaders'] );
Route::get('outstandingorders', [OnlineOrders::class,'outstandingorders']);
Route::get('onlineOrderHistory/{date1}/{date2}', [OnlineOrders::class,'onlineOrderHistory']);
Route::get('getFreshOrderHeadersOutstanding', [OnlineOrders::class,'getFreshOrderHeadersOutstanding']);
Route::post('Xmlcommitremoteorder',[OnlineOrders::class,'Xmlcommitremoteorder']);
Route::get('getFreshOrderHeaders ',[OnlineOrders::class,'getFreshOrderHeaders']);
Route::get('getOrderLines/{id}',[OnlineOrders::class,'getOrderLines']);
Route::get('getNewDealToAuth/{id}',[OnlineOrders::class,'getNewDealToAuth']);
Route::post('postauthdeal',[OnlineOrders::class,'postauthdeal']);

//ONLINE ORDERS ENDS HERE!!!

//ONLINE ORDERS RECON CONTROLLER STARTS HERE !!!

Route::get('returnRefunds', [OnlineOrdersReconController::class,'returnRefunds']);
Route::get('viewRefunds', [OnlineOrdersReconController::class,'viewRefunds']);

//ONLINE ORDERS RECON CONTROLLER ENDS HERE !!!

/******************************************BACK ORDERS**********************************************************************************/
//BACK ORDERCONTROLLER CONTROLLER STARTS HERE
Route::get('remoteordersbackorders', [OnlineOrdersReconController::class,'remoteordersbackorders']);
Route::post('testAPIbackorders',[OnlineOrdersReconController::class,'testAPIbackorders'] );
Route::post('deleteRemoteOrderbackorders',[OnlineOrdersReconController::class,'deleteRemoteOrderbackorders'] );
Route::post('updateOnlineLinesAndHeadersbackorder', [OnlineOrdersReconController::class,'updateOnlineLinesAndHeadersbackorder']);
Route::get('outstandingordersbackorder', [OnlineOrdersReconController::class,'outstandingordersbackorder']);
Route::get('onlineOrderHistorybackorder/{date1}/{date2}',[OnlineOrdersReconController::class,'onlineOrderHistorybackorder'] );
Route::get('getFreshOrderHeadersOutstandingbackorder',[OnlineOrdersReconController::class,'getFreshOrderHeadersOutstandingbackorder'] );
Route::post('Xmlcommitremoteorderbackorder',[OnlineOrdersReconController::class,'Xmlcommitremoteorderbackorder'] );
Route::get('getFreshOrderHeadersbackorder',[OnlineOrdersReconController::class,'getFreshOrderHeadersbackorder'] );
Route::get('getNoStockItem',[OnlineOrdersReconController::class,'getNoStockItem']);
Route::get('getItemWithNoStock',[OnlineOrdersReconController::class,'getItemWithNoStock'] );
Route::get('getOrderLinesbackorder/{id}',[OnlineOrdersReconController::class,'getOrderLinesbackorder'] );
Route::get('getNewDealToAuthbackorder/{id}',[OnlineOrdersReconController::class,'getNewDealToAuthbackorder'] );
Route::post('postauthdealbackorder', [OnlineOrdersReconController::class,'postauthdealbackorder']);
Route::get('productsonbackorderjson',[OnlineOrdersReconController::class,'productsonbackorderjson'] );
Route::get('productsOnBackOrders',[OnlineOrdersReconController::class,'productsOnBackOrders'] );
//BACK ORDERCONTROLLER CONTROLLER ENDS HERE
/********************************************************END **************************************************************************/


//WAREHOUSECONTROLLER CONTROLLER STARTS HERE !!!
Route::group(['middleware' => 'auth'], function() {
    Route::get('listenToScale', [WareHouseController::class,'listenToScale']);
    Route::get('getForkliftNumber', [WareHouseController::class,'getForkliftNumber']);
    Route::get('getMainWarehouseReport', [WareHouseController::class,'getMainWarehouseReport']);
    Route::get('getMainWarehouseReportByDate', [WareHouseController::class,'getMainWarehouseReportByDate']);
    Route::get('recievingwarehousereport', [WareHouseController::class,'recievingwarehousereport']);
    Route::get('warehouseitems', [WareHouseController::class,'warehouseInvetoryItems']);
    Route::get('onOrderAdvanced', [WareHouseController::class,'onOrderAdvanced']);
    Route::get('initiateproductonmachine', [WareHouseController::class,'initiateproductonmachine']);
    Route::get('getPallets', [WareHouseController::class,'getPallets']);
    Route::get('getDeptname', [WareHouseController::class,'getDeptname']);
    Route::get('getAreaname', [WareHouseController::class,'getAreaname']);
    Route::get('getLabels', [WareHouseController::class,'getLabels']);
    Route::get('getMappedLabels', [WareHouseController::class,'getMappedLabels']);
    Route::get('getCustomername', [WareHouseController::class,'getCustomername']);
    Route::get('getScales', [WareHouseController::class,'getScales']);
    Route::get('getTare', [WareHouseController::class,'getTare']);
    Route::get('getMachines', [WareHouseController::class,'getMachines']);
    Route::get('getgroupname', [WareHouseController::class,'getgroupname']);
    Route::get('viewpickingtickets',[TabletLoadingApp::class,'viewpickingtickets']);
    Route::get('getGroupTypeById', [WareHouseController::class,'getGroupTypeById']);
    Route::post('saveGroupTypeById', [WareHouseController::class,'saveGroupTypeById']);
    Route::get('getProductsMappedToGroupType', [WareHouseController::class,'getProductsMappedToGroupType']);
    Route::post('saveProductsMappedToGroupType', [WareHouseController::class,'saveProductsMappedToGroupType']);
    Route::get('getGroupTypesByGroupId', [WareHouseController::class,'getGroupTypesByGroupId']);
    Route::get('getgroupsetting', [WareHouseController::class,'getgroupsetting']);
    Route::get('getusers', [WareHouseController::class,'getusers']);
    Route::get('deleteUser', [WareHouseController::class,'deleteUser']);
    Route::get('updateUser', [WareHouseController::class,'updateUser']);
    Route::get('updateUserPrinters', [WareHouseController::class,'updateUserPrinters']);
    Route::get('getweigh', [WareHouseController::class,'getweigh']);
    Route::get('getscales', [WareHouseController::class,'getscales']);
    Route::get('getregrade', [WareHouseController::class,'getregrade']);
    Route::get('getticketno', [WareHouseController::class,'getticketno']);
    Route::get('getmasswmax', [WareHouseController::class,'getmasswmax']);
    Route::get('getSEno', [WareHouseController::class,'getSEno']);
    Route::get('getretest', [WareHouseController::class,'getretest']);
    Route::get('getMappedItemstoPalletJson', [WareHouseController::class,'getMappedItemstoPalletJson']);
    Route::get('getMachinemappedtoarea', [WareHouseController::class,'getMachinemappedtoarea']);
    Route::get('getMachinesmappedtodept', [WareHouseController::class,'getMachinesmappedtodept']);
    Route::post('getpalletconfforitems', [WareHouseController::class,'getpalletconfforitems']);
    Route::post('validatepalletsplan', [WareHouseController::class,'validatepalletsplan']);
    Route::get('getMappedDepartmentsMachinesItemasJson', [WareHouseController::class,'getMappedDepartmentsMachinesItemasJson']);
    Route::get('getProductsMappedToMachine', [WareHouseController::class,'getProductsMappedToMachine']);
    Route::post('mapProductToMachine', [WareHouseController::class,'mapProductToMachine']);
    Route::get('selectedDepartment', [WareHouseController::class,'selectedDepartment']);
    Route::post('updatePalletConfig', [WareHouseController::class,'updatePalletConfig']);
    Route::post('deletePalletConfig', [WareHouseController::class,'deletePalletConfig']);
    Route::post('savespalletstoitems', [WareHouseController::class,'savespalletstoitems']);
    Route::post('savesmachinedeptitems', [WareHouseController::class,'savesmachinedeptitems']);
    Route::post('savesMachinetoarea', [WareHouseController::class,'savesMachinetoarea']);
    Route::post('savesMachinemaptodept', [WareHouseController::class,'savesMachinemaptodept']);
    Route::post('updateDeptName', [WareHouseController::class,'updateDeptName']);
    Route::post('deleteDept', [WareHouseController::class,'deleteDept']);
    Route::post('updateAreaName', [WareHouseController::class,'updateAreaName']);
    Route::post('deleteCustomerName', [WareHouseController::class,'deleteCustomerName']);
    Route::post('updateGalvCustomer', [WareHouseController::class,'updateGalvCustomer']);

    Route::get('getgalvcreateproductspecsheet', [WareHouseController::class,'getgalvcreateproductspecsheet']);
    Route::post('deletesalesorders', [WareHouseController::class,'deletesalesorders']);
    Route::post('deleteScale', [WareHouseController::class,'deleteScale']);
    Route::post('updateMachineName', [WareHouseController::class,'updateMachineName']);
    Route::post('deleteMachine', [WareHouseController::class,'deleteMachine']);
    Route::post('updategroupname', [WareHouseController::class,'updategroupname']);
    Route::post('savesPallet', [WareHouseController::class,'savesPallet']);
    Route::post('savesdeptname', [WareHouseController::class,'savesdeptname']);
    Route::post('savesareaname', [WareHouseController::class,'savesareaname']);
    Route::post('updateAreaName', [WareHouseController::class,'updateAreaName']);
    Route::post('deleteArea', [WareHouseController::class,'deleteArea']);
    Route::post('savescustomername', [WareHouseController::class,'savescustomername']);
    Route::post('savesscale', [WareHouseController::class,'savesscale']);
    Route::post('savesmachine', [WareHouseController::class,'savesmachine']);
    Route::post('savesgroupname', [WareHouseController::class,'savesgroupname']);
    Route::post('savessettingname', [WareHouseController::class,'savessettingname']);
    Route::post('removemapping', [WareHouseController::class,'removemapping']);
    Route::post('unmapmachinefromdept', [WareHouseController::class,'unmapmachinefromdept']);
    Route::post('removemappingdeptmachitems', [WareHouseController::class,'removemappingdeptmachitems']);
    Route::post('savepermissions', [WareHouseController::class,'savepermissions']);
    Route::post('printgenericlabel', [WareHouseController::class,'printgenericlabel']);
    Route::post('printgalvlabel', [WareHouseController::class,'printgalvlabel']);
    Route::get('startendjob', [WareHouseController::class,'startendjob']);
    Route::get('issuestock', [WareHouseController::class,'issuestock']);
    Route::get('getIssueStock', [WareHouseController::class,'getIssueStock']);
    Route::get('syncing', [WareHouseController::class,'syncing']);
    Route::get('syncPastelStockTable', [WareHouseController::class,'syncPastelStockTable']);
    Route::get('getLocationNamesAndTypes', [WareHouseController::class,'getLocationNamesAndTypes']);
    Route::get('getWIP', [WareHouseController::class,'getWIP']);
    Route::get('getRoofWIP', [WareHouseController::class,'getRoofWIP']);
    Route::get('getroofingWIP', [WareHouseController::class,'getroofingWIP']);
    Route::get('roofingReport', [WareHouseController::class,'roofingReport']);
    Route::get('galvReport', [WareHouseController::class,'galvReport']);
    Route::get('galvProducts', [WareHouseController::class,'galvProducts']);
    Route::post('updateGalvProduct', [WareHouseController::class,'updateGalvProduct']);
    Route::get('getRoofingSalesOrders', [WareHouseController::class,'getRoofingSalesOrders']);
    Route::post('deleteRoofingBatch', [WareHouseController::class,'deleteRoofingBatch']);
    Route::post('deleteRoofingSO', [WareHouseController::class,'deleteRoofingSO']);
    Route::get('getWIPjobstarted', [WareHouseController::class,'getWIPjobstarted']);
    Route::get('endjob', [WareHouseController::class,'endjob']);
    Route::get('getJobStarted', [WareHouseController::class,'getJobStarted']);
    Route::get('getjobsdatajson', [WareHouseController::class,'getjobsdatajson']);
    Route::get('getgenericlabelprintscreen', [WareHouseController::class,'getgenericlabelprintscreen']);
    Route::get('createuserpage', [WareHouseController::class,'createuserpage']);
    Route::get('getUserPrinters', [WareHouseController::class,'getUserPrinters']);
    Route::post('createuser', [WareHouseController::class,'createuser']);
    Route::get('modifyuserleaderpage',[WareHouseController::class,'modifyuserleaderpage']);
    Route::post('modifyuserleader',[WareHouseController::class,'modifyuserleader']);
    Route::post('deleteuserleader',[WareHouseController::class,'deleteuserleader']);
    Route::get('creategrouppage', [WareHouseController::class, 'creategrouppage']);
    Route::get('qrcodetracker', [WareHouseController::class,'qrcodetracker']);
    Route::get('getviewGridStockSummary', [WareHouseController::class,'getviewGridStockSummary']);
    Route::get('getviewGridStockReport', [WareHouseController::class,'getviewGridStockReport']);
    Route::get('getviewGridStockDetails', [WareHouseController::class,'getviewGridStockDetails']);
    Route::get('getviewGridStockBalance', [WareHouseController::class,'getviewGridStockBalance']);
    Route::get('getpalletmovementreport', [WareHouseController::class,'getpalletmovementreport']);
    Route::get('getitemmovementreport', [WareHouseController::class,'getitemmovementreport']);
    Route::get('getpalletreversalreport', [WareHouseController::class,'getpalletreversalreport']);
    Route::get('wmaxreprint', [WareHouseController::class,'wmaxreprint']);
    Route::post('galvReprintEdit', [WareHouseController::class,'galvReprintEdit']);
    Route::get('getGalvReprints', [WareHouseController::class,'getGalvReprints']);
    Route::get('binandqrcodes', [WareHouseController::class,'binandqrcodes']);
    Route::get('printlocationqrcodes/{location}', [WareHouseController::class,'printlocationqrcodes']);
    Route::get('getProductGroupMappedToDept', [WareHouseController::class,'getProductGroupMappedToDept']);
    Route::get('getProdCategory', [WareHouseController::class,'getProdCategory']);
    Route::get('doneprintingpallet', [WareHouseController::class,'doneprintingpallet']);
    Route::get('getBinLocationsJson', [WareHouseController::class,'getBinLocationsJson']);
    Route::get('qrcodeimage/{binlocation}', [WareHouseController::class,'qrcodeimage']);
    Route::get('customergridlookup', [WareHouseController::class,'customergridlookup']);
    Route::get('getMachinesforselecteddept', [WareHouseController::class,'getMachinesforselecteddept']);
    Route::post('insertIntoJobTable', [WareHouseController::class,'insertIntoJobTable']);
    Route::post('insertPrePlannedSO', [WareHouseController::class,'insertPrePlannedSO']);
    Route::post('updateRoofLines', [WareHouseController::class,'updateRoofLines']);
    Route::post('updateRoofLinesSequence', [WareHouseController::class,'updateRoofLinesSequence']);
    Route::get('getPalletForSelectedItem', [WareHouseController::class,'getPalletForSelectedItem']);
    Route::get('getDepListToPlan', [WareHouseController::class,'getDepListToPlan']);
    Route::get('getProdListToPlan', [WareHouseController::class,'getProdListToPlan']);
    Route::get('getsalesorderstoplan', [WareHouseController::class,'getsalesorderstoplan']);
    Route::get('qrcodereversepallet', [WareHouseController::class,'qrcodereversepallet']);
    Route::get('qrcodebreakpallet', [WareHouseController::class,'qrcodebreakpallet']);
    Route::get('getProductPlannedOnThatMachine', [WareHouseController::class,'getProductPlannedOnThatMachine']);
    Route::get('roofinguserscreen', [WareHouseController::class,'roofinguserscreen']);
    Route::get('choosemachine/{department}', [WareHouseController::class,'choosemachine']);
    Route::get('printpalletchoosemachine/{department}', [WareHouseController::class,'printpalletchoosemachine']);
    Route::get('choosproducttomake/{qty}/{itemcode}/{palletid}/{machineid}', [WareHouseController::class,'choosproducttomake']);
    Route::get('printpalletchoosproducttomake/{department}/{machine}', [WareHouseController::class,'printpalletchoosproducttomake']);
    Route::get('printselectedcriteria/{department}/{machine}/{product}', [WareHouseController::class,'printselectedcriteria']);
    Route::get('goprintfirstqrcode/{department}/{machine}/{product}/{pallet}/{required}', [WareHouseController::class,'goprintfirstqrcode']);
    Route::get('startprintingjob/{qty}/{machine}/{product}/{pallet}/{startdate}', [WareHouseController::class,'startprintingjob']);
    Route::post('acceptholdweigh', [WareHouseController::class,'acceptholdweigh']);
    Route::post('savestockchangewmax', [WareHouseController::class,'savestockchangewmax']);
    Route::post('saveretest', [WareHouseController::class,'saveretest']);
    Route::post('regradeproduct', [WareHouseController::class,'regradeproduct']);
    Route::post('addproductspec', [WareHouseController::class,'addproductspec']);
    Route::post('updatemanualloadingifitemhasnolabelatall', [WareHouseController::class,'updatemanualloadingifitemhasnolabelatall']);
    Route::post('editproductspec', [WareHouseController::class,'editproductspec']);
    Route::get('teamleadermanage/{ref}', [WareHouseController::class, 'teamleadermanage']);
    Route::get('teamleaderUpdatePickingLoadingTable', [WareHouseController::class, 'teamleaderUpdatePickingLoadingTable']);
    Route::get('teamleaderupdateholdstatus', [WareHouseController::class, 'teamleaderupdateholdstatus']);
    Route::get('teamleaderollover', [WareHouseController::class, 'teamleaderollover']);
    Route::get('getTeamLeaderPlans',[WarehouseController::class,'getTeamLeaderPlans']);
    Route::post('printtripsheetmobile',[WarehouseController::class,'printtripsheetmobile']);
    Route::get('teamLeaderAssign',[WarehouseController::class,'teamLeaderAssign']);
    Route::get('teamLeaderEquipmentAssign',[WarehouseController::class,'teamLeaderEquipmentAssign']);
    Route::get('teamLeaderGetPickingPlanData',[WarehouseController::class,'teamLeaderGetPickingPlanData']);
    Route::get('teamLeaderGetNotifications',[WarehouseController::class,'teamLeaderGetNotifications']);
    Route::get('teamLeaderGetStatus',[WarehouseController::class,'teamLeaderGetStatus']);
    Route::get('teamLeaderApproveNotification',[WarehouseController::class,'teamLeaderApproveNotification']);
    Route::get('teamLeaderUnapproveNotification',[WarehouseController::class,'teamLeaderUnapproveNotification']);
    Route::get('teamLeaderReveseApprovedNotification',[WarehouseController::class,'teamLeaderReveseApprovedNotification']);
    Route::get('teamLeaderGetInstructions',[WarehouseController::class,'teamLeaderGetInstructions']);
    Route::get('teamLeaderGetPickingPlanToInvoice',[WarehouseController::class,'teamLeaderGetPickingPlanToInvoice']);
    Route::post('teamLeaderCompleteLoad',[WarehouseController::class,'teamLeaderCompleteLoad']);
    Route::get('getproductbyjobid',[WareHouseController::class,'getproductbyjobid']);
    Route::post('printgenericpalletlabel',[WareHouseController::class,'printgenericpalletlabel']);
    Route::get('updatestartdate', [WareHouseController::class,'updatestartdate']);
    Route::get('jobupdateprint/{jobid}', [WareHouseController::class,'jobupdateprint']);
    Route::get('roofingSOUpdate/{reference}/{machine}', [WareHouseController::class,'roofingSOUpdate']);
    Route::get('getRoofingSOtoUpdate', [WareHouseController::class,'getRoofingSOtoUpdate']);
    Route::get('changeRoofingSOStatus', [WareHouseController::class,'changeRoofingSOStatus']);
    Route::get('changeRoofingInvoiceStatus', [WareHouseController::class,'changeRoofingInvoiceStatus']);
    Route::post('sendProductionCommunication', [WareHouseController::class,'sendProductionCommunication']);
    Route::get('getsalesorders', [WareHouseController::class,'getsalesorders']);
    Route::get('getroofingheaders', [WareHouseController::class,'getroofingheaders']);
    Route::get('getroofinglines', [WareHouseController::class,'getroofinglines']);
    Route::get('sendLabelToThePrinter', [WareHouseController::class,'sendLabelToThePrinter']);
    Route::get('sendRoofingLabelToThePrinter', [WareHouseController::class,'sendRoofingLabelToThePrinter']);
    Route::get('printAdditionalRoofingLabels', [WareHouseController::class,'printAdditionalRoofingLabels']);
    Route::get('startgenratingqrcodeforpallet/{jpbid}/{isroofing}', [WareHouseController::class,'startgenratingqrcodeforpallet']);
    Route::get('createPalletConfig', [WareHouseController::class,'createPalletConfig']);
    Route::get('mapitemstopallet', [WareHouseController::class,'mapitemstopallet']);
    Route::post('saveLabels', [WareHouseController::class,'saveLabels']);
    Route::post('deleteSavedLabelMapping',[WareHouseController::class,'deleteSavedLabelMapping']);
    Route::get('getUpliftmentPage',[WareHouseController::class,'getUpliftmentPage']);
    Route::get('retrieveUpliftmentPrint/{intupliftmentnumber}',[WareHouseController::class,'getUpliftmentPrintPDFEmbed']);
    Route::post('insertUpliftmentAll',[WareHouseController::class,'insertUpliftmentAll']);
    Route::post('updateUpliftmentPost',[WareHouseController::class,'updateUpliftmentPost']);
    Route::post('approveUpliftmentPost',[WareHouseController::class,'approveUpliftmentPost']);
    Route::get('getUpliftmentSalesOrderLines',[WareHouseController::class,'getUpliftmentSalesOrderLines']);
    Route::get('getUpliftmentRecords',[WareHouseController::class,'getUpliftmentRecords']);
    Route::post('getCustomerForSelectedCompany',[WareHouseController::class,'getCustomerForSelectedCompany']);
    Route::post('getAreaAddressInvoiceInfoParam',[WarehouseController::class,'getAreaAddressInvoiceInfoParam']);
    Route::post('getAreaAddressInvoices',[WareHouseController::class,'getAreaAddressInvoices']);
    Route::post('updateSavedLabels', [WareHouseController::class,'updateSavedLabels']);
    Route::post('deleteSavedLabels', [WareHouseController::class,'deleteSavedLabels']);
    Route::get('getUpliftmentDetails',[WareHouseController::class,'getUpliftmentDetails']);
    Route::post('deleteUpliftmentPost',[WareHouseController::class,'deleteUpliftmentPost']);
    Route::post('printUpliftmentPost',[WareHouseController::class,'printUpliftmentPost']);
    Route::post('completeUpliftmentPost',[WareHouseController::class,'completeUpliftmentPost']);
    Route::post('denyUpliftmentPost',[WareHouseController::class,'denyUpliftmentPost']);
    Route::get('upliftImageGetter/{upliftmentnumber}',[WareHouseController::class,'upliftImageGetter']);
    Route::get('upliftmentBacklog/{upliftmentnumber}',[WareHouseController::class,'upliftmentBacklog']);
    Route::get('upliftmentUploads/{upliftmentnumber}',[WareHouseController::class,'upliftmentUploads']);
    Route::get('upliftEnquiry/{upliftmentnumber}',[WareHouseController::class,'upliftEnquiry']);
    Route::post('upliftmentMessagePost',[WarehouseController::class,'upliftmentMessagePost']);
    Route::post('mapLabelToProdCat', [WareHouseController::class,'mapLabelToProdCat']);
    Route::post('deleteMappedLabels', [WareHouseController::class,'deleteMappedLabels']);
    Route::post('xmlUserGridPermsPost',[WareHouseController::class,'xmlUserGridPermsPost']);
    Route::get('galvmodulecomms',[WareHouseController::class,'galvmodulecomms']);
    Route::get('areapage', [WareHouseController::class,'areapage']);
    Route::get('labelspage', [WareHouseController::class,'labelspage']);
    Route::get('labelmapping', [WareHouseController::class,'labelmapping']);
    Route::get('getLabelInformation', [WareHouseController::class,'getLabelInformation']);
    Route::get('genericproductlabels', [WareHouseController::class,'genericproductlabels']);
    Route::get('warehousepalletlabels', [WareHouseController::class,'warehousepalletlabels']);
    Route::get('getProductInfo', [WareHouseController::class,'getProductInfo']);
    Route::get('getProductInfoAppend',[WareHouseController::class,'getProductInfoAppend']);
    Route::get('getProductBarcode', [WareHouseController::class,'getProductBarcode']);
    Route::get('userpermissions/{userid}', [WareHouseController::class,'userpermissions']);
    Route::get('dashboard', [WareHouseController::class,'dashboard']);
    Route::get('departmentpage', [WareHouseController::class,'departmentpage']);
    Route::get('machines', [WareHouseController::class,'machinespage']);
    Route::get('mapmachinetoarea', [WareHouseController::class,'mapmachinetoarea']);
    Route::get('mapmachinestodept', [WareHouseController::class,'mapmachinestodept']);
    Route::get('mapitemsmachinesdept', [WareHouseController::class,'mapdeptitem']);
    Route::get('createjobs', [WareHouseController::class,'createjobs']);
    Route::get('roofworkorders', [WareHouseController::class,'roofworkorders']);
    Route::get('printpalletsselectdept', [WareHouseController::class,'printpalletsselectdept']);
    Route::get('location', [WareHouseController::class,'location']);
    Route::get('stocklocation', [WareHouseController::class,'stocklocation']);
    Route::get('stockdetails/{productCode}', [WareHouseController::class,'stockdetails']);
    Route::get('getjobsdata', [WareHouseController::class,'getjobsdata']);
    Route::get('exceptionmovementreport', [WareHouseController::class,'exceptionmovementreport']);
    Route::get('getjobcard/{JobID}', [WareHouseController::class,'getjobcard']);
    Route::get('getgalvlabel/{JobNo}/{CustName}/{TicketNo}/{Status}', [WareHouseController::class,'getgalvlabel']);
    Route::get('getallactivejobs', [WareHouseController::class,'getallactivejobs']);
    Route::get('getgalvproductspecsheet', [WareHouseController::class,'getgalvproductspecsheet']);
    Route::get('galvcustomer', [WareHouseController::class,'galvcustomer']);
    Route::get('galvcreateprodspec', [WareHouseController::class,'galvcreateprodspec']);
    Route::get('galveditprodspec', [WareHouseController::class,'galveditprodspec']);
    Route::get('galvscale', [WareHouseController::class,'galvscale']);
    Route::get('wmaxweigh', [WareHouseController::class,'wmaxweigh']);
    Route::get('wmaxregrade', [WareHouseController::class,'wmaxregrade']);
    Route::get('wmaxstockchange', [WareHouseController::class,'wmaxstockchange']);
    Route::get('wmaxretest', [WareHouseController::class,'wmaxretest']);
    Route::get('pickersandloadersdashboard', [WareHouseController::class,'pickersandloadersdashboard']);
    Route::get('pickingticketmanager/{ref}', [WareHouseController::class,'pickingticketmanager']);
    Route::get('getpickersandloadersdashboard', [WareHouseController::class,'getpickersandloadersdashboard']);
    Route::get('stockIssueTypes', [WareHouseController::class,'stockIssueTypes']);
    Route::get('getStockIssueTypes', [WareHouseController::class,'getStockIssueTypes']);
    Route::post('saveStockIssueType', [WareHouseController::class,'saveStockIssueType']);
    Route::post('updateStockIssueType', [WareHouseController::class,'updateStockIssueType']);
    Route::post('deleteStockIssueType', [WareHouseController::class,'deleteStockIssueType']);
    Route::get('subDepartments', [WareHouseController::class,'subDepartments']);
    Route::get('getSubDepartments', [WareHouseController::class,'getSubDepartments']);
    Route::post('saveSubDepartment', [WareHouseController::class,'saveSubDepartment']);
    Route::post('updateSubDepartment', [WareHouseController::class,'updateSubDepartment']);
    Route::post('deleteSubDepartment', [WareHouseController::class,'deleteSubDepartment']);
    Route::post('savestockissue', [WareHouseController::class,'savestockissue']);
    Route::get('getStockItemsByGroup', [WareHouseController::class,'getStockItemsByGroup']);
    Route::get('getMachinesByDepartment', [WareHouseController::class,'getMachinesByDepartment']);
    Route::get('getUpkeepJobAsset/{ID}', [WareHouseController::class,'getUpkeepJobAsset']);
    Route::get('getUpkeepJobLocation/{ID}', [WareHouseController::class,'getUpkeepJobLocation']);
    Route::get('GetAreaDeptSubDeptByMachine', [WareHouseController::class,'GetAreaDeptSubDeptByMachine']);
    Route::get('bulkMapping', [WareHouseController::class,'bulkMapping']);
    Route::get('checkBulkMapping', [WareHouseController::class,'checkBulkMapping']);
    Route::post('bulkMappingCRUD', [WareHouseController::class,'bulkMappingCRUD']);
    Route::get('getBulkMappingAreaDeptSubDeptMachines', [WareHouseController::class,'getBulkMappingAreaDeptSubDeptMachines']);
    Route::get('getProductsMappedToDepartment', [WareHouseController::class,'getProductsMappedToDepartment']);
    Route::get('nailsInner', [WareHouseController::class,'nailsInner']);
    Route::post('nailsInnerCrud', [WareHouseController::class,'nailsInnerCrud']);
    Route::get('genericqrcodereverse', [WareHouseController::class,'genericqrcodereverse']);
    Route::get('qrcodereverse', [WareHouseController::class,'qrcodereverse']);
    Route::get('trucksequencing', [WareHouseController::class,'trucksequencing']);
    Route::get('getTruckSequencing', [WareHouseController::class,'getTruckSequencing']);
    Route::post('updateTruckLoadingSequence', [WareHouseController::class,'updateTruckLoadingSequence']);
    Route::get('failedInvoices', [WareHouseController::class,'failedInvoices']);
    Route::get('getFailedInvoices', [WareHouseController::class,'getFailedInvoices']);
    Route::get('checkScanned', [WareHouseController::class,'checkScanned']);
    Route::get('getCheckScanned', [WareHouseController::class,'getCheckScanned']);
});

//WAREHOUSECONTROLLER CONTROLLER ENDS HERE !!!

//GALV CONTROLLER STARTS HERE !!!
Route::group(['middleware' => 'auth'], function() {
    Route::get('galvJumboCoilsPrint', [GalvController::class,'galvJumboCoilsPrint']);
    Route::get('getWmaxTickets', [GalvController::class,'getWmaxTickets']);
    Route::get('galvPrintJumboCoil', [GalvController::class,'galvPrintJumboCoil']);
    Route::get('wmaxscrap', [GalvController::class,'wmaxscrap']);
    Route::post('postScrapWeigh', [GalvController::class,'postScrapWeigh']);

    Route::get('wmaxlanding', [GalvController::class,'wmaxlanding']);
    Route::get('qc1', [GalvController::class,'qc1']);
    Route::get('qc2', [GalvController::class,'qc2']);
    Route::get('getqc1comments', [GalvController::class,'getqc1comments']);
    Route::get('getqc2comments', [GalvController::class,'getqc2comments']);
    Route::post('qc1pf', [GalvController::class,'qc1pf']);
    Route::post('qc2pf', [GalvController::class,'qc2pf']);
    Route::get('getqc1', [GalvController::class,'getqc1']);
    Route::get('getqc2', [GalvController::class,'getqc2']);
    Route::get('checkForGalvUpdates', [GalvController::class,'checkForGalvUpdates']);
    Route::get('deleteGalvChecker', [GalvController::class,'deleteGalvChecker']);
    Route::get('wmaxgetcustomerproduct', [GalvController::class,'wmaxgetcustomerproduct']);
    Route::get('wmaxgetproductinfo', [GalvController::class,'wmaxgetproductinfo']);
    Route::get('wmaxgetproductwiresize', [GalvController::class,'wmaxgetproductwiresize']);
    Route::get('wmaxdepartmentgalv', [GalvController::class,'wmaxdepartmentgalv']);
    Route::get('wmaxdepartmentmachinesgalv', [GalvController::class,'wmaxdepartmentmachinesgalv']);
    Route::get('getGalvWIP', [GalvController::class,'getGalvWIP']);
    Route::get('changeGalvJobStatus', [GalvController::class,'changeGalvJobStatus']);
    Route::get('getGalvWIPConsolidated',[GalvController::class,'getGalvWIPConsolidated']);
    Route::post('insertIntoJobTableGalv', [GalvController::class,'insertIntoJobTableGalv']);

});
//GALV CONTROLLER ENDS HERE !!!

//WAREHOUSE SETUP CONTROLLER STARTS HERE !!!
Route::group(['middleware' => 'auth'], function() {
    Route::get('LocationsAndBins', [WarehouseSetupController::class,'LocationsAndBins']);
    Route::post('stockLocationCrud', [WarehouseSetupController::class,'stockLocationCrud']);
    Route::post('stockLocationTypesCrud', [WarehouseSetupController::class,'stockLocationTypesCrud']);
    Route::post('stockLocationAttributesCrud', [WarehouseSetupController::class,'stockLocationAttributesCrud']);
    Route::post('dcCRUD', [WarehouseSetupController::class,'dcCRUD']);
    Route::post('binCrud', [WarehouseSetupController::class,'binCrud']);
    Route::post('binAttributesCrud', [WarehouseSetupController::class,'binAttributesCrud']);
});
//WAREHOUSE SETUP CONTROLLER ENDS HERE !!!

//COMPANYAUTHCONTROLLER CONTROLLER STARTS HERE !!!
Route::get('getBlockedAccountToAuth', [CompanyAuthController::class,'getBlockedAccountToAuth']);
Route::get('viewBlockedAccount',[CompanyAuthController::class,'viewBlockedAccount'] );
Route::get('getSpecificOrdersBlocked/{customerId}', [CompanyAuthController::class,'getSpecificOrdersBlocked']);
Route::get('getSpecificBlockedOrdersJson/{orderid}',[CompanyAuthController::class,'getSpecificBlockedOrdersJson'] );
Route::get('getoutstandingorderstoauthjson/{orderid}', [CompanyAuthController::class,'getoutstandingorderstoauthjson']);


//COMPANYAUTHCONTROLLER CONTROLLER ENDS HERE !!!

//POS CONTROLLER STARTS HERE !!!
Route::get('viewassignuserstotill',[POS::class,'viewassignuserstotill']);
Route::post('submittillusers',[POS::class,'submittillusers'] );
Route::post('closedrawer',[POS::class,'closedrawer'] );

//POS CONTROLLER ENDS HERE !!!

//GOOGLE MAPS CONTROLLER STARTS HERE !!!

Route::get('mappage/{date}/{routeid}/{ordertype}', [GoogleMapsController::class,'mappage']);

//GOOGLE MAPS CONTROLLER STARTS HERE !!!

//IMPORT EXCEL CONTROLLER STARTS HERE !!!
Route::get('/import_excel', [ImportExcelController::class,'mappage']);
Route::post('/import_excel/import', [ImportExcelController::class,'mappage']);

//IMPORT EXCEL CONTROLLER ENDS HERE !!!

//LAYALTYPROGRAMCONTROLLER CONTROLLER STARTS HERE !!!

Route::get('registercards', [LayaltyProgramController::class,'MapACardToTheUsers']);
Route::get('cardnumberlookup',[LayaltyProgramController::class,'CardNumberLookUp'] );
Route::get('saveinfocard',[LayaltyProgramController::class,'saveinfocard'] );
Route::get('registercardswalking', [LayaltyProgramController::class,'MapACardToTheUsersWalking']);
Route::get('cardnumberlookupWalking',[LayaltyProgramController::class,'CardNumberLookUpWalking'] );
Route::get('saveinfocardwalking', [LayaltyProgramController::class,'saveinfocardWalking']);
Route::get('verifyemail', [LayaltyProgramController::class,'verifyemail']);
Route::get('checkifIdexists',[LayaltyProgramController::class,'checkifIdexists'] );


Route::get('routePlannerExtParam/{date}/{ordertype}/{route}/{status}', [TabletLoadingApp::class,'routePlannerExtParam']);



//LAYALTYPROGRAMCONTROLLER CONTROLLER STARTS HERE !!!
/*************************XERO********************************/
Route::get('/manage/xero', [\App\Http\Controllers\XeroController::class, 'index'])->name('xero.auth.success');


Route::get('/xero/createInvoices', [\App\Http\Controllers\XeroController::class, 'createInvoices'])->name('xero.createInvoices');
Route::get('/xero/retrieveInvoices', [\App\Http\Controllers\XeroController::class, 'retrieveInvoices'])->name('xero.retrieveInvoices');
Route::get('/xero/retrieveInvoice', [\App\Http\Controllers\XeroController::class, 'retrieveInvoice'])->name('xero.retrieveInvoice');
Route::get('/xero/createReceipts', [\App\Http\Controllers\XeroController::class, 'createReceipts'])->name('xero.createReceipts');
Route::get('/xero/retrieveReceipts', [\App\Http\Controllers\XeroController::class, 'retrieveReceipts'])->name('xero.retrieveReceipts');
Route::get('/xero/createPurchaseOrders', [\App\Http\Controllers\XeroController::class, 'createPurchaseOrders'])->name('xero.createPurchaseOrders');
Route::get('/xero/getPurchaseOrders', [\App\Http\Controllers\XeroController::class, 'getPurchaseOrders'])->name('xero.getPurchaseOrders');
Route::get('/xero/getInvoiceAsPdf', [\App\Http\Controllers\XeroController::class, 'getInvoiceAsPdf'])->name('xero.getInvoiceAsPdf');
Route::get('/xero/createCreditNotes', [\App\Http\Controllers\XeroController::class, 'createCreditNotes'])->name('xero.createCreditNotes');
Route::get('/xero/getCreditNotes', [\App\Http\Controllers\XeroController::class, 'getCreditNotes'])->name('xero.getCreditNotes');
Route::get('/xero/getItems', [\App\Http\Controllers\XeroController::class, 'getItems'])->name('xero.getItems');


/**********HANDCRAFTED APIs*************************************************************************************************************/

Route::get('getOrderTypes',[ApisContoller::class,'getOrderTypes']);
Route::get('getRoutes',[ApisContoller::class,'getRoutes']);

//PDFS
Route::group(['middleware' => 'auth'], function() {
    Route::get('displayPDFLabel/{id}',[PDFController::class,'displayPDFLabel']);
    Route::get('printGalvLabel/{id}',[PDFController::class,'printGalvLabel']);
    Route::get('printRoofingLabel/{id}',[PDFController::class,'printRoofingLabel']);
    Route::get('printNailsInnerLabel/{id}',[PDFController::class,'printNailsInnerLabel']);
    Route::get('printNailsOuterLabel/{id}',[PDFController::class,'printNailsOuterLabel']);
    Route::get('printBarbedWireLabel/{id}',[PDFController::class,'printBarbedWireLabel']);
    Route::get('printLabelPage/{department}',[PDFController::class,'printLabelPage']);
    Route::post('printLabelByDepartment',[PDFController::class,'printLabelByDepartment']);
    Route::get('getUserPrintersMappedToProductCategory', [PDFController::class,'getUserPrintersMappedToProductCategory']);
    Route::get('galvQCJobCard/{id}', [PDFController::class,'galvQCJobCard']);
});

// API's Controller
Route::group(['middleware' => 'auth'], function() {
    Route::get('getOpenUpkeepWorkOrders', [ApisController::class,'getOpenUpkeepWorkOrders']);
});

// Production Controller
Route::group(['middleware' => 'auth'], function() {
    Route::get('productionCapture', [ProductionController::class,'productionCapture']);
    Route::post('postProductionCaptureCRUD', [ProductionController::class,'postProductionCaptureCRUD']);
});

// Loading Controller
Route::group(['middleware' => 'auth'], function() {
    Route::get('loadTracking', [LoadingController::class,'loadTracking']);
    Route::get('getLoadTracking', [LoadingController::class,'getLoadTracking']);
    Route::post('postLoadTrackingUpdate', [LoadingController::class,'postLoadTrackingUpdate']);
});

// Stock Control Controller
Route::group(['middleware' => 'auth'], function() {
    Route::get('stockLocation', [StockControlController::class,'stockLocation']);
    Route::get('getStockLocationSummary', [StockControlController::class,'getStockLocationSummary']);
    Route::get('getStockDetailsSummary', [StockControlController::class,'getStockDetailsSummary']);
    Route::get('getIssuedStock', [StockControlController::class,'getIssuedStock']);
    Route::get('stockAdjustment', [StockControlController::class,'stockAdjustment']);
    Route::get('getBinStockCount', [StockControlController::class,'getBinStockCount']);
    Route::post('processStockAdjustment', [StockControlController::class,'processStockAdjustment']);
});

// Stock Take Control Controller
Route::group(['middleware' => 'auth'], function() {

    Route::post('saveStockTake', [StockTakeController::class,'saveStockTake']);
    Route::get('getStockTakeLines', [StockTakeController::class,'getStockTakeLines']);
    Route::get('selectStockTake', [StockTakeController::class,'selectStockTake']);
    Route::get('productStockCountMapping', [StockTakeController::class,'productStockCountMapping']);
    Route::post('postMappedItems', [StockTakeController::class,'postMappedItems']);
    Route::get('getBinsForLocations', [StockTakeController::class,'getBinsForLocations']);

    // New And imporved methods
    Route::get('stockTake', [StockTakeController::class,'stockTake']);
    Route::get('getStockTakes', [StockTakeController::class,'getStockTakes']);
    Route::post('createStockTake', [StockTakeController::class,'createStockTake']);
    Route::post('updateStockTakeStatus', [StockTakeController::class,'updateStockTakeStatus']);
    Route::get('stockCounts/{ID}', [StockTakeController::class,'stockCounts']);
    Route::post('approveVarianceAdjustment', [StockTakeController::class,'approveVarianceAdjustment']);
    Route::post('syncStockMovements', [StockTakeController::class,'syncStockMovements']);
    Route::get('getNextStockTakeId', [StockTakeController::class,'getNextStockTakeId']);

});

// Diamond Mesh Controller
Route::group(['middleware' => 'auth'], function() {
    Route::get('diamondMeshWorkOrders', [DiamondMeshController::class,'diamondMeshWorkOrders']);
    Route::get('getDiamondMeshSalesOrders', [DiamondMeshController::class,'getDiamondMeshSalesOrders']);
    Route::post('createDiamondMeshPlan', [DiamondMeshController::class,'createDiamondMeshPlan']);
    Route::get('getDiamondMeshHeaders', [DiamondMeshController::class,'getDiamondMeshHeaders']);
    Route::get('getDiamondMeshLines', [DiamondMeshController::class,'getDiamondMeshLines']);
    Route::get('getDiamondMeshWorkInProgress', [DiamondMeshController::class,'getDiamondMeshWorkInProgress']);
    Route::post('updateDiamondMeshLines', [DiamondMeshController::class,'updateDiamondMeshLines']);

    Route::get('updateDiamondMeshJobStatus/{reference}/{machine}', [DiamondMeshController::class,'updateDiamondMeshJobStatus']);
    Route::get('getDiamondMeshLinesByReference', [DiamondMeshController::class,'getDiamondMeshLinesByReference']);
    Route::get('changeDiamondMeshJobStatus', [DiamondMeshController::class,'changeDiamondMeshJobStatus']);
    Route::post('updateDiamondMeshLinesSequence', [DiamondMeshController::class,'updateDiamondMeshLinesSequence']);

    Route::get('sendDiamondMeshLabelToThePrinter', [DiamondMeshController::class,'sendDiamondMeshLabelToThePrinter']);

    Route::get('diamondMeshReprint', [DiamondMeshController::class,'diamondMeshReprint']);
    Route::post('diamondMeshInsertReprint', [DiamondMeshController::class,'diamondMeshInsertReprint']);
    Route::get('diamondMeshReport', [DiamondMeshController::class,'diamondMeshReport']);

    Route::post('deleteDiamondMeshBatch', [DiamondMeshController::class,'deleteDiamondMeshBatch']);
    Route::post('deleteDiamondMeshSO', [DiamondMeshController::class,'deleteDiamondMeshSO']);
});

// Roofing Controller
Route::group(['middleware' => 'auth'], function() {
    Route::get('roofingReprint', [RoofingController::class,'roofingReprint']);
    Route::post('roofingInsertReprint', [RoofingController::class,'roofingInsertReprint']);
});

Route::group(['middleware' => 'auth'], function() {
    Route::prefix('wire-draw')->name('wire-draw.')->group(function () {
        Route::get('customers/get-customers', [WireDrawCustomersController::class,'getCustomerName'])->name('customers.get-customers');
        Route::resource('customers', WireDrawCustomersController::class);
        Route::get('products/get-products', [WireDrawProductsController::class,'getProductsName'])->name('products.get-products');
        Route::resource('products', WireDrawProductsController::class);
        Route::get('headers/get-headers', [WireDrawHeadersController::class,'getheaders'])->name('headers.get-headers');
        Route::post('headers/add-rod', [WireDrawHeadersController::class,'addrod'])->name('headers.add-rod');
        Route::get('headers/getproduct/{getproduct}', [WireDrawHeadersController::class,'getproduct'])->name('headers.getproduct');
        Route::resource('headers', WireDrawHeadersController::class);
        Route::get('changeJobStatus', [WireDrawHeadersController::class,'changeJobStatus'])->name('changeJobStatus');
        Route::get('qcscreen/get-qcscreen', [WireDrawqcscreenController::class,'getqc'])->name('qcscreen.get-qcscreen');
        Route::resource('qcscreen', WireDrawqcscreenController::class);
        Route::get('stands/get-stands', [WireDrawStandsController::class,'getStandName'])->name('stands.get-stands');
        Route::resource('stands', WireDrawStandsController::class);
        Route::resource('weight', WireDrawWireDrawWeightController::class);
        Route::get('rod-supplier/get-rodsupplier', [WireDrawWireDrawRodSupplierController::class,'getRodSupplierName'])->name('rod-supplier.get-rodsupplier');
        Route::resource('rod-supplier', WireDrawWireDrawRodSupplierController::class);
    });
});

// Planning Controller
Route::group(['middleware' => 'auth'], function() {
    Route::get('pickingPlanner', [PlanningController::class,'pickingPlanner']);
    Route::post('getSalesOrdersToPlanOptimized', [PlanningController::class,'getSalesOrdersToPlanOptimized']);
    Route::post('savePickingPlan', [PlanningController::class,'savePickingPlan']);
    Route::post('getPickingPlanToEdit', [PlanningController::class,'getPickingPlanToEdit']);
});

Route::group(['middleware' => 'auth'], function() {
    Route::resource('ibt', controller: IbtController::class)->only('index', 'store');
    Route::get('getIBTRecords',[IbtController::class,'getIBTRecords'])->name(name: 'getIBTRecords');
    Route::get('getIBTDetails',[IbtController::class,'getIBTDetails']);
    Route::post('update-ibt',[IbtController::class,'updateIBTDetails']);
    Route::post('update-ibt-lines',[IbtController::class,'updateIbtLines']);
});

