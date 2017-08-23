<?php

namespace spec\Application\Controller;

use Application\Controller\CustomerAddAddressController;
use Infrastructure\Repository\CustomerRepository;
use Model\Entity\Customer;
use Model\Value\Address;
use Model\Value\Factory\AddressFactory;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Zend\Mvc\Controller\Plugin\Params;
use Zend\Mvc\Controller\PluginManager;
use Zend\View\Model\JsonModel;

class CustomerAddAddressControllerSpec extends ObjectBehavior
{
    private $params;
    private $request;

    public function let(
        CustomerRepository $repository,
        Customer $customer,
        AddressFactory $factory,
        Address $address,
        PluginManager $plugins,
        Params $params
    ) {
        $this->params = $params;
        $this->params->__invoke()->willReturn($this->params);

        $factory->createFromInput(Argument::any())->willReturn($address);
        $repository->get(Argument::any())->willReturn($customer);
        $repository->save(Argument::any())->willReturn(null);
        $customer->receiveAddress(Argument::any())->willReturn(null);
        $customer->toArray()->willReturn(['cep' => '12345678']);

        $plugins->setController(Argument::any())->willReturn(null);
        $plugins->get('params', null)->willReturn($params);

        $this->beConstructedWith($repository, $factory);
        $this->setPluginManager($plugins);
    }

    public function it_is_initializable()
    {
        $this->shouldHaveType(CustomerAddAddressController::class);
    }

    public function it_can_add_address_to_a_customer()
    {
        $request = $this->getRequest();
        $request->setContent('{}');
        $this->params->fromRoute('id')->willReturn(null);

        $jsonModel = $this->addAddressAction();
        $jsonModel->shouldBeAnInstanceOf(JsonModel::class);
        $json = $jsonModel->serialize();
        $json->shouldContain('"cep":"12345678"');
    }
}
