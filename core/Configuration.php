<?php
namespace Phrank;

/**
 * Configuration class for managing application settings
 * Following settings are part of the framework's core configuration:
 * - basePath: The base path of the application
 * - environment: The current environment (e.g., development, production)
 * - debugMode: A boolean indicating if debug mode is enabled
 * Custom configuration options can be added using the set() method.
 */
class Configuration {
    private string $basePath;
    private string $environment;
    private bool $debugMode;

    // Custom configuration options can be added here
    private array $settings = [];

    public function __construct() {
        $this->basePath = '';
        $this->environment = '';
        $this->debugMode = false;
        $this->settings['basePath'] = $this->basePath;
        $this->settings['environment'] = $this->environment;
        $this->settings['debugMode'] = $this->debugMode;
    }

    public function set(string $key, $value): self {
        $this->settings[$key] = $value;
        return $this;
    }

    public function get(string $key) {
        return $this->settings[$key] ?? null;
    }

    public function getAll(): array {
        return $this->settings;
    }

    public function setBasePath(string $path): self {
        $this->basePath = $path;
        $this->settings['basePath'] = $this->basePath;
        return $this;
    }

    public function setEnvironment(string $env): self {
        $this->environment = $env;
        $this->settings['environment'] = $this->environment;
        return $this;
    }

    public function getBasePath(): string {
        return $this->basePath;
    }

    public function getEnvironment(): string {
        return $this->environment;
    }

    public function setDebugMode(bool $debug): self {
        $this->debugMode = $debug;
        $this->settings['debugMode'] = $this->debugMode;
        return $this;
    }

    public function isDebugMode(): bool {
        return $this->debugMode;
    }
}