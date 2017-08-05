<?php

namespace Application\Controller;

use Interop\Container\ContainerInterface;
use Library\Repository\ExampleRepository;
use Zend\ServiceManager\Factory\FactoryInterface;

class IndexControllerFactory implements FactoryInterface
{
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        $repository = $container->get(ExampleRepository::class);
        return new $requestedName($repository);
    }
}
