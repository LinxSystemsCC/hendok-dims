<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
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
            box-shadow: 0 0 0.5cm rgba(0,0,0,0.5);
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
            border:2px solid rgb(0, 0, 0);
            margin-top:20px;
        }

        table.table-bordered > thead > tr > th{
            border:1px solid rgb(0, 0, 0);
        }
        table.table-bordered > tbody > tr > td{
            border:1px solid rgb(0, 0, 0);
        }

        table tr {
            height: 23px;
        }

        table tr td{
            padding:3px !important;
            text-align: left;
            vertical-align: middle;
            font-size: 10px;
            font-weight: bold;
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
</head>

<body>
    @foreach($jobdata as $val)
    <page size="A4">
        <div style="padding: 35px">
            <div>
                <img  src="{{url('/images/HendokLogo.jpg')}}" style="height: 70px;">
            </div>
            <div>
                <table class="table table-bordered">
                    <tbody>
                        <tr>
                            <td class="col-md-1">DATE:</td>
                            <td class="col-md-2"></td>
                            <td class="col-md-1">SHIFT:</td>
                            <td class="col-md-2"></td>
                        </tr>

                        <tr>
                            <td class="col-md-1">MACHINE NO:</td>
                            <td class="col-md-2">{{$val->strMachineName}}</td>
                            <td class="col-md-1">OPERATOR NAME:</td>
                            <td class="col-md-2"></td>
                        </tr>

                        <tr>
                            <td class="col-md-1">DEPARTMENT:</td>
                            <td class="col-md-2">{{$val->strDeptName}}</td>
                            <td class="col-md-1">PRODUCT:</td>
                            <td class="col-md-2">{{$val->PastelDescription}}</td>
                        </tr>

                        <tr>
                            <td class="col-md-1">BATCH:</td>
                            <td class="col-md-2">HK- {{$val->intJobId}}</td>
                            <td class="col-md-1">JOB START DATE:</td>
                            <td class="col-md-2">{{$val->dteStartDate}}</td>
                        </tr>

                        <tr>
                            <td class="col-md-1">QTY REQUIRED:</td>
                            <td class="col-md-2">{{$val->mnyQtyRequired}}</td>
                            <td class="col-md-1">QTY COMPLETE:</td>
                            <td class="col-md-2">
                                @if ($val->mnyQtyProduced == null )
                                    0 
                                @else
                                    {{round($val->mnyQtyProduced, 0)}}
                                @endif
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <div style="margin: 0px">
                <table class="table table-bordered">
                    <tbody>
                        <tr>
                            <td class="col-md-1"></td>
                            <td class="col-md-1">TIME</td>
                            <td class="col-md-6">REASON</td>
                            <td class="col-md-1">QC CHECK</td>
                            <td class="col-md-1"></td>
                        </tr>

                        <tr>
                            <td>START</td>
                            <td> </td>
                            <td> </td>
                            <td>06:00</td>
                            <td> </td>
                        </tr>

                        <tr>
                            <td>STOP</td>
                            <td> </td>
                            <td> </td>
                            <td> </td>
                            <td> </td>
                        </tr>

                        <tr>
                            <td>START</td>
                            <td> </td>
                            <td> </td>
                            <td>08:00</td>
                            <td> </td>
                        </tr>

                        <tr>
                            <td>STOP</td>
                            <td> </td>
                            <td> </td>
                            <td> </td>
                            <td> </td>
                        </tr>

                        <tr>
                            <td>START</td>
                            <td> </td>
                            <td> </td>
                            <td>10:00</td>
                            <td> </td>
                        </tr>

                        <tr>
                            <td>STOP</td>
                            <td> </td>
                            <td> </td>
                            <td> </td>
                            <td> </td>
                        </tr>

                        <tr>
                            <td>START</td>
                            <td> </td>
                            <td> </td>
                            <td>12:00</td>
                            <td> </td>
                        </tr>

                        <tr>
                            <td>STOP</td>
                            <td> </td>
                            <td> </td>
                            <td> </td>
                            <td> </td>
                        </tr>

                        <tr>
                            <td>START</td>
                            <td> </td>
                            <td> </td>
                            <td>14:00</td>
                            <td> </td>
                        </tr>

                        <tr>
                            <td>STOP</td>
                            <td> </td>
                            <td> </td>
                            <td> </td>
                            <td> </td>
                        </tr>

                        <tr>
                            <td>START</td>
                            <td> </td>
                            <td> </td>
                            <td>16:00</td>
                            <td> </td>
                        </tr>

                        <tr>
                            <td>STOP</td>
                            <td> </td>
                            <td> </td>
                            <td> </td>
                            <td> </td>
                        </tr>

                        <tr>
                            <td>START</td>
                            <td> </td>
                            <td> </td>
                            <td>18:00</td>
                            <td> </td>
                        </tr>

                        <tr>
                            <td>STOP</td>
                            <td> </td>
                            <td> </td>
                            <td> </td>
                            <td> </td>
                        </tr>

                        <tr>
                            <td>START</td>
                            <td> </td>
                            <td> </td>
                            <td>20:00</td>
                            <td> </td>
                        </tr>

                        <tr>
                            <td>STOP</td>
                            <td> </td>
                            <td> </td>
                            <td> </td>
                            <td> </td>
                        </tr>

                        <tr>
                            <td>START</td>
                            <td> </td>
                            <td> </td>
                            <td>22:00</td>
                            <td> </td>
                        </tr>

                        <tr>
                            <td>STOP</td>
                            <td> </td>
                            <td> </td>
                            <td> </td>
                            <td> </td>
                        </tr>

                        <tr>
                            <td>START</td>
                            <td> </td>
                            <td> </td>
                            <td>00:00</td>
                            <td> </td>
                        </tr>

                        <tr>
                            <td>STOP</td>
                            <td> </td>
                            <td> </td>
                            <td> </td>
                            <td> </td>
                        </tr>

                        <tr>
                            <td>START</td>
                            <td> </td>
                            <td> </td>
                            <td>02:00</td>
                            <td> </td>
                        </tr>

                        <tr>
                            <td>STOP</td>
                            <td> </td>
                            <td> </td>
                            <td> </td>
                            <td> </td>
                        </tr>

                        <tr>
                            <td>START</td>
                            <td> </td>
                            <td> </td>
                            <td>04:00</td>
                            <td> </td>
                        </tr>

                        <tr>
                            <td>STOP</td>
                            <td> </td>
                            <td> </td>
                            <td> </td>
                            <td> </td>
                        </tr>

                        <tr>
                            <td>START</td>
                            <td> </td>
                            <td> </td>
                            <td>06:00</td>
                            <td> </td>
                        </tr>

                        <tr>
                            <td>STOP</td>
                            <td> </td>
                            <td> </td>
                            <td> </td>
                            <td> </td>
                        </tr>

                        <tr>
                            <td>START</td>
                            <td> </td>
                            <td> </td>
                            <td>6:00</td>
                            <td> </td>
                        </tr>

                        <tr>
                            <td>STOP</td>
                            <td> </td>
                            <td> </td>
                            <td> </td>
                            <td> </td>
                        </tr>

                        <tr>
                            <td>START</td>
                            <td> </td>
                            <td> </td>
                            <td>6:00</td>
                            <td> </td>
                        </tr>

                        <tr>
                            <td>STOP</td>
                            <td> </td>
                            <td> </td>
                            <td> </td>
                            <td> </td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <div>
                <table class="table table-bordered">
                    <tbody>
                        <tr>
                            <td class="col-md-1">TOTAL PRODUCT</td>
                            <td class="col-md-43"></td>
                        </tr>
                        <tr>
                            <td class="col-md-1">TOTAL SCRAP</td>
                            <td class="col-md-4"></td>

                        </tr>
                    </tbody>
                </table>
            </div>
            <div>
                <h4>SIGN:___________________</h3>
            </div>

        </div>
    </page>
    @endforeach
    
</body>
</html>