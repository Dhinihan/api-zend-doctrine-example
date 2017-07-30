<?php

namespace Application\Repository;

use Interop\Container\ContainerInterface;
use Zend\ServiceManager\Factory\FactoryInterface;

class ExampleRepositoryFactory implements FactoryInterface
{
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        $em = $container->get('Doctrine\ORM\EntityManager');
        return new ExampleRepository($em);
    }
}
