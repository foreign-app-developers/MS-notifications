<?php

namespace App;

use App\Entity\Notification;

interface NotificationInterface
{
    public function sendNotification(Notification $notification);

}