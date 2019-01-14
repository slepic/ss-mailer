<?php

namespace SsMailer\Applications;

class Send extends \SsMailer\Http\Application
{
    public function __construct(
        \SsMailer\Http\ServerRequestFactoryInterface $requestFactory = null,
        \SsMailer\Http\ResponseSenderInterface $responseSender = null
    ) {
        //performs persitatance of send requests to be processed later
        $persister = new \SsMailer\Model\Send\FakePersister();

        //performs send of immediate emails
        $mailer = new \SsMailer\Model\FakeMailer();

        //sends emails immediately
        $immediateSender = new \SsMailer\Model\Send\ImmediateSender($mailer);

        //sends notifications to webhooks
        $hookedSender = new \SsMailer\Model\Send\HookedSender($immediateSender);

        //pushes delayd emails to a queue
        $sender = new \SsMailer\Model\Send\DelayedSender($hookedSender, $persister);

        //maps input and output of the process to json representations
        $jsonHandler = new \SsMailer\Json\Send\Handler($sender);

        //wraps json data with http layer
        $handler = new \SsMailer\Http\JsonHandler($jsonHandler);

        parent::__construct($handler, $requestFactory, $responseSender);
    }
}
