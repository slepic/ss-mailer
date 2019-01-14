<?php

namespace SsMailer\Model\Send;

interface NotifierInterface
{
    public function onSuccessEmail(HookableRequestInterface $request): void;
    public function onErrorEmail(HookableRequestInterface $request, array $errors): void;
}
