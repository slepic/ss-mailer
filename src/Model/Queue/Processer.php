<?php

namespace SsMailer\Model\Queue;

use SsMailer\Model\Queue\RepositoryInterface;
use SsMailer\Model\Send\SenderInterface;

class Processer
{
    private $sender;
    private $repository;

    public function __construct(RepositoryInterface $repository, SenderInterface $sender)
    {
        $this->repository = $repository;
        $this->sender = $sender;
    }

    public function processQueue(): void
    {
        foreach ($this->repository->getEmailsToSend() as $request) {
            $this->sender->sendEmail($request);
        }
    }
}
