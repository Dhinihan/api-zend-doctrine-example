<?php

namespace Application;

use Application\Controller\AbstractCrudController;
use Application\Controller\CustomerController;
use Doctrine\ORM\EntityManager;
use Infrastructure\Repository\CustomerRepository;
use Model\Factory\CustomerFactory;
use Zend\ServiceManager\AbstractFactory\ConfigAbstractFactory;
use Zend\Stdlib\ArrayUtils;

return ArrayUtils::merge(
    AbstractCrudController::config(CustomerController::class, 'customer'),
    [
        ConfigAbstractFactory::class => [
            CustomerController::class => [
                CustomerRepository::class,
                CustomerFactory::class,
            ],
            CustomerRepository::class => [
                EntityManager::class
            ],
            CustomerFactory::class => []
        ]
    ]
);
