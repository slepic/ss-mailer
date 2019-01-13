<?php

namespace SsMailer\Model;

interface EmailBuilderInterface
{
    public function setFrom(string $from): void;
    public function setTo(array $to): void;
    public function setCc(array $cc): void;
    public function setBcc(array $bcc): void;
    public function setSubject(string $subject): void;
    public function setBody(string $body): void;
    public function setIsHtml(bool $isHtml = true): void;

    public function buildEmail(): EmailInterface;
}
