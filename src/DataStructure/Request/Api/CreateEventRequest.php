<?php

namespace App\DataStructure\Request\Api;

use App\DataStructure\Request\RequestDataInterface;
use Symfony\Component\Validator\Constraints as Assert;

final class CreateEventRequest implements RequestDataInterface
{
    /**
     * @Assert\NotNull(message="Source not defined")
     * @Assert\Type(type="string", message="Source should be a string")
     * @var string
     */
    public $source;

    /**
     * @Assert\DateTime()
     * @var null|\DateTime
     */
    public $date;
}