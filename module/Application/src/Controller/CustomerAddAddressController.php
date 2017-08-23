<?php

namespace Application\Controller;

use Infrastructure\Repository\CustomerRepository;
use Model\Value\Factory\AddressFactory;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\JsonModel;

class CustomerAddAddressController extends AbstractActionController
{
    private $customerRespository;
    private $addressFactory;

    public function __construct(CustomerRepository $customerRespository, AddressFactory $addressFactory)
    {
        $this->customerRespository = $customerRespository;
        $this->addressFactory = $addressFactory;
    }

    public function addAddressAction()
    {
        $params = $this->getJsonParams();
        $id = $this->params()->fromRoute('id');
        $address = $this->addressFactory->createFromInput($params);
        $customer = $this->customerRespository->get($id);
        $customer->receiveAddress($address);
        $this->customerRespository->save($customer);
        return new JsonModel($customer->toArray());
    }

    protected function getJsonParams()
    {
        $request = $this->getRequest();
        $content = $request->getContent();
        return json_decode($content, true);
    }
}
