<?php

namespace SsMailer\Http;

use Psr\Http\Server\RequestHandlerInterface as Handler;
use Psr\Http\Message\ResponseFactoryInterface as ResponseFactory;
use Psr\Http\Message\StreamFactoryInterface as StreamFactory;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use SsMailer\Json\HandlerInterface as JsonDelegateHandler;
use SsMailer\Json\CoderInterface as JsonCoder;
use SsMailer\Json\Coder as DefaultCoder;
use Zend\Diactoros\ResponseFactory as DefaultResponseFactory;
use Zend\Diactoros\StreamFactory as DefaultStreamFactory;

class JsonHandler implements Handler
{
    private $handler;
    private $responseFactory;
    private $streamFactory;
    private $json;

    public function __construct(
        JsonDelegateHandler $handler,
        ResponseFactory $responseFactory = null,
        StreamFactory $streamFactory = null,
        JsonCoder $coder = null
    ) {
        $this->handler = $handler;
        $this->responseFactory = $responseFactory ?: new DefaultResponseFactory();
        $this->streamFactory = $streamFactory ?: DefaultStreamFactory();
        $this->json = $coder ?: new DefaultJsonCoder();
    }

    /**
     * Passes request body to JsonHandler and always returns the result json, encoded inside the response body.
     */
    public function handle(Request $request): Response
    {
        $jsonRequest = $this->json->decode((string) $request->getBody());
        $jsonResponse = $this->handler->handle($jsonRequest);
        $response = $this->responseFactory->createResponse(200);
        if ($jsonResponse === null) {
            return $response;
        }
        $body = $this->json->encode($jsonResponse);
        $responseStream = $this->streamFactory->createStream($body);
        return $response->withBody($responseStream);
    }
}
