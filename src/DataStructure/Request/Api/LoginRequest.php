<?php

namespace App\DataStructure\Request\Api;

use App\DataStructure\Request\RequestDataInterface;
use Symfony\Component\Validator\Constraints as Assert;

final class LoginRequest implements RequestDataInterface
{
    /**
     * @Assert\NotNull(message="Nickname not defined")
     * @Assert\Type(type="alnum", message="Only alphanumeric characters allowed")
     * @Assert\Length(min="3", max="255",
     *     minMessage="Nickname is too short.",
     *     maxMessage="Nickname is too long."
     * )
     * @var string
     */
    public $nickname;

    /**
     * @Assert\NotNull(message="Password not defined")
     * @Assert\Length(min="8", max="255",
     *     minMessage="Password is too short.",
     *     maxMessage="Password is too long."
     * )
     * @var string
     */
    public $password;
}