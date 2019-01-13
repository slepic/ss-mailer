<?php

namespace SsMailer\Model\Send;

interface PersisterInterface
{

    /**
     * @param RequestInterface
     * @return string Returns new id of the request.
     */
    public function persistSendRequest(RequestInterface $request): string;
}
