<?php

namespace App\Service;

use App\DataStructure\Analytics\AnalyticsEventInterface;
use App\Provider\Storage\File\AnalyticsStorage;
use App\Security\User;
use SocialTech\StorageInterface;
use Symfony\Component\Serializer\SerializerInterface;

class AnalyticsService
{
    private SerializerInterface $serializer;
    private StorageInterface $storage;

    /**
     * AnalyticsService constructor.
     * @param SerializerInterface $serializer
     * @param AnalyticsStorage $storage
     */
    public function __construct(SerializerInterface $serializer, AnalyticsStorage $storage)
    {
        $this->serializer = $serializer;
        $this->storage = $storage;
    }

    /**
     * @param AnalyticsEventInterface $event
     */
    public function saveEvent(AnalyticsEventInterface $event): void
    {
        $eventContent = $this->serializer->serialize($event->toArray(), 'json');
        $path = $this->getPathByEventContent($eventContent);
        if (!$this->storage->exists($path)) {
            $this->storage->store($path, $eventContent);
        }
    }

    /**
     * @param string $content
     * @return string
     * @todo update if we want to store data by date
     */
    private function getPathByEventContent(string $content): string
    {
        $filename = md5($content) . '.json';

        return "{$this->storage->getRootDir()}/{$filename}";
    }

    public function mergeUserEvents(User $user): void
    {
        // TDB
    }
}