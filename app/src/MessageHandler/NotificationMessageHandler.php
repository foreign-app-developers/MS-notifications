<?php

namespace App\MessageHandler;


use App\Entity\Notification;
use App\Service\EmailService;
use App\Service\PushService;
use App\Service\SmsService;
use App\Service\TgService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler]
class NotificationMessageHandler
{
    private $entityManager;
    private EmailService $emailService;
    private TgService $tgService;
    private PushService $pushService;
    private SmsService $smsService;
    public function __construct(EmailService $emailService, TgService $tgService, EntityManagerInterface $entityManager,PushService $pushService, SmsService $smsService)
    {
        $this->emailService = $emailService;
        $this->tgService = $tgService;
        $this->pushService = $pushService;
        $this->entityManager = $entityManager;
        $this->smsService = $smsService;
    }
    public function __invoke(Message $message)
    {

        switch ($message->getType()) {
            case 'email':
                $this->emailService->sendNotification($message);
                break;
            case 'tg':
                $this->tgService->sendNotification($message);
                break;
            case 'push':
                $this->pushService->sendNotification($message);
                break;
            case 'sms':
                $this->smsService->sendNotification($message);
                break;
            default:
                throw new \Exception('Invalid notification type');
        }
    }

}