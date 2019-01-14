<?php

namespace SsMailer\Json;

use stdClass;

class DefaultResponseFactory implements ResponseFactoryInterface
{
    public function createSuccessResponse()
    {
        $response = new stdClass();
        $response->status = true;
        return $response;
    }

    public function createErrorResponse(array $errors)
    {
        $response = new stdClass();
        $response->status = false;
        $response->errors = (object) $errors;
        return $response;
    }
}
