<?php

namespace App\Controller;

use App\DBAL\Types\NotificationTypes;
use App\Entity\Notification;
use App\Repository\NotificationRepository;
use http\Client\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/api/notification', name: 'app_notification')]
class NotificationController extends AbstractController
{

    #[Route('/add', name: 'add_notification',methods: "POST")]
    public function addNotification( NotificationRepository $repo):JsonResponse
    {
        $notification = new Notification();
        $notification->setType(NotificationTypes::SMS);
        $notification->setContent("123");
        $notification->setFromVal("1");
        $notification->setMoment(new \DateTime());
        $notification->setTitle("123");
        $notification->setIsReaded(true);
        $notification->setTimeToSend(new \DateTime());
        $notification->setToVal("asd");

        $repo->save($notification, True);

        return $this->json([
            'data' => $notification,
            'message' => 'Уведомление успешно создан!',
        ]);
    }

}
