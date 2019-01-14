<?php

namespace SsMailer\Model\Send;

use SsMailer\Model\Send\SenderInterface;
use SsMailer\Model\Send\PersisterInterface;
use SsMailer\Model\Send\RequestInterface;
use SsMailer\Model\Send\DelayableRequestInterface;
use DateTime;

/**
 * Delays send of delayable emails.
 */
class DelayedSender implements SenderInterface
{
    private $sender;
    private $persister;

    public function __construct(SenderInterface $sender, PersisterInterface $persister)
    {
        $this->sender = $sender;
        $this->persister = $persister;
    }

    public function sendEmail(RequestInterface $request)
    {
        if ($request instanceof DelayedRequestInterface && $request->isDelayed() && $request->getSendDateTime() > new DateTime()) {
            return $this->persister->persistSendRequest($request);
        }
        return $this->sender->sendEmail($request);
    }
}
