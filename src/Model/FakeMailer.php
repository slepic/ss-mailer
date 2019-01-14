<?php

namespace SsMailer\Model;

class FakeMailer implements MailerInterface
{
    public function sendEmail(EmailInterface $email): ?array
    {
        if (strpos($email->getFrom(), 'error') !== false) {
            return [
                'from' => 'You have hit error email.'
            ];
        }
        return null;
    }
}
