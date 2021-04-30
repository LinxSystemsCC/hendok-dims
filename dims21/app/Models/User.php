<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;
    public $webhook;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'UserName', 'Password', 'strField6',
    ];


    public function getAuthPassword()
    {
        return $this->strField6;
    }
    protected $connection = 'sqlsrv3';
    protected $table = 'tblDIMSUSERS';
    protected $primaryKey = 'UserID';

    public function routeNotificationForSlack()
    {
        $channelName = $this->channel('#general');
        //dd($channelName);
        Return $channelName; //'https://hooks.slack.com/services/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';
    }
    /* public function routeNotificationForSlack(  ) {
       // if($this->webhook){
            return config('slack.channels.'.'#general');
        //}
    }

   public function slackChannel($channel){
        $this->webhook = $channel;
        return $this;
    }*/
    public function channel($webHook)
    {
        switch($webHook)
        {
            case '#general':
                return 'https://hooks.slack.com/services/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';

        }
    }
}
