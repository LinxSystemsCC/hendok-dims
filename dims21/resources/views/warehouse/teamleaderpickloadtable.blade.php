<table id="pickLoadTable" class="table mb-0">
    <thead class="sticky-top">
        <tr class="bg-dark text-white fw-bold">
            <th class="col-xs-2">Order Date</th>
            <th class="col-xs-2">SO Number</th>
            <th class="col-xs-2">Description</th>
            <th class="col-xs-2">Weight</th>
            <th class="col-xs-2">Qty</th>
            <th class="col-xs-2">Picked</th>
            <th class="col-xs-2">Loaded</th>
        </tr>
    </thead>
    <tbody>
        <?php
        $storenames = "";
        $orderNumber = "";
        $area = "";
        $orderdate = "";
        $istrue = true;
        $count = 0;
        $totalWeight = 0;
        $totalQty = 0;
        $totalPickedQty = 0;
        $totalLoadedQty = 0;
        ?>

        @foreach($listproducts as $val)

        <?php
        $externalCount = 0;
        $pool = '012345-6789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ-';
        $t = time();
        $randomString = substr(str_shuffle(str_repeat($pool, 10)), 0, 10);
        $ID = $t . $randomString;
        ?>

        @if($count == 0)
        <tr class="bg-secondary text-white fw-bold" id="{{$ID}}">
            <td colspan="7">STOP: {{$val->intSequence}} - {{ $val->StoreName}}</td>
        </tr>
        @endif
        @if($storenames != $val->StoreName)
        @if($count > 0)
        <tr class="bg-dark">
            <td colspan="3" class="text-white fw-bold">Totals</td>
            <td class="text-white fw-bold">{{$totalWeight}}</td>
            <td class="text-white fw-bold">{{$totalQty}}</td>
            <td class="text-white fw-bold">{{$totalPickedQty}}</td>
            <td class="text-white fw-bold">{{$totalLoadedQty}}</td>
        </tr>
        <tr class="bg-secondary text-white fw-bold">
            <td colspan="7">STOP: {{$val->intSequence}} - {{ $val->StoreName}}</td>
        </tr>
        @endif
        <?php
        // Reset totals for the new sequence
        $totalWeight= 0;
        $totalQty = 0;
        $totalPickedQty = 0;
        $totalLoadedQty = 0;
        ?>
        @if($val->isLineInvoiced == 1)
        <tr id="rtrr{{$ID}}" @if($val->isPriorityLine == '1') class='bg-danger text-white' @endif>
        @else
        <tr id="rtrr{{$ID}}" @if($val->isPriorityLine == '1') class='bg-danger text-white' @endif>
        @endif
        <td>{{ $val->OrderDate}}</td>
        <td>{{$val->OrderNum}}</td>
            @if(Auth::user()->DefaultRoute == 8)
        <td>{{ $val->PastelDescription }}<input type="hidden" class="intAutoPickinghidden" value={{ $val->intAutoPicking }}>  <input type="hidden" class="hasLabel" value={{ $val->hasLabel }}></td>
            @else
                <td>{{ $val->PastelDescription }}<input type="hidden" class="intAutoPickinghidden" value={{ $val->intAutoPicking }}>  <input type="hidden" class="hasLabel" value="0"></td>
            @endif
        <td>{{ floatval($val->weightPlanned) }}</td>
        <td>{{ floatval($val->mnyQty)}}</td>
        <td @if($val->mnyPickedQuantity < $val->mnyQty) class='bg-warning  text-black' @else class='bg-success text-white' @endif>
            {{ floatval($val->mnyPickedQuantity)}}
        </td>
        <td @if($val->mnyLoadedQty < $val->mnyQty) class='bg-warning  text-black' @else class='bg-success text-white' @endif>
            {{ floatval($val->mnyLoadedQty)}}
            @if($val->sageWeight == 1)
                <button class="btn btn-outline-dark btn-sm float-end btnFinishPickingWeighted" value={{ $val->intAutoPicking }}><i class="fa fa-check p-0"></i></button>
            @endif
        </td>
        </tr>
        <?php
        $istrue = true;
        $storenames = $val->StoreName;
        $orderNumber = $val->OrderNum;
        $area = $val->areas;
        $orderdate = $val->OrderDate;
        $totalWeight += floatval($val->weightPlanned);
        $totalQty += floatval($val->mnyQty);
        $totalPickedQty += floatval($val->mnyPickedQuantity);
        $totalLoadedQty += floatval($val->mnyLoadedQty);
        ?>
        @else
        <tr @if($val->isPriorityLine == '1') class='bg-danger text-white' @endif>
            @if($orderdate != $val->OrderDate)
            <td>{{ $val->OrderDate}}</td>
            @else
            <td></td>
            @endif
            @if($orderNumber != $val->OrderNum)
            <td>{{$val->OrderNum}}</td>
            @else
            <td></td>
            @endif
                @if(Auth::user()->DefaultRoute == 8)
                    <td>{{ $val->PastelDescription }}<input type="hidden" class="intAutoPickinghidden" value={{ $val->intAutoPicking }}>  <input type="hidden" class="hasLabel" value={{ $val->hasLabel }}></td>
                @else
                    <td>{{ $val->PastelDescription }}<input type="hidden" class="intAutoPickinghidden" value={{ $val->intAutoPicking }}>  <input type="hidden" class="hasLabel" value="0"></td>
                @endif
            <td>{{ floatval($val->weightPlanned) }}</td>
            <td>{{ floatval($val->mnyQty)}}</td>
            <td @if($val->mnyPickedQuantity < $val->mnyQty) class='bg-warning  text-black' @else class='bg-success text-white' @endif>
                {{ floatval($val->mnyPickedQuantity)}}
            </td>
            <td @if($val->mnyLoadedQty < $val->mnyQty) class='bg-warning  text-black' @else class='bg-success text-white' @endif>
                {{ floatval($val->mnyLoadedQty)}}
                @if($val->sageWeight == 1)
                    <button class="btn btn-outline-dark btn-sm float-end btnFinishPickingWeighted" value={{ $val->intAutoPicking }}><i class="fa fa-check p-0"></i></button>
                @endif
            </td>
        </tr>
        <?php
        $storenames = $val->StoreName;
        $orderNumber = $val->OrderNum;
        $orderdate = $val->OrderDate;
        $area = $val->areas;
        if ($storenames == $val->StoreName) {
            $istrue = true;
        }
        $totalWeight += floatval($val->weightPlanned);
        $totalQty += floatval($val->mnyQty);
        $totalPickedQty += floatval($val->mnyPickedQuantity);
        $totalLoadedQty += floatval($val->mnyLoadedQty);
        ?>
        @endif
        <?php $count++; ?>
        @endforeach
        <tr class="bg-dark">
            <td colspan="3" class="text-white fw-bold">Totals</td>
            <td class="text-white fw-bold">{{$totalWeight}}</td>
            <td class="text-white fw-bold">{{$totalQty}}</td>
            <td class="text-white fw-bold">{{$totalPickedQty}}</td>
            <td class="text-white fw-bold">{{$totalLoadedQty}}</td>
        </tr>
        {{-- <tr class="bg-secondary text-white fw-bold">
            <td colspan="7" class="text-secondary">Easter Egg</td>
        </tr> --}}
    </tbody>
</table>
