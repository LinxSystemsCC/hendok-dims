@extends('layouts.app')

@section('content')
<div class="container">

    <div class="row">

        <div class="col-lg-7  visible-md visible-lg">
            {!! Form::open(array('method'=>'get','class'=>'')) !!}
            <div class="input-group">

                <input name="search" value="{{ old('search') }}" type="text" class="form-control" placeholder="Search for...">
                <span class="input-group-btn">
		        <button class="btn btn-default" type="submit">Go!</button>
		      </span>

            </div><!-- /input-group -->
            {!! Form::close() !!}
            @if(isset($details))
                <p>  <b> {{ $query }} </b>  :</p>
            @endif
        </div>
        <div class="col-md-7 visible-md visible-lg">

            <div class="panel panel-default" style="height: 500px;min-height: 300px;overflow-y:auto;">
                <div id="two-columns" class="grid-container" style="display:block;">
                    <ul class="rig columns-6">
                        @if(isset($details))
                            @foreach($details as $values)

                                <li>
                                    <a href="{{ url('shop',$values->PastelCode)}}"><img src="images/{{$values->UserField3}}" /></a>
                                    <a href="{{ url('shop',$values->PastelCode)}}"><h5>{{$values->PastelDescription}}</h5></a>
                                    <a href="{{ url('shop',$values->PastelCode)}}"><h4 class="price">{{$values->PriceInc}} </h4></a>
                                </li>
                            @endforeach
                        @else

                            @foreach($products as $values)

                                <li>
                                    <a href="{{ url('shop',$values->PastelCode)}}"><img src="images/{{$values->UserField3}}" /></a>
                                    <a href="{{ url('shop',$values->PastelCode)}}"><h5 style="font-size: 10px">{{$values->PastelDescription}}</h5></a>
                                    <a href="{{ url('shop',$values->PastelCode)}}"><h5 class="price">R{{round($values->PriceInc,2)}} </h5></a>
                                </li>
                            @endforeach
                        @endif

                    </ul>
                </div>
            </div>
        </div>
        <div class="col-md-5 ">
            <div class="panel panel-default">
                <div id="two-columns" class="grid-container" style="display:block;">
                    <ul class="rig columns-1">
                        <li style=" width: 97%;font-family: sans-serif">
                            <div class="tab-frame" style="height: 470px;min-height: 300px;overflow-y:auto;">
                                <input type="radio" checked name="tab" id="tab1">
                                <label for="tab1">Invoices</label>

                                <input type="radio" name="tab" id="tab2">
                                <label for="tab2">Specials</label>

                                <input type="radio" name="tab" id="tab3">
                                <label for="tab3">Pattern</label>
                                <input type="radio" name="tab" id="tab4" >
                                <label for="tab4" class="visible-xs">Search</label>

                                <div class="tab">
                                    <table class="table" style=" width: 100%;font-family: sans-serif;">
                                        <tr style="font-size: 9px;" >
                                            <th>Invoice No</th>
                                            <th>Order date</th>
                                            <th>Delivery Date</th>
                                            <th>Ref</th>
                                        </tr>
                                        <?php $counter=0;$inv="id";$k=0; ?>
                                            @foreach($invoices as $value)
                                                @if($inv != $value->InvoiceNo )
                                                <tr style="font-size: 8px;" onclick="show_hide_row('hidden_row1<?php echo $counter+1 ?>');">
                                                    <td>
                                                        <a href="{{ url('/invoiceXXX')}}/{{$value->InvoiceNo}}/0"{{$value->InvoiceNo}}>{{$value->InvoiceNo}}</a>
                                                    </td>
                                                    <td><?php echo substr($value->OrderDate,0,10); ?></td>
                                                    <td><?php echo substr($value->DeliveryDate,0,10 ); ?></td>
                                                    <td>{{$value->OrderNo}}</td>
                                                </tr>
                                                <?php $counter++; ?>

                                            @endif
                                                    <tr style="font-size: 9px;"  class="hidden_row1{{$counter}}  hidden_row" >
                                                        <td style="padding: 0px;">{{$value->PastelDescription}}</td>
                                                        <td style="padding: 0px;">{{$value->Qty}}</td>
                                                    </tr>
                                                    @if($inv != $value->InvoiceNo )
                                                    @endif
                                                    <?php $inv=$value->InvoiceNo; ?>

                                            @endforeach

                                        </table>

                                </div>
                                <div class="tab">Show products that are on special for that specific user</div>
                                <div class="tab"> <table style=" width: 100%;font-family: sans-serif">
                                        <tr>
                                            <td>Name</td>
                                            <td>Qty</td>
                                            <td>Trend</td>
                                        </tr>
                                        @foreach($pattern as $value)

                                            @if(intval($value->PushProduct) == 1)
                                                <tr class="push_product">
                                            @else
                                                <tr>
                                                    @endif
                                                    <td>{{$value->PastelDescription}} <a href="{{ url('shop',$value->PastelDescription)}}">Buy Again</a></td>

                                                    <td>{{intval($value->Qty)}}</td>
                                                    <td>
                                                        @if($value->TrendingId == 1)
                                                            <i class="fa fa-arrow-up" aria-hidden="true" style="color: forestgreen"></i>
                                                        @endif
                                                        @if($value->TrendingId == 2)
                                                            <i class="fa fa-arrow-down" aria-hidden="true"></i>
                                                        @endif
                                                        @if($value->TrendingId == 3)
                                                            <i class="fa fa-circle" aria-hidden="true" style="color: forestgreen"></i>
                                                        @endif
                                                        @if($value->TrendingId == 4)
                                                            <i class="fa fa-stop" aria-hidden="true"></i>
                                                        @endif
                                                    </td>
                                                </tr>
                                                @endforeach
                                    </table></div>
                                <div class="tab"> {!! Form::open(array('method'=>'get','class'=>'')) !!}
                                    <div class="input-group">

                                        <input name="search" value="{{ old('search') }}" type="text" class="form-control" placeholder="Search for...">
                                        <span class="input-group-btn">
                                        <button class="btn btn-default" type="submit">Go!</button>
                                      </span>

                                    </div><!-- /input-group -->
                                    {!! Form::close() !!}
                                    @if(isset($details))
                                        <p>  <b> {{ $query }} </b>  :</p>
                                    @endif
                                    <div id="two-columns" class="grid-container" style="display:block;">
                                        <ul class="rig columns-6">
                                            @if(isset($details))
                                                @foreach($details as $values)

                                                    <li>
                                                        <a href="{{ url('shop',$values->PastelCode)}}"><img src="images/{{$values->UserField3}}" /></a>
                                                        <a href="{{ url('shop',$values->PastelCode)}}"><h5>{{$values->PastelDescription}}</h5></a>
                                                        <a href="{{ url('shop',$values->PastelCode)}}"><h4 class="price">{{$values->PriceInc}} </h4></a>
                                                    </li>
                                                @endforeach
                                            @else

                                                @foreach($products as $values)

                                                    <li>
                                                        <a href="{{ url('shop',$values->PastelCode)}}"><img src="images/{{$values->UserField3}}" /></a>
                                                        <a href="{{ url('shop',$values->PastelCode)}}"><h5 style="font-size: 10px">{{$values->PastelDescription}}</h5></a>
                                                        <a href="{{ url('shop',$values->PastelCode)}}"><h5 class="price">R{{round($values->PriceInc,2)}} </h5></a>
                                                    </li>
                                                @endforeach
                                            @endif

                                        </ul>
                                    </div>


                                </div>
                            </div></li>
                    </ul>
                </div>
            </div>
        </div>




    </div>
</div>
@endsection
<script type="text/javascript">
    function show_hide_row(row)
    {
        $("."+row).toggle();
    }
</script>
