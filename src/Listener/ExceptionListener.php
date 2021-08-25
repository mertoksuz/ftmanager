<?php
namespace App\Listener;

use App\Exception\InvalidJWTException;
use Psr\Log\LoggerAwareTrait;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Event\ExceptionEvent;

class ExceptionListener
{
    use LoggerAwareTrait;

    public function onKernelException(ExceptionEvent $event)
    {
        $throwable = $event->getThrowable();

        $statusCode = Response::HTTP_INTERNAL_SERVER_ERROR;

        if ($throwable->getCode() != 0) {
            $statusCode = $throwable->getCode();
        }

        $response = new JsonResponse();
        $response->setStatusCode($statusCode);
        $message = json_encode(['error' => $throwable->getMessage()]);
        $response->setContent($message);
        $this->logger->info($message);

        $event->setResponse($response);
    }
}