<?php

namespace Jeidison\Factory7to8;

/**
 * Class ConverterParam
 * @package Jeidison\Factory7to8
 *
 * @author  Jeidison Farias <jeidison.farias@gmail.com>
 */
class ConverterParam
{
    /**
     * path origin factories
     * @var string
     */
    private $pathFactoryOrigin;

    /**
     * path destination factories
     * @var string
     */
    private $pathFactoryDest;

    /**
     * Namespaces of models
     * @var array
     */
    private $defaultNamespaces = ['App\Models\\', 'App\\', 'App\Model\\'];

    public function __construct()
    {
        $this->pathFactoryDest = database_path('Factories');
        $this->pathFactoryOrigin = database_path('factories');
    }

    /**
     * @return string
     */
    public function getPathFactoryOrigin(): string
    {
        return $this->pathFactoryOrigin;
    }

    /**
     * @param string $pathFactoryOrigin
     * @return ConverterParam
     */
    public function setPathFactoryOrigin(string $pathFactoryOrigin): ConverterParam
    {
        $this->pathFactoryOrigin = $pathFactoryOrigin;
        return $this;
    }

    /**
     * @return string
     */
    public function getPathFactoryDest(): string
    {
        return $this->pathFactoryDest;
    }

    /**
     * @param string $pathFactoryDest
     * @return ConverterParam
     */
    public function setPathFactoryDest(string $pathFactoryDest): ConverterParam
    {
        $this->pathFactoryDest = $pathFactoryDest;
        return $this;
    }

    /**
     * @return array|string[]
     */
    public function getDefaultNamespaces(): array
    {
        return $this->defaultNamespaces;
    }

    /**
     * @param array|string[] $defaultNamespaces
     * @return ConverterParam
     */
    public function setDefaultNamespaces(array $defaultNamespaces): ConverterParam
    {
        $this->defaultNamespaces = $defaultNamespaces;
        return $this;
    }

}
