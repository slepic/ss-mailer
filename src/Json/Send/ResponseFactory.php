<?php

namespace SsMailer\Json\Send;

use stdClass;

class ResponseFactory implements ResponseFactoryInterface
{
    /**
     * @param string|null $messageId
     * @return scalar|array|stdClass|JsonSerializable
     */
    public function createSuccessResponse(?string $messageId = null)
    {
        $json = new stdClass();
        $json->status = true;
        if ($messageId !== null) {
            $json->messageId = $messageId;
        }
        return $json;
    }

    /**
     * @param string[] $errors
     * @return scalar|array|stdClass|JsonSerializable
     */
    public function createErrorResponse(array $errors)
    {
        $json = new stdClass();
        $json->status = false;
        $json->errors = (object) $errors;
        return $json;
    }
}
