<?php

namespace SsMailer\Model\Send;

use SsMailer\Model\EmailInterface;
use SsMailer\Model\EmailBuilderInterface;
use SsMailer\Model\Email as DefaultEmailBuilder;
use DateTimeInterface;

class Request implements RequestInterface, RequestBuilderInterface, RequestBuilderFactoryInterface
{
    private $emailBuilder;
    private $email;
    private $sendDateTime;

    public function __construct(
        EmailBuilderInterface $emailBuilder = null,
        EmailInterface $email = null,
        DateTimeInterface $sendDateTime = null
    ) {
        $this->emailBuilder = $emailBuilder ?: new DefaultEmailBuilder();
        $this->email = $email;
        $this->sendDateTime = $sendDateTime;
    }

    public function getEmailBuilder(): EmailBuilderInterface
    {
        return $this->emailBuilder;
    }

    /**
     * @return bool
     */
    public function isDelayed(): bool
    {
        return $this->sendDateTime !== null;
    }

    /**
     * @return DateTimeInterface
     */
    public function getSendDateTime(): DateTimeInterface
    {
        return $this->sendDateTime;
    }

    public function setSendDateTime(DateTimeInterface $sendDateTime): void
    {
        $this->sendDateTime = $sendDateTime;
    }

    /**
     * @return EmailInterface
     */
    public function getEmail(): EmailInterface
    {
        if ($this->email === null) {
            $email = $this->emailBuilder->buildEmail();
            $this->setEmail($email);
        }
        return $this->email;
    }

    public function setEmail(EmailInterface $email): void
    {
        $this->email = $email;
    }

    public function buildRequest(): RequestInterface
    {
        return clone $this;
    }

    public function createRequestBuilder(): RequestBuilderInterface
    {
        return clone $this;
    }

    public function __clone()
    {
        $this->emailBuilder = clone $this->emailBuilder;
        if ($this->email !== null) {
            $this->email = clone $this->email;
        }
    }
}
