<?php

namespace SsMailer\Json\Send;

use SsMailer\Json\HandlerInterface;
use SsMailer\Json\Send\RequestFactoryInterface as RequestFactory;
use SsMailer\Json\Send\ResponseFactoryInterface as ResponseFactory;
use SsMailer\Model\Send\SenderInterface as Sender;

class Handler implements HandlerInterface
{
    private $requestFactory;
    private $responseFactory;
    private $sender;

    public function __construct(
        RequestFactory $requestFactory,
        ResponseFactory $responseFactory,
        Sender $sender
    ) {
        $this->requestFactory = $requestFactory;
        $this->responseFactory = $responseFactory;
        $this->sender = $sender;
    }

    public function handle($json)
    {
        $request = $this->requestFactory->createRequest($json);
        if ($request->hasErrors()) {
            return $this->responseFactory->createErrorResponse($request->getErrors());
        }
        $email = $request->getEmailRequest();
        $response = $this->sender->sendEmail($email);
        if ($response->getStatus()) {
            return $this->responseFactory->createSuccessResponse($response->getMessageId());
        }
        return $this->responseFactory->createErrorResponse($response->getErrors());
    }
}
