<?php

namespace SsMailer\Json\Send;

use SsMailer\Json\HandlerInterface;
use SsMailer\Json\Send\RequestFactory as DefaultRequestFactory;
use SsMailer\Json\Send\ResponseFactory as DefaultResponseFactory;
use SsMailer\Json\Send\RequestFactoryInterface as RequestFactory;
use SsMailer\Json\Send\ResponseFactoryInterface as ResponseFactory;
use SsMailer\Model\Send\SenderInterface as Sender;
use SsMailer\Model\Send\RequestInterface as Request;

class Handler implements HandlerInterface
{
    private $requestFactory;
    private $responseFactory;
    private $sender;

    public function __construct(
        Sender $sender,
        RequestFactory $requestFactory = null,
        ResponseFactory $responseFactory = null
    ) {
        $this->sender = $sender;
        $this->requestFactory = $requestFactory ?: new DefaultRequestFactory();
        $this->responseFactory = $responseFactory ?: new DefaultResponseFactory();
    }

    public function handle($json)
    {
        $request = $this->requestFactory->createRequest($json);
        if ($request instanceof Request) {
            $result = $this->sender->sendEmail($request);
            if ($result === null || is_string($result)) {
                return $this->responseFactory->createSuccessResponse($result);
            } elseif (is_array($result)) {
                return $this->responseFactory->createProcessErrorResponse($result);
            }
            throw new Exception('Sender did not return messageId nor array of errors.');
        } elseif (is_array($request)) {
            return $this->responseFactory->createInputErrorResponse($request);
        }
        throw new Exception('Request factory did not return RequestInterface nor array of errors.');
    }
}
