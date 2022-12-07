<html lang="en">
<head>
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <style>
        body {
            background: rgb(204,204,204) !important; 
            }
        page {
            background: white;
            display: block;
            margin: 0 auto;
            margin-top: 0.5cm;
            margin-bottom: 0.5cm;
            box-shadow: 0 0 0.5cm black;
            }
        page[size="A4"] {  
            width: 21cm;
            height: 29.7cm; 
            }
        @media print {
            body, page {
                margin: 0;
                box-shadow: 0;
            }
        }

        table.table-bordered{
            border:2px solid black;
            margin-top:20px;
        }

        table.table-bordered > thead > tr > th{
            border:1px solid black;
        }
        table.table-bordered > tbody > tr > td{
            border:1px solid black;
        }

        table tr {
            height: 36px;
        }

        table tr td{
            padding:3px !important;
            text-align: left;
            vertical-align: middle;
            font-size: 10px;
            font-weight: bold;
            border-top-style:solid;
            border-top-width:2pt;
            border-left-style:solid;
            border-left-width:2pt;
            border-bottom-style:solid;
            border-bottom-width:2pt;
            border-right-style:solid;
            border-right-width:2pt;
        }

        .parent {
            display: flex;
            height: 120px;
        }

        .child {
            margin: auto; 
            object-fit: cover;
        }

        p {
            margin: 0 0 0px !important;
        }
        
    </style>
    <title>Job Card</title>

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <link rel="stylesheet" href="//code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css">
    <script src="https://code.jquery.com/jquery-3.6.0.js"></script>
    <script src="https://code.jquery.com/ui/1.13.2/jquery-ui.js"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.5/jszip.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/babel-polyfill/7.4.0/polyfill.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/exceljs/4.1.1/exceljs.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/FileSaver.js/2.0.2/FileSaver.min.js"></script>
    <link rel="stylesheet" href="https://cdn3.devexpress.com/jslib/20.1.7/css/dx.common.css">
    <link rel="stylesheet" href="https://cdn3.devexpress.com/jslib/20.1.7/css/dx.light.css">

    <script src="{{ asset('js/jquery-ui.js') }}"></script>
    <script src="{{ asset('js/jquery.dialogextend.js') }}"></script>
    <!-- DevExtreme library -->
    <script type="text/javascript" src="https://cdn3.devexpress.com/jslib/20.1.7/js/dx.all.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>

    <!-- jQuery --> <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/js/select2.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.14.7/dist/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
    <script type="text/javascript" src="https://cdn3.devexpress.com/jslib/20.1.7/js/dx.all.js"></script>
</head>

<body>
    {{-- @foreach($jobdata as $val) --}}
    <page size="A4">
        <div style="padding: 40px">
            <table style="border-collapse:collapse;" cellspacing="0">
                <!-- Header -->
                <tr>
                    <td style="width:278pt;" colspan="3" rowspan="4">
                        <div class="parent">
                            <img class="child" src="{{url('/images/HendokLogo.jpg')}}" style="height: 100px;">
                        </div>
                        
                    </td>
                    <td style="width:226pt;" colspan="2" bgcolor="#F1F1F1">
                        <p style="text-align: center;">PRODUCT SPECIFICATIONS MANUFACTURING SHEET</p>
                    </td>
                </tr>
                <tr>
                    <td style="width:226pt;" colspan="2">
                        <p style="text-align: center;">Document No. HDK.GPL.001P.FM04 Rev: 0</p>
                    </td>
                </tr>
                <tr>
                    <td style="width:226pt;" colspan="2">
                        <p style="text-align: center;">Date of implementation: 24/11/2022</p>
                    </td>
                </tr>
                <tr>
                    <td style="width:226pt;" colspan="2">
                        <p style="text-align: center;">Controlled by: Quality Assurance</p>
                    </td>
                </tr>
    
                <!-- Customer Info -->
                <tr>
                    <td style="width:504pt;" colspan="5">
                        <p style="text-align: center;">Specifications drawn from Customer Requirements (SABS / 1411 Part 6 / BS1442)</p>
                    </td>
                </tr>
                <tr>
                    <td style="width:147pt;" bgcolor="#F1F1F1">
                        <p>Customer Name</p>
                    </td>
                    <td style="width:357pt;" colspan="4">
                        <p>Zamefa</p>
                    </td>
                </tr>
                <tr>
                    <td style="width:147pt;" bgcolor="#F1F1F1">
                        <p>Product</p>
                    </td>
                    <td style="width:357pt;" colspan="4">
                        <p>1.60mm</p>
                    </td>
                </tr>
                <tr>
                    <td style="width:147pt;" bgcolor="#F1F1F1">
                        <p>Product Application</p>
                    </td>
                    <td style="width:357pt;" colspan="4">
                        <p>Cables</p>
                    </td>
                </tr>
                <tr>
                    <td style="width:504pt;" colspan="5">
                    </td>
                </tr>
    
                <!-- Rod Specifications -->
                <tr>
                    <td style="width:504pt;" colspan="5" bgcolor="#F1F1F1">
                        <p style="text-align: center;">ROD SPECIFICATIONS</p>
                    </td>
                </tr>
                <tr>
                    <td style="width:147pt;" bgcolor="#F1F1F1">
                        <p>ROD DIAMETER</p>
                    </td>
                    <td style="width:357pt;" colspan="4">
                        <p>5.50mm</p>
                    </td>
                </tr>
                <tr>
                    <td style="width:147pt;" bgcolor="#F1F1F1">
                        <p>ROD GRADE</p>
                    </td>
                    <td style="width:357pt;" colspan="4">
                        <p>1006</p>
                    </td>
                </tr>
                <tr>
                    <td style="width:147pt;" bgcolor="#F1F1F1">
                        <p>ROD TREATMENT</p>
                    </td>
                    <td style="width:357pt;" colspan="4">
                        <p>Very clean rod, use sander unit</p>
                    </td>
                </tr>
                <tr>
                    <td style="width:504pt;" colspan="5">
                    </td>
                </tr>
    
                <!-- GALVANISING WIRE SPECIFICATIONS -->
                <tr>
                    <td style="width:504pt;" colspan="5" bgcolor="#F1F1F1">
                        <p style="text-align: center;">GALVANISING WIRE SPECIFICATIONS</p>
                    </td>
                </tr>
                <tr>
                    <td style="width:147pt;" bgcolor="#F1F1F1">
                        <p>DIAMETER GALV WIRE</p>
                    </td>
                    <td style="width:357pt;" colspan="4">
                        <p>1.60mm</p>
                    </td>
                </tr>
                <tr>
                    <td style="width:147pt;" bgcolor="#F1F1F1">
                        <p>DIAMETER TOLERANCE</p>
                    </td>
                    <td style="width:44pt;" bgcolor="#F1F1F1">
                        <p>MIN</p>
                    </td>
                    <td style="width:131pt;">
                        <p>1.56mm</p>
                    </td>
                    <td style="width:44pt;" bgcolor="#F1F1F1">
                        <p>MAX</p>
                    </td>
                    <td style="width:139pt;">
                        <p>1.64mm</p>
                    </td>
                </tr>
                
                <tr>
                    <td style="width:147pt;" bgcolor="#F1F1F1">
                        <p>TENSILE STRENGTH</p>
                    </td>
                    <td style="width:44pt;" bgcolor="#F1F1F1">
                        <p>MIN</p>
                    </td>
                    <td style="width:131pt;">
                        <p>370PMa</p>
                    </td>
                    <td style="width:43pt;" bgcolor="#F1F1F1">
                        <p>MAX</p>
                    </td>
                    <td style="width:139pt;">
                        <p>580MPa</p>
                    </td>
                </tr>

                <tr>
                    <td style="width:147pt;" bgcolor="#F1F1F1">
                        <p>1% STRESS TEST</p>
                    </td>
                    <td style="width:44pt;" bgcolor="#F1F1F1">
                        <p>MIN</p>
                    </td>
                    <td style="width:131pt;">
                        <p>N/A</p>
                    </td>
                    <td style="width:131pt;" bgcolor="#F1F1F1">
                        <p>SPEED</p>
                    </td>
                    <td style="width:139pt;">
                        <p>53RPM</p>
                    </td>
                </tr>
                
                <tr>
                    <td style="width:147pt;" bgcolor="#F1F1F1">
                        <p>ELONGATION</p>
                    </td>
                    <td style="width:44pt;" bgcolor="#F1F1F1">
                        <p>MIN</p>
                    </td>
                    <td style="width:131pt;">
                        <p>6%</p>
                    </td>
                    <td style="width:43pt;" bgcolor="#F1F1F1">
                        <p>LED BATH DIP</p>
                    </td>
                    <td style="width:139pt;">
                        <p>FULL 700 / DIPPER 1</p>
                    </td>
                </tr>
            
                <tr>
                    <td style="width:147pt;" bgcolor="#F1F1F1">
                        <p>ZINC COATING (g/m²)</p>
                    </td>
                    <td style="width:44pt;" bgcolor="#F1F1F1">
                        <p>MIN</p>
                    </td>
                    <td style="width:131pt;">
                        <p>370PMa</p>
                    </td>
                    <td style="width:43pt;" bgcolor="#F1F1F1">
                        <p>MAX</p>
                    </td>
                    <td style="width:139pt;">
                        <p>580MPa</p>
                    </td>
                </tr>
                
                <tr>
                    <td style="width:147pt;" bgcolor="#F1F1F1">
                        <p>ZINC COATING TYPE</p>
                    </td>
                    <td style="width:357pt;" colspan="4">
                        <p>LG</p>
                    </td>
                </tr>

                <tr>
                    <td style="width:147pt;" bgcolor="#F1F1F1">
                        <p>COATING UNIFORMITY</p>
                    </td>
                    <td style="width:87pt;" colspan="2">
                        <p>No red deposits: Copper Dip: x1 1min dip & x1 half min</p>
                    </td>
                    <td style="width:131pt;" bgcolor="#F1F1F1">
                        <p>MMCE(NITRO SETTING) estimated</p>
                    </td>
                    <td style="width:139pt;">
                        <p>TBC</p>
                    </td>
                </tr>

                <tr>
                    <td style="width:147pt;" bgcolor="#F1F1F1">
                        <p>COATING ADHESION</p>
                    </td>
                    <td style="width:87pt;" colspan="2">
                        <p>No flaking or cracking</p></p>
                    </td>
                    <td style="width:131pt;" bgcolor="#F1F1F1">
                        <p>NITRO DIE SIZE</p>
                    </td>
                    <td style="width:139pt;">
                        <p>6MM</p>
                    </td>
                </tr>

                <tr>
                    <td style="width:147pt;" bgcolor="#F1F1F1">
                        <p>LABELING</p>
                    </td>
                    <td style="width:357pt;" colspan="4">
                        <p>Stock code / Product / MPa Spec / Customer Name / Mass / Date manufactured / Operator / Ticket number</p>
                    </td>
                </tr>

                <tr>
                    <td style="width:147pt;" bgcolor="#F1F1F1">
                        <p>MAX NO. OF WELDS ALLOWED</p>
                    </td>
                    <td style="width:87pt;" colspan="2">
                        <p>0</p>
                    </td>
                    <td style="width:131pt;" bgcolor="#F1F1F1">
                        <p>PACKAGING REQUIREMENTS</p>
                    </td>
                    <td style="width:139pt;">
                        <p>Shrink wrapped &amp; double plastic</p>
                    </td>
                </tr>
                
                <!-- SPECIAL INSTRUCTIONS -->
                <tr>
                    <td style="width:504pt;" colspan="5" bgcolor="#F1F1F1">
                        <p style="text-align: center;">SPECIAL INSTRUCTIONS</p>
                    </td>
                </tr>
                <tr>
                    <td style="width:504pt;; height: 70px; vertical-align:top" colspan="5">
                        <p>Jumbos to be strapped (x4 straps), shrink wrapped and wrapped with two layers of plastic.</p>
                        <p>400kg jumbos (+-50kg tolerance) / Coil ID: 300mm / Coil OD: 650mm (Use tape measure to verify cage)</p>
                        <p>Coil to be free from any tangles during unwinding process</p>
                    </td>
                </tr>
            </table>



        </div>
    </page>
    {{-- @endforeach --}}
    
</body>

<script>
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

</html>