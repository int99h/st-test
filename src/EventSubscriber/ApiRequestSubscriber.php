<?php

namespace App\EventSubscriber;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Event\RequestEvent;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use Symfony\Component\Uid\UuidV4;

class ApiRequestSubscriber implements EventSubscriberInterface
{
    const ATTRIBUTE_USER_ID = 'userId';

    private TokenStorageInterface $tokenStorage;

    public function __construct(TokenStorageInterface $tokenStorage)
    {
        $this->tokenStorage = $tokenStorage;
    }

    public function onKernelRequest(RequestEvent $event)
    {
        if (!$event->getRequest()->getSession()->isStarted()) {
            $event->getRequest()->getSession()->start();
        }
        $token = $this->tokenStorage->getToken();
        if (!$token->hasAttribute(self::ATTRIBUTE_USER_ID)) {
            $token->setAttribute(
                self::ATTRIBUTE_USER_ID,
                $event->getRequest()->getSession()->getId()
            );
        }
        $token->getAttribute(self::ATTRIBUTE_USER_ID);
    }

    public static function getSubscribedEvents()
    {
        return [
            'kernel.request' => 'onKernelRequest',
        ];
    }
}
