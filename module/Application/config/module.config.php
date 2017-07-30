<?php
/**
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2016 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Application;

use Application\Controller\AbstractCrudController;
use Application\Controller\IndexController;
use Application\Controller\IndexControllerFactory;
use Application\Repository\ExampleRepository;
use Application\Repository\ExampleRepositoryFactory;
use Zend\Router\Http\Literal;
use Zend\Router\Http\Segment;
use Zend\ServiceManager\Factory\InvokableFactory;
use Zend\Stdlib\ArrayUtils;

return ArrayUtils::merge(
    AbstractCrudController::config(IndexController::class, 'application'),
    [
        'controllers' => [
            'factories' => [
                IndexController::class => IndexControllerFactory::class
            ],
        ],
        'service_manager' => [
            'factories' => [
                ExampleRepository::class => ExampleRepositoryFactory::class
            ],
        ],
        'view_manager' => [
            'strategies' => [
                'ViewJsonStrategy'
            ],
        ],
        'doctrine' => [
            'driver' => [
                // defines an annotation driver with two paths, and names it `my_annotation_driver`
                'my_annotation_driver' => [
                    'class' => \Doctrine\ORM\Mapping\Driver\AnnotationDriver::class,
                    'cache' => 'array',
                    'paths' => [
                        __DIR__ . '/../src/Entity'
                    ],
                ],

                // default metadata driver, aggregates all other drivers into a single one.
                // Override `orm_default` only if you know what you're doing
                'orm_default' => [
                    'drivers' => [
                        // register `my_annotation_driver` for any entity under namespace `My\Namespace`
                        'Application\Entity' => 'my_annotation_driver',
                    ],
                ],
            ],
            'configuration' => [
                'orm_default' => [
                    'types' => [
                        'uuid' => 'Infrastructure\DoctrineType\Uuid',
                    ],
                ],
            ],
        ],
    ]
);
