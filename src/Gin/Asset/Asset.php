<?php

namespace Tonik\Gin\Asset;

use Tonik\Gin\Contract\ConfigInterface;
use Tonik\Gin\Foundation\Exception\FileNotFoundException;

class Asset
{
    /**
     * Theme config instance.
     *
     * @var ConfigInterface
     */
    protected $config;

    /**
     * Asset file.
     *
     * @var string
     */
    protected $file;

    /**
     * Construct asset.
     *
     * @param ConfigInterface $config
     */
    public function __construct(ConfigInterface $config)
    {
        $this->config = $config;
    }

    /**
     * Get asset file URI.
     *
     * @return string
     * @throws \Tonik\Gin\Foundation\Exception\FileNotFoundException
     */
    public function getUri(): string
    {
        if ($this->fileExists($file = $this->getPublicPath())) {
            return $this->getPublicUri();
        }

        throw new FileNotFoundException("Asset file [$file] cannot be located.");
    }

    /**
     * Get asset file path.
     *
     * @return string
     * @throws \Tonik\Gin\Foundation\Exception\FileNotFoundException
     */
    public function getPath(): string
    {
        if ($this->fileExists($file = $this->getPublicPath())) {
            return $file;
        }

        throw new FileNotFoundException("Asset file [$file] cannot be located.");
    }

    /**
     * Gets asset uri path.
     *
     * @return string
     */
    public function getPublicUri(): string
    {
        $uri = $this->config['paths']['uri'];

        return $uri . '/' . $this->getRelativePath();
    }

    /**
     * Gets asset directory path.
     *
     * @return string
     */
    public function getPublicPath(): string
    {
        $directory = $this->config['paths']['directory'];

        return $directory . '/' . $this->getRelativePath();
    }

    /**
     * Gets asset relative path.
     *
     * @return string
     */
    public function getRelativePath(): string
    {
        $public = $this->config['directories']['public'];

        return $public . '/' . $this->file;
    }

    /**
     * Checks if asset file exsist.
     *
     * @param  string $file
     *
     * @return boolean
     */
    public function fileExists($file): bool
    {
        return file_exists($file);
    }

    /**
     * Gets the Asset file.
     *
     * @return string
     */
    public function getFile(): string
    {
        return $this->file;
    }

    /**
     * Sets the Asset file.
     *
     * @param string $file the file
     *
     * @return self
     */
    public function setFile($file): self
    {
        $this->file = $file;

        return $this;
    }
}
