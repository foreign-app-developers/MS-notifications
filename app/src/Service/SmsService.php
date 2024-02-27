<?php

namespace App\Service;

use App\Entity\Notification;
use App\NotificationInterface;

class SmsService implements NotificationInterface
{
    public function sendNotification(Notification $notification): void
    {
        $url = 'https://api3.greensms.ru/sms/send';
        $authorizationHeader = 'Authorization: eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJ1c2VyIjoidGVzdCIsImlhdCI6MTU5OTYxNjM2NywiZXhwIjoxNTk5NzAyNzU3fQ.NLJV_KwOKlfRxP09wUlrjQYxwclKxT_hiJWb4rjZMSk';

        $toPhoneNumber = $_ENV['SMS_' . $notification->getToVal()];
        $message = $notification->getContent();

        $data = [
            'user' => 'Vovafel228',
            'pass' => 'Vovafel228',
            'to' => $toPhoneNumber,
            'txt' => $message,
        ];

        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array($authorizationHeader, 'Content-Type: application/json'));
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        $response = curl_exec($ch);

        curl_close($ch);

    }
}
