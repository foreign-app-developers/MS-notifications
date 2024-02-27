<?php

namespace App\Service;

use App\Entity\Notification;
use App\NotificationInterface;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
use Symfony\Component\Mime\Address;

class EmailService implements NotificationInterface
{
    private MailerInterface $mailer;

    public function __construct(MailerInterface $mailer)
    {
        $this->mailer = $mailer;
    }

    public function sendNotification(Notification $notification): void
    {
        $toAddresses = $_ENV['EMAIL_' . $notification->getToVal()];

        $email = (new Email())
            ->from('Kristey@example.com')
            ->to($toAddresses)
            ->subject($notification->getTitle())
            ->text($notification->getContent());

        $this->mailer->send($email);
    }
}