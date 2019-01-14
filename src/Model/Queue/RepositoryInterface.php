<?php

namespace SsMailer\Model\Queue;

use SsMailer\Model\Send\RequestInterface;

interface RepositoryInterface
{
    /**
     * @return RequestInterface[]
     */
    public function getEmailsToSend(): iterable;
}
