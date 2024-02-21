<?php

namespace App\Command;

use App\Telegram\TelegramHandler;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use WeStacks\TeleBot\Objects\Update;
use WeStacks\TeleBot\TeleBot;
#[AsCommand(
    name: 'tg:start',
    description: 'Start tg bot.',
    hidden: false,
    aliases: ['tg:start']
)]
class TgbotCommand extends Command
{

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $output->writeln('Tg bot is working...');

        $handler = function(TeleBot $bot, Update $update, $next) {
            if ($update->message->text !== '/notify') {
                return $bot->sendMessage([
                    'chat_id' => $update->chat()->id,
                    'text' => 'Я просто бот для уведомлений, я вас не понимаю('
                ]);
            }

            return $next();
        };

        $bot = new TeleBot([
            'token' => '7036475639:AAFyl1_cvNTjTMGRSVZDx6AFy_bcCiZrir8',
            'handlers' => [
                $handler,
                TelegramHandler::class,
            ]
        ]);

        $last_offset = 0;
        while (true) {
            $updates = $bot->getUpdates([
                'offset' => $last_offset + 1
            ]);
            foreach ($updates as $update) {
                $bot->handleUpdate($update);
                $last_offset = $update->update_id;
                $id = $update->chat()->id;
                $name = $update->chat()->first_name;

                // Проверяем, есть ли запись с таким ID в файле
                $filePath = __DIR__ . '/Telegram_id.txt';
                $existingData = file_get_contents($filePath);

                if (!str_contains($existingData, "$id $name")) {
                    // Записываем только если записи с таким ID нет
                    $data = "$id $name\n";
                    file_put_contents($filePath, $data, FILE_APPEND);
                }
            }
        }

        return Command::SUCCESS;
    }
}
