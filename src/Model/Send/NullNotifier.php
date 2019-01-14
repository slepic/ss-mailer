<?php

namespace SsMailer\Model\Send;

class NullNotifier implements NotifierInterface
{
    public function onSuccessEmail(HookableRequestInterface $request): void
    {
    }

    public function onErrorEmail(HookableRequestInterface $request, array $errors): void
    {
    }
}
