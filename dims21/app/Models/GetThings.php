<?php
/**
 * Created by PhpStorm.
 * User: Reginald
 * Date: 17/07/2017
 * Time: 09:33 AM
 */

namespace App;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

use Illuminate\Notifications\Notifiable;

class GetThings extends Model
{

    /*public function getProduts($prodCode,$column)
    {
        $getProducts =DB::connection('sqlsrv3')->table('tblProducts')->where('PastelCode', "$prodCode")->value($column);
        return $getProducts;
    }*/
    // Import Notifiable Trait
    use Notifiable;
    // Specify Slack Webhook URL to route notifications to
    public function routeNotificationForSlack() {
        return $this->slack_webhook_url;
    }
}