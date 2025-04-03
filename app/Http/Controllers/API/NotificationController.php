<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\CmsSentPushNotification;
use Illuminate\Http\Request;
use twa\cmsv2\Traits\APITrait;

class NotificationController extends Controller
{

    use APITrait;
    
    // public function list()
    // {
       
    //     $notifications = CmsSentPushNotification::whereNull('deleted_at')->get()->map(function ($notification) {
    //         return [
    //             'id' => $notification->id,
    //             'title' => $notification->title,
    //             'message' => $notification->message,
    //             'text' => $notification->text,
    //             'image' => get_image($notification->image),
    //             'created_at' => $notification->created_at,
    //         ];
    //     });

    //     return $this->responseData($notifications);
    // }
}
