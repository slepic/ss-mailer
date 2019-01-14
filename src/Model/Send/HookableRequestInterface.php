<?php

namespace SsMailer\Model\Send;

use SsMailer\Model\Send\RequestInterface;

interface HookableRequestInterface extends RequestInterface
{
    /**
     * @return ?string
     */
    public function getSuccessUrl(): ?string;

    /**
     * @return ?string
     */
    public function getErrorUrl(): ?string;
}
