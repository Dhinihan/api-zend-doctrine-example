<?php

namespace Infrastructure\Rest;

use Zend\EventManager\AbstractListenerAggregate;
use Zend\EventManager\EventManagerInterface;
use Zend\Mvc\MvcEvent;
use Zend\View\Model\JsonModel;

class JsonError extends AbstractListenerAggregate
{
    public function attach(EventManagerInterface $events, $priority = 1)
    {
        $this->listeners[] = $events->attach(MvcEvent::EVENT_DISPATCH_ERROR, [$this, 'handleError'], $priority);
        $this->listeners[] = $events->attach(MvcEvent::EVENT_RENDER_ERROR, [$this, 'handleError'], $priority);
    }

    public function serializeToJson(\Throwable $exception, int $statusDefault = 500) : JsonModel
    {
        $data = [];
        $data['message'] = $exception->getMessage();
        $data['status'] = $this->extractStatus($exception, $statusDefault);
        return new JsonModel($data);
    }

    public function extractStatus(\Throwable $exception, int $statusDefault) : int
    {
        $code = $exception->getCode();
        if ($code < 400 || $code >= 600) {
            return $statusDefault;
        }
        return $code;
    }

    public function handleError(MvcEvent $e)
    {
        $request = $e->getParam('application')->getRequest();
        $response  = $e->getResponse();
        $exception = $e->getParam('exception');

        $json = $this->serializeToJson($exception, $response->getStatusCode());
        $json->setTerminal(true);

        $response->setStatusCode($this->extractStatus($exception, $response->getStatusCode()));

        $e->setResult($json);
        $e->setViewModel($json);
    }
}
