<?php

namespace App\Controller;

use App\Service\EmailService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


class EmailNotiferContoller extends AbstractController
{
    #[Route('/email/notifier', name: 'app_email_notifier')]
    public function sendNotification(EmailService $notificationService)
    {
// Логика получения данных уведомления и получателя
    $recipientEmail = ['ms.notific1234@gmail.com', 'Vovafelinger75@gmail.com', 'ksmksmj@yandex.ru'];
    $subject = 'Проверка связи дубль второй "Массовая рассылка"';
    $content = 'Если ты видишь и читаешь это письмо, пришли кристине кодовое слово "Курва Ежик"';

    $notificationService->sendNotification($recipientEmail, $subject, $content);

    return new Response('Уведомление успешно отправлено');
    }
}