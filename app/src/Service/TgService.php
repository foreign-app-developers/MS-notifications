<?php

namespace App\Service;

use App\Entity\Notification;
use App\NotificationInterface;
use Symfony\Component\Notifier\Bridge\Telegram\TelegramOptions;
use Symfony\Component\Notifier\ChatterInterface;
use Symfony\Component\Notifier\Message\ChatMessage;

class TgService implements NotificationInterface
{
    private $chatter;

    public function __construct(ChatterInterface $chatter)
    {
        $this->chatter = $chatter;
    }

    public function sendNotification(Notification $notification): string
    {

        $messageText = '<b>' . $notification->getTitle() . '</b>' . "\n" . $notification->getContent();
        $chatId = $_ENV['TG_' . $notification->getToVal()];
        $chatMessage = new ChatMessage($messageText);
        $telegramOptions = (new TelegramOptions())
            ->chatId($chatId)
            ->parseMode('HTML')
            ->disableWebPagePreview(true)
            ->disableNotification(false);
        $chatMessage->options($telegramOptions);
        $this->chatter->send($chatMessage);
        return "success";

    }
}