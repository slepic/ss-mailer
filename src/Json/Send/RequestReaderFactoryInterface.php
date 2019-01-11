<?php

namespace SsMailer\Json\Send;

use SsMailer\Model\Send\RequestReaderInterface;

interface RequestReaderFactoryInterface
{
    public function createRequestReader($json): RequestReaderInterface;
}
