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
        $json = $this->serializeToJson($exception);
        $json->shouldBeArray();
        $json->shouldHaveKeyWithValue("message", "It is an error");
        $json->shouldHaveKeyWithValue("status", 400);
    }

    public function it_uses_code_default_when_none_is_informed()
    {
        $exception = new \Exception('It is an error');
        $json = $this->serializeToJson($exception, 123);
        $json->shouldBeArray();
        $json->shouldHaveKeyWithValue("message", "It is an error");
        $json->shouldHaveKeyWithValue("status", 123);
    }

    public function it_uses_code_default_when_the_code_is_less_than_400()
    {
        $exception = new \Exception('It is an error', 399);
        $json = $this->serializeToJson($exception, 321);
        $json->shouldBeArray();
        $json->shouldHaveKeyWithValue("message", "It is an error");
        $json->shouldHaveKeyWithValue("status", 321);
    }

    public function it_uses_code_default_when_the_code_is_more_than_599()
    {
        $exception = new \Exception('It is an error', 600);
        $json = $this->serializeToJson($exception, 222);
        $json->shouldBeArray();
        $json->shouldHaveKeyWithValue("message", "It is an error");
        $json->shouldHaveKeyWithValue("status", 222);
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
        $event->getError()->willReturn(Application::ERROR_EXCEPTION);

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

    public function it_can_handle_a_non_throwable_error(
        MvcEvent $event,
        Request $request,
        Response $response,
        Application $app
    ) {
        $result = new \StdClass();
        $event->getParam('exception')->willReturn(null);
        $event->getError()->willReturn(Application::ERROR_CONTROLLER_NOT_FOUND);

        $event->getParam('application')->willReturn($app);
        $app->getRequest()->willReturn($request);
        $event->getResponse()->willReturn($response);
        $event->getResult()->willReturn($result);
        $response->getStatusCode()->willReturn(200);

        $response->setStatusCode(500)->shouldBeCalled();
        $event->setResult(Argument::type(JsonModel::class))->shouldBeCalled();
        $event->setViewModel(Argument::type(JsonModel::class))->shouldBeCalled();

        $this->handleError($event);
    }
}
