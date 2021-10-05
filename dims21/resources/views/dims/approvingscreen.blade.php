@extends('layouts.app')

@section('content')
    <?php
    $v  =  new \App\Http\Controllers\SalesForm();
    $prices= $v->getThings(Auth::user()->GroupId,'Picking Price');
    $limits = $v->getThings(Auth::user()->GroupId,'Picking Credit Limit');
    $stock = $v->getThings(Auth::user()->GroupId,'Picking No Stock');
    $vload = $v->getThings(Auth::user()->GroupId,'Picking Load');
    $rpriority = $v->getThings(Auth::user()->GroupId,'Picking Priority');
    ?>

    <div class="container" style="background: white;font-family: sans-serif;">
        <div class="row">
            <h4 style="color:black;">Auth Screen</h4>
            <div class="col-lg-12 ">

        @if($prices !="0")<h4 style="color:black;">Price Issues</h4>
        <table id="pickingpricing">
            <thead>
            <tr >
                <th class="col-xs-1">Picking Reference</th>
                <th class="col-xs-1">Code</th>
                <th class="col-xs-3">Description</th>
                <th class="col-xs-1">Quantity</th>
                <th class="col-xs-1">Price</th>
                <th class="col-xs-2">Explanation</th>
                <th class="col-xs-1"></th>


            </tr>
            </thead>
            <tbody>
            @foreach($price as $val )
                <tr>
                    <td>{{ $val->strUnickReference}}</td>
                    <td>{{ $val->PastelCode}}</td>
                    <td>{{ $val->PastelDescription}}</td>
                    <td>{{ $val->mnyQty}}</td>
                    <td>{{ $val->mnyPrice}}</td>
                    <td>{{ $val->strRuleExplanation}}</td>
                    <td><input type="checkbox" name="unique" id ="unique" style="height: 20px !important;width: 50px !important;"  class="unique" value="{{ $val->intAutoPickingruleid}}" ></td>

                </tr>
            @endforeach

            </tbody>
        </table>
            <button class="btn-lg btn-success" id="authprices" style="float: right;">Auth Prices</button>
            @endif
    </div>
    <div class="col-lg-12 ">

        @if($limits !="0") <h4 style="color:black;">Credit Limit</h4>
            <table id="pickingpricing">
                <thead>
                <tr >
                    <th class="col-xs-1">Picking Reference</th>
                    <th class="col-xs-1">Code</th>
                    <th class="col-xs-3">Description</th>
                    <th class="col-xs-1">Quantity</th>
                    <th class="col-xs-1">Price</th>
                    <th class="col-xs-2">Explanation</th>
                    <th class="col-xs-1"></th>


                </tr>
                </thead>
                <tbody>
                @foreach($limit as $val )
                    <tr>
                        <td>{{ $val->strUnickReference}}</td>
                        <td>{{ $val->PastelCode}}</td>
                        <td>{{ $val->PastelDescription}}</td>
                        <td>{{ $val->mnyQty}}</td>
                        <td>{{ $val->mnyPrice}}</td>
                        <td>{{ $val->strRuleExplanation}}</td>
                        <td><input type="checkbox" name="uniquelimits" id ="uniquelimits" style="height: 20px !important;width: 50px !important;"  class="uniquelimits" value="{{ $val->intAutoPickingruleid}}" ></td>

                    </tr>
                @endforeach

                </tbody>
            </table>
            <button class="btn-lg btn-success" id="authcreditlimit" style="float: right;">Auth Limits</button>
        @endif
    </div>
            <div class="col-lg-12 ">

                @if($stock !="0")   <h4 style="color:black;">No Stock</h4>
                    <table id="pickingpricing">
                        <thead>
                        <tr >
                            <th class="col-xs-1">Picking Reference</th>
                            <th class="col-xs-1">Code</th>
                            <th class="col-xs-3">Description</th>
                            <th class="col-xs-1">Quantity</th>
                            <th class="col-xs-1">Price</th>
                            <th class="col-xs-2">Explanation</th>
                            <th class="col-xs-1"></th>


                        </tr>
                        </thead>
                        <tbody>
                        @foreach($nostock as $val )
                            <tr>
                                <td>{{ $val->strUnickReference}}</td>
                                <td>{{ $val->PastelCode}}</td>
                                <td>{{ $val->PastelDescription}}</td>
                                <td>{{ $val->mnyQty}}</td>
                                <td>{{ $val->mnyPrice}}</td>
                                <td>{{ $val->strRuleExplanation}}</td>
                                <td><input type="checkbox" name="uniquestock" id ="uniquestock" style="height: 20px !important;width: 50px !important;"  class="uniquestock" value="{{ $val->intAutoPickingruleid}}" ></td>

                            </tr>
                        @endforeach

                        </tbody>
                    </table>
                    <button class="btn-lg btn-success" id="authnostock" style="float: right;">Auth No Stock</button>
                @endif
            </div>

            <div class="col-lg-12 ">

                @if($vload !="0")   <h4 style="color:black;">Load Issue</h4>
                <table id="pickingpricing">
                    <thead>
                    <tr >
                        <th class="col-xs-1">Picking Reference</th>
                        <th class="col-xs-1">Code</th>
                        <th class="col-xs-3">Description</th>
                        <th class="col-xs-1">Quantity</th>
                        <th class="col-xs-1">Price</th>
                        <th class="col-xs-2">Explanation</th>
                        <th class="col-xs-1"></th>


                    </tr>
                    </thead>
                    <tbody>
                    @foreach($load as $val )
                        <tr>
                            <td>{{ $val->strUnickReference}}</td>
                            <td>{{ $val->PastelCode}}</td>
                            <td>{{ $val->PastelDescription}}</td>
                            <td>{{ $val->mnyQty}}</td>
                            <td>{{ $val->mnyPrice}}</td>
                            <td>{{ $val->strRuleExplanation}}</td>
                            <td><input type="checkbox" name="uniqueload" id ="uniqueload" style="height: 20px !important;width: 50px !important;"  class="uniqueload" value="{{ $val->intAutoPickingruleid}}" ></td>

                        </tr>
                    @endforeach

                    </tbody>
                </table>
                <button class="btn-lg btn-success" id="authload" style="float: right;">Auth Load</button>
                @endif
            </div>

            <div class="col-lg-12 ">

                @if($rpriority !="0")   <h4 style="color:black;">Priority Products</h4>
                <table id="pickingpricing">
                    <thead>
                    <tr >
                        <th class="col-xs-1">Picking Reference</th>
                        <th class="col-xs-1">Code</th>
                        <th class="col-xs-3">Description</th>
                        <th class="col-xs-1">Quantity</th>
                        <th class="col-xs-1">Price</th>
                        <th class="col-xs-2">Explanation</th>
                        <th class="col-xs-1"></th>


                    </tr>
                    </thead>
                    <tbody>
                    @foreach($priority as $val )
                        <tr>
                            <td>{{ $val->strUnickReference}}</td>
                            <td>{{ $val->PastelCode}}</td>
                            <td>{{ $val->PastelDescription}}</td>
                            <td>{{ $val->mnyQty}}</td>
                            <td>{{ $val->mnyPrice}}</td>
                            <td>{{ $val->strRuleExplanation}}</td>
                            <td><input type="checkbox" name="uniquepriority" id ="uniquepriority" style="height: 20px !important;width: 50px !important;"  class="uniquepriority" value="{{ $val->intAutoPickingruleid}}" ></td>

                        </tr>
                    @endforeach

                    </tbody>
                </table>
                <button class="btn-lg btn-success" id="authpriority" style="float: right;">Auth Products</button>
                @endif
            </div>

        </div>
    </div>
@endsection
<script src="{{ asset('js/jquery-2.2.3.min.js') }}"></script>
<style>
    table {
        border-collapse: collapse;
        border-spacing: 0;
        width: 100%;
        border: 1px solid #ddd;
    }

    th, td {
        text-align: left;
        padding: 16px;
    }

    tr:nth-child(even) {
        background-color: #f2f2f2;
    }
</style>
<script>
    $(document).ready(function (){
        $('#orderListing').hide();
        $('#pricing').hide();
        $('#callList').hide();
        $('#copyOrdersBtn').hide();
        $('#tabletLoadingApp').hide();
        $('#salesQuotebtn').hide();
        $("#returns").hide();
        $("#pricingOnCustomer").hide();
        $("#salesOnOrder").hide();
        $("#salesInvoiced").hide();
        $("#posCashUp").hide();

        $('#authprices').click(function(){
            var unique = new Array();
            $('[name="unique"]:checked').each(function(checkbox) {
                // selected.push(checkbox);
                var id = $(this).val();
                unique.push({
                    'autoid': id
                });
            });
            postData(unique);
        });

        $('#authcreditlimit').click(function(){
            var uniquelimits = new Array();
            $('[name="uniquelimits"]:checked').each(function(checkbox) {
                // selected.push(checkbox);
                var id = $(this).val();
                uniquelimits.push({
                    'autoid': id
                });
            });
            postData(uniquelimits);
        });

        $('#authnostock').click(function(){
            var uniquestock = new Array();
            $('[name="uniquestock"]:checked').each(function(checkbox) {
                // selected.push(checkbox);
                var id = $(this).val();
                uniquestock.push({
                    'autoid': id
                });
            });
            postData(uniquestock);
        });

        $('#authload').click(function(){
            var uniqueload = new Array();
            $('[name="uniqueload"]:checked').each(function(checkbox) {
                // selected.push(checkbox);
                var id = $(this).val();
                uniqueload.push({
                    'autoid': id
                });
            });
            postData(uniqueload);
        });
        $('#authpriority').click(function(){
            var uniquepriority = new Array();
            $('[name="uniquepriority"]:checked').each(function(checkbox) {
                // selected.push(checkbox);
                var id = $(this).val();
                uniquepriority.push({
                    'autoid': id
                });
            });
            postData(uniquepriority);
        });

        function postData(ids){
            $.ajax({
                url: '{!!url("/updatepickingauthstatus")!!}',
                type: "POST",
                data: {

                    authIds: ids
                },
                success: function (data) {

                    location.reload();
                }
            });
        }

    });

</script>
