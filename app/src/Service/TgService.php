<?php

namespace App\Service;

use App\Entity\Notification;
use App\Entity\UserRequisite;
use App\MessageHandler\Message;
use App\NotificationInterface;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Notifier\Bridge\Telegram\TelegramOptions;
use Symfony\Component\Notifier\ChatterInterface;
use Symfony\Component\Notifier\Message\ChatMessage;

class TgService implements NotificationInterface
{
    private $chatter;
    private EntityManagerInterface $entityManager;

    public function __construct(ChatterInterface $chatter,EntityManagerInterface $entityManager)
    {
        $this->chatter = $chatter;
        $this->entityManager = $entityManager;
    }

    public function sendNotification(Message $notification): string
    {
        $messageText = '<b>' . $notification->getTitle() . '</b>' . "\n" . $notification->getContent();
        $chatMessage = new ChatMessage($messageText);

        $toUserIds = $notification->getTo();
        $userRequisiteRepository = $this->entityManager->getRepository(UserRequisite::class);
        $toAddresses = [];
        foreach ($toUserIds as $userId) {
            $userRequisite = $userRequisiteRepository->findOneBy(['userId' => $userId, 'type' => 'tg']);
            $toAddresses[] = $userRequisite->getRequisite();
        }
        foreach ($toAddresses as $chatId) {
            $telegramOptions = (new TelegramOptions())
                ->chatId($chatId)
                ->parseMode('HTML')
                ->disableWebPagePreview(true)
                ->disableNotification(false);
            $chatMessage->options($telegramOptions);
            $this->chatter->send($chatMessage);
        }
        return "success";

    }
}