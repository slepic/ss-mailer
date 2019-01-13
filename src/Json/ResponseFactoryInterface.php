<?php

namespace SsMailer\Json;

interface ResponseFactoryInterface
{
    public function createSuccessResponse();
    public function createErrorResponse(array $errors);
}
