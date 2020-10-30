<?php

namespace App\Manager;

use App\DataStructure\Request\Api\LoginRequest;
use App\DataStructure\Request\Api\RegistrationRequest;
use App\Exception\UserAlreadyExistException;
use App\Security\User;
use App\Security\UserProvider;
use App\Service\UserService;
use Symfony\Component\Security\Core\Authentication\AuthenticationManagerInterface;
use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Core\Exception\BadCredentialsException;
use Symfony\Component\Security\Core\Exception\UsernameNotFoundException;

class UserManager
{
    private UserService $userService;
    private UserPasswordEncoderInterface $encoder;
    private AuthenticationManagerInterface $authentication;

    public function __construct(
        UserService $userService,
        UserPasswordEncoderInterface $encoder,
        AuthenticationManagerInterface $authenticationManager
    )
    {
        $this->userService = $userService;
        $this->encoder = $encoder;
        $this->authentication = $authenticationManager;
    }

    /**
     * @param string $userId
     * @param RegistrationRequest $request
     * @return User
     * @throws UserAlreadyExistException
     */
    public function register(string $userId, RegistrationRequest $request): User
    {
        // create user
        $user = (new User())
            ->setId($userId)
            ->setFirstname($request->firstname)
            ->setLastname($request->lastname)
            ->setNickname($request->nickname)
            ->setAge($request->age)
        ;
        if ($this->userService->isExist($user)) {
            throw new UserAlreadyExistException("User already exist.", 400);
        }
        // password
        $encodedPassword = $this->encoder->encodePassword($user, $request->password);
        $user->setPassword($encodedPassword);
        // save
        $this->userService->saveUser($user);

        return $user;
    }

    /**
     * @param LoginRequest $request
     * @return User
     */
    public function authenticate(LoginRequest $request): User
    {
        // load user file
        $user = $this->userService->getUser($request->nickname);
        if (!$user) {
            throw new UsernameNotFoundException();
        }
        if (!$this->encoder->isPasswordValid($user, $request->password)) {
            throw new BadCredentialsException();
        }
        // auth user
        $token = new UsernamePasswordToken(
            $request->nickname,
            $request->password,
            'app_user_provider',
        );
        $this->authentication->authenticate($token);
    }
}