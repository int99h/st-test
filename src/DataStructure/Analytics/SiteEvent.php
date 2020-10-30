<?php

namespace App\DataStructure\Analytics;

class SiteEvent extends AbstractAnalyticsEvent
{
    private string $userId;
    private string $source;
    private \DateTimeInterface $date;

    public function __construct(string $userId, string $source, \DateTimeInterface $date = null)
    {
        $this->userId = $userId;
        $this->source = $source;
        $this->date = $date ?? new \DateTimeImmutable();
    }

    /**
     * @return string
     */
    public function getUserId(): string
    {
        return $this->userId;
    }

    /**
     * @return string
     */
    public function getSource(): string
    {
        return $this->source;
    }

    /**
     * @return \DateTimeInterface
     */
    public function getDate(): \DateTimeInterface
    {
        return $this->date;
    }

    /**
     * @return array
     */
    public function toArray(): array
    {
        return [
            "id_user" => $this->getUserId(),
            "source_label" => $this->getSource(),
            "date_created" => $this->getDate()->format(self::DATE_FORMAT),
        ];
    }
}