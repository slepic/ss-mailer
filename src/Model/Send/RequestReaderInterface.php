<?php

namespace SsMailer\Model\Send;

use SsMailer\Model\Send\RequestInterface;
use SsMailer\Model\ErroneousInterface;

interface RequestReaderInterface extends ErroneousInterface
{
    public function getRequest(): RequestInterface;
}
