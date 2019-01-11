<?php

namespace SsMailer\Model;

interface EmailInterface
{
    /**
     * Get sender email.
     *
     * @return string
     */
    public function getFrom(): string;

    /**
     * Get list of target emails.
     *
     * @return string[]
     */
    public function getTo(): iterable;

    /**
     * Get list of Cc emails.
     *
     * @return string[]
     */
    public function getCc(): iterable;

    /**
     * Get list of Bcc emails.
     *
     * @return string[]
     */
    public function getBcc(): iterable;

    /**
     * Get subject of the email.
     *
     * @return string
     */
    public function getSubject(): string;

    /**
     * Get body of the email.
     *
     * @return string
     */
    public function getBody(): string;

    /**
     * Tells if body is in html format.
     *
     * @return bool
     */
    public function isHtml(): bool;
}
