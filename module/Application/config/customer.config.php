<?php

namespace Application;

use Application\Controller\AbstractCrudController;
use Application\Controller\CustomerAddAddressController;
use Application\Controller\CustomerController;
use Doctrine\ORM\EntityManager;
use Infrastructure\Repository\CustomerRepository;
use Model\Factory\CustomerFactory;
use Model\Value\Factory\AddressFactory;
use Zend\Router\Http\Segment;
use Zend\ServiceManager\AbstractFactory\ConfigAbstractFactory;
use Zend\Stdlib\ArrayUtils;

return ArrayUtils::merge(
    AbstractCrudController::config(CustomerController::class, 'customer'),
    [
        'router' => [
            'routes' => [
                "customer-address" => [
                    'type' => Segment::class,
                    'options' => [
                        'route' => '/customer/:id/add-address',
                        'defaults' => [
                            'action' => 'add-address',
                            'controller' => CustomerAddAddressController::class
                        ],
                    ],
                ],
            ],
        ],
        ConfigAbstractFactory::class => [
            CustomerController::class => [
                CustomerRepository::class,
                CustomerFactory::class,
            ],
            CustomerAddAddressController::class => [
                CustomerRepository::class,
                AddressFactory::class,
            ],
            CustomerRepository::class => [
                EntityManager::class
            ],
            CustomerFactory::class => [],
            AddressFactory::class => [],
        ]
    ]
);
