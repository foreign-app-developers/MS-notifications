<?php

namespace App\Controller;

use App\DBAL\Types\NotificationTypes;
use App\Entity\Notification;
use App\Repository\NotificationRepository;
use App\Service\TgService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/api/notification', name: 'app_notification')]
class NotificationController extends AbstractController
{

    #[Route('/send', name: 'add_notification',methods: "POST")]
    public function sendNotification(NotificationRepository $repo, Request $request, TgService $tgService):JsonResponse
    {
        $data = json_decode($request->getContent(), true);
        $notification = new Notification();
        $notification->setContent($data['content']);
        $notification->setFromVal('asd');
        $notification->setMoment(new \DateTime());
        $notification->setTitle($data['title']);
        $notification->setIsReaded(false);
        $notification->setTimeToSend(new \DateTime());
        $notification->setToVal($data['to']);
        if($data['type'] == 'sms'){
            $notification->setType(NotificationTypes::SMS);
        }
        if($data['type'] == 'email'){
            $notification->setType(NotificationTypes::EMAIL);
        }
        if($data['type'] == 'tg'){
            $notification->setType(NotificationTypes::TG);
            $tgService->sendNotification($notification);
            $repo->save($notification, True);
        }

        return $this->json([
            'data' => $notification,
            'message' => 'Уведомление успешно отправлено!',
        ]);
    }

}
