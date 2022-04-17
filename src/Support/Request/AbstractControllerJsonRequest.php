<?php
declare(strict_types=1);

namespace App\Support\Request;

use App\Support\Exception\ApplicationException;

abstract class AbstractControllerJsonRequest extends AbstractControllerRequest
{
    protected function setRequest($request)
    {
        if ($request->getContentType() !== "json") {
            throw new ApplicationException("Request body no json.");
        }

        $data = json_decode($request->getContent(), true);

        if (json_last_error() !== JSON_ERROR_NONE) {
            throw new ApplicationException('invalid json body: ' . json_last_error_msg());
        }

        parent::setRequest($data);
    }
}