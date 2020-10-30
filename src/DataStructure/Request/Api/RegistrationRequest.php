<?php

namespace App\DataStructure\Request\Api;

use App\DataStructure\Request\RequestDataInterface;
use Symfony\Component\Validator\Constraints as Assert;

final class RegistrationRequest implements RequestDataInterface
{
    /**
     * @Assert\NotNull(message="Firstname not defined")
     * @Assert\Length(min="3", max="255",
     *     minMessage="Firstname is too short.",
     *     maxMessage="Firstname is too long."
     * )
     * @var string
     */
    public $firstname;

    /**
     * @Assert\NotNull(message="Lastname not defined")
     * @Assert\Length(min="3", max="255",
     *     minMessage="Lastname is too short.",
     *     maxMessage="Lastname is too long."
     * )
     * @var string
     */
    public $lastname;

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
     * @Assert\NotNull(message="Age not defined")
     * @Assert\Type(type="int", message="Age must be a number")
     * @var int
     */
    public $age;

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