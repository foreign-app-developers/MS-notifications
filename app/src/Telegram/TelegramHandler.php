<?php

namespace App\Telegram;

use WeStacks\TeleBot\Handlers\CommandHandler;
use WeStacks\TeleBot\Handlers\UpdateHandler;
use WeStacks\TeleBot\Objects\Update;
use WeStacks\TeleBot\TeleBot;

class TelegramHandler extends CommandHandler
{
    protected static $aliases = [ '/notify' ];
    protected static $description = 'подписаться на уведомления';

    public function handle()
    {
        return $this->sendMessage([
            'text' => 'Успешно!'
        ]);
    }
}
