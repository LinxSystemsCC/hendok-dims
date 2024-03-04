<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ApisController extends Controller
{
    
    public function getOpenUpkeepWorkOrders(){
        $curl = curl_init();
    
        $token = DB::connection('sqlsrv3')->table('tblHendokApiIntegration')->where('strHostName', 'Upkeep')->value('strSessionToken');
    
        curl_setopt_array($curl, array(
            CURLOPT_URL => 'https://api.onupkeep.com/api/v2/work-orders',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_SSL_VERIFYPEER => false,
            CURLOPT_CUSTOMREQUEST => 'GET',
            CURLOPT_HTTPHEADER => array(
                'Session-Token: ' . $token,
                'Cookie: upkeepsess=' . $token
            ),
        ));
    
        $response = curl_exec($curl);
    
        if ($response === false) {
            // Handle cURL error
            $error = curl_error($curl);
            // Log or handle the error
            echo "cURL Error: " . $error;
            curl_close($curl); // Close curl handle
            return []; // Return an empty array or handle the error differently
        }
    
        curl_close($curl); // Close curl handle
    
        dump($response);
    
        $result = json_decode($response, true);
    
        if ($result === null) {
            // Handle JSON decoding error
            $jsonError = json_last_error_msg();
            // Log or handle the error
            echo "JSON Decoding Error: " . $jsonError;
            return []; // Return an empty array or handle the error differently
        }
    
        // Check if the expected structure exists in the result
        if (!isset($result['results'])) {
            // Handle unexpected response format
            echo "Unexpected response format";
            return []; // Return an empty array or handle the error differently
        }
    
        dump($result);
    
        $openWorkOrders = [];
    
        foreach ($result['results'] as $workOrder) {
            if ($workOrder['status'] !== 'complete') {
                $openWorkOrders[] = $workOrder;
            }
        }
    
        // dd($openWorkOrders);
        return $openWorkOrders;
    }
    
}
