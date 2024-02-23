<?php

namespace App\Service;

use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
use Symfony\Component\Mime\Address;

class EmailService
{
    private MailerInterface $mailer;

    public function __construct(MailerInterface $mailer)
    {
        $this->mailer = $mailer;
    }

    public function sendNotification(array $recipientEmails, $subject, $content)
    {
        $toAddresses = [];
        foreach ($recipientEmails as $recipientEmail) {
            $toAddresses[] = new Address($recipientEmail);
        }
        $email = (new Email())
            ->from('Kristey@example.com')
            ->to(...$toAddresses)
            ->subject($subject)
            ->text($content);

        $this->mailer->send($email);
    }
}
