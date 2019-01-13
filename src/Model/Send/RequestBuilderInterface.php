<?php

namespace SsMailer\Model\Send;

use SsMailer\Model\EmailBuilderInterface;
use SsMailer\Model\EmailInterface;
use SsMailer\Model\Send\RequestInterface;
use DateTimeInterface;

interface RequestBuilderInterface
{
    public function setSendDateTime(DateTimeInterface $dateTime): void;
    public function getEmailBuilder(): EmailBuilderInterface;
    public function setEmail(EmailInterface $email): void;

    public function buildRequest(): RequestInterface;
}
