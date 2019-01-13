<?php

namespace SsMailer\Model;

class FakeMailer implements MailerInterface
{
    public function sendEmail(EmailInterface $email): ?array
    {
        if (strpos('error', $email->getFrom())) {
            return [
                'from' => 'You have hit error email.'
            ];
        }
        return null;
    }
}
