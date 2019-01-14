<?php

namespace SsMailer\Model\Send;

use SsMailer\Model\Send\RequestInterface;
use DateTimeInterface;

interface DelayableRequestInterface extends RequestInterface
{
    /**
     * @return bool
     */
    public function isDelayed(): bool;

    /**
     * @return DateTimeInterface
     */
    public function getSendDateTime(): DateTimeInterface;
}
