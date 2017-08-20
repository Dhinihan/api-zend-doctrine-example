<?php

namespace Infrastructure\Rest;

use Zend\EventManager\AbstractListenerAggregate;
use Zend\EventManager\EventManagerInterface;
use Zend\Mvc\Application;
use Zend\Mvc\MvcEvent;
use Zend\View\Model\JsonModel;

class JsonError extends AbstractListenerAggregate
{
    public function attach(EventManagerInterface $events, $priority = 1)
    {
        $this->listeners[] = $events->attach(MvcEvent::EVENT_DISPATCH_ERROR, [$this, 'handleError'], $priority);
        $this->listeners[] = $events->attach(MvcEvent::EVENT_RENDER_ERROR, [$this, 'handleError'], $priority);
    }

    public function serializeToJson(\Throwable $exception, int $statusDefault = 500) : array
    {
        $data = [];
        $data['message'] = $exception->getMessage();
        $data['status'] = $this->extractStatus($exception, $statusDefault);
        return $data;
    }

    public function extractStatus(\Throwable $exception, int $statusDefault) : int
    {
        $code = $exception->getCode();
        if ($code < 400 || $code >= 600) {
            return $statusDefault;
        }
        return $code;
    }

    public function handleError(MvcEvent $event)
    {
        $request = $event->getParam('application')->getRequest();
        $response  = $event->getResponse();

        $data = $this->getJsonError($event, $response->getStatusCode());

        $jsonModel = new JsonModel($data);
        $jsonModel->setTerminal(true);
        $response->setStatusCode($data['status']);

        $event->setResult($jsonModel);
        $event->setViewModel($jsonModel);
    }

    private function getJsonError(MvcEvent $event, $code) : array
    {
        if ($event->getError() === Application::ERROR_EXCEPTION) {
            return $this->serializeToJson($event->getParam('exception'), $code);
        }
        $data['message'] = $event->getError();
        $data['status'] = 500;
        return $data;
    }
}
