<?php

namespace SsMailer\Applications;

class Queue
{
    private $processer;

    public function __construct(\SsMailer\Model\Queue\RepositoryInterface $repository)
    {
        //sends emails
        $mailer = new \SsMailer\Model\FakeMailer();

        //sends email requests immediately
        $immediateSender = new \SsMailer\Model\Send\ImmediateSender($mailer);

        //call webhooks while sending emails
        $sender = new \SsMailer\Model\Send\HookedSender($immediateSender);

        //processes the persistent queue
        $this->processer = new \SsMailer\Model\Queue\Processer($repository, $sender);
    }
    public function run(): void
    {
        $this->processer->processQueue();
    }
}
