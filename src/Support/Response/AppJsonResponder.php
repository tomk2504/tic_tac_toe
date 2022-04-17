<?php
declare(strict_types=1);

namespace App\Support\Response;

use App\Http\ApplicationCode;
use App\Support\Response\Contract\AppResponder;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class AppJsonResponder implements AppResponder
{
    private int $applicationCode;
    private array $data;
    private string $message;
    private array $errors;
    protected int $httpStatusCode = Response::HTTP_OK;

    public function respondWithSuccess(
        array $payload = [],
        $applicationCode = ApplicationCode::SUCCESS,
        $message = 'success',
        $httpStatusCode = Response::HTTP_OK
    ): JsonResponse
    {

        $this->setApplicationCode($applicationCode);
        $this->setMessage($message);
        $this->setPayload($payload);

        $this->setHttpStatusCode($httpStatusCode);

        return $this->returnSuccessResponse();
    }

    public function respondClientError(
        array $errors = [],
        int $statusCode = ApplicationCode::BAD_REQUEST,
        $message = 'invalid request'
    ): JsonResponse
    {
        $this->setApplicationCode($statusCode);
        $this->setMessage($message);
        $this->setErrors($errors);

        $this->setHttpStatusCode(Response::HTTP_BAD_REQUEST);

        return $this->returnErrorResponse();
    }

    public function respondServerError(
        array $errors = [],
        int $statusCode = ApplicationCode::SERVER_ERROR,
        $message = 'internal error'
    ): JsonResponse
    {
        $this->setApplicationCode($statusCode);
        $this->setMessage($message);
        $this->setErrors($errors);

        $this->setHttpStatusCode(Response::HTTP_INTERNAL_SERVER_ERROR);

        return $this->returnErrorResponse();
    }

    private function setApplicationCode(int $code): void
    {
        $this->applicationCode = $code;
    }

    private function setMessage(string $message): void
    {
        $this->message = $message;
    }

    private function setPayload(array $data): void
    {
        $this->data = $data;
    }

    private function setHttpStatusCode(int $statusCode): void
    {
        $this->httpStatusCode = $statusCode;
    }

    private function returnSuccessResponse(): JsonResponse
    {
        return new JsonResponse([
            'code' => $this->applicationCode,
            'message' => $this->message,
            'data' => $this->data
        ], $this->httpStatusCode);
    }

    private function setErrors(array $errors): void
    {
        $this->errors = $errors;
    }

    private function returnErrorResponse(): JsonResponse
    {
        return new JsonResponse([
            'code' => $this->applicationCode,
            'message' => $this->message,
            'errors' => $this->errors
        ], $this->httpStatusCode);
    }
}