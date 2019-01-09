<?php

namespace SsMailer\Http;

use Psr\Http\Server\RequestHandlerInterface as Handler;
use SsMailer\Http\ServerRequestFactoryInterface as RequestFactory;
use SsMailer\Http\ResponseSenderInterface as ResponseSender;
use SsMailer\Http\ZendServerRequestFactory as DefaultRequestFactory;
use SsMailer\Http\HttpInteropResponseSender as DefaultResponseSender;

class Application
{
    private $handler;
    private $requestFactory;
    private $responseSender;

    public function __construct(
        Handler $handler,
        RequestFactory $requestFactory = null,
        ResponseSender $responseSender = null
    ) {
        $this->handler = $handler;
        $this->requestFactory = $requestFactory ?: new DefaultRequestFactory();
        $this->responseSender = $responseSender ?: new DefaultResponseSender();
    }

    public function run(): void
    {
        $request = $this->requestFactory->createServerRequest();
        $response = $this->handler->handle($request);
        $this->responseSender->sendResponse($response);
    }
}
