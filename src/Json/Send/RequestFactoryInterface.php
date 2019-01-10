<?php

namespace SsMailer\Json\Send;

interface RequestFactoryInterface
{
    public function createRequest($json): RequestInterface;
}
