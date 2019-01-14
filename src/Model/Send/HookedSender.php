<?php

namespace SsMailer\Model\Send;

use SsMailer\Model\Send\SenderInterface;
use SsMailer\Model\Send\NotifierInterface;
use SsMailer\Model\Send\RequestInterface;
use SsMailer\Model\Send\HookableRequestInterface;

/**
 * Notifies listeners of hookable emails.
 */
class HookedSender implements SenderInterface
{
    private $sender;
    private $notifier;

    public function __construct(SenderInterface $sender, NotifierInterface $notifier = null)
    {
        $this->sender = $sender;
        $this->notifier = $notifier ?: new NullNotifier();
    }

    public function sendEmail(RequestInterface $request)
    {
        $result = $this->sender->sendEmail($request);
        if (is_array($result)) {
            if ($request instanceof HookableRequestInterface) {
                $this->notifier->onErrorEmail($request, $result);
            }
            return $result;
        }
        if ($request instanceof HookableRequestInterface) {
            $this->notifier->onSuccessEmail($request, $result);
        }
        return $result;
    }
}
