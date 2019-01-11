<?php

namespace SsMailer\Model\Send;

use SsMailer\Model\EmailInterface;
use DateTimeInterface;

interface RequestInterface
{
    /**
     * @return bool
     */
    public function isDelayed(): bool;

    /**
     * @return DateTimeInterface
     */
    public function getSendDateTime(): DateTimeInterface;

    /**
     * @return EmailInterface
     */
    public function getEmail(): EmailInterface;
}
