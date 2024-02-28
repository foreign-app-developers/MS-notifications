<?php

namespace App\Service;

use App\Entity\Notification;
use App\NotificationInterface;
use Symfony\Component\Notifier\Bridge\Firebase\Notification\AndroidNotification;
use Symfony\Component\Notifier\ChatterInterface;
use Symfony\Component\Notifier\Message\ChatMessage;

class PushService implements NotificationInterface
{
    private $chatter;

    public function __construct(ChatterInterface $chatter)
    {
        $this->chatter = $chatter;
    }
    public function sendNotification(Notification $notification): string
    {
        $chatMessage = new ChatMessage($notification->getContent());
        $chatId = $_ENV['PUSH_' . $notification->getToVal()];
        $androidOptions = (new AndroidNotification($chatId, []))
            ->tag('myNotificationId')
            ->title($notification->getTitle())
        ;
        $chatMessage->options($androidOptions);
        $this->chatter->send($chatMessage);
        return "success";

    }

}