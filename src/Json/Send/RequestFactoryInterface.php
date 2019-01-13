<?php

namespace SsMailer\Json\Send;

use SsMailer\Model\Send\RequestInterface;

interface RequestFactoryInterface
{
    /**
     * @return RequestInterface|string[] Return prepared request or array of input errors.
     */
    public function createRequest($json);
}
