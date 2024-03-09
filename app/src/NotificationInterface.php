<?php

namespace App;

use App\Entity\Notification;
use App\MessageHandler\Message;

interface NotificationInterface
{
    public function sendNotification(Message $notification);

}