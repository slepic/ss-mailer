<?php

namespace SsMailer\Model\Send;

interface RequestBuilderFactoryInterface
{
    public function createRequestBuilder(): RequestBuilderInterface;
}
