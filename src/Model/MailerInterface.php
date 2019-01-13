<?php

namespace SsMailer\Model;

interface MailerInterface
{
    public function sendEmail(EmailInterface $email): ?array;
}
