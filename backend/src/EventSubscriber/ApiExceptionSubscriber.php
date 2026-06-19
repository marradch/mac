<?php

namespace App\EventSubscriber;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\Exception\BadRequestException;
use Symfony\Component\HttpKernel\Event\ExceptionEvent;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpKernel\KernelEvents;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Validator\Exception\ValidationFailedException;
use Symfony\Component\HttpKernel\Exception\UnprocessableEntityHttpException;
use App\Exception\RetryableException;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

class ApiExceptionSubscriber implements EventSubscriberInterface
{
    public static function getSubscribedEvents(): array
    {
        return [
            KernelEvents::EXCEPTION => 'onException',
        ];
    }

    public function onException(ExceptionEvent $event): void
    {
        $exception = $event->getThrowable();

        if ($exception instanceof UnprocessableEntityHttpException) {
            $previous = $exception->getPrevious();

            if ($previous instanceof ValidationFailedException) {
                $violations = $previous->getViolations();

                $errors = [];

                foreach ($violations as $violation) {
                    $field = $violation->getPropertyPath();

                    $errors[$field] = $violation->getMessage();
                }

                $response = new JsonResponse([
                    'message' => 'Validation failed',
                    'errors' => $errors
                ], 422);
                $event->setResponse($response);
            } else {
                $response = new JsonResponse([
                    'status' => 'error',
                    'message' => $exception->getMessage()
                ], 422);
            }
        } else if ($exception instanceof RetryableException) {
            $response = new JsonResponse([
                'status' => 'error',
                'type' => 'retryable_error',
                'message' => $exception->getMessage(),
                'retry_after' => $exception->getRetryAfterSeconds(),
            ], $exception->getStatusCode());
            $event->setResponse($response);
        } else if ($exception instanceof NotFoundHttpException) {
            $response = new JsonResponse([
                'status' => 'error',
                'type' => 'not_found',
                'message' => 'Not found',
            ], 404);
            $event->setResponse($response);
        } else if ($exception instanceof BadRequestHttpException) {
            $response = new JsonResponse([
                'status' => 'error',
                'message' => $exception->getMessage(),
            ], 404);
            $event->setResponse($response);
        }/*else {
            $response = new JsonResponse([
                'status' => 'error',
                'type' => 'internal_error',
                'message' => 'Something went wrong',
            ], 500);
        }*/

        //$event->setResponse($response);
    }
}
