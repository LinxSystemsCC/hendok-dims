@extends('layouts.app')

@section('content')
    <div class="container" style="font-family: sans-serif;">
        <h3>{{$invoiceNumber}}</h3>

        <div class="row">
           <form action="{{ url('/reordering') }}" method="POST" class="side-by-side">
                {!! csrf_field() !!}
            <div class="col-lg-4 table-responsive">
            <table >
                <tr>
                    <th style="text-align: center;">Select</th>
                    <th style="text-align: center;">Name</th>
                    <th style="text-align: center;">Quantity</th>
                </tr>

                    @foreach($items as $value)

                        <tr>
                            <td><input name="prolang[]" value="{{$value->PastelCode}}" type="checkbox"> </td>
                            <td>{{$value->PastelDescription}}</td>
                            <td style="text-align: center;"><input style="width: 70px;" name="gty[]" type="text" value="{{$value->Qty}}" ></td>
                        </tr>

                    @endforeach
            </table>
        </div>
                <input type="submit" class="btn btn-primary btn-sm" value="Proceed" style="position:fixed;bottom:0;right: 0px;">
            </form>
        </div>
    </div>

@endsection
<script src="//ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
<script>
    $(document).ready(function () {
        $('input:text').prop('readOnly', true);
        $('input:text').prop('disabled', true);

        $('input:checkbox').on('click', function () {
            if ($(this).prop('checked')) {
                $(this).parent().nextAll().find('input').prop('readOnly', false);
                $(this).parent().nextAll().find('input').prop('disabled', false);
            } else {
                $(this).parent().nextAll().find('input').prop('readOnly', true);
                $(this).parent().nextAll().find('input').prop('disabled', true);
            }
        });
    });
</script>


