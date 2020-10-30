<?php

namespace App\DataStructure\Analytics;

use App\Security\User;

abstract class AbstractAnalyticsEvent implements AnalyticsEventInterface
{
    const DATE_FORMAT = "Y-m-d H:i:s";
}