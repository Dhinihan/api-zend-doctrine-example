<?php

namespace spec\Infrastructure\Rest;

use Infrastructure\Rest\JsonError;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Zend\EventManager\EventManagerInterface;
use Zend\Http\Request;
use Zend\Http\Response;
use Zend\Mvc\Application;
use Zend\Mvc\MvcEvent;
use Zend\View\Model\JsonModel;

class JsonErrorSpec extends ObjectBehavior
{
    public function it_is_initializable()
    {
        $this->shouldHaveType(JsonError::class);
    }

    public function it_serializes_exceptions()
    {
        $exception = new \Exception('It is an error', 400);
        $response = $this->serializeToJson($exception);
        $response->shouldBeAnInstanceOf(JsonModel::class);
        $json = $response->serialize();
        $json->shouldContain('"message":"It is an error"');
        $json->shouldContain('"status":400');
    }

    public function it_uses_code_default_when_none_is_informed()
    {
        $exception = new \Exception('It is an error');
        $response = $this->serializeToJson($exception, 123);
        $response->shouldBeAnInstanceOf(JsonModel::class);
        $json = $response->serialize();
        $json->shouldContain('"message":"It is an error"');
        $json->shouldContain('"status":123');
    }

    public function it_uses_code_default_when_the_code_is_less_than_400()
    {
        $exception = new \Exception('It is an error', 399);
        $response = $this->serializeToJson($exception, 321);
        $response->shouldBeAnInstanceOf(JsonModel::class);
        $json = $response->serialize();
        $json->shouldContain('"message":"It is an error"');
        $json->shouldContain('"status":321');
    }

    public function it_uses_code_default_when_the_code_is_more_than_599()
    {
        $exception = new \Exception('It is an error', 600);
        $response = $this->serializeToJson($exception, 222);
        $response->shouldBeAnInstanceOf(JsonModel::class);
        $json = $response->serialize();
        $json->shouldContain('"message":"It is an error"');
        $json->shouldContain('"status":222');
    }

    public function it_is_attachable_to_an_event(EventManagerInterface $manager)
    {
        $manager->attach(MvcEvent::EVENT_DISPATCH_ERROR, [$this, 'handleError'], 1)->shouldBeCalled();
        $manager->attach(MvcEvent::EVENT_RENDER_ERROR, [$this, 'handleError'], 1)->shouldBeCalled();
        $this->attach($manager, 1);
    }

    public function it_can_handle_an_error(MvcEvent $event, Request $request, Response $response, Application $app)
    {
        $result = new \StdClass();
        $event->getParam('exception')->willReturn(new \Exception('It is an error', 400));

        $event->getParam('application')->willReturn($app);
        $app->getRequest()->willReturn($request);
        $event->getResponse()->willReturn($response);
        $event->getResult()->willReturn($result);
        $response->getStatusCode()->willReturn(200);

        $response->setStatusCode(400)->shouldBeCalled();
        $event->setResult(Argument::type(JsonModel::class))->shouldBeCalled();
        $event->setViewModel(Argument::type(JsonModel::class))->shouldBeCalled();

        $this->handleError($event);
    }
}
