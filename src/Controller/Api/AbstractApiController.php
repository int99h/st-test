<?php

namespace App\Controller\Api;

use App\Security\User;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

abstract class AbstractApiController extends AbstractController
{
    const ATTRIBUTE_USER_ID = 'userId';

    private TokenStorageInterface $tokenStorage;

    public function __construct(TokenStorageInterface $tokenStorage)
    {
        $this->tokenStorage = $tokenStorage;
    }

    protected function getUserId(): string
    {
        /** @var User $user */
        $user = $this->getUser();
        if ($user === null) {
            $token = $this->tokenStorage->getToken();
            $userId = $token->getAttribute(self::ATTRIBUTE_USER_ID);
        } else {
            $userId = $user->getId();
        }

        return $userId;
    }
}