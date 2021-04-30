<?php

use App\Http\Controllers\SalesForm;
use Illuminate\Support\Facades\Route;

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

Route::get('/', function () {
    return view('welcome');
});
Route::post('getLiveDriversInfo', 'ExternalFunctions@getLiveDriversInfo');
Auth::routes();

//Route::get('/home', 'SalesForm@index')->name('home');
Route::get('home',[SalesForm::class, 'index'])->name('home');
Route::get('/sales', 'SalesForm@index');
Route::get('pl', 'SalesForm@pl');
Route::get('returns', 'SalesForm@returns');
Route::get('getProductsStopedBuyingJSon', 'SalesForm@getProductsStopedBuyingJSon');
Route::get('getProductsStopedBuying', 'SalesForm@getProductsStopedBuying');
Route::get('getCustomerStoppedBuyingJSon', 'SalesForm@getCustomerStoppedBuyingJSon');
Route::get('getCustomerStoppedBuying', 'SalesForm@getCustomerStoppedBuying');
Route::get('/getCustomers', 'SalesForm@getCustomers');
Route::get('/prod', 'SalesForm@getProducts');
Route::get('ordersreport', 'SalesForm@ordersreport');
Route::get('getOrdersreportinfo/{date1}/{date2}', 'SalesForm@getOrdersreportinfo');
Route::get('/registered', 'RecentRegistered@index')->name('registered');
Route::post('/updatecart', 'ArtificialCrud@updateCart');
Route::post('/updatereordering', 'ArtificialCrud@updatereordering');
Route::post('/emptyCart', 'ArtificialCrud@deleteCartItems');
Route::post('/cartreorderingremoveitem', 'ArtificialCrud@deleteReorderingItems');
Route::get('/invoiceXXX/{invoiceno}/{type}', 'ArtificialCrud@invoiceDetails');
Route::post('/reordering/', 'ArtificialCrud@reorderBasedOnSelectedInvoice');
Route::get('/incompletOrders', 'IncompletOrders@incompletOrders');
Route::get('testPhpgrid', 'RecentRegistered@testPhpgrid');
Route::get('instocksheet', 'RecentRegistered@instocksheet');


//Route::post('ItemSearchCreate', 'ItemSearchController@create');
Route::resource('shop', 'HomeController', ['only' => ['show']]);
Route::resource('cart', 'CartController');

Route::get('custCode', 'SalesFormFunctions@CustomerCode');
Route::get('getExportForm', 'DimsExportController@getExportForm');
Route::get('getDimsUsers', 'UserFeature@getDimsUsers');
Route::get('getCommonRoutes', 'DimsCommon@getCommonRoutes');
Route::get('PointGrid', 'DimsCommon@PointGrid');
Route::get('customerPointsTrends', 'DimsCommon@customerPointsTrends');
Route::get('cardsList', 'DimsCommon@cardsList');
Route::get('getCartsGrid', 'DimsCommon@getCartsGrid');
Route::get('getPointGrid', 'DimsCommon@getPointGrid');
Route::post('increasePoints', 'DimsCommon@increasePoints');
Route::post('updatecustomerwebstoreinfo', 'DimsCommon@updatecustomerwebstoreinfo');
Route::get('viewStatusReport', 'DimsCommon@viewStatusRepoRoute::post(\'deletecard\', \'DimsCommon@deletecard\');
rt');
Route::get('getConsolidatedStatsReport', 'DimsCommon@getConsolidatedStatsReport');
Route::get('massCustomer', 'DimsCommon@massCustomer');
Route::get('massProducts', 'DimsCommon@massProducts');
Route::get('getCostsPerdate', 'DimsCommon@getCostsPerdate');
Route::get('viewdailycash', 'DimsCommon@viewdailycash');
Route::get('viewDeletedOrders', 'DimsCommon@viewDeletedOrders');
Route::get('deleteordersJson/{datefrom}/{dateto}', 'DimsCommon@deleteordersJson');
Route::get('customersalesperiod/{datefrom}/{dateto}', 'DimsCommon@customersalesperiod');
Route::get('getdailycash/{datefrom}/{dateTo}', 'DimsCommon@getdailycash');
Route::get('customersalesperiodwebpage', 'DimsCommon@customersalesperiodwebpage');
Route::get('advancedcustomerspecials', 'DimsCommon@advancedcustomerspecials');
Route::get('advancedcustomerspecialsJson', 'DimsCommon@advancedcustomerspecialsJson');
Route::get('routePlannerSuggestions/{date}/{ordertype}/{route}/{status}', 'TabletLoadingApp@routePlannerSuggestions');
Route::post('masscustomerdatatable', 'DimsCommon@masscustomerdatatable');
Route::post('massproductdatatable', 'DimsCommon@massproductdatatable');
Route::post('customerOrderListingHeader', 'DimsCommon@customerOrderListingHeader');
Route::post('credentialsmatch', 'DimsCommon@credentialsmatch');
Route::post('getAvailable', 'DimsCommon@getAvailable');
Route::post('clearorderlocksperorder', 'DimsCommon@clearorderlocksperorder');
Route::get('massCustomerUpdate/{custId}', 'DimsCommon@massCustomerUpdate');
Route::get('customerorderpattern/{custId}', 'DimsCommon@customerorderpattern');
Route::get('spGetCostsPerDate/{date1}/{date2}', 'DimsCommon@spGetCostsPerDate');
Route::post('deletepatternline', 'DimsCommon@deletepatternline');
Route::post('custID', 'SalesFormFunctions@getCustomerID');
Route::get('getAllProductsAndCosts', 'SalesFormFunctions@getAllProductsAndCosts');
Route::get('getProductCodes', 'SalesFormFunctions@getProductCodes');
Route::get('custDescription', 'SalesFormFunctions@CustomerDescription');
Route::get('prodCode', 'SalesFormFunctions@ProductCode');
Route::get('prodDesciption', 'SalesFormFunctions@ProductDescription');
Route::get('deliveryTypes', 'SalesFormFunctions@getDeliverTypes');
Route::get('getDeliveryDate', 'DimsCommon@getDeliveryDate');
Route::get('dimsAdminUsers', 'DimsCommon@dimsAdminUsers');
Route::post('restFullOrderLock', 'DimsCommon@restFullOrderLock');
Route::post('restFullUnLockOrder', 'DimsCommon@restFullUnLockOrder');
Route::post('deleteuserOrderLocks', 'DimsCommon@deleteuserOrderLocks');
Route::post('updatebasicinfo', 'DimsCommon@updatebasicinfo');
Route::post('updateContactInfo', 'DimsCommon@updateContactInfo');
Route::post('updatePayments', 'DimsCommon@updatePayments');
Route::post('insertIntoPushProducts', 'DimsCommon@insertIntoPushProducts');
Route::post('insertIntoProhibitProducts', 'DimsCommon@insertIntoProhibitProducts');
Route::post('removePushProducts', 'DimsCommon@removePushProducts');
Route::post('removeProhibitProducts', 'DimsCommon@removeProhibitProducts');
Route::get('productOnPush/{customerId}', 'DimsCommon@productOnPush');
//Route::get('removeProhibitProducts/{customerId}', 'DimsCommon@removeProhibitProducts');massCustomer
Route::get('productOnprohibit/{customerId}', 'DimsCommon@productOnprohibit');
Route::get('specials', 'DimsCommon@specials');
Route::get('customerspecialsbulkediting/{customercode}/{datefrom}/{dateto}', 'DimsCommon@customerspecialsbulkediting');
Route::get('groupspecialsbulkediting/{customercode}/{datefrom}/{dateto}', 'DimsCommon@groupspecialsbulkediting');
Route::get('getbulkeditingLandingage/{customercode}/{datefrom}/{dateto}', 'DimsCommon@getbulkeditingLandingage');
Route::get('getgroupspecialbulkeditingLandingage/{groupId}/{datefrom}/{dateto}', 'DimsCommon@getgroupspecialbulkeditingLandingage');
Route::get('groupspecials', 'DimsCommon@groupspecials');
Route::get('overallspecials', 'DimsCommon@overallspecials');
Route::get('andNewSpecial', 'DimsCommon@andNewSpecial');
Route::get('customerspecialTemplate', 'DimsCommon@customerspecialTemplate');
Route::get('checkifcustomerspecial/{date1}/{date2}', 'DimsCommon@checkifcustomerspecials');
Route::get('getcheckifcustomerspecials', 'DimsCommon@getcheckifcustomerspecials');
Route::get('addNewGroupSpecial', 'DimsCommon@addNewGroupSpecial');
Route::get('managementSearch', 'DimsCommon@managementSearch');
Route::post('updateDelvAdress', 'DimsCommon@updateDelvAdress');
Route::post('XmlBulkEditingCustomerSpecials', 'DimsCommon@XmlBulkEditingCustomerSpecials');
Route::post('XmlBulkEditingGroupSpecials', 'DimsCommon@XmlBulkEditingGroupSpecials');
Route::get('managementcosoleresult/{consoletype}/{OrderId}/{InvoiceNo}/{ProductCode}', 'ConsoleManagement@managementcosoleresult');
Route::post('createCustomerSpecials', 'DimsCommon@createCustomerSpecials');
Route::post('XmlCreateCustomerSpecials', 'DimsCommon@XmlCreateCustomerSpecials');
Route::post('overallSpecialHeader', 'DimsCommon@overallSpecialHeader');
Route::post('createGroupSpecials', 'DimsCommon@createGroupSpecials');
Route::post('createOverallSpecials', 'DimsCommon@createOverallSpecials');
Route::post('customerByDateOrContract', 'DimsCommon@customerByDateOrContract');
Route::post('customerGroupByDateOrContract', 'DimsCommon@customerGroupByDateOrContract');
Route::get('viewgroupinexcel/{from}/{to}/{groupid}', 'DimsCommon@viewgroupinexcel');
Route::get('jsonViewgroupspecialExcel/{from}/{to}/{groupid}', 'DimsCommon@jsonViewgroupspecialExcel');
Route::post('overallSpecailByDateOrContract', 'DimsCommon@overallSpecailByDateOrContract');
Route::post('updatespeciialLine', 'DimsCommon@updatespeciialLine');
Route::post('updategGroupSpecialLine', 'DimsCommon@updategGroupSpecialLine');
Route::post('updateOverallSpecialLine', 'DimsCommon@updateOverallSpecialLine');
Route::post('insertIntoTblPicking', 'DimsCommon@insertIntoTblPicking');
Route::post('insertIntoTblPickingPerRoute', 'DimsCommon@insertIntoTblPickingPerRoute');
Route::post('startcopyingorderpatternhistorytoaccount', 'DimsCommon@startcopyingorderpatternhistorytoaccount');
Route::post('deleteaddressonthecustomerdeliveryaddresstbl', 'DimsCommon@deleteaddressonthecustomerdeliveryaddresstbl');
Route::post('updateCContactsOnOrder', 'SalesFormFunctions@updateCContactsOnOrder');
Route::post('orderheaderAndOrderLines', 'SalesFormFunctions@orderheaderAndOrderLines');
Route::get('getDataFromManagementConsole', 'DimsCommon@getDataFromManagementConsole');
Route::get('getDataFromManagementConsoleForAuditors', 'DimsCommon@getDataFromManagementConsoleForAuditors');
Route::get('customerAddressLandingPage', 'DimsCommon@customerAddressLandingPage');
Route::get('customerDeliveryAddress/{custcode}', 'DimsCommon@customerDeliveryAddress');
Route::get('selectCustomerAddressToUpdate/{addressid}/{address1}/{address2}/{address3}/{address4}/{address5}/{customercode}', 'DimsCommon@selectCustomerAddressToUpdate');
Route::post('getCutomerPriceOnOrderForm', 'SalesFormFunctions@returnProductPrice');
Route::post('getCutomerPastInvoices', 'SalesFormFunctions@getCustomerPast10Invoices');
Route::post('customerSpecials', 'SalesFormFunctions@getCustomerSpecials');
Route::post('groupSpecials', 'SalesFormFunctions@getGroupSpecials');
Route::post('combinedSpecials', 'SalesFormFunctions@combinedSpecials');
Route::post('priceSearch', 'SalesFormFunctions@priceLookUpOntab');
Route::post('insertOrderHeader', 'SalesFormFunctions@insertOrderHearder');
Route::post('insertHeaderForOtherTrans', 'SalesFormFunctions@insertHeaderForOtherTrans');
Route::post('insertOrderDetails', 'SalesFormFunctions@insertOrderDetails');
Route::post('insertNewAddress', 'SalesFormFunctions@insertNewAddress');
Route::post('jsonOrderDetails', 'SalesFormFunctions@postOrderDetailsAsJsonArray');
Route::post('jsonOtherTransactionsLinesDetails', 'SalesFormFunctions@postOrderDetailsAsJsonArrayForOtherTransactions');
Route::post('jsonOrderDetailsPos', 'SalesFormFunctions@postOrderDetailsAsJsonArrayPOS');
Route::post('createbackorderonsplit', 'SalesFormFunctions@createbackorderonsplit');
Route::post('printPickingSlipPerOrder', 'SalesFormFunctions@printPickingSlipPerOrder');
Route::post('productsOnOrder', 'SalesFormFunctions@productsOnOrder');
Route::post('countOnSalesOrder', 'SalesFormFunctions@countOnSalesOrder');
Route::post('productsOnInvoiced', 'SalesFormFunctions@productsOnInvoiced');
Route::post('getOrderPattern', 'SalesFormFunctions@getCustomerOderpattern');
Route::post('getCustomerRoutes', 'SalesFormFunctions@getCustomerRouteWithOtherRoutesByPriority');
Route::post('getOrderListing', 'SalesFormFunctions@getOrderListing');
Route::post('getOrderListingOtherTrans', 'SalesFormFunctions@getOrderListingOtherTrans');
Route::post('onCheckOrderHeader', 'SalesFormFunctions@onCheckOrderHeader');
Route::post('checkIfOrderExistsWithOrderType', 'SalesFormFunctions@checkIfOrderExists');
Route::post('onCheckOrderHeaderDetails', 'SalesFormFunctions@onCheckOrderHeaderDetails');
Route::post('isClosedRoute', 'SalesFormFunctions@isClosedRoute');
//FOR OTHER TRANSACTIONS
Route::post('onCheckOrderHeaderForOtherTrans', 'SalesFormFunctions@onCheckOrderHeaderForOtherTrans');
Route::post('checkIfOrderExistsWithOrderTypeForOtherTrans', 'SalesFormFunctions@checkIfTransactionsExists');
Route::post('onCheckOrderHeaderDetailsForOtherTrans', 'SalesFormFunctions@onCheckOrderHeaderDetailsForOtherTrans');
Route::post('convertToSalesOrder', 'SalesFormFunctions@convertToSalesOrder');
Route::post('treatAsQuote', 'SalesFormFunctions@treatAsQuote');
//END OF OTHER TRANS

Route::post('generalPriceChecking', 'SalesFormFunctions@generalPriceChecking');
Route::post('advancedorderno', 'SalesFormFunctions@advancedOrderNo');
Route::post('generalPriceCheckAndLastCost', 'SalesFormFunctions@generalPriceCheckAndLastCost');
Route::post('getCallList', 'SalesFormFunctions@getCallList');
Route::post('getCallListNew', 'SalesFormFunctions@getCallListNew');
Route::post('insertCallistFilters', 'SalesFormFunctions@insertCallistFilters');
Route::post('isCalled', 'SalesFormFunctions@insertCallID');
Route::post('selectCustomerMultiAddress', 'SalesFormFunctions@selectCustomerMultiAddress');
Route::post('copyOrdersToCustomers', 'SalesFormFunctions@copyOrdersToCustomers');
Route::post('generatePDFForOrders', 'SalesFormFunctions@generatePDFForOrders');
Route::post('countAddress', 'SalesFormFunctions@countAddress');
Route::post('countomerSingleAddress', 'SalesFormFunctions@countomerSingleAddress');
Route::post('createNewCustomDelvDate', 'SalesFormFunctions@spCreateNewtblCustomerDeliveryAddress');
Route::post('getLastInsertedDate', 'SalesFormFunctions@getLastInsertedDate');
Route::post('getProductStockOnHand', 'SalesFormFunctions@getProductStockOnHand');
Route::post('deleteOrderDetails', 'SalesFormFunctions@DeleteOrderDetails');
Route::post('DeleteOrderDetailsOrtherTrans', 'SalesFormFunctions@DeleteOrderDetailsOrtherTrans');
Route::post('updateAuthHeader', 'SalesFormFunctions@updateAuthHeader');
Route::post('selectAddressFromMultiAddressDeliveruyAddressId', 'SalesFormFunctions@selectAddressFromMultiAddressDeliveruyAddressId');
Route::post('logMessageAjax', 'ConsoleManagement@logMessageAjax');
Route::post('logMessageAuth', 'ConsoleManagement@logMessageAuth');
Route::post('deleteallLinesOnOrder', 'ConsoleManagement@deleteallLinesOnOrder');
Route::post('logMessageAuthMargin', 'ConsoleManagement@logMessageAuthMargin');
Route::post('getRouteData', 'TabletLoadingApp@getRouteData');
Route::post('sequenceOrdersByMode', 'TabletLoadingApp@sequenceOrdersByMode');
Route::post('sequenceOrdersByMode', 'TabletLoadingApp@sequenceOrdersByMode');
Route::post('resequenceOrders', 'TabletLoadingApp@resequenceOrders');
Route::get('truckControlId', 'TabletLoadingApp@truckControlId');
Route::get('routePlannerPrintPreview/{date}/{dateTo}/{ordertype}/{route}/{status}', 'TabletLoadingApp@routePlannerPrintPreview');
Route::post('moveTheOrder', 'TabletLoadingApp@moveTheOrder');
Route::post('moveTheOrderArray', 'TabletLoadingApp@moveTheOrderArray');
Route::get('truckControlFromDate', 'TabletLoadingApp@truckControlFromDate');
Route::get('amalgamation', 'TabletLoadingApp@amalgamation');
Route::get('retrieve/{del}/{route}/{ordertype}', 'TabletLoadingApp@retrieve');
Route::get('driverFleetInfo/{del}/{route}/{ordertype}', 'TabletLoadingApp@driverFleetInfo');
Route::get('bulkPickingPerUserJSON/{from}/{to}', 'TabletLoadingApp@bulkPickingPerUserJSON');
Route::get('bulkPickingPerUserView', 'TabletLoadingApp@bulkPickingPerUserView');
Route::get('designPickingInformationPerTeam/{del}/{route}/{ordertype}', 'TabletLoadingApp@designPickingInformationPerTeam');
Route::get('truckControlSheetDetails', 'TabletLoadingApp@truckControlSheetDetails');
Route::post('stopsUnmapped', 'TabletLoadingApp@stopsUnmapped');
Route::post('getRouteDataMultiSelected', 'TabletLoadingApp@getRouteDataMultiSelected');
Route::get('routeplanner', 'TabletLoadingApp@routeplanner');
Route::get('routePlannerExt', 'TabletLoadingApp@routePlannerExt');
Route::get('invoicesnotprinting', 'TabletLoadingApp@invoicesnotprinting');
Route::post('notifypickers', 'TabletLoadingApp@notifypickers');
Route::get('liveBulkPicking', 'TabletLoadingApp@liveBulkPicking');
Route::get('printLoadingSheet/{routingId}', 'TabletLoadingApp@printLoadingSheet');
Route::get('getDrivers', 'TabletLoadingApp@getDrivers');
Route::get('getTrucks', 'TabletLoadingApp@getTrucks');
Route::get('getData/{orderdate}/{ordertype}/{routename}/{driver}/{assistant}/{truckname}/{assistanttwo}/{userid}', 'TabletLoadingApp@getData');
Route::get('liveFleetDeliveries', 'TabletLoadingApp@liveFleetDeliveries');
Route::get('driverreq_report', 'TabletLoadingApp@driverreq_report');
Route::get('driverreq_reportJson/{date1}/{date2}', 'TabletLoadingApp@driverreq_reportJson');
Route::get('driverreq_perrouteJson/{routeid}', 'TabletLoadingApp@driverreq_perrouteJson');
Route::get('updatelogisticsinformation', 'TabletLoadingApp@updatelogisticsinformation');
Route::get('ligisticsplan/{dates}', 'TabletLoadingApp@ligisticsplan');
Route::get('LogisticsInsertMapRoute/{routingId}/{ot}/{route}', 'TabletLoadingApp@LogisticsInsertMapRoute');
Route::get('createtripsheet', 'TabletLoadingApp@createtripsheet');
Route::get('createtripsheetnotes', 'TabletLoadingApp@createtripsheetnotes');
Route::post('getRoutingIdNotes', 'TabletLoadingApp@getRoutingIdNotes');
Route::post('saveRoutingIdNotes', 'TabletLoadingApp@saveRoutingIdNotes');
Route::get('routePlannerExtParam/{date}/{ordertype}/{route}/{status}', 'TabletLoadingApp@routePlannerExtParam');
Route::get('routeplannermap', 'TabletLoadingApp@routeplannermap');
Route::get('geoJson', 'TabletLoadingApp@geoJson');
Route::get('drone', 'TabletLoadingApp@drone');
Route::get('getRouteDifference', 'TabletLoadingApp@getRouteDifference');
Route::get('ordersNotONDefaultRoutes', 'TabletLoadingApp@ordersNotONDefaultRoutes');
Route::get('productontheminiorderform/{orderId}', 'TabletLoadingApp@spTabletLoading');
Route::get('updateTableLoadingAppProducts', 'TabletLoadingApp@updateTableLoadingAppProducts');
Route::post('sequencingTheStops', 'TabletLoadingApp@sequencingTheStops');
Route::post('orderDetailsWithDeliveryAddress', 'TabletLoadingApp@orderDetailsWithDeliveryAddress');
Route::post('orderDetailsWithDeliveryAddressOnOrder', 'TabletLoadingApp@orderDetailsWithDeliveryAddressOnOrder');
Route::post('forceinvoicetoprint', 'TabletLoadingApp@forceinvoicetoprint');
Route::post('updateIQInvoices', 'TabletLoadingApp@updateIQInvoices');
Route::post('forcecredits', 'TabletLoadingApp@forcecredits');
Route::post('combineroutes', 'TabletLoadingApp@combineroutes');
Route::post('updateOrderHeader', 'SalesFormFunctions@UpdateOrderHearder');
Route::post('deleteByHiddenToken', 'SalesFormFunctions@deleteByHiddenToken');
Route::post('updateOrderHeaderForOtherTransactions', 'SalesFormFunctions@updateOrderHeaderForOtherTransactions');
Route::post('tempDeliverAddress', 'SalesFormFunctions@tempDeliverAddress');
Route::get('pointofsale', 'SalesFormFunctions@pointOfSale');
Route::post('posCashFloat', 'SalesFormFunctions@posCashFloat');
Route::post('postPOSfloat', 'SalesFormFunctions@postPOSfloat');
Route::post('deletePOSfloat', 'SalesFormFunctions@deletePOSfloat');
Route::post('updateDiscount', 'SalesFormFunctions@updateDiscount');
Route::post('intoTblPrintedDoc', 'DimsCommon@intoTblPrintedDoc');
Route::post('invoicedoc', 'DimsCommon@invoicedoc');
Route::post('uploader', 'DimsCommon@uploader');
Route::post('warehouseProductStockLookUp', 'DimsCommon@warehouseProductStockLookUp');
Route::post('intoTblPrintedDocPickingSlips', 'DimsCommon@intoTblPrintedDocPickingSlips');
Route::post('emailOrder', 'DimsCommon@InsertToEmail');
Route::post('printInvoiceNow', 'DimsCommon@printInvoiceNow');
Route::post('printTruckControlID', 'DimsCommon@printTruckControlID');
Route::post('removeCustomerSpecial', 'DimsCommon@removeCustomerSpecial');
Route::post('increasePriceUsingMargin', 'DimsCommon@increasePriceUsingMargin');
Route::get('masscusterspecialdatefilter/{datefrom}/{dateto}/{marginless}/{margingreater}/{rep}', 'DimsCommon@masscusterspecialdatefilter');
Route::get('changefiltereddatamassspecials/{dateFromFilter}/{dateToFilter}/{marginfilterless}/{marginfiltergreater}/{rep}', 'DimsCommon@changefiltereddatamassspecials');
Route::get('getJsonCustomerGrid', 'DimsCommon@getJsonCustomerGrid');
//Route::get('masscusterspecialdatefilter/{datefrom}/{dateto}', 'DimsCommon@masscusterspecialdatefilter');
Route::post('removeGroupSpecial', 'DimsCommon@removeGroupSpecial');
Route::post('deleteselectedgroupspeciallines', 'DimsCommon@deleteselectedgroupspeciallines');
Route::post('deleteselectedcustomerspeciallines', 'DimsCommon@deleteselectedcumassCustomerstomerspeciallines');
Route::post('removeOverallSpecial', 'DimsCommon@removeOverallSpecial');
Route::post('verifyAuth', 'DimsCommon@verifyAuth');
Route::post('changesalesman', 'DimsCommon@changesalesman');
Route::post('changerouteonorder', 'DimsCommon@changerouteonorder');
Route::post('masscustomerspecialupgrade', 'DimsCommon@masscustomerspecialupgrade');
Route::post('verifyAuthOnAdmin', 'DimsCommon@verifyAuthOnAdmin');
Route::post('verifyAuthCreditors', 'DimsCommon@verifyAuthCreditors');
Route::post('AuthExternaOrders', 'DimsCommon@AuthExternaOrders');
Route::post('verifyAuthOnAdminMargin', 'DimsCommon@verifyAuthOnAdminMargin');
Route::post('verifyAuthGroupLeaders', 'DimsCommon@verifyAuthGroupLeaders');
Route::post('communications', 'DimsCommon@communications');
Route::post('clearAllLocksRestFull', 'DimsCommon@clearAllUserLocks');
Route::post('doneextending', 'DimsCommon@doneextending');
Route::post('doneextendinggroupspecials', 'DimsCommon@doneextendinggroupspecials');
Route::post('updatecustomergridpricing', 'DimsCommon@updatecustomergridpricing');
Route::get('invoiceLookUp', 'DimsCommon@invoiceLookUp');
Route::get('customerLookUp', 'DimsCommon@customerLookUp');
Route::get('marginControl', 'DimsCommon@marginControl');
Route::get('viewCreditLimit', 'DimsCommon@viewCreditLimit');
Route::get('viewproductbydate', 'ProductsController@viewproductbydate');
Route::get('devexpressproducts', 'ProductsController@devExpressProductsgrid');
Route::get('listProdutsToBePrinted', 'ProductsController@listProdutsToBePrinted');
Route::get('listProdutsToBePrintedJson', 'ProductsController@listProdutsToBePrintedJson');
Route::get('productbydatejson/{date1}/{date2}/{productId}', 'ProductsController@productbydatejson');
Route::get('customernoteshistory/{customerid}', 'DimsCommon@customernoteshistory');
Route::get('getCreditLimitJson', 'DimsCommon@getCreditLimitJson');
Route::get('getAgeAnalysis/{customerid}', 'DimsCommon@getAgeAnalysis');
Route::POST('customernoteshistoryupdate', 'DimsCommon@customernoteshistoryupdate');
Route::POST('customernoteshistoryinsert', 'DimsCommon@customernoteshistoryinsert');
Route::POST('assignRouteToTheCustomer', 'DimsCommon@assignRouteToTheCustomer');
Route::get('blnCompanyReports', 'DimsCommon@blnCompanyReports');
Route::get('massgridspecialscustomer', 'DimsCommon@massgridspecialscustomer');
Route::get('userpickingloadingperformancereport', 'DimsCommon@userpickingloadingperformancereport');
Route::get('userpickingloadingperformancereportJson/{datefrom}/{dateto}', 'DimsCommon@userpickingloadingperformancereportJson');
Route::get('pickingLiveGrid', 'DimsCommon@pickingLiveGrid');
Route::get('driverLiveGrid', 'DimsCommon@driverLiveGrid');
Route::get('custometPricingPage/{customerid}', 'DimsCommon@custometPricingPage');
Route::get('custometPricingJson/{customerid}', 'DimsCommon@custometPricingJson');
Route::get('customersalespage', 'DimsCommon@customersalespage');
Route::get('getDeliveryAddressOrderPattern/{account}/{addressid}', 'DimsCommon@getDeliveryAddressOrderPattern');
Route::get('customersalesJson/{datefrom1}/{dateto1}/{datefrom2}/{dateto3}', 'DimsCommon@customersalesJson');
Route::get('customerupdatepricingfromcustomerssalespage/{custcode}/{datefrom}/{dateto}/{datefrom2}/{dateto2}', 'DimsCommon@customerupdatepricingfromcustomerssalespage');
//Route::get('massgridspecialscustomer', 'RecentRegistered@testPhpgrid');
Route::post('copyInvoice', 'SalesFormFunctions@copyOrderToNewOrder');
Route::post('adjustDispatch', 'SalesFormFunctions@adjustTheDispatchQtyOnPickingOrder');
Route::post('printAdjustmentDispatch', 'SalesFormFunctions@printInvoiceFromPickingFormAdjustment');
Route::post('createAbackOrder', 'SalesFormFunctions@createAbackOrder');
Route::post('waitingForInvoiceNo', 'SalesFormFunctions@waitingForInvoiceNo');
Route::post('checkifInvoiced', 'SalesFormFunctions@checkifInvoiced');
Route::post('AssignInvoiceNumber', 'SalesFormFunctions@AssignInvoiceNumber');
Route::post('toProcessPosTenderLines', 'SalesFormFunctions@toProcessPosTenderLines');
Route::get('updatePosRoute', 'SalesFormFunctions@updatePosRoute');
Route::get('salesquote', 'SalesQuotes@salesquote');
Route::post('generateSalesQuote', 'SalesQuotes@generateSalesQuote');
Route::post('createQuotesHeader', 'SalesQuotes@createQuotesHeader');
Route::post('previewSaleQuotes', 'SalesQuotes@previewSaleQuotes');
Route::post('viewSalesQuotes', 'SalesQuotes@viewSalesQuotes');
Route::post('viewSalesQuotesConverted', 'SalesQuotes@viewSalesQuotesConverted');
Route::post('startConvertingQuoteToOrder', 'SalesQuotes@startConvertingQuoteToOrder');
Route::get('printTheQuote/{quoteId}', 'SalesQuotes@printTheQuote');
Route::post('email', 'EmailController@email');
Route::post('emailSalesOrder', 'EmailController@emailSalesOrder');
Route::get('getAllOrderIDs', 'SalesFormFunctions@getAllOrderIDs');
Route::get('reports', 'DimsReports@reports');

Route::get('outstandingDriversCashoff', 'DimsReports@outstandingDriversCashoff');
Route::get('getreportLayout', 'DimsReports@getreportLayout');
Route::get('getreportAuthBelowMargin', 'DimsReports@getreportAuthBelowMargin');
Route::get('getJsonAuthBelowMargin/{dateFrom}/{dateTo}', 'DimsReports@getJsonAuthBelowMargin');
Route::get('getOrderPlacedAfterCutOff', 'DimsReports@getOrderPlacedAfterCutOff');
Route::get('getJsonCutOffTime/{dateFrom}', 'DimsReports@getJsonCutOffTime');
Route::get('dshb', 'DimsReports@dashboardSalesPerformance');
Route::post('getPickingTeamsByDept', 'DimsReports@getPickingTeamsByDept');
Route::post('getPickingTeamsByDeptPalladium', 'DimsReports@getPickingTeamsByDeptPalladium');
Route::get('getPickingDept', 'DimsReports@getPickingDept');
Route::get('getPickingDeptPalladium', 'DimsReports@getPickingDeptPalladium');
Route::get('printQuatation', 'DimsReports@quotationLayout');
Route::get('showTripSheets', 'DimsReports@showTripSheets');
Route::get('getTripSheetDetails/{routingId}', 'DimsReports@getTripSheetDetails');
Route::get('reprintTripSheet/{routingId}', 'DimsReports@reprintTripSheet');
Route::post('authorisationActions', 'DimsReports@Authorised');
Route::post('getDayTripSheetList', 'DimsReports@getDayTripSheetList');
Route::get('bulpickingPerRoutePreview/{pickingid}', 'DimsReports@bulpickingPerRoutePreview');
Route::get('bulpickingbyBatch/{timestamp}', 'DimsCommon@bulpickingbyBatch');

Route::get('UpdateDocument','DimsCommon@UpdateDocument');
Route::post('updateDocumentupdate','DimsCommon@UpdateDocumentupdate');
Route::get('pickingbyteam/{array}/{deldate}/{ordertype}/{routeId}', 'DimsReports@pickingbyteam');
Route::post('fetchData', 'DimsReports@fetchData');
Route::post('selectBulkPickingHeader', 'DimsReports@selectBulkPickingHeader');
Route::post('selectBulkBatchPickingHeader', 'DimsReports@selectBulkBatchPickingHeader');
Route::post('createBulkpicking', 'DimsReports@createBulkpicking');
Route::get('slackUser/{oType}/{route}/{Ddate}', 'DimsReports@slackUser');
Route::post('getBinLocationByPickingTimes', 'DimsReports@getBinLocationByPickingTimes');
Route::post('gridResult', 'DimsReports@gridResult');
Route::post('gridResultPalladium', 'DimsReports@gridResultPalladium');
Route::get('top30Orders', 'DimsReports@top30Orders');
Route::get('creditNoteReasonsJSon/{date1}/{date2}', 'DimsReports@creditNoteReasonsJSon');
Route::get('creditNoteReasonsView', 'DimsReports@creditNoteReasonsView');
Route::get('creditNoteReasonsJSonWithBook', 'TabletLoadingApp@creditNoteReasonsJSonWithBook');
Route::get('pickingmain', 'DimsReports@pickingSlipManue');
Route::get('rptToSeeInTockVsOrders', 'DimsReports@rptToSeeInTockVsOrders');
Route::get('getJsonSrockVsOrdered/{date1}/{date2}/{percentage}', 'DimsReports@getJsonSrockVsOrdered');
Route::post('topOrdersOfACustomer', 'DimsReports@topOrdersOfACustomer');
Route::post('contactDetailsOnOrder', 'DimsReports@contactDetailsOnOrder');
Route::post('getCustomerOrderId', 'SalesFormFunctions@getCustomerOrderId');
Route::post('productPriceLookUp', 'SalesFormFunctions@productPriceLookUp');
Route::post('associatedItem', 'SalesFormFunctions@associatedItem');
Route::post('changeDeliveryAddressOnNoInvoiceNo', 'SalesFormFunctions@changeDeliveryAddressOnNoInvoiceNo');
Route::get('sendMessages', 'LoadingAppAPIs@sendMessages');
Route::get('sendMessageJson', 'LoadingAppAPIs@sendMessageJson');
Route::get('sendMessagePicking', 'LoadingAppAPIs@sendMessagePicking');
Route::get('batchPrinting', 'LoadingAppAPIs@batchPrinting');
Route::post('stockApi', 'LoadingAppAPIs@stockApi');
//Route::get('sendMessages/{pp}/{pp2}/{pp3}', 'LoadingAppAPIs@sendMessages');
Route::get('slack', 'LoadingAppAPIs@slack');
Route::get('salesHeaderExported', 'PalladiumDimsStatus@salesHeaderExported');
Route::get('callist', 'CallList@index');
Route::get('getViewCallLogger', 'CallList@getViewCallLoger');
Route::get('callLogger', 'CallList@callLogger');
Route::get('getphonebook', 'CallList@getPhoneBook');
Route::get('savephonebook', 'CallList@savephonebook');
Route::get('removePhoneBookContact', 'CallList@removePhoneBookContact');
Route::get('customerphonebookcontacts', 'CallList@customerphonebookcontacts');
Route::get('luck/{date}/{ext}/{file}', 'CallList@luck');
Route::post('updateSalesHeaderExportedStatus', 'PalladiumDimsStatus@updateSalesHeaderExportedStatus');
Route::get('..config', 'ConfigurationManger@index');
Route::post('editconfig', 'ConfigurationManger@editconfig'); //
Route::get('gridPickingSlipCollectios', 'PickingManagementCotroller@gridPickingSlipCollectios');
Route::post('updateiscollected', 'PickingManagementCotroller@updateiscollected');
Route::post('reprintPickingSlip', 'PickingManagementCotroller@reprintPickingSlip');

/**********************************************************CRUD****************************************************************/
Route::get('drivers', 'DriversController@readItems');
Route::get('getRoutingIds', 'DriversController@getRoutingIds');
Route::get('printDriversCashOff/{ref}', 'DriversController@printDriversCashOff');
Route::get('creditRequisitionByRoutingId/{routingId}', 'DriversController@creditRequisitionByRoutingId');
Route::get('getdriverscashoff', 'DriversController@getdriverscashoff');
Route::get('CreditDeptComment/{orderdetailid}', 'DriversController@CreditDeptComment');
Route::post('CreditDeptCommentUpdate', 'DriversController@CreditDeptCommentUpdate');
Route::post('getDriversCashOffJson', 'DriversController@getDriversCashOffJson');
Route::post('exportCashOff', 'DriversController@exportCashOff');
Route::post('postDriversCashOff', 'DriversController@postDriversCashOff');
Route::post('invoicessignedaroundpremises', 'DriversController@invoicessignedaroundpremises');
Route::post('createnewsheet', 'DriversController@createnewsheet');
Route::get('LiveDriverStops', 'DriversController@LiveDriverStops');

Route::post('/addItem', 'DriversController@addItem');
Route::post('/editItem', 'DriversController@editItem');
Route::post('/deleteItem', 'DriversController@deleteItem');

Route::get('trucks', 'DriversController@readTrucksItems');
Route::post('/addTrucksItem', 'DriversController@addTrucksItem');
Route::post('/editTrucksItem', 'DriversController@editTrucksItem');
Route::post('/deleteTrucksItem', 'DriversController@deleteTrucksItem');

Route::get('routes1', 'DriversController@readRoutesItems');
Route::post('/addRoutesItem', 'DriversController@addRoutesItem');
Route::post('/editRoutesItem', 'DriversController@editRoutesItem');
Route::post('/deleteRoutesItem', 'DriversController@deleteRoutesItem');

Route::get('glcodes', 'DriversController@readGLCode');
Route::get('driversperformancereport', 'DriversController@driversperformancereport');
Route::get('getdriversandinfo/{date1}/{date2}', 'DriversController@getdriversandinfo');
Route::get('getNoOfDelPerCustomer/{date1}/{date2}', 'DriversController@getNoOfDelPerCustomer');
Route::get('driverspdfdocs', 'DriversController@driverspdfdocs');
Route::get('cashupscheckinvoice/{invoice}', 'DriversController@cashupscheckinvoice');
Route::post('postcashupscheckinvoice', 'DriversController@postcashupscheckinvoice');
Route::get('noOfStops', 'DriversController@noOfStops');
Route::get('getCashCollected', 'DriversController@getCashCollected');
Route::get('cashCollectedReport/{dateFrom}/{dateTo}', 'DriversController@cashCollectedReport');
Route::post('driverspdfdocsByInv', 'DriversController@driverspdfdocsByInv');
Route::post('postPODSToTheAccounting', 'DriversController@postPODSToTheAccounting');
Route::post('driverspdfdocsByInvsubinfo', 'DriversController@driverspdfdocsByInvsubinfo');
Route::post('driverspdfdocsBytripsheet', 'DriversController@driverspdfdocsBytripsheet');
Route::post('driverpdfdocrequisition', 'DriversController@driverpdfdocrequisition');
Route::post('isCheckedCashUp', 'DriversController@isCheckedCashUp');
Route::post('/addGLCode', 'DriversController@addGLCode');
Route::post('/editGLCode', 'DriversController@editGLCode');
Route::post('/deleteGLCode', 'DriversController@deleteGLCode');
Route::get('checkingDriversStockAndComment/{orderdetailId}', 'DriversController@checkingDriversStockAndComment');
Route::post('updatereturndispatchmessage', 'DriversController@updatereturndispatchmessage');
Route::post('getResendEmailJson', 'DriversController@getResendEmailJson');
Route::get('getResendEmail', 'DriversController@getResendEmail');
Route::post('postResendEmailJson', 'DriversController@postResendEmailJson');

Route::get('usersCrud', 'UsersController@readUser');
Route::get('viewUserRole', 'UsersController@viewUserRole');
Route::post('systemrolesandgrouproles', 'UsersController@systemrolesandgrouproles');
Route::post('updateremoverole', 'UsersController@updateremoverole');
Route::get('salesPerformanceview', 'UsersController@salesPerformanceview');
Route::get('userorders/{from}/{to}/{userid}/{username}', 'UsersController@userorders');
Route::get('userorderslines/{orderid}', 'UsersController@userorderslines');
Route::get('getUserOrders/{from}/{to}/{user}', 'UsersController@getUserOrders');
Route::get('gridCustomermanagement/{users}/{routes}', 'UsersController@gridCustomermanagement');
Route::get('salesPerformance/{datefrom}/{dateTo}', 'UsersController@salesPerformance');
Route::get('gridEditViewProducts', 'ProductsController@gridEditViewProducts');
Route::get('selectPricelists', 'ProductsController@selectPricelists');
Route::post('getPriceListUsed', 'ProductsController@getPriceListUsed');
Route::get('getListPriceListPrices/{id}/{pricelistusedid}', 'ProductsController@getListPriceListPrices');
Route::get('createnewpricelist/{newname}/{pricelistcopyfrom}/{groups}/{gp}/{effectivedate}', 'ProductsController@createnewpricelist');
Route::post('postupdatepricelistinfo', 'ProductsController@postupdatepricelistinfo');
Route::get('createpricelist', 'ProductsController@createpricelist');
Route::get('getPriceListTemplate', 'ProductsController@getPriceListTemplate');
Route::get('importexcelpricelist', 'ProductsController@importexcelpricelist');
Route::get('getPricelistNamesAndViewInBulk', 'ProductsController@getPricelistNamesAndViewInBulk');
Route::get('getBulkPriceLists', 'ProductsController@getBulkPriceLists');
Route::get('extraProdInfoView/{prodid}/{code}', 'ProductsController@extraProdInfoView');
Route::get('crowdpromotion', 'ProductsController@crowdpromotion');
Route::get('updateproductsummary', 'ProductsController@updateproductsummary');
Route::get('productdevexpress', 'ProductsController@productdevexpress');
Route::get('getPickingTeams', 'ProductsController@getPickingTeams');
Route::post('printbarcode', 'ProductsController@printbarcode');
Route::post('sendstickerstoprinter', 'ProductsController@sendstickerstoprinter');
Route::get('printPriceList', 'ProductsController@printPriceList');
Route::get('printstickers', 'ProductsController@PrintProductBarcodeStickers');
Route::get('viewlabelstickerstoprint', 'ProductsController@viewlabelstickerstoprint');
Route::get('listChangedProducts/{dateFrom}/{dateTo}/{PriceList}', 'ProductsController@listChangedProducts');
Route::post('printbulklabels', 'ProductsController@printbulklabels');
Route::post('printbulklabelsbyPricelist', 'ProductsController@printbulklabelsbyPricelist');

Route::get('bulkgridforlabels', 'ProductsController@bulkgridforlabels');
Route::get('getproductextrainformation/{prductId}', 'ProductsController@getproductextrainformation');
Route::post('updategridproductsAndTeams', 'ProductsController@updategridproductsAndTeams');
Route::post('savedatafromimport', 'ProductsController@savedatafromimport');
Route::get('itemsOutOfStockBeforePicking', 'ProductsController@itemsOutOfStockBeforePicking');
Route::get('getViewItemsOutOfStock', 'ProductsController@getViewItemsOutOfStock');
Route::post('printAllBarcode', 'ProductsController@printAllBarcode');
Route::post('/addUser', 'UsersController@addUser');
Route::post('updategridroutes', 'UsersController@updategridroutes');
Route::post('/editUser', 'UsersController@editUser');
Route::post('/deleteUser', 'UsersController@deleteUser');

Route::get('grid_Users','UsersController@gridUsers');
Route::get('jsonGetUsers','UsersController@jsonGetUsers');
Route::post('updateUsers','UsersController@updateUsers');
Route::post('updateuserpassword','UsersController@updateuserpassword');
Route::post('updateuserinfo','UsersController@updateuserinfo');
Route::get('ordertypes', 'ControlPanelController@readOrderType');
Route::post('/addOrderType', 'ControlPanelController@addOrderType');
Route::post('/editOrderType', 'ControlPanelController@editOrderType');
Route::post('/deleteOrderType', 'ControlPanelController@deleteOrderType');

Route::get('brands', 'ControlPanelController@readBrand');
Route::post('/addBrand', 'ControlPanelController@addBrand');
Route::post('/editBrand', 'ControlPanelController@editBrand');
Route::post('/deleteBrand', 'ControlPanelController@deleteBrand');

Route::get('groups', 'ControlPanelController@readGroup');
Route::post('/addGroup', 'ControlPanelController@addGroup');
Route::post('/editGroup', 'ControlPanelController@editGroup');
Route::post('/deleteGroup', 'ControlPanelController@deleteGroup');

Route::get('taxes', 'ControlPanelController@readTax');
Route::post('/addTax', 'ControlPanelController@addTax');
Route::post('/editTax', 'ControlPanelController@editTax');
Route::post('/deleteTax', 'ControlPanelController@deleteTax');

Route::get('pickingteam', 'ControlPanelController@readPickingTeam');
Route::post('/addPickingTeam', 'ControlPanelController@addPickingTeam');
Route::post('/editPickingTeam', 'ControlPanelController@editPickingTeam');
Route::post('/deletePickingTeam', 'ControlPanelController@deletePickingTeam');

Route::get('groupbrands', 'ControlPanelController@readGroupBrand');
Route::post('/addGroupBrand', 'ControlPanelController@addGroupBrand');
Route::post('/editGroupBrand', 'ControlPanelController@editGroupBrand');
Route::post('/deleteGroupBrand', 'ControlPanelController@deleteGroupBrand');

Route::get('PathEditor', 'UsersController@PathsAndEmails');
Route::post('editUsers', 'UsersController@editUsers');
/**********************************************************APPS**************************************************************************************/
Route::get('getDeals', 'DealsFromTheApp@getDealsNotYetApproved');
Route::get('testJaspr/{id}', 'JasperReports@testJaspr');
Route::get('CashOffPDF/{ref}/{type}', 'JasperReports@CashOffPDF');
Route::get('specialnsJasper/{id}/{dateFrom}/{dateTo}', 'JasperReports@specialnsJasper');
Route::get('pdforder/{id}', 'JasperReports@PDFOrders');
Route::get('PDFDelDate/{id}', 'JasperReports@PDFDelDate');
Route::get('overallSpecailJasper/{datefrom}/{dateto}', 'JasperReports@overallSpecailJasper');
Route::get('excelorder/{id}', 'JasperReports@EXCELOrders');
Route::get('groupSpecailJasper/{datefrom}/{dateto}/{groupid}', 'JasperReports@groupSpecailJasper');
Route::get('compilereports', 'JasperReports@compileExample');
Route::get('FreshOrders', 'JasperReports@FreshOrders');
Route::get('approveadeal/{token}', 'DealsFromTheApp@approveADeal');
Route::get('rejectadeal/{token}', 'DealsFromTheApp@rejectADeal');
Route::get('approveddeal', 'DealsFromTheApp@approvedDeals');
Route::get('rejecteddeal', 'DealsFromTheApp@rejectedDeals');
Route::get('briefcaseDamages', 'ExternalFunctions@briefcaseDamages');
Route::get('getTransfers', 'ExternalFunctions@getTransfers');
Route::get('getInvoices/{customercode}/{from}/{to}', 'ExternalFunctions@getInvoices');
Route::get('transferblade', 'ExternalFunctions@transferblade');
Route::get('getTransfersJson/{date}/{dateTo}', 'ExternalFunctions@getTransfersJson');
Route::post('openorderdetailsformergedtransfers', 'ExternalFunctions@openorderdetailsformergedtransfers');
Route::get('getTransfersJsonbydate/{date}', 'ExternalFunctions@getTransfersJsonbydate');
Route::post('updateCheckedOrNotTrasfers', 'ExternalFunctions@updateCheckedOrNotTrasfers');
Route::post('checkUnCheckTransfers', 'ExternalFunctions@checkUnCheckTransfers');

Route::get('getWebstoreCustomers', 'ExternalFunctions@getWebstoreCustomers');
Route::get('officemap', 'ExternalFunctions@officemap');
Route::get('getWebstoreFile', 'ExternalFunctions@getWebstoreFile');
Route::get('brifcaseCustomerEdits', 'ExternalFunctions@brifcaseCustomerEdits');
Route::get('synchProducts', 'ExternalFunctions@synchProducts');
Route::get('testWebstoreSpeed', 'ExternalFunctions@testWebstoreSpeed');
Route::get('damageshistory', 'ExternalFunctions@damageshistory');
Route::get('transfersstatus', 'ExternalFunctions@transfersstatus');
Route::get('print_damages/{id}', 'ExternalFunctions@printDamages');
Route::get('process_damage/{id}', 'ExternalFunctions@processDamage');
Route::post('getDamgedLines', 'ExternalFunctions@getDamgedLines');
Route::post('updatevisits', 'ExternalFunctions@updatevisits');
Route::post('getDamagesHistoryHeader', 'ExternalFunctions@getDamagesHistoryHeader');
Route::post('updateWebstoremasterFileInfo', 'ExternalFunctions@updateWebstoremasterFileInfo');
Route::post('deleteDamagedLine', 'ExternalFunctions@deleteDamagedLine');
Route::post('saveupdateasset', 'ExternalFunctions@saveupdateasset');
Route::get('viewVisits', 'ExternalFunctions@viewVisits');
Route::get('viewDeals', 'ExternalFunctions@viewDeals');
Route::get('assets', 'ExternalFunctions@assets');
Route::get('crudasset/{id}', 'ExternalFunctions@crudasset');
Route::get('missedvisit', 'ExternalFunctions@viewMissedVisit');
Route::get('notVisitedView', 'ExternalFunctions@notVisitedView');
Route::get('visitsdates/{datefrom}/{dateto}', 'ExternalFunctions@visitsdates');
Route::get('dealsdates/{datefrom}/{dateto}', 'ExternalFunctions@dealsdates');
Route::get('webstore', 'ExternalFunctions@webstore');

Route::get('/WebstoreMessages','DimsCommon@WebstoreMessages');
Route::get('/getMessageGrid', 'DimsCommon@getMessageGrid');
Route::post('updateMessage', 'DimsCommon@updateMessage');


Route::get('remoteorders', 'OnlineOrders@remoteorders');
Route::get('mymarketGetSales', 'OnlineOrders@mymarketGetSales');
Route::post('getMymarketOrdersToDealWith', 'OnlineOrders@getMymarketOrdersToDealWith');
Route::get('viewMyMarketOrders', 'OnlineOrders@viewMyMarketOrders');
Route::get('orderScreening', 'OnlineOrders@orderScreening');
Route::post('testAPI', 'OnlineOrders@testAPI');
Route::post('deleteRemoteOrder', 'OnlineOrders@deleteRemoteOrder');
Route::post('updateOnlineLinesAndHeaders', 'OnlineOrders@updateOnlineLinesAndHeaders');
Route::get('outstandingorders', 'OnlineOrders@outstandingorders');
Route::get('onlineOrderHistory/{date1}/{date2}', 'OnlineOrders@onlineOrderHistory');
Route::get('getFreshOrderHeadersOutstanding', 'OnlineOrders@getFreshOrderHeadersOutstanding');
Route::post('Xmlcommitremoteorder', 'OnlineOrders@Xmlcommitremoteorder');
Route::get('getFreshOrderHeaders ', 'OnlineOrders@getFreshOrderHeaders');
Route::get('getOrderLines/{id}', 'OnlineOrders@getOrderLines');
Route::get('getNewDealToAuth/{id}', 'OnlineOrders@getNewDealToAuth');
Route::post('postauthdeal', 'OnlineOrders@postauthdeal');

Route::get('returnRefunds', 'OnlineOrdersReconController@returnRefunds');
Route::get('viewRefunds', 'OnlineOrdersReconController@viewRefunds');

/******************************************BACK ORDERS**********************************************************************************/
Route::get('remoteordersbackorders', 'BackOrderController@remoteordersbackorders');
Route::post('testAPIbackorders', 'BackOrderController@testAPIbackorders');
Route::post('deleteRemoteOrderbackorders', 'BackOrderController@deleteRemoteOrderbackorders');
Route::post('updateOnlineLinesAndHeadersbackorder', 'BackOrderController@updateOnlineLinesAndHeadersbackorder');
Route::get('outstandingordersbackorder', 'BackOrderController@outstandingordersbackorder');
Route::get('onlineOrderHistorybackorder/{date1}/{date2}', 'BackOrderController@onlineOrderHistorybackorder');
Route::get('getFreshOrderHeadersOutstandingbackorder', 'BackOrderController@getFreshOrderHeadersOutstandingbackorder');
Route::post('Xmlcommitremoteorderbackorder', 'BackOrderController@Xmlcommitremoteorderbackorder');
Route::get('getFreshOrderHeadersbackorder', 'BackOrderController@getFreshOrderHeadersbackorder');
Route::get('getNoStockItem', 'BackOrderController@getNoStockItem');
Route::get('getItemWithNoStock', 'BackOrderController@getItemWithNoStock');
Route::get('getOrderLinesbackorder/{id}', 'BackOrderController@getOrderLinesbackorder');
Route::get('getNewDealToAuthbackorder/{id}', 'BackOrderController@getNewDealToAuthbackorder');
Route::post('postauthdealbackorder', 'BackOrderController@postauthdealbackorder');
Route::get('productsonbackorderjson', 'BackOrderController@productsonbackorderjson');
Route::get('productsOnBackOrders', 'BackOrderController@productsOnBackOrders');
/********************************************************END **************************************************************************/

Route::post('synchwebstore', 'ExternalFunctions@synchwebstore');
Route::post('syncproducts', 'ExternalFunctions@syncproducts');
Route::post('syncpricelistPrices', 'ExternalFunctions@syncpricelistPrices');
Route::post('syncpricelistStock', 'ExternalFunctions@syncpricelistStock');
Route::post('syncoverallspecials', 'ExternalFunctions@syncoverallspecials');
Route::post('synccustomers', 'ExternalFunctions@synccustomers');
Route::post('syncorderpattern', 'ExternalFunctions@syncorderpattern');
Route::post('syncpricelist', 'ExternalFunctions@syncpricelist');
Route::post('syncgroupspecials', 'ExternalFunctions@syncgroupspecials');
Route::post('synccustomerspecials', 'ExternalFunctions@synccustomerspecials');
Route::get('restFullInvoices/{month}/{year}/{custcode}', 'ExternalFunctions@restFullInvoices');
Route::get('returnPDF/{invoicenumber}', 'ExternalFunctions@returnPDF');
Route::get('visitsLog/{date1}/{date2}', 'ExternalFunctions@visitsLog');
Route::get('notVisitedLog/{date1}/{date2}', 'ExternalFunctions@notVisitedLog');


/*Route::get('/addProduct/{productId}', 'CartController@addItem');
Route::get('/removeItem/{productId}', 'CartController@removeItem');
Route::get('/cart', 'CartController@showCart');*/
//Route::delete('emptyCart', 'CartController@emptyCart');

/***
 * WAREHOUSE ROUTES
 */


Route::get('warehouseitems', 'WareHouseController@warehouseInvetoryItems');
Route::get('onOrderAdvanced', 'WareHouseController@onOrderAdvanced');

/***
 * AUTH ORDERS
 */
Route::get('getBlockedAccountToAuth', 'CompanyAuthController@getBlockedAccountToAuth');
Route::get('viewBlockedAccount', 'CompanyAuthController@viewBlockedAccount');
Route::get('getSpecificOrdersBlocked/{customerId}', 'CompanyAuthController@getSpecificOrdersBlocked');
Route::get('getSpecificBlockedOrdersJson/{orderid}', 'CompanyAuthController@getSpecificBlockedOrdersJson');
Route::get('getoutstandingorderstoauthjson/{orderid}', 'CompanyAuthController@getoutstandingorderstoauthjson');

/******************************************POS*************************************************************************************************
 ************************************************************************************************************************************************/
Route::get('viewassignuserstotill', 'POS@viewassignuserstotill');
Route::post('submittillusers', 'POS@submittillusers');
Route::post('closedrawer', 'POS@closedrawer');

/****************************************************MAPS
/*******************************************************************************************/
Route::get('mappage/{date}/{routeid}/{ordertype}', 'GoogleMapsController@mappage');

Route::get('/import_excel', 'ImportExcelController@index');
Route::post('/import_excel/import', 'ImportExcelController@import');

/*************************************************LOYALTY*/
/********************************************************PROGRAM*********************************************************************************************************/
Route::group(['middleware' => 'auth'], function() {
    Route::get('registercards', 'LayaltyProgramController@MapACardToTheUsers');
    Route::get('cardnumberlookup', 'LayaltyProgramController@CardNumberLookUp');
    Route::get('saveinfocard', 'LayaltyProgramController@saveinfocard');


    Route::get('registercardswalking', 'LayaltyProgramController@MapACardToTheUsersWalking');
    Route::get('cardnumberlookupWalking', 'LayaltyProgramController@CardNumberLookUpWalking');
    Route::get('saveinfocardwalking', 'LayaltyProgramController@saveinfocardWalking');
    Route::get('verifyemail', 'LayaltyProgramController@verifyemail');
    Route::get('checkifIdexists', 'LayaltyProgramController@checkifIdexists');
});

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
