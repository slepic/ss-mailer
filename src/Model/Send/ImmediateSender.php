<?php

namespace SsMailer\Model\Send;

use SsMailer\Model\Send\SenderInterface;
use SsMailer\Model\Send\RequestInterface;
use SsMailer\Model\MailerInterface;

/**
 * Notifies listeners of hookable emails.
 */
class ImmediateSender implements SenderInterface
{
    private $mailer;

    public function __construct(MailerInterface $mailer)
    {
        $this->mailer = $mailer;
    }

    public function sendEmail(RequestInterface $request)
    {
        return $this->mailer->sendEmail($request->getEmail());
    }
}
