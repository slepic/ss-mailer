<?php

namespace SsMailer\Model\Send;

use SsMailer\Model\Send\SenderInterface;
use SsMailer\Model\Send\RequestInterface;
use SsMailer\Model\Send\PersisterInterface;
use SsMailer\Model\MailerInterface;
use DateTime;

class Sender implements SenderInterface
{
    private $mailer;
    private $persister;

    public function __construct(MailerInterface $mailer, PersisterInterface $persister)
    {
        $this->mailer = $mailer;
        $this->persister = $persister;
    }

    public function sendEmail(RequestInterface $request)
    {
        if ($request->isDelayed() && $request->getSendDateTime() > new DateTime()) {
            return $this->persister->persistSendRequest($request);
        }
        return $this->mailer->sendEmail($request->getEmail());
    }
}
