<?php

namespace SsMailer\Model\Send;

class FakePersister implements PersisterInterface
{
    public function persistSendRequest(RequestInterface $request): string
    {
        return md5(time());
    }
}
