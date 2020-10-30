<?php

namespace App\EventSubscriber;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Event\ExceptionEvent;

class ApiExceptionSubscriber implements EventSubscriberInterface
{
    public function onKernelException(ExceptionEvent $event)
    {
        $exception = $event->getThrowable();
        $error = [
            'code' => $exception->getCode(),
            'message' => $exception->getMessage(),
        ];
        if (getenv('APP_ENV') === 'dev') {
            $error['trace'] = $exception->getTraceAsString();
        }
        $event->setResponse(new JsonResponse(['success' => false, 'error' => $error]));
        $event->stopPropagation();
    }

    public static function getSubscribedEvents()
    {
        return [
            'kernel.exception' => 'onKernelException',
        ];
    }
}
