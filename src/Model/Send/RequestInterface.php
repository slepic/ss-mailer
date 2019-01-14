<?php

namespace SsMailer\Model\Send;

use SsMailer\Model\EmailInterface;

interface RequestInterface
{
    /**
     * @return EmailInterface
     */
    public function getEmail(): EmailInterface;
}
