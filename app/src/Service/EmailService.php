<?php

namespace App\Service;

use App\Entity\Notification;
use App\Entity\UserRequisite;
use App\NotificationInterface;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
use Symfony\Component\Mime\Address;
use Doctrine\ORM\EntityManagerInterface;

class EmailService implements NotificationInterface
{
    private MailerInterface $mailer;
    private EntityManagerInterface $entityManager;

    public function __construct(MailerInterface $mailer, EntityManagerInterface $entityManager)
    {
        $this->mailer = $mailer;
        $this->entityManager = $entityManager;
    }

    public function sendNotification(Notification $notification): void
    {
        $toUserIds = $notification->getToVal();
        $userRequisiteRepository = $this->entityManager->getRepository(UserRequisite::class);
        $toAddresses = [];
        foreach ($toUserIds as $userId) {
            $userRequisite = $userRequisiteRepository->findOneBy(['userId' => $userId, 'type' => 'email']);
            $toAddresses[] = $userRequisite->getRequisite();
            }
        $email = (new Email())
            ->from($notification->getFromVal())
            ->to(...$toAddresses)
            ->subject($notification->getTitle())
            ->text($notification->getContent());

        $this->mailer->send($email);
    }
}