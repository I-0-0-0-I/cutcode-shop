<?php

declare(strict_types=1);

namespace App\Logging\Telegram;

use App\Services\Telegram\TelegramBotApi;
use App\Services\Telegram\TelegramBotApiException;
use Monolog\Handler\AbstractProcessingHandler;
use Monolog\Logger;

final class TelegramLoggerHandler extends AbstractProcessingHandler
{
    private array $config;

    public function __construct(array $config)
    {
        $level = Logger::toMonologLevel($config['level']);
        parent::__construct($level);
        $this->config = $config;
    }

    /**
     * @param array $record
     * @return void
     * @throws TelegramBotApiException
     */
    protected function write(array $record): void
    {
        TelegramBotApi::sendMessage($this->config['token'], $this->config['chat_id'], $record['formatted']);
    }
}
