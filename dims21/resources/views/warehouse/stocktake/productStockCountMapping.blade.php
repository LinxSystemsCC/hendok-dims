<!DOCTYPE html>
<html>
<head>

    <meta name="csrf-token" content="{{ csrf_token() }}" />   
	  <script type="text/javascript" src="https://code.jquery.com/jquery-3.5.1.min.js"></script>     <link rel="stylesheet" href="{{ asset('css/jquery-ui2.min.css') }}" type="text/css" />
    <script src="{{ asset('js/jquery-2.2.3.min.js') }}"></script>
    <script src="{{ asset('js/jquery-ui.js') }}"></script>
    <link href="{{ asset('css/jquery.flexdatalist.min.css') }}" rel="stylesheet"  type='text/css'>
    <script src="{{ asset('js/jquery.flexdatalist.min.js') }}"></script>
    <!-- DevExtreme themes -->
    <link rel="stylesheet" href="https://cdn3.devexpress.com/jslib/20.1.7/css/dx.common.css">
    <link rel="stylesheet" href="https://cdn3.devexpress.com/jslib/20.1.7/css/dx.light.css">

    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!-- DevExtreme library -->

    <script src="https://cdnjs.cloudflare.com/ajax/libs/exceljs/3.3.1/exceljs.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/FileSaver.js/1.3.8/FileSaver.min.js"></script>    <script src="https://cdn3.devexpress.com/jslib/20.1.8/js/dx.all.js"></script>



    <style>
        .vertical-menu {
            width: 200px;
        }

        .vertical-menu a {
            background-color: #eee;
            color: black;
            display: block;
            padding: 12px;
            text-decoration: none;
        }

        .vertical-menu a:hover {
            background-color: #ccc;
        }

        .vertical-menu a.active {
            background-color: #04AA6D;
            color: white;
        }
    </style>



</head>
    <div class="col-lg-12"  style="background: white;">
        <div class="col-lg-12"  style="background: white;">
      
            <div class="col-lg-12"  style="background: white;">

      
        <div class="col-lg-12"  style="background: white;">
              <div class="form-group col-md-1 itCanHide"  style="margin-bottom: 0px;font-weight: 700;font-size: 11px;">
                            <label class="control-label" for="stockDesc"  style="margin-bottom: 0px;font-weight: 700;font-size: 11px;">Stocktake Name</label>
                            <input type="text" name="stockDesc" class="form-control input-sm col-xs-1" id="stockDesc" style="height:22px;font-size: 10px;font-weight: 900;    color: black;">
                            <input type="text" name="stockDescHidden" class="form-control input-sm col-xs-1" id="stockDescHidden" style="height:22px;font-size: 10px;font-weight: 900;    color: black;" hidden>
       
						</br>
                        <button type="button" id="submitMapProduct" class="btn-xs btn-success" style="padding: 2px 49px;margin-top: 5px;float: left;">Map Products</button>
                    </div>  
			
            <div class="col-lg-12" id="afterFilter">
                <div id="gridContainer" style="width:100% !important">
                
				</div>
            
                
            </div>

        </div>
    </div>
        </div>
    </div>

<style>

       .dx-datagrid-table{
           font-size:15px;
       }
</style>

<script>
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
     $( document ).on( 'focus', ':input', function(){
        $( this ).attr( 'autocomplete', 'off' );
    });
	var jArrayStockCounts = JSON.stringify({!! json_encode($stockCounts) !!});
var finalDataStockCounts =$.map(JSON.parse(jArrayStockCounts), function(item) {
return {
    intAutoId:item.intAutoId,
    strStockTakeName:item.strStockTakeName
}
});
	var jArrayProducts = JSON.stringify({!! json_encode($products) !!});
var finalDataProducts =$.map(JSON.parse(jArrayProducts), function(item) {
return {
    strPartNumber:item.PastelCode,
    strDesc:item.PastelDescription,
    strCategory:item.strCategory
}
});


    $(document).ready(function() {
 var stocktakes = $('#stockDesc').flexdatalist({
            minLength: 1,
            valueProperty: '*',
            selectionRequired: true,
            searchContain:true,
            focusFirstResult: true,
            visibleProperties: ["strStockTakeName"],
            searchIn: 'strStockTakeName',
            data: finalDataStockCounts
        });
   
        stocktakes.on('select:flexdatalist', function (event, data) {

       
            $('#stockDesc').val(data.strStockTakeName);
            $('#stockDescHidden').val(data.intAutoId);
			$.ajax({

			   url: '{!!url("/stocktakenamedatagrid")!!}',
			   type: "POST",
			   data: {
					stocktakename: $('#stockDescHidden').val()
				 },
			   success: function (data) {
				   console.log(data);
				   var dataarray = new Array();
				   $.each(data, function(key,value){
					   dataarray.push(value.strPartNumber);
				   });
				   console.log(dataarray);
				   for (i = 0; i < dataarray.length; ++i) {


				   $("#gridContainer").dxDataGrid("instance").selectRows([dataarray[i]],true);
				   }
				}

			});

        });

        $('#orderListing').hide();
        $('#pricing').hide();
        $('#pricingOnCustomer').hide();
        $('#callList').hide();
        $('#tabletLoadingApp').hide();
        $('#copyOrdersBtn').hide();
        $('#salesOnOrder').hide();
        $('#salesInvoiced').hide();
        $('#posCashUp').hide();
        $('#popUpdateLine').hide();
        $('#updatedspecials').hide();
        $('#extend').hide();
        $('#extedingspecial').hide();

     
   $("#gridContainer").dxDataGrid({
			dataSource: {  
            store: {  
                type: 'array',  
                key: 'strPartNumber',  
                data: finalDataProducts  
            }  
        } ,
       showBorders: true,
       filterRow: { visible: true },
       allowColumnResizing: true,  
	   selection: {
      mode: "multiple",
    },
		paging:{
        pageSize: 50,
            },

		export: {
         enabled: true
                },
         onExporting(e) {
                const workbook = new ExcelJS.Workbook();
                const worksheet = workbook.addWorksheet('itemsmap');

                DevExpress.excelExporter.exportDataGrid({
                    component: e.component,
                    worksheet,
                    autoFilterEnabled: true,
                        }).then(() => {
                         workbook.xlsx.writeBuffer().then((buffer) => {
                          saveAs(new Blob([buffer], { type: 'application/octet-stream' }), 'itemsmap.xlsx');
                                      });
                        });
                        e.cancel = true;
                },
				columns: [
						{
						   dataField: "strPartNumber",
						   caption: "Item Code",
						   width: 200,

						},{
						   dataField: "strDesc",
						   caption: "Item Description",
						   width: 600,

						},{
						   dataField: "strCategory",
						   caption: "Item Category",
						   width: 100,

						},
					],
				
				});
$('#submitMapProduct').click(function(){
	
	var dataGrid = $("#gridContainer").dxDataGrid("instance");
 
var selectedRowsData = dataGrid.getSelectedRowsData();

            var productsXML ="<xml>";
 $.each(selectedRowsData ,function(key,value) {
      
                    productsXML= productsXML + "<result>";
                    productsXML= productsXML + "<strPartNumber>"+value.strPartNumber+"</strPartNumber>";
                    productsXML= productsXML+ "</result>";



            });
			
            productsXML= productsXML+"</xml>";
			console.log(productsXML);
			console.log($('#stockDescHidden').val());
	$.ajax({

       url: '{!!url("/postMappedItems")!!}',
       type: "POST",
	   data: {
			stocktakename: $('#stockDescHidden').val(),
			xmlproducts:  productsXML
         },
       success: function (data) {

                        alert(data[0].result);
        location.reload();

			}

		});
});
	



            });
    function showDialog(tag,width,height)
    {
        $( tag ).dialog({height: height, modal: false,
            width: width,containment: false}).dialogExtend({
            "closable" : true, // enable/disable close button
            "maximizable" : false, // enable/disable maximize button
            "minimizable" : true, // enable/disable minimize button
            "collapsable" : true, // enable/disable collapse button
            "dblclick" : "collapse", // set action on double click. false, 'maximize', 'minimize', 'collapse'
            "titlebar" : false, // false, 'none', 'transparent'
            "minimizeLocation" : "right", // sets alignment of minimized dialogues
            "icons" : { // jQuery UI icon class

                "maximize" : "ui-icon-circle-plus",
                "minimize" : "ui-icon-circle-minus",
                "collapse" : "ui-icon-triangle-1-s",
                "restore" : "ui-icon-bullet"
            },
            "load" : function(evt, dlg){ }, // event
            "beforeCollapse" : function(evt, dlg){ }, // event
            "beforeMaximize" : function(evt, dlg){ }, // event
            "beforeMinimize" : function(evt, dlg){ }, // event
            "beforeRestore" : function(evt, dlg){ }, // event
            "collapse" : function(evt, dlg){  }, // event
            "maximize" : function(evt, dlg){ }, // event
            "minimize" : function(evt, dlg){  }, // event
            "restore" : function(evt, dlg){  } // event
        });
    }






</script>
