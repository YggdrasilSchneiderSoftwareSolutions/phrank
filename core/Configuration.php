<?php
namespace Phrank;

class Configuration {
    private string $basePath;
    private string $environment;

    // TODO Custom configuration options can be added here
    //private array $config = [];

    public function __construct() {
        $this->basePath = '';
        $this->environment = '';
    }

    public function setBasePath(string $path): self {
        $this->basePath = $path;
        return $this;
    }

    public function setEnvironment(string $env): self {
        $this->environment = $env;
        return $this;
    }

    public function getBasePath(): string {
        return $this->basePath;
    }

    public function getEnvironment(): string {
        return $this->environment;
    }
}