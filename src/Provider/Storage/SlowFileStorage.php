<?php

namespace App\Provider\Storage;

use SocialTech\SlowStorage;

class SlowFileStorage extends SlowStorage
{
    private string $rootDir;

    public function __construct(string $rootDir)
    {
        if (!is_dir($rootDir) || !is_writable($rootDir)) {
            throw new \InvalidArgumentException("Directory not exist or not writable.");
        }
        $this->rootDir = $rootDir;
    }

    /**
     * @return string
     */
    public function getRootDir(): string
    {
        return $this->rootDir;
    }

    /**
     * @inheritDoc
     */
    public function store(string $path, string $content): void
    {
        parent::store($this->getPath($path), $content);
    }

    /**
     * @inheritDoc
     */
    public function exists(string $path): bool
    {
        return parent::exists($this->getPath($path));
    }

    /**
     * @inheritDoc
     */
    public function append(string $path, string $content): void
    {
        parent::append($this->getPath($path), $content);
    }

    /**
     * @inheritDoc
     */
    public function load(string $path): string
    {
        return parent::load($this->getPath($path));
    }

    /**
     * @param string $path
     * @return string
     */
    private function getPath(string $path): string
    {
        return str_replace('//', '/', "{$this->rootDir}/{$path}");
    }
}