<?php

namespace Application\Controller;

use Application\Repository\ExampleRepository;
use Interop\Container\ContainerInterface;
use Zend\ServiceManager\Factory\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class IndexControllerFactory implements FactoryInterface
{
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        $repository = $container->get(ExampleRepository::class);
        return new $requestedName($repository);
    }
}
