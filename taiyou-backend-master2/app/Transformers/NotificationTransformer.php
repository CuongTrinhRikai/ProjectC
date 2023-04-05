<?php
namespace App\Transformers;

use App\Model\System\Notification;
use League\Fractal\TransformerAbstract;

class NotificationTransformer extends TransformerAbstract
{
  public function transform(Notification $notification)
  {

    return [
        'id'=>$notification->id,
        'title'=>$notification->title,
        'content'=>$notification->body,
        'registrantName'=>$notification->name_of_registrant ?? null,
        'createdAt'=>japaneseDateTime($notification->created_at)->format('Y-m-d H:i:s'),
    ];
  }
}
