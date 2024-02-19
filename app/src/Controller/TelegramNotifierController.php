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
        $chatMessage = new ChatMessage('Я не бот, я человек. Помоги, спаси меня');

// Создаем параметры для Telegram
        $telegramOptions = (new TelegramOptions())
            ->chatId('894761531')
            ->parseMode('MarkdownV2')
            ->disableWebPagePreview(true)
            ->disableNotification(true);

// Добавляем пользовательские параметры к чат-сообщению и отправляем сообщение
        $chatMessage->options($telegramOptions);

        $this->chatter->send($chatMessage);
        return $this->json([
            'message' => 'Welcome to your new controller!',
            'path' => 'src/Controller/TelegramNotifierController.php',
        ]);
    }
}
