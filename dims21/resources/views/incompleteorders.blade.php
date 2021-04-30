@extends('layouts.app')

@section('content')
    <div class="container">
        <h3>Incomplete Orders</h3>
        <div class="row">
            <table class="table">
                <thead>
                <tr>
                    <th class="table-image"></th>
                    <th>OrderNumber</th>
                    <th>OrderDate</th>
                    <th>Items</th>
                </tr>
                </thead>
                <tbody>

                @foreach($items as $item)
                    <td>

                        <form action="{{ url('cart', [$item->intOrderDetailId]) }}" method="POST" class="side-by-side">
                            {!! csrf_field() !!}
                            <input type="hidden" name="_method" value="DELETE">
                            <input type="hidden" name="_method" value="DELETE">
                            <input type="submit" class="btn btn-danger btn-sm" value="{{$item->orderID}}">
                        </form>
                    </td>
                <td>{{$item->dteOrderDate}}</td>
                <td>{{$item->dteOrderDate}}</td>


                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection