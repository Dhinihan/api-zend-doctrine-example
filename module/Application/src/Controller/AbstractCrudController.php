<?php

namespace Application\Controller;

use Infrastructure\Repository\RepositoryInterface;
use Zend\Mvc\Controller\AbstractRestfulController;
use Zend\Router\Http\Segment;
use Zend\View\Model\JsonModel;

abstract class AbstractCrudController extends AbstractRestfulController
{
    private $repository;

    public function __construct(RepositoryInterface $repository)
    {
        $this->repository = $repository;
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
        try {
            $items = [];
            $paginator = $this->repository->generatePaginator();
            $items['total_items'] = $paginator->getTotalItemCount();
            $items['page'] = $this->params()->fromQuery('page', 1);
            $items['page_size'] = $this->params()->fromQuery('limit', 25);

            $paginator->setItemCountPerPage($items['page_size']);
            $items['items'] = (array) $paginator->getItemsByPage($items['page']);
        } catch (\Exception $e) {
            die(var_dump($e->getMessage()));
        }

        return new JsonModel($items);
    }
}
