<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Notifier\ChatterInterface;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Notifier\Bridge\Telegram\TelegramOptions;
use Symfony\Component\Notifier\Message\ChatMessage;
use WeStacks\TeleBot\Objects\Update;
use WeStacks\TeleBot\TeleBot;
use App\Telegram\TelegramHandler;


class TelegramNotifierController extends AbstractController
{
    private $chatter;

    public function __construct(ChatterInterface $chatter)
    {
        $this->chatter = $chatter;
    }

    #[Route('/telegram/notifier', name: 'app_telegram_notifier')]
    public function index(): JsonResponse
    {
        $messageText = '<b>Сегодня в Томске холодно. Одевайтесь теплее.</b>';

        $chatIds = ['543463540', '979327862', '894761531','527791785','605031557','845213915'];

        foreach ($chatIds as $chatId) {
            $chatMessage = new ChatMessage($messageText);
            $telegramOptions = (new TelegramOptions())
                ->chatId($chatId)
                ->parseMode('HTML')
                ->disableWebPagePreview(true)
                ->disableNotification(false);
            $chatMessage->options($telegramOptions);
            $this->chatter->send($chatMessage);
        }

        return $this->json([
            'message' => 'Notification sent successfully!',
        ]);
    }
}
