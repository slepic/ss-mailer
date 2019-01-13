<?php

namespace SsMailer\Model;

class Email implements EmailInterface, EmailBuilderInterface
{
    private $from = '';
    private $to = [];
    private $cc = [];
    private $bcc = [];
    private $subject = '';
    private $body = '';
    private $isHtml = false;

    /**
     * Get sender email.
     *
     * @return string
     */
    public function getFrom(): string
    {
        return $this->from;
    }

    /**
     * Get list of target emails.
     *
     * @return string[]
     */
    public function getTo(): iterable
    {
        return $this->to;
    }

    /**
     * Get list of Cc emails.
     *
     * @return string[]
     */
    public function getCc(): iterable
    {
        return $this->cc;
    }

    /**
     * Get list of Bcc emails.
     *
     * @return string[]
     */
    public function getBcc(): iterable
    {
        return $this->bcc;
    }

    /**
     * Get subject of the email.
     *
     * @return string
     */
    public function getSubject(): string
    {
        return $this->subject;
    }

    /**
     * Get body of the email.
     *
     * @return string
     */
    public function getBody(): string
    {
        return $this->body;
    }

    /**
     * Tells if body is in html format.
     *
     * @return bool
     */
    public function isHtml(): bool
    {
        return $this->isHtml;
    }

    public function setFrom(string $from): void
    {
        $this->from = $from;
    }

    public function setTo(array $to): void
    {
        $this->to = $to;
    }

    public function setCc(array $cc): void
    {
        $this->cc = $cc;
    }

    public function setBcc(array $bcc): void
    {
        $this->bcc = $bcc;
    }

    public function setSubject(string $subject): void
    {
        $this->subject = $subject;
    }

    public function setBody(string $body): void
    {
        $this->body = $body;
    }

    public function setIsHtml(bool $isHtml = true): void
    {
        $this->isHtml = $isHtml;
    }

    public function buildEmail(): EmailInterface
    {
        return clone $this;
    }

    public function createEmailBuilder(): EmailBuilderInterface
    {
        return clone $this;
    }
}
