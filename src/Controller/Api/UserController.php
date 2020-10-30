<?php

namespace App\Controller\Api;

use App\DataStructure\Request\Api\LoginRequest;
use App\DataStructure\Request\Api\RegistrationRequest;
use App\Manager\UserManager;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class UserController extends AbstractApiController
{
    /**
     * @Route("/api/user/registration", methods={"POST"})
     */
    public function registration(RegistrationRequest $request, UserManager $userManager): Response
    {
        $userManager->register($this->getUserId(), $request);

        return $this->json([], Response::HTTP_CREATED);
    }

    /**
     * @Route("/api/user/login", methods={"POST"})
     */
    public function login(LoginRequest $request, UserManager $userManager): Response
    {
        $userManager->authenticate($request);
        return $this->json([
            'nickname' => $request->nickname,
            'password' => $request->password,
        ]);
    }
}
