<?php

namespace App\MessageHandler;

use App\Message\AnalyticsMessage;
use App\Service\AnalyticsService;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;

final class AnalyticsMessageHandler implements MessageHandlerInterface
{
    private AnalyticsService $analytics;

    public function __construct(AnalyticsService $analytics)
    {
        $this->analytics = $analytics;
    }

    public function __invoke(AnalyticsMessage $message)
    {
        try {
            $this->analytics->saveEvent($message->getEvent());
        } catch (\Exception $exception) {
            // log error
        }
    }
}
