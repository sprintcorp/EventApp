<?php

namespace App\Exception;

use Doctrine\DBAL\ConnectionException;
use Symfony\Component\HttpFoundation\File\Exception\AccessDeniedException;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Event\ExceptionEvent;
use Symfony\Component\HttpKernel\Exception\HttpExceptionInterface;
use Symfony\Component\Validator\Exception\InvalidArgumentException;

class ErrorHandler
{
    public function onKernelException(ExceptionEvent $event): void
    {
        $exception = $event->getThrowable();

        // Handle specific exceptions
        if ($exception instanceof InvalidArgumentException) {
            $response = new JsonResponse([
                'error' => $exception->getMessage(),
            ], Response::HTTP_BAD_REQUEST);

        } elseif ($exception instanceof HttpExceptionInterface) {
            $response = new JsonResponse([
                'error' => $exception->getMessage(),
            ], $exception->getStatusCode());

        } elseif ($exception instanceof ConnectionException) {
            $response = new JsonResponse([
                'error' => 'Database connection error.',
            ], Response::HTTP_SERVICE_UNAVAILABLE);

        } elseif ($exception instanceof AccessDeniedException) {
            $response = new JsonResponse([
                'error' => 'Access denied.',
            ], Response::HTTP_FORBIDDEN);

        } elseif ($this->isFatalError($exception)) {
            // Handle code errors
            $response = new JsonResponse([
                'error' => 'Internal Server Error',
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        } else {
            // Handle general exceptions
            $response = new JsonResponse([
                'error' => 'Unexpected error occurred',
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }

        // Set the response on the event
        $event->setResponse($response);
    }

    private function isFatalError(\Throwable $exception): bool
    {
        $fatalErrors = [
            E_ERROR,
            E_PARSE,
            E_CORE_ERROR,
            E_COMPILE_ERROR,
            E_USER_ERROR,
        ];

        return in_array($exception->getCode(), $fatalErrors, true);
    }
}
