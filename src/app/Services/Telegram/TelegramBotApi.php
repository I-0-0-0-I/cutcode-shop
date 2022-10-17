<?php

declare(strict_types=1);

namespace App\Services\Telegram;

use Exception;
use Illuminate\Support\Facades\Http;
use Symfony\Component\HttpFoundation\Response;

final class TelegramBotApi
{
    private const HOST = 'https://api.telegram.org/bot';

    /**
     * @throws TelegramBotApiException
     */
    public static function sendMessage(string $token, int $chatId, string $message): bool
    {
        try {
            $response = Http::get(self::HOST . $token . '/sendMessage', [
                'chat_id' => $chatId,
                'text' => $message
            ]);
            if ($response->status() !== Response::HTTP_OK) {
                throw new Exception($response->reason());
            }
            return true;
        } catch (Exception $e) {
            throw new TelegramBotApiException($e->getMessage());
        }
    }
}
