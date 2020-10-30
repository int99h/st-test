<?php

namespace App\DataStructure\Analytics;

interface AnalyticsEventInterface
{
    /**
     * @return array
     */
    public function toArray(): array;
}