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
use Infrastructure\Rest\JsonError;
use Library\Factory\ExampleFactory;
use Library\Repository\ExampleRepository;
use Library\Repository\ExampleRepositoryFactory;
use Ramsey\Uuid\Doctrine\UuidType;
use Zend\ServiceManager\Factory\InvokableFactory;
use Zend\Stdlib\ArrayUtils;

return ArrayUtils::merge(
    AbstractCrudController::config(IndexController::class, 'application'),
    [
        'api-problem' => [
            'render_error_controllers' => IndexController::class
        ],
        'controllers' => [
            'factories' => [
                IndexController::class => IndexControllerFactory::class
            ],
        ],
        'listeners' => [
            JsonError::class
        ],
        'service_manager' => [
            'factories' => [
                ExampleRepository::class => ExampleRepositoryFactory::class,
                ExampleFactory::class => InvokableFactory::class,
                JsonError::class => InvokableFactory::class
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
                        __DIR__ . '/../src/Entity'
                    ],
                ],

                // default metadata driver, aggregates all other drivers into a single one.
                // Override `orm_default` only if you know what you're doing
                'orm_default' => [
                    'drivers' => [
                        // register `my_annotation_driver` for any entity under namespace `My\Namespace`
                        'Library\Entity' => 'my_annotation_driver',
                    ],
                ],
            ],
            'configuration' => [
                'orm_default' => [
                    'types' => [
                        'uuid' => UuidType::class,
                    ],
                ],
            ],
        ],
    ]
);
