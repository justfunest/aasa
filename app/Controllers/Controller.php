<?php

namespace App\Controllers;

use Psr\Container\ContainerInterface;

/**
 * Class Controller
 * @package App\Controllers
 */
abstract class Controller
{

    protected $container;

    /**
     * Controller constructor.
     * @param ContainerInterface $container
     */
    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }
}