<?php

namespace SsMailer\Applications;

class Cancel extends \SsMailer\Http\Application
{
    public function __construct(
        \SsMailer\Http\ServerRequestFactoryInterface $requestFactory = null,
        \SsMailer\Http\ResponseSenderInterface $responseSender = null
    ) {
        $repository = new \SsMailer\Model\Cancel\FakeCancelableRepository();

        //maps input and output of the process to json representations
        $jsonHandler = new \SsMailer\Json\Cancel\Handler($repository);

        //wraps json data with http layer
        $handler = new \SsMailer\Http\JsonHandler($jsonHandler);

        parent::__construct($handler, $requestFactory, $responseSender);
    }
}
