<?php

namespace SsMailer\Json\Send;

use SsMailer\Json\HandlerInterface;
use SsMailer\Json\Send\RequestReaderFactoryInterface as ReaderFactory;
use SsMailer\Json\Send\ResponseFactoryInterface as ResponseFactory;
use SsMailer\Model\Send\SenderInterface as Sender;

class Handler implements HandlerInterface
{
    private $readerFactory;
    private $responseFactory;
    private $sender;

    public function __construct(
        ReaderFactory $readerFactory,
        ResponseFactory $responseFactory,
        Sender $sender
    ) {
        $this->readerFactory = $readerFactory;
        $this->responseFactory = $responseFactory;
        $this->sender = $sender;
    }

    public function handle($json)
    {
        $reader = $this->readerFactory->createRequestReader($json);
        if ($reader->hasErrors()) {
            return $this->responseFactory->createErrorResponse($reader->getErrors());
        }
        $request = $reader->getRequest();
        $response = $this->sender->sendEmail($request);
        if ($response->hasErrors()) {
            return $this->responseFactory->createErrorResponse($response->getErrors());
        }
        return $this->responseFactory->createSuccessResponse($response->getMessageId());
    }
}
