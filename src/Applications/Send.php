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

        //checkes whether mail is to be delivered immediately or with delay and acts accordingly
        $sender = new \SsMailer\Model\Send\Sender($mailer, $persister);

        //maps input and output of the process to json representations
        $jsonHandler = new \SsMailer\Json\Send\Handler($sender);

        //wraps json data with http layer
        $handler = new \SsMailer\Http\JsonHandler($jsonHandler);

        parent::__construct($handler, $requestFactory, $responseSender);
    }
}
