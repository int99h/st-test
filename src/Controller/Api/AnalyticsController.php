<?php

namespace App\Controller\Api;

use App\DataStructure\Analytics\SiteEvent;
use App\DataStructure\Request\Api\CreateEventRequest;
use App\Message\AnalyticsMessage;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AnalyticsController extends AbstractApiController
{
    /**
     * @Route("/api/analytics/event", methods={"POST"})
     */
    public function createEvent(CreateEventRequest $request): Response
    {
        $event = new SiteEvent(
            $this->getUserId(),
            $request->source,
            $request->date
        );
        $this->dispatchMessage(new AnalyticsMessage($event));

        return $this->json([]);
    }
}
