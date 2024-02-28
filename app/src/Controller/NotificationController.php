<?php

namespace App\Controller;

use App\DBAL\Types\NotificationTypes;
use App\Entity\Notification;
use App\Repository\NotificationRepository;
use App\Service\EmailService;
use App\Service\PushService;
use App\Service\TgService;
use App\Service\SmsService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;


#[Route('/api/notification', name: 'app_notification')]
class NotificationController extends AbstractController
{
    #[Route('/send', name: 'add_notification',methods: "POST")]
    public function sendNotification(NotificationRepository $repo, Request $request, TgService $tgService, EmailService $emailService, SmsService $smsService, PushService $pushService):JsonResponse
    {
        date_default_timezone_set('Asia/Tomsk');
        $date = (new \DateTime());
        $data = json_decode($request->getContent(), true);
        $notification = new Notification();
        $notification->setContent($data['content']);
        $notification->setFromVal('asd');
        $notification->setMoment($date);
        $notification->setTitle($data['title']);
        $notification->setIsReaded(false);
        $notification->setTimeToSend($date);
        $notification->setToVal($data['to']);
        if($data['type'] == 'sms'){
            $notification->setType(NotificationTypes::SMS);
            $smsService->sendNotification($notification);
            $repo->save($notification, True);
        }
        if($data['type'] == 'email'){
            $notification->setType(NotificationTypes::EMAIL);
            $emailService->sendNotification($notification);
            $repo->save($notification, True);
        }
        if($data['type'] == 'tg'){
            $notification->setType(NotificationTypes::TG);
            $tgService->sendNotification($notification);
            $repo->save($notification, True);
        }
        if($data['type'] == 'push'){
            $notification->setType(NotificationTypes::PUSH);
            $pushService->sendNotification($notification);
            $repo->save($notification, True);
        }

        return $this->json([
            'data' => $notification,
            'message' => 'Уведомление успешно отправлено!',
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
    #[Route('/sorted', name: 'sorted_notifications', methods: 'GET')]
    public function sortNotifications(NotificationRepository $repo, Request $request): JsonResponse
    {

        $type = $request->query->get('type', null);

        if ($type === null) {
            return $this->json(['message' => 'Отсутствует параметр type.'], 400);
        }

        // Проверка на валидность типа для предотвращения SQL-инъекций
        $validTypes = ['sms', 'email', 'tg'];

        if (!in_array($type, $validTypes)) {
            return $this->json(['message' => 'Неверный тип уведомлений.'], 400);
        }

        $notifications = $repo->findByType($type);

        return $this->json([
            'data' => $notifications,
            'message' => "Уведомления типа '{$type}' успешно получены!",
        ]);
    }

}
