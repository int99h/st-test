<?php

namespace App\Service;

use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Serializer\SerializerInterface;
use App\Provider\Storage\File\UserStorage;
use App\Security\User;

class UserService
{
    private SerializerInterface $serializer;
    private UserPasswordEncoderInterface $encoder;
    private UserStorage $storage;

    public function __construct(
        SerializerInterface $serializer,
        UserPasswordEncoderInterface $encoder,
        UserStorage $storage
    )
    {
        $this->serializer = $serializer;
        $this->encoder = $encoder;
        $this->storage = $storage;
    }

    public function getUser(string $nickname): ?User
    {
        $path = $this->getStoragePath($nickname);
        if (!$this->storage->exists($path)) {
            return null;
        }
        $user = $this->serializer->deserialize(
            $this->storage->load($path),
            User::class,
            'json'
        );

        return $user;
    }

    /**
     * @param User $user
     * @return bool
     */
    public function isExist(User $user): bool
    {
        $path = $this->getStoragePath($user->getNickname() ?? $user->getId());

        return $this->storage->exists($path);
    }

    /**
     * @param User $user
     */
    public function saveUser(User $user): void
    {
        $json = $this->serializer->serialize($user, 'json');
        $this->storage->store($this->getStoragePath($user->getNickname()), $json);
    }

    /**
     * @param string $identity
     * @return string
     */
    private function getStoragePath(string $identity): string
    {
        $filename = "{$identity}.json";

        return "{$this->storage->getRootDir()}/{$filename}";
    }
}