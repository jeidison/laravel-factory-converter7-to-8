<?php

namespace Jeidison\Factory7to8;

/**
 * Class UpdateParam
 * @package Jeidison\Factory7to8
 *
 * @author  Jeidison Farias <jeidison.farias@gmail.com>
 */
class UpdateParam
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
     * @return UpdateParam
     */
    public function setPathFactoryOrigin(string $pathFactoryOrigin): UpdateParam
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
     * @return UpdateParam
     */
    public function setPathFactoryDest(string $pathFactoryDest): UpdateParam
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
     * @return UpdateParam
     */
    public function setDefaultNamespaces(array $defaultNamespaces): UpdateParam
    {
        $this->defaultNamespaces = $defaultNamespaces;
        return $this;
    }

}
