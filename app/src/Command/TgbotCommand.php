<?php

namespace App\Command;

use App\Telegram\TelegramHandler;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
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

        $bot = new TeleBot([
            'token' => '7036475639:AAFyl1_cvNTjTMGRSVZDx6AFy_bcCiZrir8',
            'handlers' => [
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

                $data = "$id $name\n";
                $filePath = __DIR__. '/Telegram_id.txt';
                file_put_contents($filePath, $data, FILE_APPEND);
            }
        }

        return Command::SUCCESS;
    }
}
