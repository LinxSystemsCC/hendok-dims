@extends('layouts.app')

@section('content')
    <div class="container" style="font-family: sans-serif;">

        <div class="row">
            <div class="col-lg-8 table-responsive">
                <i>Quantity is Editable</i>
                <table class="table">
                    <tr>

                        <th>Name</th>
                        <th>Quantity</th>
                        <th>Price</th>
                    </tr>
                    @for($i=0;$i<count($items) ;$i++)
                        <tr style="font-size: 12px;">

                            <td>{{$items[$i]['productDescription']}}</td>
                            <td contenteditable="true" onBlur="saveToDatabase(this,'Quantity','{{$items[$i]['gty']}}','{{$items[$i]['gty']}}')" onClick="showEdit(this);">{{$items[$i]['gty']}}</td>
                            <td>0</td>
                            <td>
                                <form action="{{ url('cartreorderingremoveitem') }}" method="POST" class="side-by-side">
                                    {!! csrf_field() !!}
                                    <input type="hidden" name="_method" value="DELETE">
                                    <input type="hidden" name="token_id" value="{{$items[$i]['productCode']}}">

                                    <input type="submit" class="btn btn-danger btn-sm" value="Remove">
                                </form>

                            </td>
                        </tr>
                    @endfor
                </table>
            </div>
        </div>
    </div>
@endsection
<script>

    function showEdit(editableObj) {
        $(editableObj).css("background","#FFF");
    }

    function saveToDatabase(editableObj,column,partnumber,mainId) {

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });            $(editableObj).css("background","#FFF url(loaderIcon.gif) no-repeat right");
        $.ajax({
            url: "{{ url("/updatereordering") }}",
            type: "post",
            data:'column='+column+'&editval='+editableObj.innerHTML+'&id='+partnumber+'&mainId='+mainId,
            success: function(data){
                $(editableObj).css("background","#FDFDFD");
            }
        });
    }

</script>