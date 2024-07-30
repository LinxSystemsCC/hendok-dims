@extends('layouts.base')

{{-- Set the Title --}}
@section('title', 'Stock Counts')


{{-- Set to show navbar --}}
@php
    $includeMenu = true;
@endphp

@section('page')
    
    <div class="container">
        
        <h3>DATA SYNCING</h3>
        <div class="row">
            <button class="btn btn-primary col text-nowrap m-2" id="syncPastelStock">SYNC PASTEL STOCK TABLE</button>
            <button class="btn btn-primary col text-nowrap m-2" id="syncStockMovement">PROCESS STOCK MOVEMENT QUEUE</button>
        </div>
    </div>

@endsection

@section('scripts')

<script>
    $(document).ready(function() {

        $('#syncPastelStock').click(function(){
            $.ajax({
                url: '{!!url("/syncPastelStockTable")!!}',
                type: "GET",
                data: {

                },
                success: function (data) {
                    if (data === true){
                        // alert("The table has successfully synced");
                        DevExpress.ui.notify({
                            message: 'Sucessfully Synced Sage Products',
                            type: 'success', // 'info', 'success', 'warning'
                            displayTime: 3500,
                        });
                    }else{
                        // alert("An error occured while trying to sync the table");
                        DevExpress.ui.notify({
                            message: 'An Error Occured While Trying to Sync Sage Products',
                            type: 'error', // 'info', 'success', 'warning'
                            displayTime: 3500,
                        });
                    }
                    
                }
            });
        });

        $('#syncStockMovement').click(function(){
            $.ajax({
                url: '{!!url("/syncStockMovements")!!}',
                type: "post",
                data: {
                },
                success: function (data) {
                    if (data === true){
                        DevExpress.ui.notify({
                            message: 'Successfully Synced Stock Transactions',
                            type: 'success', // 'info', 'success', 'warning'
                            displayTime: 3500,
                        });
                    }else{
                        DevExpress.ui.notify({
                            message: 'An Error Occured While Trying to Sync Stock Transactions',
                            type: 'error', // 'info', 'success', 'warning'
                            displayTime: 3500,
                        });
                    }
                    
                }
            });
        });
    });
</script>

@endsection