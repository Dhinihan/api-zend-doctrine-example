<?php
/**
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2016 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Application;

use Application\Controller\AbstractCrudController;
use Application\Controller\IndexController;
use Infrastructure\DoctrineType\CPFType;
use Infrastructure\Rest\JsonError;
use Ramsey\Uuid\Doctrine\UuidType;
use Zend\ServiceManager\AbstractFactory\ConfigAbstractFactory;
use Zend\Stdlib\ArrayUtils;

return ArrayUtils::merge(
    AbstractCrudController::config(IndexController::class, 'application'),
    [
        ConfigAbstractFactory::class => [
            IndexController::class => [
                'Library\Repository\ExampleRepository',
                'Library\Factory\ExampleFactory',
            ],
            'Library\Repository\ExampleRepository' => [
                'Doctrine\ORM\EntityManager'
            ],
            'Library\Factory\ExampleFactory' => [],
            JsonError::class => [],
        ],
        'api-problem' => [
            'render_error_controllers' => IndexController::class
        ],
        'controllers' => [
            'abstract_factories' => [
                ConfigAbstractFactory::class
            ],
        ],
        'listeners' => [
            JsonError::class
        ],
        'service_manager' => [
            'abstract_factories' => [
                ConfigAbstractFactory::class
            ],
            'factories' => [
            ],
        ],
        'view_manager' => [
            'template_path_stack' => [
                'application' => __DIR__ . '/../view',
            ],
            'template_map' => [
                'application/index/index' => __DIR__ . '/../view/application/index/index.phtml',
                'site/layout'             => __DIR__ . '/../view/layout/layout.phtml',
                'error'                   => __DIR__ . '/../view/error/index.phtml',
                'error/404'               => __DIR__ . '/../view/error/404.phtml',
            ],
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
                        __DIR__ . '/../../Library/src/Entity',
                        __DIR__ . '/../../Model/src/Entity'
                    ],
                ],

                // default metadata driver, aggregates all other drivers into a single one.
                // Override `orm_default` only if you know what you're doing
                'orm_default' => [
                    'drivers' => [
                        // register `my_annotation_driver` for any entity under namespace `My\Namespace`
                        'Library\Entity' => 'my_annotation_driver',
                        'Model\Entity' => 'my_annotation_driver',
                    ],
                ],
            ],
            'configuration' => [
                'orm_default' => [
                    'types' => [
                        'uuid' => UuidType::class,
                        'cpf' => CPFType::class,
                    ],
                ],
            ],
        ],
    ]
);
