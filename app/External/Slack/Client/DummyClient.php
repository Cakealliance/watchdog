<?php

declare(strict_types=1);

namespace App\External\Slack\Client;

class DummyClient extends Client
{
    public function sendMessage(string $message): void
    {
        dump([
            'type' => 'Webhook message',
            'message' => $message,
        ]);
    }

    public function sendMessageToChannel(string $channel, string $message): void
    {
        dump([
            'type' => 'Post to channel',
            'channel' => $channel,
            'message' => $message,
        ]);
    }
}
