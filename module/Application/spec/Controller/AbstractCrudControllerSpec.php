<?php

namespace spec\Application\Controller;

use Application\Controller\AbstractCrudController;
use Infrastructure\Repository\RepositoryInterface;
use Library\Entity\EntityInterface;
use PhpSpec\ObjectBehavior;
use Zend\Mvc\Controller\AbstractRestfulController;
use Zend\Paginator\Paginator;
use Zend\Router\Http\Segment;
use Zend\View\Model\JsonModel;

class AbstractCrudControllerSpec extends ObjectBehavior
{
    private $repository;

    public function let(RepositoryInterface $repository)
    {
        $this->repository = $repository;
        $this->beAnInstanceOf(DummyCrudController::class);
        $this->beConstructedWith($repository);
    }

    public function it_is_initializable()
    {
        $this->shouldHaveType(AbstractCrudController::class);
    }

    public function it_should_extend_abstract_restful_controller()
    {
        $this->shouldBeAnInstanceOf(AbstractRestfulController::class);
    }

    public function it_can_generate_a_configuration()
    {
        $config = $this::config('Module\Controller\EntidadeController', 'entidade');
        $config->shouldBeArray();
        $config->shouldBeARouterConfiguration();
    }

    public function it_can_get_list_of_entities(Paginator $paginator)
    {
        $this->repository->generatePaginator()->willReturn($paginator);
        $paginator->getTotalItemCount()->willReturn(4);
        $paginator->setItemCountPerPage(25)->shouldBeCalled();
        $paginator->getItemsByPage(1)->willReturn([['id' => 1], ['id' => 2], ['id' => 3], ['id' => 4]]);

        $response = $this->getList();

        $response->shouldBeAnInstanceOf(JsonModel::class);
        $json = $response->serialize();

        $json->shouldContain('"total_items":4');
        $json->shouldContain('"page":1');
        $json->shouldContain('"page_size":25');
        $json->shouldContain('"items":[{"id":1},{"id":2},{"id":3},{"id":4}]');
    }

    public function it_can_get_a_specific_entity(EntityInterface $entity)
    {
        $this->repository->get(1)->willReturn($entity);
        $entity->toArray()->willReturn([
            'id' => 1,
            'nome' => 'Um Nome',
        ]);

        $response = $this->get(1);
        $json = $response->serialize();

        $json->shouldContain('"id":1');
        $json->shouldContain('"nome":"Um Nome"');
    }

    public function getMatchers()
    {
        return [
            'beARouterConfiguration' => function ($subject) {
                $type = $subject['router']['routes']['entidade']['type'] ?? null;
                $options = $subject['router']['routes']['entidade']['options'] ?? null;

                return $type === Segment::class &&
                       $options['route'] == '/entidade[/:id]' &&
                       $options['defaults']['controller'] == 'Module\Controller\EntidadeController';
            }
        ];
    }
}

// @codingStandardsIgnoreStart
class DummyCrudController extends AbstractCrudController
{
}
// @codingStandardsIgnoreEnd
