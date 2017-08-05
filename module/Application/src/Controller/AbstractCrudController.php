<?php

namespace Application\Controller;

use Infrastructure\Repository\RepositoryInterface;
use Library\Factory\EntityFactoryInterface;
use Zend\Mvc\Controller\AbstractRestfulController;
use Zend\Router\Http\Segment;
use Zend\View\Model\JsonModel;

abstract class AbstractCrudController extends AbstractRestfulController
{
    private $repository;
    private $factory;

    public function __construct(RepositoryInterface $repository, EntityFactoryInterface $factory)
    {
        $this->repository = $repository;
        $this->factory = $factory;
    }

    public static function config($controllerClass, $entidadeName)
    {
        return [
            'router' => [
                'routes' => [
                    "$entidadeName" => [
                        'type'    => Segment::class,
                        'options' => [
                            'route'    => "/$entidadeName" . '[/:id]',
                            'defaults' => [
                                'controller' => $controllerClass
                            ],
                        ],
                    ],
                ],
            ],
        ];
    }

    public function getList()
    {
        $items = [];
        $paginator = $this->repository->generatePaginator();
        $items['total_items'] = $paginator->getTotalItemCount();
        $items['page'] = $this->params()->fromQuery('page', 1);
        $items['page_size'] = $this->params()->fromQuery('limit', 25);

        $paginator->setItemCountPerPage($items['page_size']);
        $items['items'] = (array) $paginator->getItemsByPage($items['page']);

        return new JsonModel($items);
    }

    public function get($id)
    {
        $entity = $this->repository->get($id);
        $data = $entity->toArray();
        return new JsonModel($data);
    }

    public function create($input)
    {
        $entity = $this->factory->createFromInput($input);

        $this->repository->save($entity);

        $response = $this->getResponse();
        $response->setStatusCode(201);

        $data = $entity->toArray();
        return new JsonModel($data);
    }
}
