<?php

namespace SsMailer\Json\Send;

interface ResponseFactoryInterface
{
    /**
     * @param string|null $messageId
     * @return scalar|array|stdClass|JsonSerializable
     */
    public function createSuccessResponse(?string $messageId = null);

    /**
     * @param string[] $errors
     * @return scalar|array|stdClass|JsonSerializable
     */
    public function createInputErrorResponse(array $errors);

    /**
     * @param string[] $errors
     * @return scalar|array|stdClass|JsonSerializable
     */
    public function createProcessErrorResponse(array $errors);
}
