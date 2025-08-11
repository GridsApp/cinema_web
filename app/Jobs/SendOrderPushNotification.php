<?php

namespace App\Jobs;

use App\Models\User;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use Illuminate\Queue\InteractsWithQueue;

class SendOrderPushNotification implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $userId;

    /**
     * Create a new job instance.
     */
    public function __construct($userId)
    {
        $this->userId = $userId;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $user = User::find($this->userId);

        if (!$user) {
            return;
        }

        $playerID = $user->player_id;

        if(!$playerID){
            return;
        }

        $conditions = [
            "condition" => [],
            "value" => []
        ];


        $titles = [
            'en' => 'We’d love your feedback',
            'ar' => 'نود معرفة رأيك'
        ];
        
        $messages = [
            'en' => 'Please fill out our quick survey' ,
            'ar' => 'يرجى تعبئة استبياننا السريع '
        ];

        $data = [];

        $config = config('omnipush.onesignal');
        (new \twa\cmsv2\Http\Controllers\OneSignalController($config['data']))->sendPush($titles,$messages,$conditions , $data , null , $playerID);

        $user->last_order_notified_at = now();
        $user->save();     
    }
}
