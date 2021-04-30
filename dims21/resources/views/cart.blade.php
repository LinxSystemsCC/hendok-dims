@extends('layouts.app')

@section('content')

    <div class="container">

        <h3>Your Cart</h3>

        <hr>

        @if (session()->has('success_message'))
            <div class="alert alert-success">
                {{ session()->get('success_message') }}
            </div>
        @endif

        @if (session()->has('error_message'))
            <div class="alert alert-danger">
                {{ session()->get('error_message') }}
            </div>
        @endif
        <div style="float:right">
            <form action="{{ url('/emptyCart') }}" method="POST">
                {!! csrf_field() !!}
                <input type="hidden" name="intOrderId" value="{{$items[0]->intOrderId}}">
                <input type="submit" class="btn btn-danger btn-sm" value="Empty Cart">
            </form>
        </div>
            <table class="table">
                <thead>
                <tr>
                    <th class="table-image"></th>
                    <th>Product</th>
                    <th>Quantity</th>
                    <th>Price</th>
                    <th>LineTot</th>
                    <th class="column-spacer"></th>
                    <th></th>
                </tr>
                </thead>

                <tbody>
                @foreach($items as $item)
                    <tr>
                        <td class="table-image"><a href=""><img style="height: 30px;"  src="{{ asset('images/' . $item->imageName) }}" alt="product" class="img-responsive cart-image"></a></td>
                        <td><a href="">{{ $item->title }}</a></td>
                        <td style="background: white; width: 15px !important;" contenteditable="true" onBlur="saveToDatabase(this,'fltQty','{{$item->intOrderDetailId}}')" onClick="showEdit(this);">{{$item->fltQty}}</td>

                        <td>R{{ $item->fltPrice }}</td>
                        <td>R{{ $item->lineTot }}</td>
                        <td class=""></td>
                        <td>
                            <form action="{{ url('cart', [$item->intOrderDetailId]) }}" method="POST" class="side-by-side">
                                {!! csrf_field() !!}
                                <input type="hidden" name="_method" value="DELETE">
                                <input type="submit" class="btn btn-danger btn-sm" value="Remove">
                            </form>

                        </td>
                    </tr>

                @endforeach
                <tr>
                    <td class="table-image"></td>
                    <td></td>
                    <td class="small-caps table-bg" style="text-align: right">Subtotal</td>
                    <td>R{{$total}}</td>
                    <td></td>
                    <td></td>
                </tr>
                <tr>
                    <td class="table-image"></td>
                    <td></td>
                    <td class="small-caps table-bg" style="text-align: right">Tax</td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>

                <tr class="border-bottom">
                    <td class="table-image"></td>
                    <td style="padding: 40px;"></td>
                    <td class="small-caps table-bg" style="text-align: right">Your Total</td>
                    <td class="table-bg">R{{$total}}</td>
                    <td class="column-spacer"></td>
                    <td></td>
                </tr>

                </tbody>
            </table>

            <a href="{{ url('/home') }}" class="btn btn-primary btn-sm">Continue Shopping</a> &nbsp;
            <a href="#" class="btn btn-success btn-sm">Proceed to Checkout</a>
        <div class="spacer"></div>

    </div> <!-- end container -->

@endsection


<script>

        function showEdit(editableObj) {
            $(editableObj).css("background","#FFF");
        }

        function saveToDatabase(editableObj,column,id) {

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });            $(editableObj).css("background","#FFF url(loaderIcon.gif) no-repeat right");
            $.ajax({
                url: "{{ url("/updatecart") }}",
                type: "post",
                data:'column='+column+'&editval='+editableObj.innerHTML+'&id='+id,
                success: function(data){
                    $(editableObj).css("background","#FDFDFD");
                }
            });
        }

</script>
