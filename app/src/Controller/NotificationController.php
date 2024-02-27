<?php

namespace App\Controller;

use App\DBAL\Types\NotificationTypes;
use App\Entity\Notification;
use App\Repository\NotificationRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\{JsonResponse, Request};
use Symfony\Component\Routing\Attribute\Route;


#[Route('/api/notification', name: 'app_notification')]
class NotificationController extends AbstractController
{

    #[Route('/add', name: 'add_notification',methods: "POST")]
    public function addNotification( NotificationRepository $repo):JsonResponse
    {
        $notification = new Notification();
        $notification->setType(NotificationTypes::EMAIL);
        $notification->setContent("123");
        $notification->setFromVal("Вова");
        $notification->setMoment(new \DateTime());
        $notification->setTitle("ыфаффа");
        $notification->setIsReaded(false);
        $notification->setTimeToSend(new \DateTime());
        $notification->setToVal("asd");

        $repo->save($notification, True);

        return $this->json([
            'data' => $notification,
            'message' => 'Уведомление успешно создан!',
        ]);
    }

    #[Route('/delete/{id}', name: 'delete_notification', methods: 'DELETE')]
    public function deleteNotification(NotificationRepository $repo, int $id): JsonResponse
    {
        $notification = $repo->find($id);

        if (!$notification) {
            return $this->json(['message' => 'Уведомление не найдено.'], 404);
        }

        $repo->remove($notification, True);

        return $this->json(['message' => 'Уведомление успешно удалено!']);
    }

    #[Route('/edit/{id}', name: 'editNotification', methods: ['PUT'])]
    public function editNotification(Request $request, NotificationRepository $repo, $id): JsonResponse
    {
        $data = json_decode($request->getContent(), true);

        if (empty($data['content']) || empty($data['title'])) {
            return $this -> json(['message' => 'Некорректные данные'], 400);
        }

        $notification = $repo->find($id);

        if (!$notification) {
            return $this -> json(['message' => 'Уведомление не найдено'], 404);
        }

        $notification->setType($data['type']);
        $notification->setContent($data['content']);
        $notification->setFromVal($data['fromVal']);
        $notification->setTitle($data['title']);
        $notification->setToVal($data['toVal']);

        $repo->save($notification, true);

        return $this ->json([
            'message' => 'Уведомление успешно отредактировано',
            'data' => $notification
        ]);
    }

    #[Route('/mark-read/{id}', name: 'mark_single_notification_as_read', methods: 'PUT')]
    public function markSingleAsRead(NotificationRepository $repo, int $id): JsonResponse
    {
        $notification = $repo->find($id);

        if (!$notification) {
            return $this->json(['message' => 'Уведомление не найдено.'], 404);
        }

        $notification->setIsReaded(true);
        $repo->save($notification, true);

        return $this->json(['message' => 'Уведомление успешно помечено как прочитанное!']);
    }

    #[Route('/mark-all-read', name: 'mark_all_notifications_as_read', methods: 'PUT')]
    public function markAllAsRead(Request $request, NotificationRepository $repo): JsonResponse
    {
        $data = json_decode($request->getContent(), true);

        if (empty($data['type']) || empty($data['fromVal'])) {
            return $this->json(['message' => 'Некорректные данные'], 400);
        }

        $notifications = $repo->findBy(['type' => $data['type'], 'from_val' => $data['fromVal'], 'isReaded' => false]);

        foreach ($notifications as $notification) {
            $notification->setIsReaded(true);
            $repo->save($notification, true);
        }

        return $this->json(['message' => 'Все уведомления успешно помечены как прочитанные!']);
    }

}
