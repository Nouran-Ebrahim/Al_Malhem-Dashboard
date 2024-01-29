<?php

namespace Modules\Client\Http\Controllers\api;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Routing\Controller;
use Modules\Client\Entities\Client;
use Modules\Notification\Entities\Notification;

class NotificationController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth:client');
    }

   public function index(Request $request)
   {
       $notifications = Auth::user()->notifications()->select('id','title','description','image','created_at','read_at')->latest()->paginate($request['paginate'] ?? 10);
       // Group notifications by date
       $groupedNotifications = $notifications->groupBy(function ($item) {
           return $item->created_at->format('Y-m-d');
       });

       // Format the dates
       $formattedNotifications = $groupedNotifications->map(function ($notificationGroup, $date) {
           return [
               'formattedDate' => $this->formatDate($date),
               'notifications' => $notificationGroup,
           ];
       })->values();
        return return_msg(true,'Client Notifications',$formattedNotifications);
   }

    private function formatDate($date)
    {
        $formattedDate = Carbon::today()->format('Y-m-d');

        if ($date === $formattedDate) {
            return 'اليوم';
        } elseif ($date === Carbon::yesterday()->format('Y-m-d')) {
            return 'امس';
        } else {
            return $date;
        }
    }

   public function readNotification(Request $request)
   {
        Notification::whereIn('id',$request['notifications_ids'])->update(['read_at' =>Carbon::now()]);
        return return_msg(true,'Notification read successfully');
   }

   public function unReadNotificationsCount()
   {
    $unReadCount = Notification::whereNull('read_at')->whereHasMorph('notifiable',[Client::class],function($query){
                        $query->where('notifiable_id',Auth::id());
                    })->count();
    return return_msg(true,'un Read Notifications Count',$unReadCount);
   }
}
