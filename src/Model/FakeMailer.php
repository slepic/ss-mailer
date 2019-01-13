<?php

namespace SsMailer\Model;

class FakeMailer implements MailerInterface
{
    public function sendEmail(EmailInterface $email): ?array
    {
        if (strpos('error', $email->getFrom()) !== false) {
            return [
                'from' => 'You have hit error email.'
            ];
        }
        return null;
    }
}
