<?php

namespace App\Support\Response\Contract;

use App\Http\ApplicationCode;

interface AppResponder
{
    public function respondWithSuccess(
        array $payload = [],
        $applicationCode = ApplicationCode::SUCCESS,
        $message = 'success'
    );

    public function respondClientError(
        array $errors = [],
        int $statusCode = ApplicationCode::BAD_REQUEST,
        $message = 'invalid request'
    );

    public function respondServerError(
        array $errors = [],
        int $statusCode = ApplicationCode::SERVER_ERROR,
        $message = 'invalid request'
    );
}