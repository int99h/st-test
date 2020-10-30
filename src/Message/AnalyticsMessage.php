<?php

namespace App\Message;

use App\DataStructure\Analytics\AnalyticsEventInterface;

final class AnalyticsMessage
{
    private AnalyticsEventInterface $event;

    public function __construct(AnalyticsEventInterface $event)
    {
        $this->event = $event;
    }

    public function getEvent(): AnalyticsEventInterface
    {
        return $this->event;
    }
}
